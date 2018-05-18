<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class register extends CI_Controller {
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
        $this->load->view('view_register');
        $this->load->view('templates/footer');
    }
     
    function existEmail (){
        $email=$this->input->post('email');
        //verifies email exists in DB
        return (!($this->user_model->is_registered($email))); 
    }
  

   /* public function validar (){
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
    }*/
    
        public function validar()
    {
        // basic required field
        $this->form_validation->set_rules('name', 'name', 'required|alpha');
        $this->form_validation->set_rules('surname', 'surname', 'required|alpha'); 
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|callback_existEmail');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('passwordRepeat', 'passwordRepeat', 'required|matches[password]');
         
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('fail');
        }
        else
        {
            // load success template...
            $this->load->view('success');
        }
    }
    
    
}
