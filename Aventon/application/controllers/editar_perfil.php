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
        $this->load->library('session');
        $this->load->library('upload');
    }

    public function index() {
        if ($this->session->userdata('logueado')) { //si está logueado
            $id = $this->session->userdata('id_user');
            $perfil_db = $this->model_user->user_by_id($id);
            $this->session->set_flashdata($perfil_db);
            $data = array();
            parent::index_page('view_editar_perfil', $data);
        } else {
            redirect('login');
        }
    }

    //Esta función guarda en flashdata los valores introducidos en cada campo,
    // para mostrarlos en la vista luego del post fallido (con error)
    private function set_flash_campos_edit_profile() {
        $perfil_post = array(
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'email' => $this->input->post('email')
        );

        $this->session->set_flashdata($perfil_post);
    }

    function notExistEmail() {
        $email_post = $this->input->post('email');
        $email_session = $this->session->userdata('email');
        if ($email_post == $email_session) {
            return TRUE;
        } else {
            //verifies email no existe in DB
            return (!$this->model_user->is_registered($email_post));
        }
    }
    
    private function validation_rules() {
        $user = array(
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
                'label' => 'email',
                'rules' => 'required|callback_notExistEmail|trim'
            ),
        );
        return $user;
    }

    //Esta función actualiza los datos en la sesión, cuando después del post, la valiación dió verdadera
    private function update_user_session_data() {
       
          $usuario_data = array(
                        'email' => $this->input->post('email'),
                        'nombre' => $this->input->post('nombre'),
                        'apellido' => $this->input->post('apellido'),
                        'id_user'=>$this->session->userdata('id_user'),
                        'logueado' => FALSE
                    );
                    $this->session->set_userdata($usuario_data);
        /*
        $this->session->unset_userdata('nombre');
            $this->session->unset_userdata('apellido');
            $this->session->unset_userdata('email');
       
            $this->session->set_userdata('nombre', $this->input->post('nombre'));
            $this->session->set_userdata('apellido', $this->input->post('apellido'));
            $this->session->set_userdata('email', $this->input->post('email'));  
        * 
        */  
    }

    // Esta función crea un array con los datos del User, que obtiene del post, para guardar en la BD (los pasa al modelo)
    private function array_user() {
        $user = array(
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'email' => $this->input->post('email')
        );
        return $user;
    }

    public function update_user() {
        if ($this->input->post()) {
            
            $this->form_validation->set_rules($this->validation_rules());
            
            if ($this->form_validation->run() == TRUE) { //si la validación es true, actualizo datos de sesión, y redirijo a "viajes"                 
                $user = $this->array_user();
                $id = $this->session->userdata('id_user');
                if ($this->model_user->update_user($user,$id) == TRUE) { //si los datos se guardan correctamente en la BD
                    $this->update_user_session_data(); //actualizo datos de la sesión, y seteo logueado=FALSE (CIERRO SESION, PERO SIN DESTRUIRLA)
                    //cierro sesión y redirijo al login,con EMAIL precargado y mostrando mensaje de exito 
                    $this->session->set_flashdata('email', $this->input->post('email')); 
                    $this->session->set_flashdata('notifico', 'La modificacion se realizó satisfactoriamente. Vuelva a iniciar sesión');
                    redirect('login');
                } else { //si fallo el guardado en la BD no actualizo los datos en la sesión
                    $this->session->set_flashdata('notifico', '[!] ERROR al actualizar los datos. Intentelo mas tarde.');
                    redirect('viaje/');
                }
            } else { //hubo error en las validaciones (luego del post), guardo los valores ingresados en flashdata, para mostrarlos en la vista
                $this->set_flash_campos_edit_profile();
                $this->session->set_flashdata('notifico', validation_errors());
                redirect('editar_perfil/');
            }
        }
    }
    

}
