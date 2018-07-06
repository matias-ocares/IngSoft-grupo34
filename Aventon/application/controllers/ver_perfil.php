<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class ver_perfil extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_user');
        $this->load->model('model_solicitud');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
       // $this->load->library('upload');
    }

    public function index() {
       
           $data = array(); 
            parent::index_page('view_ver_perfil', $data);
        
    }
    
    
     public function mi_perfil(){
        $id = $this->session->userdata('id_user');
            $usuario = $this->model_user->user_by_id($id);
            $this->session->set_flashdata('nom',$usuario['nombre']);
            $this->session->set_flashdata('ap',$usuario['apellido']);
            redirect('ver_perfil/');
     }
    public function ver_un_perfil() {
         $id_postulante=$this->uri->segment(3);
        
        $perfil_db = $this->model_user->user_by_id($id_postulante);
            $this->session->set_flashdata('nom',$perfil_db['nombre']);
            $this->session->set_flashdata('ap',$perfil_db['apellido']);
            
           redirect('ver_perfil/'); 
    }
    
    
}