<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require (APPPATH . '/libraries/REST_Controller.php');
    
    class Business extends REST_Controller{
        public function __construct(){
            parent:: __construct();
            $this->load->model('Business_model');
        }
        //add business
        public function index_post(){
	    $shortcode = $this->post('shortcode');
	    $bizname = $this->post('bizname');
            $bizlocation = $this->post('bizlocation');
            $email = $this->post('email');
            $data = array(
               'business_name'=>$bizname,
               'business_location'=>$bizlocation,
               'shortcode'=>$shortcode,
               'email'=>$email
            );
            $nameinfo = $data['business_name'];
            //check business first
            $checkifbizexisists = $this->Business_model->checkBusiness($nameinfo);
            $response ="";
            //ifbizexists
            if($checkifbizexisists){
                $response ="false";
            }
            //add business
            else{
                $adduser = $this->Business_model->createBusiness($data);
                if($adduser){
                    $response ="true";
                }
                else{
                    $response ="false";
                }
            }
  	    echo $response;
        }
        //get all businesses
        public function index_get(){
            $allbizs = $this->Business_model->getAllBusinesses();
            if($allbizs){
                return $this->response($allbizs,200);
            }
            else{
                return $this->response("No records found",404);
            }
        }
        //delete a business
        function index_delete(){
            $identifier = $this->delete('identifier');
            echo $identifier;
            if($this->Business_model->deleteBiz($identifier)){
                echo "1";
            }
            else{
                echo "0";
            }
        }
    }
?>
