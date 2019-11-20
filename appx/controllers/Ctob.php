<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require (APPPATH . '/libraries/REST_Controller.php');

    class Ctob extends REST_Controller{
        public function __construct(){
            parent:: __construct();
            $this->load->model('Transactions');
            $this->load->library('mpesa');
        }
        function index_post(){
            $shortcode = $this->post('shortcode');
            $amount = $this->post('amount');
            $phone = $this->post('phone');

            $response = $this->mpesa->c2btransactions($shortcode,$amount,$phone);
            $output = json_decode($response);
        }
    }


?>