<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class crear_viaje extends controller {

    public function __construct() {
        parent::__construct();
        //load model
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_viaje');
        //load code igniter library to validate form
        $this->load->library('form_validation');
        $this->load->helper('url');
        
    }

    public function index() {
        if ($this->session->userdata('logueado') && $this->model_viaje->getMisAutos()) { //aca tambien se pregunta si tiene un auto asociado,sino no le permite crear viaje

            $data = array();
            $data['title']= 'Auto';
            $data['groups'] = $this->model_viaje->getMisAutos();
            $data['notifico'] = $this->session->flashdata('notifico');
            parent::index_page('/viaje/view_crear_viaje', $data);
        } else if (!$this->session->userdata('logueado')){
            
            redirect('login');}
            else{
             $this->session->set_flashdata('notifico', 'No posee autos registrados para cargar un viaje.');
               redirect('login/logueado');   
            }
        }
    
    
    private function set_flash_campos_viaje() {
        $campos_data = array(
            'origen' => $this->input->post('origen'),
            'destino' => $this->input->post('destino'),
            'fecha' => $this->input->post('fecha'),
            'hora' => $this->input->post('hora'),
            'duracion_horas' => $this->input->post('duracion'),
            'costo' => $this->input->post('costo'),
            'plazas' => $this->input->post('plazas'),
            'auto' => $this->input->post('auto'),
        );
        $this->session->set_flashdata($campos_data);
    }
    
    function existFecha() {
        $viaje= array (
               'fecha' => $this->input->post('fecha'),
               'hora'=> $this->input->post('hora'),
               'id_user'=>$this->session->userdata('id_user'),
               'duracion'=> $this->input->post('duracion')
                );
        
        return ($this->model_viaje->is_registered($viaje));
    }    
    function alpha_dash_space($str)
{
    return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
} 
     private function validation_rules() {
        //funcón provada que crea las reglas de validación

        $config = array(
            array(
                'field' => 'origen',
                'label' => 'Origen',
                'rules' => 'required|callback_alpha_dash_space'
            ),
            array(
                'field' => 'destino',
                'label' => 'Destino',
                'rules' => 'required|callback_alpha_dash_space'
            ),
            array(
                'field' => 'fecha',
                'label' => 'Fecha',
                'rules' => 'required|callback_existFecha'
            ),
            array(
                'field' => 'hora',
                'label' => 'Hora',
                'rules' => 'required'
            ),
            array(
                'field' => 'duracion',
                'label' => 'Duracion',
                'rules' => 'required'
            ),
            array(
                'field' => 'costo',
                'label' => 'Costo',
                'rules' => 'required'
            ),
            array(
                'field' => 'auto',
                'label' => 'Auto',
                'rules' => 'required'
            ),
            array(
                'field' => 'plazas',
                'label' => 'Plazas',
                'rules' => 'required'
            )
        );
        return $config;
    }
    
    private function array_viaje() {
        $viaje = array();
        
        $viaje ['fecha'] = $this->input->post('fecha');
        $viaje  ['hora_inicio'] = $this->input->post('hora');
        $viaje ['duracion_horas'] = $this->input->post('duracion'); 
        $viaje ['costo'] = $this->input->post('costo');
        $viaje ['plazas_total'] =$this->input->post('plazas');
        $viaje ['plazas_libre'] =$this->input->post('plazas');
        $viaje ['id_chofer'] = $this->session->userdata('id_user');//con este guardo el id de usuario que obtuve al guardar la sesion iniciada.
        $viaje ['origen'] = $this->input->post('origen');
        $viaje  ['destino'] = $this->input->post('destino');
        return $viaje;
    }
    
    private function array_id(){
        $id=array();
        $id['id_user']= $this->session->userdata('id_user');
        $id_auto= $this->model_viaje->consulta_id_auto($this->input->post('auto'));
        $id['id_auto']= $id_auto->id_auto;
        $id_viaje= $this->model_viaje->consulta_id_viaje($this->array_viaje());
        $id['id_viaje']=$id_viaje->id_viaje;
        return $id;        
    }
    public function crear_viaje() {
        if ($this->input->post()) {
            $this->set_flash_campos_viaje();

            $this->form_validation->set_rules($this->validation_rules());
            if ($this->form_validation->run() == TRUE) {
                $viaje = $this->array_viaje();
               if( $this->model_viaje->register_viaje($viaje)== TRUE) {
                   $id= $this->array_id();
                   $this->model_viaje->registrar_ids($id);
                   $this->session->set_flashdata('notifico', 'Se cargó el viaje exitosamente.');
               redirect('login/logueado');}
               else {
                   $this->session->set_flashdata('notifico', 'Por el momento no pudo cargarse el viaje.');
               redirect('login/logueado');}
        }
             else {
                $this->session->set_flashdata('notifico', validation_errors());
                redirect('crear_viaje');
            }
        }
    }
     
    
}