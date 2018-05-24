<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_viaje extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // cuando se implemente las búsquedas $search debería ser un array, 
    // ya que hay más de un criterio (orígen, destino, fecha, etc) 
    public function getData($rowno, $rowperpage, $search = "") {

        //Add columns to be displayed on table
        $this->db->select('id_viaje, origen, destino, fecha, hora_inicio, duracion_horas');
        $this->db->from('viaje');

        /*
          if ($search != '') {
          $this->db->like('title', $search);
          $this->db->or_like('content', $search);
          }
         */
        $this->db->limit($rowperpage, $rowno);
        //ordered desc to display the new element at the top
        $this->db->order_by('id_viaje', 'desc');
        $query = $this->db->get();

        return $query->result_array();
        //result_array() returns the query result as a pure array, 
        //or an empty array when no result is produced.
    }

    // Select total records
    public function getrecordCount($search = "") {

        $this->db->from('viaje');

        /*
        if ($search != '') {
            $this->db->like('origen', $search);
            $this->db->and_like('content', $search);
        }
        */
        return $this->db->count_all_results();
    }

}
