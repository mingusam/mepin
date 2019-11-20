<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Mpesa{
        public $securitycredentials = "hkOJbliegnunsX+TpUYOY8g9TFu4jOgmf9K+URSk/e8Z5PbBxc7kjuB9kZv+nJcmUz2KjY8C1Rq1hexYZ6zUE1n7LBQapFEQSftHKvJtdkVfOK0IG/3pmNY6HzyW40LW27x4xbPwzZpn4B/HWD5M6Bnqnd+oAmaZ8iUFDG5ivnljL49X9YqZ7i9qGkDV1wT0GNxoJ37+dpV3a0RIaAU2J5JcyBKz+3vNe6BlD1AT9yhDaFZ2UOUc3vj34w6K3GInzVVzsEppnaao9ZcHmaKCkD1qOsop0tWBzLow1wyq0uLP5zzMGm+F4RcZa4kwM6SrtyhyxEb4s25FpCcNF45duA==";
        public $baseurl = "https://af63d159.ngrok.io/mepin/";

        protected $CI;
        public function __construct(){
            $this->CI =& get_instance();
        }        
        public function generateToken(){
            $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $consumerkey = 'bm4Ae6Wx1J7niJhtABTxWjAg7mkIcwZE';
            $consumersecret = 'k8oTYrwGFzA72vKj';
            $credentials = base64_encode($consumerkey.':'.$consumersecret);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $curl_response = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $result = json_decode($curl_response);
            return $result;
        }
        public function stkpush($shortcode,$amount,$partya,$partyb,$phone,$desc){
            $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $curl = curl_init();
            $gettoken = $this->generateToken();
            $token = $gettoken->access_token;
            $LipaNaMpesaPasskey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
            $timestamp='20'.date("ymdhis");
            $password=base64_encode($shortcode.$LipaNaMpesaPasskey.$timestamp);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json',
            'Authorization:Bearer ' .$token)); //setting custom header
            $curl_post_data = array(
                //Fill in the request parameters with valid values
                'BusinessShortCode' => $shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $partya,
                'PartyB' => $partyb,
                'PhoneNumber' =>$phone,
                'CallBackURL' => $this->baseurl.'Callback.php',
                'AccountReference' => 'Samuel',
                'TransactionDesc' => $desc
            );
            
            $data_string = json_encode($curl_post_data);
            
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($curl, CURLOPT_HEADER, false);
            
            $curl_response = curl_exec($curl);
            $result = json_decode($curl_response);
            // $merchantid = $result->MerchantRequestID;
            // $date = NOW();
            // $query = "Insert into lipanampesa(MerchantRequestID,amount,transactionDate) values($merchantid,
            // $amount,$date)";
            // $result            
            return $curl_response;
        }
        //generate account balance
        public function accountBalance($initiator,$partya,$remarks){
            $url = 'https://sandbox.safaricom.co.ke/mpesa/accountbalance/v1/query';
            $gettoken = $this->generateToken();
            $token = $gettoken->access_token;
  
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header
            
            $curl_post_data = array(
              //Fill in the request parameters with valid values
              'Initiator' => $initiator,
              'SecurityCredential' => $this->securitycredentials,
              'CommandID' => 'AccountBalance',
              'PartyA' => $partya,
              'IdentifierType' => '4',
              'Remarks' => $remarks,
              'QueueTimeOutURL' => $this->baseurl.'Balance.php',
              'ResultURL' => $this->baseurl.'Balance.php'
            );
            
            $data_string = json_encode($curl_post_data);
            
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            
            $curl_response = curl_exec($curl);
            print_r($curl_response);
            
            return $curl_response;
        }
        //perform reversal
        public function registerurl($shortcode){
            $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
            $gettoken = $this->generateToken();
            $token = $gettoken->access_token;
  
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header
        
            $curl_post_data = array(
                //Fill in the request parameters with valid values
                'ShortCode' => $shortcode,
                'ResponseType' => 'complete',
                'ConfirmationURL' => $this->baseurl.'C2bcallback.php',
                'ValidationURL' => $this->baseurl.'C2bcallback.php'
            );
            
            $data_string = json_encode($curl_post_data);
            
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            
            $curl_response = curl_exec($curl);
            print_r($curl_response);
            
            return $curl_response;
        }
        public function c2btransactions($shortcode,$amount,$phone){
            $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
            $gettoken = $this->generateToken();
            $token = $gettoken->access_token;
  
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header
    
            $curl_post_data = array(
                    //Fill in the request parameters with valid values
                'ShortCode' => $shortcode,
                'CommandID' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'Msisdn' => $phone,
                'BillRefNumber' => 'TestAPI'
            );
            $data_string = json_encode($curl_post_data);
        
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        
            $curl_response = curl_exec($curl);
            print_r($curl_response);
        
            return $curl_response;
        }
    }

?>