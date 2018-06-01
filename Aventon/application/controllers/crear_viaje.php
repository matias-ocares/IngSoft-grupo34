<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class crear_viaje extends controller {

    public function __construct() {
        parent::__construct();
        //load model
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_viaje');
        //load code igniter library to validate form
        $this->load->library('form_validation');
        $this->load->helper('url');
        
    }

    public function index() {
        if ($this->session->userdata('logueado')) { //aca tambien se pregunta si tiene un auto asociado,sino no le permite crear viaje

            $data = array();
            $data['title']= 'Auto';
            $data['groups'] = $this->model_viaje->getMisAutos();
            $data['notifico'] = $this->session->flashdata('notifico');
            parent::index_page('/viaje/view_crear_viaje', $data);
        } else {
            redirect('login');
        }
    }
    
    private function set_flash_campos_viaje() {
        $campos_data = array(
            'origen' => $this->input->post('origen'),
            'destino' => $this->input->post('destino'),
            'fecha' => $this->input->post('fecha'),
            'hora' => $this->input->post('hora'),
            'duracion_horas' => $this->input->post('duracion'),
            'costo' => $this->input->post('costo'),
            'plazas' => $this->input->post('plazas'),
            'auto' => $this->input->post('auto'),
        );
        $this->session->set_flashdata($campos_data);
    }
    
     private function validation_rules() {
        //funcón provada que crea las reglas de validación

        $config = array(
            array(
                'field' => 'origen',
                'label' => 'Origen',
                'rules' => 'required|alpha'
            ),
            array(
                'field' => 'destino',
                'label' => 'Destino',
                'rules' => 'required|alpha'
            ),
            array(
                'field' => 'fecha',
                'label' => 'Fecha',
                'rules' => 'required'
            ),
            array(
                'field' => 'hora',
                'label' => 'Hora',
                'rules' => 'required'
            ),
            array(
                'field' => 'duracion',
                'label' => 'Duracion',
                'rules' => 'required'
            ),
            array(
                'field' => 'costo',
                'label' => 'Costo',
                'rules' => 'required'
            ),
            array(
                'field' => 'auto',
                'label' => 'Auto',
                'rules' => 'required'
            ),
            array(
                'field' => 'plazas',
                'label' => 'Plazas',
                'rules' => 'required'
            )
        );
        return $config;
    }
    
    private function array_viaje() {
        $viaje = array();
        $auto['origen'] = $this->input->post('origen');
        $auto ['destino'] = $this->input->post('destino');
        $auto ['fecha'] = $this->input->post('fecha');
        $auto ['hora_inicio'] = $this->input->post('hora');
        $auto['duracion_horas'] = $this->session->userdata('duracion'); 
        $auto['costo'] = $this->session->userdata('costo');
        $auto['plazas_total'] = $this->session->userdata('plazas');
        $auto['plazas_libre'] = $this->session->userdata('plazas');
        $auto['id_auto'] = $this->session->userdata('id_auto');//PENDIENTE tengo que ver de dónde obtengo ese id para asociarlo al viaje
        $auto['id_user'] = $this->session->userdata('id_user');//con este guardo el id de usuario que obtuve al guardar la sesion iniciada.
        return $viaje;
    }
    public function crear_viaje() {
        if ($this->input->post()) {
            $this->set_flash_campos_viaje();

            $this->form_validation->set_rules($this->validation_rules());
            if ($this->form_validation->run() == TRUE) {
                $viaje = $this->array_viaje();
               if( $this->model_viaje->register_viaje($viaje)== TRUE) {
                $this->session->set_flashdata('notifico', 'Se cargó el viaje exitosamente.');
               redirect('login/logueado');}
               else {
                   $this->session->set_flashdata('notifico', 'Por el momento no pudo cargarse el viaje.');
               redirect('login/logueado');}
        }
             else {
                $this->session->set_flashdata('notifico', validation_errors());
                redirect('crear_viaje');
            }
        }
    }
     
    
}