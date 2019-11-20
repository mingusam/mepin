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
    public function getUserById($email){
        $this->db->select('firstname,lastname,email,phonenumber');
        $this->db->from('user_details');
        $this->db->where('email',$email);
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
    public function deleteUser($email){
        $this->db->where('email',$email);
        if($this->db->delete('user_details')){
            return true;
        }
        else{
            return false;
        }
    }
}

?>
