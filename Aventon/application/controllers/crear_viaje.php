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
        if ($this->session->userdata('logueado')) {

            $data = array();
            $data['notifico'] = $this->session->flashdata('notifico');
            parent::index_page('/viaje/view_crear_viaje', $data);
        } else {
            redirect('login');
        }
    }
}