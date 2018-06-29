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
        $amount_results = $this->db->count_all_results('tarjeta');
        return ($amount_results == 1);
    }

    public function tarjeta_cargada($id) {
        $this->db->where('id_user', $id);
        $amount_results = $this->db->count_all_results('tarjeta');
        return ($amount_results == 1);
    }
    
    public function is_registered_por_id($id) {
        $this->db->where('id_user', $id);
        $amount_results = $this->db->count_all_results('tarjeta');
        return ($amount_results == 1);
    }
    
    public function consulta_fecha($id){
        $this->db->select('fecha');
        $this->db->from('tarjeta');
        $this->db->where('id_user', $id);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
                
    }
    
    public function monto_disponible($id){
        $this->db->select('monto');
        $this->db->from('tarjeta');
        $this->db->where('id_user', $id);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    public function eliminar_tarjeta($id_tarjeta){
        $this->db->where('id_tarjeta',$id_tarjeta);
        $this->db->delete('tarjeta');
    }

}
