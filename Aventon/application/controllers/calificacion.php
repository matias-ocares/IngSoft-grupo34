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
         
        $data['error'] = $this->session->flashdata('error');
        $data['exito'] = $this->session->flashdata('exito');
        //parent::index_page('viaje/view_viaje_info', $data);
        
        parent::index_page('view_calificar', $data);
        
            
        }  
         
     
     
     
     
    public function ver_un_perfil() {
         $id_viaje=$this->uri->segment(3);
         $id_postulante=$this->uri->segment(3);
        
        $perfil_db = $this->model_user->user_by_id($id_postulante);
            $this->session->set_flashdata('nom',$perfil_db['nombre']);
            $this->session->set_flashdata('ap',$perfil_db['apellido']);
            $calif_chofer = $this->model_calificacion->mostrar_calificacion_as_chofer($id_postulante);
            $calif_pasajero = $this->model_calificacion->mostrar_calificacion_as_pasajero($id_postulante);
            $this->session->set_flashdata('calif_chofer',$calif_chofer);
            $this->session->set_flashdata('calif_pasajero',$calif_pasajero);
            
            
           redirect('ver_perfil/'); 
    }
    
    
  
        
    
    
}