<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_user extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function is_registered($email) {
        $this->db->where('email', $email);
        $amount_results = $this->db->count_all_results('user');
        return ($amount_results == 1);
    }
    
    public function register_user($user){        
        $this->db->insert('user', $user); 
    }
    
    public function user_by_name_pass($email, $password) {
        $this->db->select('password, email, nombre, apellido, id_user');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function update_user($user) {
        $this->db->where('id_user', $user['id_user']);
        $this->db->update('user', $user);
        $this->db->where('id_user', $user['id_user']);
        $amount_results = $this->db->count_all_results('user');
        return ($amount_results == 1);
        
    }

    
    
    

    

}
