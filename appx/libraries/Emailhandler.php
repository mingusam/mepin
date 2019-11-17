<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    
    class Emailhandler{
        protected $CI;
        public function __construct(){
            $this->CI =& get_instance();
        }
        
        public function sendMail($to,$subject,$message){
            // Load PHPMailer library
            $this->CI->load->library('phpmailer_lib');
                
            // PHPMailer object
            $mail = $this->CI->phpmailer_lib->load();
            
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host     = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'Mingusam@gmail.com';
            $mail->Password = '722632126';
            $mail->SMTPSecure = 'ssl';
            $mail->Port     = 465;
            
            $mail->setFrom('Mingusam@gmail.com', 'Samuel Mingu');
            $mail->addReplyTo('Mingusam@gmail.com', 'Samuel Mingu');
            
            // Add a recipient
            $mail->addAddress($to);
            
            
            // Email subject
            $mail->Subject = $subject;
            
            // Set email format to HTML
            $mail->isHTML(true);
            
            // Email body content
            $mailContent = $message;
            $mail->Body = $mailContent;
            
            // Send email
            if($mail->send()){
              return true;
            }else{
              return false;
            }
        }
    }


?>