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
    
    function eliminar_auto($id_auto){ 
        $this->db->select('id_viaje');
        $this->db->where('id_auto', $id_auto);
        $this->db->where('estado',0);
        $consulta = $this->db->get('viaje');
        $resultado = $consulta->result_array();
        foreach ($resultado as $viaje){
            $this->consulta_estado_postulacion($viaje['id_viaje']);
            $this->eliminar_viaje($viaje['id_viaje']);            
        }
        $this->db->where('id_auto',$id_auto);
        $this->db->set('estado',1);
        $this->db->update('auto');
    }
    
    function consulta_estado_postulacion($id){           
        $this->db->where('id_viaje', $id);
        $this->db->where('id_estado', 2);  
        $this->db->select('id_user');        
        $consulta = $this->db->get('postulacion_viaje');
        $resultado = $consulta->result_array(); 
        foreach ($resultado as $user){
            $resultado = $this->restar_reputacion($this->session->userdata('id_user'),$user['id_user'],$id);
            $this->reanudar_solicitudes_inactivas($user['id_user'],$id);
            $this->eliminar_postulacion($id,$user['id_user']);
            
        }        
    }
   function reanudar_solicitudes_inactivas($id_pasajero,$id_viaje){
        $this->db->select('fecha,hora_inicio,duracion_horas');
        $this->db->where('id_viaje',$id_viaje);
        $viaje = $this->db->get('viaje');
        $resultado=$viaje->result_array(); 
        foreach ($resultado as $viaje){
            $this->get_postulaciones($id_pasajero,$viaje['fecha'], $viaje['duracion_horas'], $viaje['hora_inicio'],1,4);
        }
        

    }
    function eliminar_postulacion($id_viaje,$id_user){
        $this->db->where('id_viaje',$id_viaje);
        $this->db->delete('postulacion_viaje');
    }
    
    public function get_postulaciones($id_postulante,$fecha,$hora, $dura, $valor, $valorActual ){
        $this->db->select('fecha,hora_inicio,viaje.id_viaje, user.id_user');
        $this->db->join('viaje', 'viaje.id_viaje = postulacion_viaje.id_viaje', 'inner');
        $this->db->join('user', 'user.id_user = postulacion_viaje.id_user', 'inner');
        $this->db->where('postulacion_viaje.id_user', $id_postulante);
        $this->db->where('id_estado', $valorActual);
        $this->db->where('fecha', $fecha);
        
        //$this->db->order_by('fecha', 'asc');
        $query = $this->db->get('postulacion_viaje');

        $resultado=$query->result_array(); 
        $fecha_inicio = $fecha;
        $hora_inicio = $hora;
        $duracion = $dura;
  
        foreach ($resultado as $id){
             if($this->postulacion_valida_antes($id['id_viaje'], $fecha_inicio, $hora_inicio) or $this->postulacion_valida_despues($id['id_viaje'], $fecha_inicio, $hora_inicio, $duracion) or $this->postulacion_valida_entre($id['id_viaje'], $fecha_inicio, $hora_inicio, $duracion)){
            //$valor= 4;
            $this-> setear_postulacion($id['id_viaje'], $id_postulante, $valor);
            }          
        }  
    }
 
    public function setear_postulacion($id_viaje, $id_postulante, $valor){
       $this->db->where('id_viaje', $id_viaje);
       $this->db->where('id_user', $id_postulante);
       $data['id_viaje']= $id_viaje;
       $data['id_user']= $id_postulante;
       $data['id_estado']= $valor;
        $this->db->update('postulacion_viaje', $data);
      
    }  
 
    //Elimina el viaje, seteando el estado del viaje de 0 a 1
    function eliminar_viaje($id){
        $this->db->where('id_viaje', $id);
        $this->db->set('estado',1);
        $this->db->update('viaje');
    }




    
}
