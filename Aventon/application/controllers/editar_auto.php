<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class editar_auto extends controller {

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
            $auto = array( //para probar momentaneamente cargo este arreglo simulando el que seleccioné previamente de mi tabla de autos
                'marca' => 'ford',
                'modelo' => 'focus',
                'num_patente' => 'AG759LH',
                'color' => 'amarillo',);

            $data = array();
            $data['notifico'] = $this->session->flashdata('notifico');
            $this->set_flash_auto_db($auto); //tiene que llegar el arreglo obtenido de la base de datos
            parent::index_page('/auto/view_editar_auto', $data);
        } else {
            redirect('login');
        }
    }

    private function set_flash_auto_db($auto) {
        $ult_campos_data = array(
            'marca' => $auto['marca'],
            'modelo' => $auto['modelo'],
            'num_patente' => $auto['num_patente'],
            'color' => $auto['color'],
        );
        $this->session->set_flashdata($ult_campos_data);
    }

    private function set_flash_campos_auto() {
        $campos_data = array(
            'marca' => $this->input->post('marca'),
            'modelo' => $this->input->post('modelo'),
            'patente' => $this->input->post('patente'),
            'color' => $this->input->post('color'),
        );
        $this->session->set_flashdata($campos_data);
    }

    function existPatente() {
        $patente = $this->input->post('patente');
        if ($this->input->post('patente') == $this->session->flashdata('num_patente')) {
            return true;
        } else {
            //verifies patente exists in DB
            return (!$this->model_auto->is_registered($patente));
        }
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
                'rules' => 'required|min_length[6]|alpha_numeric|callback_existPatente'
            ),
            array(
                'field' => 'color',
                'label' => 'Color',
                'rules' => 'required|alpha'
            )
        );
        return $config;
    }

    private function array_auto() {
        $auto = array();
        $auto['marca'] = $this->input->post('marca');
        $auto ['modelo'] = $this->input->post('modelo');
        $auto ['num_patente'] = $this->input->post('patente');
        $auto ['color'] = $this->input->post('color');
        $auto['id_user'] = $this->session->userdata('id_user'); //con este guardo el id de usuario que obtuve al guardar la sesion iniciada.
        return $auto;
    }

    public function editar_auto() {
        if ($this->input->post()) {
           
            $this->form_validation->set_rules($this->validation_rules());
            $this->set_flash_campos_auto();
            if ($this->form_validation->run() == TRUE) {
                $auto = $this->array_auto();
                if ($this->model_auto->modify_auto($auto) == TRUE) {
                    $this->session->set_flashdata('notifico', 'Se modificó el auto exitosamente.');
                    redirect('login/logueado');
                } else {
                    $this->session->set_flashdata('notifico', 'Por el momento no pudo realizar la modificación.');
                    redirect('login/logueado');
                }
            } else {
                $this->session->set_flashdata('notifico', validation_errors());
                redirect('editar_auto');
            }
        }
    }

}
