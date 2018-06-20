<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_viaje extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getMisAutos() { //para listar mis autos en el formulario de Crear Viaje

        $id = $this->session->userdata('id_user');

        $this->db->from('auto');
        $this->db->where('id_user', $id);
        $this->db->select('marca, modelo, num_patente, id_auto');

        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function is_registered($viaje){
            // Obtengo los datos del viaje pasado por parámetro en variables
            $fecha_inicio = $viaje['fecha'];
            $hora_inicio = $viaje['hora'];
            $duracion = $viaje['duracion'];
            $id_chofer = $viaje['id_chofer'];
            
            // Pregunto si se superpone al inicio
            $superpone_inicio = $this->db->query("SELECT id_viaje FROM viaje WHERE id_chofer=$id_chofer AND cast(concat('$fecha_inicio',' ','$hora_inicio') as datetime) BETWEEN cast(concat(fecha,' ',hora_inicio) as datetime) AND DATE_ADD(cast(concat(fecha,' ',hora_inicio) as datetime), INTERVAL duracion_horas hour)");
            $resultado = $superpone_inicio->row_array();
            
            return $resultado;
    }

     
    
    //registra viaje en BD, insert
    public function register_viaje($viaje) {
        $this->db->insert('viaje', $viaje);

        $this->db->trans_complete();
        return ($this->db->trans_status() === TRUE);
    }


    public function consulta_id_viaje($viaje){
        $this->db->select('id_viaje');
      $this->db->from('viaje');
      $this->db->where('fecha', $viaje['fecha']);
      $this->db->where('hora_inicio', $viaje['hora_inicio']);
      $this->db->where('id_chofer', $viaje['id_chofer']);
      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
        
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
        $query = $this->db->get('viaje', $rowperpage, $rowno);

        return $query->result_array();
        //result_array() returns the query result as a pure array, 
        //or an empty array when no result is produced.
    }

    public function viaje_por_id($id) {

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

    public function viaje_pertenece_user($id_viaje, $id_user) {
        $this->db->where('id_viaje', $id_viaje);
        $this->db->where('id_chofer', $id_user);
        $amount_results = $this->db->count_all_results('viaje');
        return ($amount_results == 1);
    }
    
    function eliminar_viaje($id){
        $this->db->where('id_viaje',$id);
        return $this->db->delete('viaje');
    }

}
