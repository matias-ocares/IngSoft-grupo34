<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class viaje extends controller {

    public function __construct() {
        parent::__construct();
        //load model
        $this->load->model('model_viaje');
        //load code igniter library to validate form
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }
    
     public function index() {
        $data = array();
        $data['error'] = $this->session->flashdata('error');
        parent::index_page('view_viaje', $data);
    }
