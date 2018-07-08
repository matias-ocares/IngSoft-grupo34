<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class eliminar_perfil extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_user');
        $this->load->model('model_viaje');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('upload');
    }

    public function index() {
        if ($this->session->userdata('logueado')) { //si está logueado
           
            $chofer = $this->model_viaje->viaje_pendiente_chofer();
            $pendiente =$this->model_viaje->viaje_pendiente_pasajero();
            $aprobado =$this->model_viaje->viaje_aprobado_pasajero();
            if(($chofer==TRUE)or($pendiente ==TRUE) or($aprobado==TRUE )){
             redirect('login'); 
            }else{
              $this->model_user->eliminar_usuario();
              
               $usuario_data = array(
                        'logueado' => FALSE
                    );
                    $this->session->set_userdata($usuario_data);
               $this->session->set_flashdata('notifico', 'USUARIO ELIMINADO EXITOSAMENTE.');
               redirect('login');
              
            }
            //parent::index_page('view_editar_perfil', $data);
        } else {
            redirect('login');
        }
    }
}