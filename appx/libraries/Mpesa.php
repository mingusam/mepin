<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Mpesa{
        public function generateToken(){
            $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $credentials = base64_encode('bm4Ae6Wx1J7niJhtABTxWjAg7mkIcwZE:k8oTYrwGFzA72vKj');
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $curl_response = curl_exec($curl);
            
            return json_decode($curl_response);
        }
        public function lipanampesa($BusinessShortCode,$Amount,$PartyA, $PartyB, $PhoneNumber,$TransactionDesc){
            $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $token = generateToken();
            $curl = curl_init();
            $LipaNaMpesaPasskey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
            $timestamp='20'.date("ymdhis");
            $password=base64_encode($BusinessShortCode.$LipaNaMpesaPasskey.$timestamp);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json',
            'Authorization:Bearer ' .$token)); //setting custom header
            $curl_post_data = array(
                //Fill in the request parameters with valid values
                'BusinessShortCode' => '$BusinessShortCode',
                'Password' => ' ',
                'Timestamp' => ' ',
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount"' => ' ',
                'PartyA' => ' ',
                'PartyB' => ' ',
                'PhoneNumber' => ' ',
                'CallBackURL' => 'https://ip_address:port/callback',
                'AccountReference' => ' ',
                'TransactionDesc' => ' '
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