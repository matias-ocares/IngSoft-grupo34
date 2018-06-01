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
        if ($this->session->userdata('logueado')) {
            $data = array();
            $data['notifico'] = $this->session->flashdata('notifico'); //Para mostrar mensajes de informacion utlizo las sesiones flashdata
            parent::index_page('view_editar_perfil', $data);
        } else {
            redirect('login');
        }
    }
    
    private function set_flash_campos_edit_profile(){
        $campos_data = array(
                    'nombre' => $this->input->post('nombre'),
                    'apellido' => $this->input->post('apellido'),
                    'email' => $this->input->post('email'),
               );
        $this->session->set_flashdata($campos_data);     
    }
    
    /*function notExistEmail() {
        $email = $this->input->post('email');
        if ($this->input->post('email') == $this->session->flashdata('email')) {
            return true;
        } else {
            //verifies patente exists in DB
            return (!$this->model_user->is_registered($email));
        }
    }*/

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
                'label' => 'email',
                'rules' => 'required|callback_notExistEmail|trim'
            ),
                     
        );
        return $user;
        
    }   
    
    private function array_user() {
        $user = array();
        $user['nombre'] = $this->input->post('nombre');
        $user ['apellido'] = $this->input->post('apellido');
        $user ['email'] = $this->input->post('email');
        $user['id_user'] = $this->session->userdata('id_user'); //con este guardo el id de usuario que obtuve al guardar la sesion iniciada.
        return $user;
    }
    
    public function update_user() {    
        if ($this->input->post()) {
            $this->form_validation->set_rules($this->validation_rules());
            $this->set_flash_campos_edit_profile();                        
            if ($this->form_validation->run() == TRUE) {                 
                $user = $this->array_user();
                if ($this->model_user->update_user($user) == TRUE) {
                    $this->session->set_flashdata('notifico', 'La modificacion se realizó satisfactoriamente.');
                    redirect('login/logueado');
                } else {
                    $this->session->set_flashdata('notifico', '[!] ERROR al actualizar los datos. Intentelo mas tarde.');
                    redirect('login/logueado');
                }
                } else {
                    $this->session->set_flashdata('notifico', validation_errors());
                    redirect('editar_perfil');
                }

        }
 
    } 
        
}
    
    
    
     
 




    


