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
    
    function create() {
        $data = array('title' => 'Add Page', 'form' => NULL);
        $this->load->view('form', $data);
}
        
    function edit() {
        $sql  = 'SELECT id_user, nombre, apellido, email ';
        $sql .= '  FROM user WHERE id_user = ?';
        $sql_params = array($id);
        $query = $this->db->query($sql, $sql_params);
        $form = $query->row_array();

        redirect('register');
    }
    
    

     
 

}


    


