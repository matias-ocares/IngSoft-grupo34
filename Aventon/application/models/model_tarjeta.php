<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_tarjeta extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function registrar_tarjeta($tarjeta) {
        $this->db->insert('tarjeta', $tarjeta);
        $this->db->where('id_user', $this->session->userdata('id_user'));
    }

    public function is_registered($numero) {
        $this->db->where('numero', $numero);
        $this->db->where('activo',1);
        $amount_results = $this->db->count_all_results('tarjeta');
        return ($amount_results == 1);
    }

    public function tarjeta_cargada($id) {
        $this->db->where('id_user', $id);
        $this->db->where('activo',1);
        $amount_results = $this->db->count_all_results('tarjeta');
        return ($amount_results == 1);
    }
    
    public function is_registered_por_id($id) {
        $this->db->where('id_user', $id);
        $this->db->where('activo',1);
        $amount_results = $this->db->count_all_results('tarjeta');
        return ($amount_results == 1);
    }
    
    public function consulta_fecha($id){
        $this->db->select('fecha');
        $this->db->from('tarjeta');
        $this->db->where('id_user', $id);
        $this->db->where('activo',1);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
                
    }
    
    public function monto_disponible($id){
        $this->db->select('monto');
        $this->db->from('tarjeta');
        $this->db->where('id_user', $id);
        $this->db->where('activo',1);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function eliminar_tarjeta($id_tarjeta){
        $this->db->where('id_tarjeta',$id_tarjeta);
        // Hago un borrado lógico de la tarjeta para no perder, las relaciones en la tabla "registro_pago"
        $estado = array('activo' => 0);
        $this->db->update('tarjeta', $estado);     
    }
   
    public function consultar_tarjeta($id_user) { 
        $this->db->where('id_user', $id_user);
        $this->db->where('activo',1);
        $consulta = $this->db->get('tarjeta');
        //$resultado = $consulta->row_array();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function actualizar_tarjeta($tarjeta,$id_user){
        $this->db->where('id_user', $id_user);
        $this->db->where('activo',1);
        $this->db->update('tarjeta',$tarjeta);
    }

}
