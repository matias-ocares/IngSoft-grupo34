<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class login extends controller {

    public function __construct() {
        parent::__construct();
        //load model
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_user');
        //load code igniter library to validate form
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index() {


        $data = array();
        $data['error'] = $this->session->flashdata('error');
        parent::index_page('view_login', $data);
    }

    function existEmail() {
        $email = $this->input->post('email');
        //verifies email exists in DB
        return ($this->model_user->is_registered($email));
    }

    private function validation_rules() {
        //función privada que crea las reglas de validación

        $config = array(
            array(
                'field' => 'email',
                'label' => 'Correo electrónico',
                'rules' => 'required|valid_email|callback_existEmail'
            ),
            array(
                'field' => 'password',
                'label' => 'Contraseña',
                'rules' => 'required|min_length[8]'
            )
        );
        return $config;
    }
    
    private function set_flash_campos_login(){
       $campos_data = array(
                        'email' => $this->input->post('email'),
                       // 'password' => $this->input->post('password')
               );
           $this->session->set_flashdata($campos_data);           
    
    }
    public function login() {

        if ($this->input->post()) {
            
            $this->set_flash_campos_login();

            $this->form_validation->set_rules($this->validation_rules());

            if ($this->form_validation->run() == TRUE) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $usuario = $this->model_user->user_by_name_pass($email, $password);
                
                
                if ($usuario) {
                    $usuario_data = array(
                        'email' => $usuario->email,
                        'nombre' => $usuario->nombre,
                        'id_user'=>$usuario-> id_user,
                        'logueado' => TRUE
                    );
                    $this->session->set_userdata($usuario_data);
                    redirect('login/logueado');
                } else {
                    $this->session->set_flashdata('error', 'Contraseña incorrecta.');
                    redirect('login');
                }
            }
        } {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login');
        }
    }

    public function logueado() {
        if ($this->session->userdata('logueado')) {
            /* acá pregunta si en userdata, el campo "logueado" está como TRUE
              En ese caso entonces va a mostrar la pagina "view_logueado", en cambio si está como FALSE, lo vuelve a la pagina de login
              esto lo hice así porque, si bien en la funcion Login ya hice esa pregunta, podría darse el caso que uno copie la url ../view_logueado
              y quiera entrar a ver qué hay..entonces siempre en cada página se debe hacer esta pregunta. if($this->session->userdata('logueado')){
             */
            $data = array();
            $data['nombre'] = $this->session->userdata('nombre');
            parent::index_page('view_logueado', $data);
        } else {
            redirect('login');
        }
    }

    public function cerrar_sesion() {

        $this->session->sess_destroy();
        redirect('login');
    }

}
