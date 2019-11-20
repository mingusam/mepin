<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 require (APPPATH . '/libraries/REST_Controller.php');

 class Login extends REST_Controller {
    public function __construct(){
        parent:: __construct();
        $this->load->model('User_model');
    }
    function index_post(){
        $email = $this->post('email');
        $password = md5($this->post('password'));
        $response = "";
        $conditions = array(
           'email' => $email,
           'password' => $password
        );
        $logdata = $this->User_model->user_login($conditions);
        if($logdata){
            $response = "true";
        }
        else{
            $response = "false";
        }
        echo $response;
    }
    function index_get(){
        $email = $this->post('email');
        $getuser = $this->User_model->getUserById($email);
        if($getuser){
            echo json_encode(array("user"=>$getuser));
        }
        else{
            echo json_encode("No records found",404);
        }
    }        
 }
 ?>
