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
   /* function password_check ($str){
        if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
        return TRUE;
        }
        return FALSE;        
    }
    */
   private function set_flash_campos_register(){
        $campos_data = array(
                    'name' => $this->input->post('name'),
                    'surname' => $this->input->post('surname'),
                    'email' => $this->input->post('email'),
               );
        $this->session->set_flashdata($campos_data);     
    }
    
    public function validation_rules(){
 
        $user=array(
            array(
                'field' => 'name',
                'label' => 'nombre',
                'rules' => 'required|alpha|trim'
            ),
            array(
                'field' => 'surname',
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
    /*public function validar() {
        // basic required field
        $this->form_validation->set_rules('name', 'name', 'required|alpha');
        $this->form_validation->set_rules('surname', 'surname', 'required|alpha');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|callback_existEmail');
        $this->form_validation->set_rules('password', 'password', 'required|min_leght[8]|alphanumeric|callback_password_check');
        $this->form_validation->set_rules('passwordRepeat', 'passwordRepeat', 'required|matches[password]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('fail');
        } else {
            // load success template...
            $this->load->view('success');
        }       
    }*/
    
    public function register() {
        if ($this->input->post()) {
            
            $this->set_flash_campos_register();

            $this->form_validation->set_rules($this->validation_rules());
            
            if ($this->form_validation->run() == TRUE) { 
                
                $user=array(
                    'nombre' => $this->input->post('name'),
                    'apellido' => $this->input->post('surname'),
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
