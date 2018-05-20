<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class login extends controller {

    public function __construct() {
        parent::__construct();
        //load model
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

    /* function validPass() {
      //verifies password matches with user password
      $email = $this->input->post('email');
      $pass = $this->input->post('password');
      return ($this->model_user->validate_credentials($email, $pass));
      }
     */

    public function login() {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $usuario = $this->model_user->user_by_name_pass($email, $password);
            if ($usuario) {
                $usuario_data = array(
                    'id' => $usuario->email,
                    'pass' => $usuario->password,
                    'nombre' => $usuario->nombre,
                    'logueado' => TRUE
                );
                $this->session->set_userdata($usuario_data);
                redirect('login/view_logueado');
            } else {
                $this->session->set_flashdata('error', 'El usuario o la contraseña son incorrectos.');
                redirect('login');
            }
        } else {

            redirect('login');
        }
    }

    public function view_logueado() {
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
        $usuario_data = array(
            'logueado' => FALSE
        );
        $this->session->set_userdata($usuario_data);
        redirect('login');
    }

}
