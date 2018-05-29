<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_user extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_users() {
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    public function is_registered($email) {
        $this->db->where('email', $email);
        $amount_results = $this->db->count_all_results('user');
        return ($amount_results == 1);
    }

    public function user_by_name_pass($email, $password) {
        $this->db->select('password, email, nombre, apellido, id_user');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
        //$resultado = $consulta->result();
      //return $resultado;
    }
    

    public function register_user($user){        
        $this->db->insert('user', $user); 
    }
    
    
            public function get_contents() {
                $this->db->select('*');
                $this->db->from('user');
                $query = $this->db->get();
                return $result = $query->result();
            }


            public function entry_update( $id ) {

                $this->db->select('*');
                $this->db->from('user');
                $this->db->where('id_user',$id );
                $query = $this->db->get();
                return $result = $query->row_array();

            }
            public function entry_update1($id) {
              $data = array(

        'name' => $this->input->post('name'),
        'surname' => $this->input->post('surname'),
        'email' => $this->input->post('email')
                );

                 $this->db->where('id_user', $id);
                $this->db->update('user', $data);

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
