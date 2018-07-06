<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class solicitud_aprobada extends controller {

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
        $config['base_url'] = 'http://localhost:1234/IngSoft-grupo34/Aventon/index.php/solicitud_aprobada/';
        $config['total_rows'] = $this->model_solicitud->getrecordCountAprobada();
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
            $lista_solicitudes = $this->model_solicitud->getSolicitudesAprobadas($rowno, $rowperpage, $search_text);

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
                $this->table->add_row($solicitud['origen'], $solicitud['destino'], $newDate, $hora_inicio, anchor('solicitud_pendiente/ver_perfil/'.$solicitud['id_user'], $solicitud['nombre'] ,",", $solicitud['apellido']), anchor('solicitud_pendiente/rechazar_solicitud/'. $solicitud['id_viaje'].'/'.$solicitud['id_user'].'/'.$solicitud['hora_inicio'].'/'.$solicitud['fecha'].'/'.$solicitud['duracion_horas'] , '<span class>Rechazar</span>'));
            }

            //Call view
            $data = array();
            //$this->session->set_flashdata('error',' '); 
            //$this->session->set_flashdata('exito',' '); 
            $data['error'] = $this->session->flashdata('error');
            $data['exito'] = $this->session->flashdata('exito');
            $this->session->set_flashdata('listado','Aprobadas Recibidas');
            parent::index_page('solicitud/view_solicitud', $data);
        } else {//no tiene creado ningún viaje, redirijo al listado de viajes
            $this->session->set_flashdata('notifico', 'No tiene ninguna solicitud ya que no ha creado ningún viaje');
            $data['notifico'] = $this->session->flashdata('notifico');
            redirect('viaje/');
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
