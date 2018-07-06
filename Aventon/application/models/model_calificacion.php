<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_calificacion extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function mostrar_calificacion_as_chofer($id_user){
     $this->db->select('calificacion');
     $this->db->from('calificacion_chofer');
     $this->db->where('id_chofer', $id_user);
     $query = $this->db->get();
     $resultado = $query->result_array();
     $valor=0;   
     foreach ($resultado as $id){ 
                $valor += $id['calificacion'];
     }
            
     return $valor;   
        
    }
    
     public function mostrar_calificacion_as_pasajero($id_user){
     $this->db->select('calificacion');
     $this->db->from('calificacion_pasajero');
     $this->db->where('id_pasajero', $id_user);
     $query = $this->db->get();
     $resultado = $query->result_array();
     $valor=0;   
     foreach ($resultado as $id){ 
                $valor += $id['calificacion'];
     }
     return $valor;      
        
        
    }
    
    
    
  /*  public function is_registered($email) {
        $this->db->where('email', $email);
        $amount_results = $this->db->count_all_results('user');
        return ($amount_results == 1);
    }

    public function register_user($user) {
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

    public function update_user($user, $id) {
        $this->db->where('id_user', $id);
        $this->db->update('user', $user);
        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE);
    }
    

    public function user_by_id($id) {
        //retorno todos los datos de un user, por "id"   
        $this->db->where('id_user', $id);
        $consulta = $this->db->get('user');
        $resultado = $consulta->row_array();
        return $resultado;
    }
*/
}
