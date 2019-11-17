<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require (APPPATH . '/libraries/REST_Controller.php');
    class Transactionscontroller extends REST_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Transactions');
        }
        function index_get(){
            $shortcode = $this->get('shortcode');
            $getdata = $this->Transactions->getTransactions($shortcode);
            if($getdata){
                //$this->response($getdata);
                echo json_encode(array("transactions"=>$getdata));
            }
            else{
                //$this->response($getdata);
                echo json_encode(array("transactions"=>"No reults found"));
            } 
        }
    }

?>