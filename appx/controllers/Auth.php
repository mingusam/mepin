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
         $data = array(
             'firstname' => $this->post('firstname'),
             'lastname' => $this->post('lastname'),
             'email' => $this->post('email'),
             'password' => $this->post('password'),
             'phonenumber' => $this->post('phone'),
             'idnumber' => $this->post('idnumber')
         );
         $subject = "Response";
         $message = "You have registered successfully";
         $cdata = array('idnumber' => $this->post('idnumber'));
         $checkuser = $this->User_model->check_user($cdata);
         if($checkuser != false){
             echo "0";
         }
         else{
            $add = $this->User_model->add_user($data);
            if($add != false){
                $to = $data['email'];
                $subject = "Success";
                $message = "Registration Successful";
                // Load PHPMailer library
                if($this->emailhandler->sendMail($to,$subject,$message)){
                    echo "Message sent successfully";
                }
                else{
                    echo "Message could not be sent";
                }
            }
            else{
                //$response = array('message'=>'User not created successfully');
                echo "2"; 
            }
         } 
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
         $idnumber = $this->delete('identity'); 
         if($this->User_model->deleteUser($idnumber)){
             echo "User deleted successfully";
         }
         else{
             echo "User could not be deleted";
         }
     }
     
 }

?>
