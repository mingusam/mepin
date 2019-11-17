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
        $password = $this->post('password');
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
        $id = $this->get('identity');
        $getuser = $this->User_model->getUserById($id);
        if($getuser){
            $this->response($getuser);
        }
        else{
            echo "No user found";
        }
    }        
 }
 ?>
