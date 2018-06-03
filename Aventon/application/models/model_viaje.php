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
        $viaje['fecha']= 2018-06-27;
        $viaje['id_user']= 2;
        $mifecha = date("Y-m-d", strtotime($viaje['fecha']));
        $this->db->select('hora_inicio, duracion_horas');
        $this->db->from('viaje');
        $this->db->where('fecha', $mifecha);
        $id= $viaje['id_user'];
        $this->db->where('id_chofer', $id); //habría que redefinir si id_chofer es id_user
        $consulta = $this->db->get();
       // $resultado = $consulta->row();
       $resultado = $consulta->result();
      //return $resultado;
       $amount_results = $this->db->count_all_results('viaje');
        
        if ($amount_results == 1 ) {
            $hora = $resultado->hora_inicio;
            $arrayHora = explode(":", $hora);
            
            $duracion = $resultado->duracion_horas;
            $inicio = ((int)$arrayHora[0] + (int)$arrayHora[1]) - ((int)$duracion);
            $fin = ((int)$arrayHora[0] + (int)$arrayHora[1]) + ((int)$duracion);
            $array = explode(":", $viaje['hora']);
            $sumo=(int)$array[0] + (int)$array[1];
            if (in_array($sumo, range($inicio, $fin))) {
                return FALSE;
            } else {
                return FALSE;
            }
        }
        return TRUE;
    }

    public function register_viaje($viaje) {
         $this->db->set($viaje);
        $this->db->insert('viaje');
        $this->db->where('id_chofer', $viaje['id_chofer']); //PENDIENTE - Cómo consulto si ese viaje fue creado.
        $this->db->where('fecha', $viaje['fecha']);
        $amount_results = $this->db->count_all_results('viaje');
        return ($amount_results == 1);
    }
    
    public function consulta_id_auto($patente){
        $this->db->select('id_auto');
      $this->db->from('auto');
      $this->db->where('num_patente', $patente);
      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
        
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
    public function registrar_ids($id){
        /*$id['id_user']='1';
        $id['id_auto']='1';
        $id['id_viaje']='1';*/
        
        $this->db->insert('id', $id);
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

}
