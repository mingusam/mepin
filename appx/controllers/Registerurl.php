<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require (APPPATH . '/libraries/REST_Controller.php');
    
    class Registerurl{
        public function __construct(){
            parent:: __construct();
            $this->load->model('Transactions');
            $this->load->library('mpesa');
        }
    }


?>