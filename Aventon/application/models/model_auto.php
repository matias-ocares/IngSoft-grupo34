<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_auto extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function is_registered($patente) {
        $this->db->where('num_patente', $patente);
        $amount_results = $this->db->count_all_results('auto');
        return ($amount_results == 1);
    }

    public function register_auto($auto) {

        $this->db->insert('auto', $auto);
        $this->db->where('num_patente', $auto['num_patente']);
        $amount_results = $this->db->count_all_results('auto');
        return ($amount_results == 1);
        
    }

  
}
