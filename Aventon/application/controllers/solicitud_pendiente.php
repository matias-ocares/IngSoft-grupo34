<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class solicitud_pendiente extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_solicitud');
        $this->load->model('model_viaje');
        $this->load->library(array('pagination', 'table'));
        $this->load->helper('url');
        $this->load->library('session');
    }

    //Allow to send parameters to index method
    function _remap($method, $args) {

        if (method_exists($this, $method)) {
            $this->$method($args);
        } else {
            $this->index($method, $args);
        }
    }

    private function set_config() { //seteo la configuración 
        //Base properties
        $config['base_url'] = 'http://localhost:1234/IngSoft-grupo34/Aventon/index.php/solicitud_pendiente/';
        $config['total_rows'] = $this->model_solicitud->getrecordCount();
        $config['per_page'] = '5';
        //Additional properties
        $config['num_links'] = 2;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_link"] = "&laquo;";
        $config["first_tag_open"] = "<li>";
        $config["first_tag_close"] = "</li>";
        $config["last_link"] = "&raquo;";
        $config["last_tag_open"] = "<li>";
        $config["last_tag_close"] = "</li>";
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '<li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '<li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        return $config;
    }

    public function index($rowno = 0) {
        //Si el user tiene al menos un viaje creado, muestro el listado de solicitudes
        if ($this->model_viaje->tiene_un_viaje()) {
            $this->pagination->initialize($this->set_config());

            // Get Results from Data Base 
            $search_text = "";
            $rowperpage = 5;
            //Get all "viajes" with all columns
            $lista_solicitudes = $this->model_solicitud->getSolicitudes($rowno, $rowperpage, $search_text);

            //Set header for the table
            $header = array('Origen', 'Destino', 'Fecha Viaje', 'Hora Inicio', 'Nombre y Apellido Postulante', 'Acciones');
            $this->table->set_heading($header);

            $tmpl = array('table_open' => '<table class="table table-hover">',
                'heading_row_start' => '<tr style="background-color: #f1f1f1; font-weight:bold; color:black; text-align:left;">',
                'heading_row_end' => '</tr>',
                'heading_cell_start' => '<th style="text-align:center;" height=35 width=50>',
                'heading_cell_end' => '</th>',
                'cell_start' => '<td style="text-align:center;" height=25>',
                'cell_end' => '</td>',
                'cell_alt_start' => '<td style="text-align:center;" height=25>',
                'cell_alt_end' => '</td>',
                'table_close' => '</table>');
            $this->table->set_template($tmpl);


            //Configure columns to be displayed on table
            foreach ($lista_solicitudes as $solicitud) {
                
                $hora_inicio = substr($solicitud['hora_inicio'], 0, -3);
                $newDate = date("d-m-Y", strtotime($solicitud['fecha']));
                $this->table->add_row($solicitud['origen'], $solicitud['destino'], $newDate, $hora_inicio, anchor('solicitud_pendiente/ver_perfil/'.$solicitud['id_user'], $solicitud['nombre'] ,",", $solicitud['apellido']), anchor('solicitud_pendiente/aceptar_solicitud/'. $solicitud['id_viaje'].'/'.$solicitud['id_user'].'/'.$solicitud['hora_inicio'].'/'.$solicitud['fecha'].'/'.$solicitud['duracion_horas'], '<span class>Aceptar</span>') . ' | ' . anchor('solicitud_pendiente/rechazar_solicitud/'. $solicitud['id_viaje'].'/'.$solicitud['id_user'].'/'.$solicitud['hora_inicio'].'/'.$solicitud['fecha'].'/'.$solicitud['duracion_horas'] , '<span class>Rechazar</span>'));
            }

            //Call view
            $data = array();
            //$this->session->set_flashdata('error',' '); 
            //$this->session->set_flashdata('exito',' '); 
            $data['error'] = $this->session->flashdata('error');
            $data['exito'] = $this->session->flashdata('exito');
            $this->session->set_flashdata('listado','Pendientes Recibidas');
            parent::index_page('solicitud/view_solicitud', $data);
        } else {//no tiene creado ningún viaje, redirijo al listado de viajes
            $this->session->set_flashdata('notifico', 'No tiene ninguna solicitud ya que no ha creado ningún viaje');
            $data['notifico'] = $this->session->flashdata('notifico');
            redirect('viaje/');
        }
    }
    
    
    public function valida_fecha($id_postulante){ //VALIDA QUE LA TARJETA NO VENCIÓ
        $this->load->model('model_tarjeta');
        $resultado= (($this->model_tarjeta->consulta_fecha($id_postulante)));
        $fecha = $resultado->fecha;
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
    
    public function valida_saldo($id_viaje, $id_postulante){ //VALIDA QUE LA TARJETA POSEE SALDO SUFICIENTE
      $datos_viaje= (($this->model_solicitud->costo_viaje($id_viaje)));
      $costo = ($datos_viaje->costo)/($datos_viaje->plazas_total);
      $this->load->model('model_tarjeta');
      $dato= $this->model_tarjeta->monto_disponible($id_postulante);
      if(($dato->monto) >= ($costo)){
          return TRUE;
      }else{
          return FALSE;
      }
    }
    
    public function inactiva_solicitudes($id_postulante, $hora_inicio, $fecha, $duracion){
      $valor= 4;  
      $valorActual= 1;
      $this->model_solicitud->get_postulaciones($id_postulante, $fecha,$hora_inicio, $duracion, $valor, $valorActual );
       
    }
    
    
    public function aceptar_solicitud(){
        
        $id_viaje=  $this->uri->segment(3);
        $id_postulante=$this->uri->segment(4);
        $hora_inicio=  $this->uri->segment(5);
        $fecha=$this->uri->segment(6);
        $duracion=$this->uri->segment(7);
        $hayplaza=$this->model_solicitud->plaza_disponible($id_viaje);
        
        if($hayplaza == true){ //HAY PLAZAS DISPONIBLES
        $bool = $this-> valida_fecha($id_postulante);        
      if($bool== TRUE){ //LA TARJETA NO VENCIÓ
        $bool = $this-> valida_saldo($id_viaje, $id_postulante);
        if($bool == TRUE){//HAY SALDO DISPONIBLE EN LA TARJETA
          $valor=2;
          $this->model_solicitud->setear_postulacion($id_viaje, $id_postulante, $valor);     
          $this->model_solicitud->restar_plaza($id_viaje);  
          $this->inactiva_solicitudes($id_postulante, $hora_inicio, $fecha, $duracion);
          
          $data = array();
          $this->session->set_flashdata('exito','PASAJERO ACEPTADO EXITOSAMENTE.'); 
          $data['error'] = $this->session->flashdata('error');
          $data['exito'] = $this->session->flashdata('exito');
          //parent::index_page('solicitud/view_solicitud_pendiente', $data);   
          redirect('solicitud_pendiente/');
            
        }
        else{ //NO HAY SALDO SUFICIENTE EN LA TARJETA
          $valor=3;
          $this->model_solicitud->setear_postulacion($id_viaje, $id_postulante, $valor);            
          $data = array();
          $this->session->set_flashdata('error','EL POSTULANTE NO POSEE SALDO SUFICIENTE.'); 
          $data['error'] = $this->session->flashdata('error');
          $data['exito'] = $this->session->flashdata('exito');
          //parent::index_page('solicitud/view_solicitud_pendiente', $data);   
          redirect('solicitud_pendiente/');
          
        }           
          
      }
      else{ //LA TARJETA YA VENCIÓ
          $valor=3;
          $this->model_solicitud->setear_postulacion($id_viaje, $id_postulante, $valor);            
          $data = array();
          $this->session->set_flashdata('error','LA TARJETA DE CRÉDITO DEL POSTULANTE ERA INVÁLIDA.'); 
          $data['error'] = $this->session->flashdata('error');
          $data['exito'] = $this->session->flashdata('exito');
          //parent::index_page('solicitud/view_solicitud_pendiente', $data);   
          redirect('solicitud_pendiente/');
      }
        
    }
    else{ // NO HAY PLAZAS DISPONIBLES
          $valor=4;
          $this->model_solicitud->setear_postulacion($id_viaje, $id_postulante, $valor);       
          $data = array();
          $this->session->set_flashdata('error','NO QUEDAN PLAZAS DISPONIBLES EN EL VIAJE'); 
          $data['error'] = $this->session->flashdata('error');
          $data['exito'] = $this->session->flashdata('exito');
          //parent::index_page('solicitud/view_solicitud_pendiente', $data);   
          redirect('solicitud_pendiente/');
    }
    }
     public function activa_solicitudes($id_postulante, $hora_inicio, $fecha, $duracion){
      $valor=1;
      $valorActual= 4;
      $this->model_solicitud->get_postulaciones($id_postulante, $fecha,$hora_inicio, $duracion, $valor,$valorActual );
       
    }
    
    public function rechazar_solicitud(){
        $id_viaje=  $this->uri->segment(3);
        $id_postulante=$this->uri->segment(4);
        $hora_inicio=  $this->uri->segment(5);
        $fecha=$this->uri->segment(6);
        $duracion=$this->uri->segment(7);
        
        $resultado= $this->model_solicitud->consulta_estado($id_viaje, $id_postulante);
        
        if($resultado->id_estado == 1){ //LA SOLICITUD ESTA PENDIENTE DE ACEPTACION
         $valor=3;
         $this->model_solicitud->setear_postulacion($id_viaje, $id_postulante, $valor);     
         $this->activa_solicitudes($id_postulante, $hora_inicio, $fecha, $duracion);      
        
         $data = array();
         $this->session->set_flashdata('exito','SOLICITUD RECHAZADA.'); 
         $data['error'] = $this->session->flashdata('error');
         $data['exito'] = $this->session->flashdata('exito');
          //parent::index_page('solicitud/view_solicitud_pendiente', $data);   
         redirect('solicitud_pendiente/');
        }
        else{ //LA SOLICITUD FUE PREVIAMENTE ACEPTADA
         $valor=3;
         $this->model_solicitud->setear_postulacion($id_viaje, $id_postulante, $valor);
         $this->activa_solicitudes($id_postulante, $hora_inicio, $fecha, $duracion);
         $this->model_viaje->restar_reputacion($this->session->userdata('id_user'),$id_postulante,$id_viaje);
         $this->model_solicitud->sumar_plaza($id_viaje);
         $data = array();
         $this->session->set_flashdata('exito','SOLICITUD RECHAZADA.');
         $this->session->set_flashdata('error','SE TE OTORGARÁ UNA CALIFICACIÓN NEGATIVA POR RECHAZAR A UN PASAJERO YA ACEPTADO.');
         
         $data['error'] = $this->session->flashdata('error');
         $data['exito'] = $this->session->flashdata('exito');
         redirect('solicitud_aprobada/');
        }
    }
    
    public function ver_perfil(){
         $id_postulante=$this->uri->segment(3);
         /*$this->load->model('model_user');
         $perfil_db = $this->model_user->user_by_id($id_postulante);
         $this->session->set_flashdata($perfil_db);
         $data = array();
         parent::index_page('view_ver_perfil', $data);
        */
        redirect('ver_perfil/ver_un_perfil/'.$id_postulante) ;
        
    }

}
