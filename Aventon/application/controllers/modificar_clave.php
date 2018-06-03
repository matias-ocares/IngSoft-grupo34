<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class modificar_clave extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_user');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }
    public function index() {
        if ($this->session->userdata('logueado')) { //si está logueado
            $id = $this->session->userdata('id_user');
            $perfil_db = $this->model_user->user_by_id($id);
            $this->session->set_flashdata($perfil_db);
            $data = array();
            parent::index_page('view_modificar_Clave', $data);
        } else {
            redirect('login');
        }
    }
    
    
    function coincideClave() {
        $new_password = $this->input->post('password');
        $old_password = $this->session->userdata('password');
        if ($email_post == $email_session) {
            return TRUE;
        } else {
            //verifies email no existe in DB
            return (!$this->model_user->is_registered($email_post));
        }
    }

        
}
    
   

