<?php
    class Business_model extends CI_model{
        
        public function __construct(){
          $this->load->database();
        }
        //add business
        public function createBusiness($data){
          $addbiz = $this->db->insert('business_details',$data);
          if($addbiz){
              return true;
          }
          else{
              return false;
          }
        }
        //get business owner
        public function getBusinessByOwner($email){
            $this->db->select('business_name,business_location,shortcode');
            $this->db->from('business_details');
            $this->db->where('email',$email);
            $query = $this->db->get();
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else{
                return 0;
            }
        }
        //get all businesses
        public function getAllBusinesses(){
            $this->db->select('*');
            $this->db->from('business_details');
            $query = $this->db->get();
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else{
                return 0;
            }
        }
        //delete business
        public function deleteBiz($identifier){
           $this->db->where('id',$identifier);
           if($this->db->delete('business_details')){
               return true;
           }
           else{
               return false;
           }
        }
        //check business 
        public function checkBusiness($nameinfo){
            $this->db->select('business_name');
            $this->db->from('business_details');
            $this->db->where('business_name',$nameinfo);
            $checkbiz = $this->db->get();
            if($checkbiz->num_rows()>0){
                return $checkbiz->row();
            }
            else{
                return false;
            }
        }
        //edit business
    }
?>