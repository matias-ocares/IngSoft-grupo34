<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/controller.php';

class register extends controller {

    public function __construct() {
        parent::__construct();
        //load model
        $this->load->model('model_user');
        //load code igniter library to validate form
        $this->load->library('form_validation');
    }

    public function index() {
        parent::index_page('view_register');
    }

    function existEmail() {
        $email = $this->input->post('email');
        //verifies email exists in DB
        return (!($this->model_user->is_registered($email)));
    }

    public function validar() {
        // basic required field
        $this->form_validation->set_rules('name', 'name', 'required|alpha');
        $this->form_validation->set_rules('surname', 'surname', 'required|alpha');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|callback_existEmail');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('passwordRepeat', 'passwordRepeat', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('fail');
        } else {
            // load success template...
            $this->load->view('success');
        }
    }

}
