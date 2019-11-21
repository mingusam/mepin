<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require (APPPATH . '/libraries/REST_Controller.php');

    class Lnmpcontroller extends REST_Controller{
        public function __construct(){
            parent:: __construct();
            $this->load->model('Transactions');
            $this->load->library('mpesa');
        }
        //lipanampesa
        function index_post(){
            $shortcode = $this->post('shortcode');
            $desc = $this->post('desc');
            $amount = $this->post('amount');
            $phone = $this->post('phone');
            $partya = $phone;
            $partyb = $shortcode;

            $response = $this->mpesa->stkpush($shortcode,$amount,$partya,$partyb,$phone,$desc);
            $output = json_decode($response);
            $merchantid = $output->MerchantRequestID;
            $responsedescription = $output->ResponseDescription;
            $responsecode = $output->ResponseCode;
            $mydate=getdate(date("U"));
            $date = $mydate['mday'].$mydate['month'].$mydate['year'];
            
            if($responsecode == 0){
                $data = array(
                    "merchantRequestID"=>$merchantid,
                    "amount"=>$amount,
                    "transactionDate"=>$date,
                    "phoneNumber"=>$phone,
                    "description"=>$desc,
                    "shortcode"=>$shortcode
                );
                $adddata = $this->Transactions->addLipa($data);
                if($adddata){
                   $merchantresponse = array(
                    "merchantid"=>$merchantid,
                    "responsedesc"=>$responsedescription);
                   echo json_encode(array("response"=>$merchantresponse));
                }
                else{
                    echo json_encode(array("response"=>"No result found"));
                }

            }
        }
    }

?>
