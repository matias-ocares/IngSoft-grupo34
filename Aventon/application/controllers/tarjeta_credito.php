<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/controller.php';

class tarjeta_credito extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        //load model
        $this->load->model('model_tarjeta');
        //load code igniter library to validate form
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index() {
        $data=array();    
        $data['error'] = $this->session->flashdata('error');
        if($this->model_tarjeta->tarjeta_cargada($this->session->userdata('id_user')) > 0){
            parent::index_page('tarjeta_credito/view_eliminar_tarjeta',$data);
        }
        else{
           parent::index_page('tarjeta_credito/view_registrar_tarjeta',$data); 
        }
    }

   private function set_flash_campos_tarjeta(){
        $campos_data = array(
                    'tipo' => $this->input->post('tipo'),
                    'titular' => $this->input->post('titular'),
                    'numero' => $this->input->post('numero'),
                    'codigo' => $this->input->post('codigo'),
                    'fecha' => $this->input->post('fecha'),
               );
        $this->session->set_flashdata($campos_data);     
    }
    
    function alpha_dash_space($str){
        return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
    } 
    
    public function solo_letras($cadena)
    {
        $patron = '/[a-zA-Z,.\s]*$/';
        if( !preg_match( $patron, $cadena ) ) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    function notExistCreditCard() {
        $numero = $this->input->post('numero');
        //verifies email exists in DB
        return (!($this->model_tarjeta->is_registered($numero)));
    }
    
    private function validation_rules(){
 
        $tarjeta=array(
            array(
                'field' => 'tipo',
                'label' => 'tipo',
                'rules' => 'required|callback_solo_letras|trim'
            ),
            array(
                'field' => 'titular',
                'label' => 'titular',
                'rules' => 'required|callback_solo_letras|trim'
            ),
            array(
                'field' => 'numero',
                'label' => 'numero',
                'rules' => 'required|callback_notExistCreditCard'
            ),
            array(
                'field' => 'codigo',
                'label' => 'codigo',
                'rules' => 'required',
            ),
            array(
                'field' => 'fecha',
                'label' => 'fecha',
                'rules' => 'required|callback_valida_fecha'
            ),
                     
        );
        return $tarjeta;
        
    } 
    
    private function array_tarjeta() {
        $tarjeta = array();
        
        $tarjeta ['tipo'] = $this->input->post('tipo');
        $tarjeta  ['titular'] = $this->input->post('titular');
        $tarjeta ['numero'] = $this->input->post('numero'); 
        $tarjeta ['codigo'] = $this->input->post('codigo');
        $tarjeta ['fecha'] =$this->input->post('fecha');
        $tarjeta ['id_user'] = $this->session->userdata('id_user');
        return $tarjeta;
    }

    public function crear_tarjeta() {
        if ($this->input->post()) {
            
            $this->set_flash_campos_tarjeta();

            $this->form_validation->set_rules($this->validation_rules());
            
            if ($this->form_validation->run() == TRUE) { 
                
                $tarjeta=$this->array_tarjeta();
                $tarjeta = $this->model_tarjeta->registrar_tarjeta($tarjeta);
                redirect('login');

            }
            else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('tarjeta_credito/');
            } 
        } 
        
    }
    
     function eliminar($id_tarjeta){
        $id_tarjeta = $this->input->post('id_tarjeta');
        $data = array();
        $this->model_tarjeta->eliminar_tarjeta($id_tarjeta);     
        
        redirect('viaje/');
    }  

    public function valida_fecha($id){ //VALIDA QUE LA TARJETA NO VENCIO
        $fecha = $this->input->post('fecha');
        //$fecha = date_format($date, 'm-y');
               
        $dia = "01";
        $mes = substr($fecha,0,2);
        $anio = substr($fecha,2,4);
        $fecha_cc = date_create("20".$anio."/".$mes."/".$dia);  //crear un objeto DateTime 
        $fechax = $fecha_cc->format('Y-m-d');
        if ($fechax > date("Y-m-d")){
            return TRUE;
        }
        else 
        {return FALSE;}
    }
    
    
    
    
    
    
}
    


