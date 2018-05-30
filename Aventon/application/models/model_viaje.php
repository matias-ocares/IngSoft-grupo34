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
    public function getViajes($rowno, $rowperpage, $search = "") {
        /*
          if ($search != '') {
          $this->db->like('title', $search);
          $this->db->or_like('content', $search);
          }
         */
        //ordered desc to display the new element at the top
        $this->db->order_by('fecha', 'asc');
        $query = $this->db->get('viaje',$rowperpage,$rowno);

        return $query->result_array();
        //result_array() returns the query result as a pure array, 
        //or an empty array when no result is produced.
    }
    
    public function viaje_por_id($id){
      
      $this->db->where('id_viaje', $id);
      $consulta = $this->db->get('viaje');
      $resultado = $consulta->row(); //This function returns a single result row
      return $resultado;
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

    public function viaje_pertenece_user ($id_viaje, $id_user){
        $this->db->where('id_viaje', $id_viaje);
        $this->db->where('id_chofer', $id_user);
        $amount_results = $this->db->count_all_results('viaje');
        return ($amount_results == 1);
    }
    
}
