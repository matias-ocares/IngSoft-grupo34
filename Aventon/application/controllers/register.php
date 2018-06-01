<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/controller.php';

class register extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        //load model
        $this->load->model('model_user');
        //load code igniter library to validate form
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index() {
        $data=array();    
        $data['error'] = $this->session->flashdata('error');
        parent::index_page('view_register',$data);
    }

    function notExistEmail() {
        $email = $this->input->post('email');
        //verifies email exists in DB
        return (!($this->model_user->is_registered($email)));
    }

   private function set_flash_campos_register(){
        $campos_data = array(
                    'nombre' => $this->input->post('nombre'),
                    'apellido' => $this->input->post('apellido'),
                    'email' => $this->input->post('email'),
               );
        $this->session->set_flashdata($campos_data);     
    }
    
    private function validation_rules(){
 
        $user=array(
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'required|alpha|trim'
            ),
            array(
                'field' => 'apellido',
                'label' => 'apellido',
                'rules' => 'required|alpha|trim'
            ),
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'required|callback_notExistEmail|trim'
            ),
            array(
                'field' => 'password',
                'label' => 'contraseña',
                'rules' => 'required',
            ),
            array(
                'field' => 'passwordRepeat',
                'label' => 'repetir contraseña',
                'rules' => 'required|matches[password]'
            ),
                     
        );
        return $user;
        
    } 

    public function register() {
        if ($this->input->post()) {
            
            $this->set_flash_campos_register();

            $this->form_validation->set_rules($this->validation_rules());
            
            if ($this->form_validation->run() == TRUE) { 
                
                $user=array(
                    'nombre' => $this->input->post('nombre'),
                    'apellido' => $this->input->post('apellido'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                );
                $usuario = $this->model_user->register_user($user);
                redirect('login');

            }
            else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('register');
            } 
        } 
        
    }
}
