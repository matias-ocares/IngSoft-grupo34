<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_controller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('user_model');
        //load code igniter library to validate form
        $this->load->library('form_validation');
    }
        
    public function index()
    {
        /*
        //get data from the database
        $data['users'] = $this->user_model->get_users();
        */
        $data['title']='Login Aventon';
        //load view and pass the data
        $this->load->view('templates/header', $data);
        $this->load->view('user_view');
        $this->load->view('templates/footer');
    }
    
    function existEmail ($email){
        //verifies email exists in DB
        return ($this->user_model->is_registered($email)); 
    }
    
    function validPass (){
        //verifies password matches with user password
        $email=$this->input->post('email');
        $pass= $this->input->post('password');
        return ($this->user_model->validate_credentials($email,$pass)); 
    }
    

    public function validar (){
        $this->form_validation->set_rules('email','Email','required|valid_email|callback_existEmail['.$this->input->post('email').']'); //nombre campo, label men error, validación
        $this->form_validation->set_rules('password','Password','required|callback_validPass');
        
        if ($this->form_validation->run() == FALSE) {
            // no pasa validacion, vuelvo a mostrar el formulario con los datos precargados
            $this->load->view('fail');
        }
    
        else {
        // validacion exitosa
        $this->load->view('success');
        }
    }  
    
    
}


