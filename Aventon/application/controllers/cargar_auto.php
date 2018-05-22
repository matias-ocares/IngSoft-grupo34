<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class cargar_auto extends controller {

    public function __construct() {
        parent::__construct();
        //load model
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_auto');
        //load code igniter library to validate form
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('logueado')) {

            $data = array();
            $data['notifico'] = $this->session->flashdata('notifico');
            parent::index_page('/auto/view_cargar_auto', $data);
        } else {
            redirect('login');
        }
    }

    private function set_flash_campos_auto() {
        $campos_data = array(
            'marca' => $this->input->post('marca'),
            'modelo' => $this->input->post('modelo'),
            'patente' => $this->input->post('patente'),
            'plazas' => $this->input->post('plazas'),
        );
        $this->session->set_flashdata($campos_data);
    }

     function existPatente() {
        $patente = $this->input->post('patente');
        //verifies patente exists in DB
        return (!$this->model_auto->is_registered($patente));
    }

    private function validation_rules() {
        //funcón provada que crea las reglas de validación

        $config = array(
            array(
                'field' => 'marca',
                'label' => 'Marca',
                'rules' => 'required'
            ),
            array(
                'field' => 'modelo',
                'label' => 'Modelo',
                'rules' => 'required'
            ),
            array(
                'field' => 'patente',
                'label' => 'Patente',
                'rules' => 'required|exact_length[6]|alpha_numeric|callback_existPatente'
            ),
            array(
                'field' => 'plazas',
                'label' => 'Plazas',
                'rules' => 'required|min_length[1]|is_natural'
            )
        );
        return $config;
    }

    private function array_auto() {
        $auto = array();
        $auto['marca'] = $this->input->post('marca');
        $auto ['modelo'] = $this->input->post('modelo');
        $auto ['num_patente'] = $this->input->post('patente');
        //$auto['color'] = $this->input->post('marca');
        $auto ['plazas'] = $this->input->post('plazas');
        $auto['id_user'] = $this->session->userdata('id_user'); //con este guardo el id de usuario que obtuve al guardar la sesion iniciada.
        return $auto;
    }

    public function cargar_auto() {
        if ($this->input->post()) {
            $this->set_flash_campos_auto();

            $this->form_validation->set_rules($this->validation_rules());
            if ($this->form_validation->run() == TRUE) {
                $auto = $this->array_auto();
                $this->model_auto->register_auto($auto);
                $this->session->set_flashdata('notifico', 'Se cargó el auto exitosamente.');
                redirect('login/logueado');
            } else {
                $this->session->set_flashdata('notifico', validation_errors());
                redirect('cargar_auto');
            }
        }
    }

}
