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

}
