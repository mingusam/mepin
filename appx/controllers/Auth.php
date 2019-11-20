<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 require (APPPATH . '/libraries/REST_Controller.php');

 class Auth extends REST_Controller {
     //Base class
     public function __construct(){
         parent:: __construct();
         $this->load->model('User_model');
         $this->load->library('emailhandler');
     }
     //add users
     function index_post(){
	     $firstname = $this->post('firstname');
         $lastname = $this->post('lastname');
	     $email = $this->post('email');
	     $password = md5($this->post('password'));
         $phonenumber = $this->post('phone');
         $data = array(
             'firstname' => $firstname,
             'lastname' => $lastname,
             'email' => $email,
             'password' => $password,
             'phonenumber' => $phonenumber
         );
         $response = "";
         $cdata = array(
               'email' => $email
         );
         $checkuser = $this->User_model->check_user($cdata);
         if($checkuser == true){
             $response ="false";
         }
         else{
            $add = $this->User_model->add_user($data);
            if($add){
                $response = "true";
            }
            else{
                //$response = array('message'=>'User not created successfully');
                $response ="false";
            }
         } 
         echo $response;
     }
     //get all users
     function index_get(){
         $result = $this->User_model->view_users();
         if($result){
             echo json_encode(array("users"=>$result));
         }
         else{
             echo json_encode("No records found",404);
         }
     }
     //delete a user
     function index_delete(){
         $email = $this->delete('email'); 
         if($this->User_model->deleteUser($email)){
             echo "User deleted successfully";
         }
         else{
             echo "User could not be deleted";
         }
     }
     
 }

?>
