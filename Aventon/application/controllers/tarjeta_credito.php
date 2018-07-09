<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/controller.php';

class tarjeta_credito extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        //load model
        $this->load->model('model_tarjeta');
        $this->load->model('model_viaje');
        //load code igniter library to validate form
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index() {
        $data=array();    
        $data['error'] = $this->session->flashdata('error');
        if($this->model_tarjeta->tarjeta_cargada($this->session->userdata('id_user')) > 0){
            redirect('tarjeta_credito/ver_datos_tarjeta');
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
     private function set_flash_tarjeta_db($tarjeta) {
        $ult_campos_data = array(
            'tipo' => $tarjeta['tipo'],
            'titular' => $tarjeta['titular'],
            'numero' => $tarjeta['numero'],
            'codigo' => $tarjeta['codigo'],
            'fecha' => $tarjeta['fecha'],
        );
        $this->session->set_flashdata($ult_campos_data);
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
        $numero_post = $this->input->post('numero');
        $numero_session = $this->session->userdata('numero');
        if ($numero_post == $numero_session) {
            return TRUE;
        } else {
            //verifies email no existe in DB
            return (!$this->model_tarjeta->is_registered($numero_post));
        }
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
                
                 $data = array();
                 $this->session->set_flashdata('exito','SE CARGÓ LA TARJETA EXITOSAMENTE.');
                 $this->session->set_flashdata('error','');
         
                $data['error'] = $this->session->flashdata('error');
                $data['exito'] = $this->session->flashdata('exito');
                redirect('viaje/');

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
    
    function eliminar_cc(){
        $id_user = $this->session-> userdata('id_user');
        
        // Si tiene viaje activo (viaje pendiente, inactivo o aprobado) cuya fecha viaje >= fecha actual
        if ($this -> model_viaje -> tiene_viaje_activo($id_user))
        {
            //redirecciono vista tarjeta con mensaje de error de que no se puede borrar
            $this->session->set_flashdata('error', 'No puede borrar su tarjeta porque tiene viajes pendientes de realizar.');
        }
        else //no tiene viaje activo
        {
          $tarjeta = $this->model_tarjeta->consultar_tarjeta($id_user);
          $this->model_tarjeta->eliminar_tarjeta($tarjeta->id_tarjeta);
          $this->session->set_flashdata('exito', 'Tarjeta borrada exitosamente.');
        }
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
    
    public function ver_datos_tarjeta() {

        $tarjeta = $this->model_tarjeta->consultar_tarjeta($this->session->userdata('id_user'));
        $this->set_flash_tarjeta_db($tarjeta);
        $data = array();
        $data['notifico'] = $this->session->flashdata('notifico');
        parent::index_page('tarjeta_credito/view_editar_tarjeta',$data);        
    }
    
    public function actualizar_tarjeta(){
        if ($this->input->post()) {   
            $this->form_validation->set_rules($this->validation_rules());
            $this->set_flash_campos_tarjeta();
            if ($this->form_validation->run() == TRUE) { 
                $tarjeta=$this->array_tarjeta();
                if ($this->model_tarjeta->actualizar_tarjeta($tarjeta,$this->session->userdata('id_user')) == TRUE){                
                    $this->session->set_flashdata('notifico','SE CARGÓ LA TARJETA EXITOSAMENTE.');
                    redirect('viaje/');
                }else{
                    $this->session->set_flashdata('notifico','Por el momento no pudo realizar la modificación.');
                    redirect('tarjeta/');                    
                }
            } else {
                $this->session->set_flashdata('notifico', validation_errors());
                $data['notifico'] = $this->session->flashdata('notifico');
                parent::index_page('tarjeta_credito/view_editar_tarjeta',$data);    
            } 
        } 
    }
    

    
    
    
    
    
}
    


