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
            $data = array(
               'idnumber'=>$this->post('idnumber'),
               'business_name'=>$this->post('bizname'),
               'business_location'=>$this->post('bizlocation'),
               'business_type'=>$this->post('biztype'),
               'shortcode'=>$this->post('shortcode')
            );
            $nameinfo = $data['business_name'];
            //check business first
            $checkifbizexisists = $this->Business_model->checkBusiness($nameinfo);
            //ifbizexists
            if($checkifbizexisists){
                echo "2";
            }
            //add business
            else{
                $adduser = $this->Business_model->createBusiness($data);
                if($adduser){
                    echo "1";
                }
                else{
                    echo "0";
                }
            }
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