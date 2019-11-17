<?php
class User_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }
    public function add_user($data){
        $add = $this->db->insert('user_details',$data);
        if($add){
            return true;
        }
        else{
            return false;
        }
    }
    public function getUserById($id){
        $this->db->select('firstname,lastname,email,idnumber,phonenumber');
        $this->db->from('user_details');
        $this->db->where('idnumber',$id);
        $query = $this->db->get();
        if($query->num_rows() == 1){
            return $query->result_array();
        }
        else{
            return 0;
        }
    }
    public function check_user($cdata){
        $checkdata = $this->db->get_where('user_details',$cdata);
        if($checkdata){
            return $checkdata->row();
        }
        else{
            return false;
        }
    }
    public function user_login($conditions){
        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('email',$conditions['email']);
        $this->db->where('password',$conditions['password']);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result_array();
        }
        else{
            return 0;
        }
    }
    public function view_users(){
        $this->db->select('firstname,lastname,idnumber,,email,password');
        $this->db->from('user_details');
        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result_array();
        }else{
          return 0;
        }
    }
    public function deleteUser($idnumber){
        $this->db->where('idnumber',$idnumber);
        if($this->db->delete('user_details')){
            return true;
        }
        else{
            return false;
        }
    }
}

?>