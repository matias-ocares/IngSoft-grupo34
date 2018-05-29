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

    
}