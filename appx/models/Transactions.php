<?php
    class Transactions extends CI_Model{
        //constructor
        public function __construct(){
            //load database
            $this->load->database();
        }
        //get all transactions
        public function getAllTransactions(){
            $this->db->select('*');
            $this->db->from('lipanampesa');
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result_array();
            }
            else{
                return 0;
            }
        }
        public function getStatus($merchantid){
	    $this->db->select('ResultDesc,mpesaReceiptNumber,description');
            $this->db->from('lipanampesa');
            $this->db->where('merchantRequestID',$merchantid);
            $query = $this->db->get();
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else{
                return 0;
            }
        }
        public function getTransactions($shortcode){
            $this->db->select('*');
            $this->db->from('lipanampesa');
            $this->db->where('shortcode',$shortcode);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result_array();
            }
            else{
                return 0;
            }
        }
        public function addLipa($data){
            $addtransaction = $this->db->insert('lipanampesa',$data);
            if($addtransaction){
                return true;
            }
            else{
                return false;
            }
        }
    }

?>
