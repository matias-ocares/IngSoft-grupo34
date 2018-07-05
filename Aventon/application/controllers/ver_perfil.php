<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class ver_perfil extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_user');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('upload');
    }

    public function index() {
        if ($this->session->userdata('logueado')) { //si está logueado
            $id = $this->session->userdata('id_user');
            $perfil_db = $this->model_user->user_by_id($id);
            $this->session->set_flashdata($perfil_db);
            $data = array();
            parent::index_page('view_ver_perfil', $data);
        } else {
            redirect('login');
        }
    }
}