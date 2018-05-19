<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_user extends CI_Model {
    public function __construct()
    {   parent::__construct();
        $this->load->database();
    }
    
    public function get_users()
    {
        $query = $this->db->get('user');
        if($query->num_rows() > 0){
            $result = $query->result_array();
            return $result;
        }else{
            return false;
        }
    }
    
    public function is_registered($email){
        $this->db->where('email',$email);
        $amount_results = $this->db->count_all_results('user');
        return ($amount_results==1);
    }
    
     public function validate_credentials($email, $pass){
        $this->db->where('email',$email);
        $this->db->where('password',$pass);
        $amount_results = $this->db->count_all_results('user');
        return ($amount_results==1);
    }
     
    /*
    public function is_register($email){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email',$email);
        //$this->db->where('user_password',$pass);
 
         if($query=$this->db->get())
            {
                return $query->row_array();
            }
        else{
             return false;
            }         
    }
     */ 
     
    
}


