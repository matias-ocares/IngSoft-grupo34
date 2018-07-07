<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_calificacion extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function mostrar_calificacion_as_chofer($id_user){
     $this->db->select('calificacion');
     $this->db->from('calificacion_chofer');
     $this->db->where('id_chofer', $id_user);
     $query = $this->db->get();
     $resultado = $query->result_array();
     $valor=0;   
     foreach ($resultado as $id){ 
                $valor += $id['calificacion'];
     }
            
     return $valor;   
        
    }
    
     public function mostrar_calificacion_as_pasajero($id_user){
     $this->db->select('calificacion');
     $this->db->from('calificacion_pasajero');
     $this->db->where('id_pasajero', $id_user);
     $query = $this->db->get();
     $resultado = $query->result_array();
     $valor=0;   
     foreach ($resultado as $id){ 
                $valor += $id['calificacion'];
     }
     return $valor;      
        
        
    }
    
   public function calificar_como_chofer($calificacion){
        $this->db->insert('calificacion_pasajero', $calificacion);
   } 
    
 
}
