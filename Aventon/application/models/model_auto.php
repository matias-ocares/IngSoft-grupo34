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

  /* 
    public function register_auto($auto) {

        $this->db->insert('auto', $auto);
        $this->db->where('num_patente', $auto['num_patente']);
        $amount_results = $this->db->count_all_results('auto');
        return ($amount_results == 1);
        
    }

     
    public function modify_auto($auto, $id_auto) {
        $this->db->where('id_auto', $id_auto);
        $this->db->update('auto', $auto);
        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE);  
    }
    */
       public function guardar($auto, $id_auto = null) {
        if ($id_auto) {
            $this->db->where('id_auto', $id_auto);
            $this->db->update('auto', $auto);
        } else {
            $this->db->insert('auto', $auto);
        }
        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE);
    }

    public function getAutos($rowno, $rowperpage) {
        
        //ordered desc to display the new element at the top
        $this->db->order_by('id_auto', 'desc');
        $query = $this->db->get('auto', $rowperpage, $rowno);
        return $query->result_array();
    }

    public function auto_por_id($id_auto) {

        $this->db->where('id_auto', $id_auto);
        $consulta = $this->db->get('auto');
        $resultado = $consulta->row_array();
        return $resultado;
    }
    
    public function patente_por_id ($id_auto) {
        $this->db->select('num_patente');
        $this->db->where('id_auto', $id_auto);
        $consulta = $this->db->get('auto');
        $resultado = $consulta->row_array();
        return $resultado;
    }

    // Select total records
    public function getrecordCount($id_user) {
        $this->db->where('id_user',$id_user);
        $this->db->from('auto');
        return $this->db->count_all_results();
    }

    public function auto_pertenece_user($id_auto, $id_user) {
        $this->db->where('id_auto', $id_auto);
        $this->db->where('id_user', $id_user);
        $amount_results = $this->db->count_all_results('auto');
        return ($amount_results == 1);
    }
}
