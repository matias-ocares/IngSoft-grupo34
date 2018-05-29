<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class editar_perfil extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_user');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }
        public function index() {
        $data=array();    
        $data['error'] = $this->session->flashdata('error');
        parent::index_page('view_editarPerfil',$data);
    }
    public function edit() {
        $data = array();
        $get = $this->uri->uri_to_assoc();
        $data['user'] = $this->model_user->entry_update( $get['id'] );
        $this->load->view('view_editarPerfil', $data);
            if ($this->input->post('submit')) {
                $this->usermodel->entry_update1($get['id']);
            }
        }
    

     
 

}


    


