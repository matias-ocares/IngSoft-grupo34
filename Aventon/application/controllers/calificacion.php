<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class calificacion extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_user');
        $this->load->model('model_viaje');
        $this->load->model('model_calificacion');
        $this->load->model('model_solicitud');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
       // $this->load->library('upload');
    }

    public function index() {
       
           $data = array(); 
            parent::index_page('view_calificar', $data);
        
    }
    
    
     public function ver_calificar_como_chofer(){
        $viaje_id=$this->uri->segment(3);
        $id_postulante=$this->uri->segment(4);
        $id_user= $this->session->userdata('id_user');
        
        
        $calificado= $this->model_user->user_by_id($id_postulante); 
        $calificador= $this->model_viaje->chofer_por_id($viaje_id);
        $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);
         $data['minombre']=$calificador->nombre;
         $data['miapellido']=$calificador->apellido;
         $data['sunombre']=$calificado['nombre'];
         $data['suapellido']=$calificado['apellido'];
         $data['id_postulante']=$id_postulante;
        $data['error'] = $this->session->flashdata('error');
        $data['exito'] = $this->session->flashdata('exito');
        //parent::index_page('viaje/view_viaje_info', $data);
        
        parent::index_page('view_calificar_como_chofer', $data);
        
            
        }
        
        public function calificar_como_chofer(){
        $calificacion['id_viaje'] = $this->input->post('id_viaje');
        $calificacion['id_pasajero'] = $this->input->post('id_postulante');
        $calificacion['id_chofer'] = $this->input->post('id_chofer');
        $calificacion['comentario'] = $this->input->post('comentario');
        $valor=$this->input->post('califica');
        if($valor == 'positivo'){
        $calificacion['calificacion'] = 1;
        }
        else
        if($valor == 'negativo'){
               $calificacion['calificacion'] = -1; 
        }else
        if($valor == 'neutro'){
        $calificacion['calificacion'] = 0;      
                }
        $this->model_calificacion->calificar_como_chofer($calificacion);        
        
      
            
            
            
        }
         
     
     
   
    
    
}