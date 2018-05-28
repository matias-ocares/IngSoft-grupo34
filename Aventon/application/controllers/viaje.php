<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class viaje extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_viaje');
        $this->load->library(array('pagination', 'table'));
        $this->load->helper('url');
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
        $config['base_url'] = 'http://localhost:1234/IngSoft-grupo34/Aventon/index.php/viaje/';
        $config['total_rows'] = $this->model_viaje->getrecordCount();
        $config['per_page'] = '5';
        //Additional properties
        $config['num_links'] = 2;
        $config['first_link'] = 'Primero';
        $config['last_link'] = 'Ultimo';
        //Properties that allow to applied css to pagination elements
        $config['cur_tag_open'] = '<b class = "actual">';
        $config['cur_tag_close'] = '</b>';
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';

        return $config;
    }

    public function ver($id) {
        //Neccesary to pass "id" as a parameter
        $viaje_id = $this->uri->segment(3);
        $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);
        parent::index_page('viaje/view_viaje_info', $data);
    }

    public function index($rowno = 0) {

        $this->pagination->initialize($this->set_config());

        // Get Results from Data Base 
        $search_text = "";
        $rowperpage = 5;
        //Get all "viajes" with all columns
        $lista_viajes = $this->model_viaje->getViajes($rowno, $rowperpage, $search_text);

        //Set header for the table
        $header = array('ID', 'Origen', 'Destino', 'Fecha Viaje', 'Hora Inicio', 'Duración Viaje (en horas)', 'Accciones');
        $this->table->set_heading($header);
        //estilos
       // $tmpl = array ( 'table_open'  => '<table style="width:100%">' );
        
        $tmpl = array ('table_open' => '<table border="1" cellpadding="4" cellspacing="0" style="width:100%">',     
                       'table_close' => '</table>');
        $this->table->set_template($tmpl);

        //Configure columns to be displayed on table
        foreach ($lista_viajes as $viaje) {
            $this->table->add_row($viaje['id_viaje'], $viaje['origen'], $viaje['destino'], $viaje['fecha'], $viaje['hora_inicio'], $viaje['duracion_horas'], anchor('viaje/ver/' . $viaje['id_viaje'], 'Ver'));
        }

        //Call view
        $data = array();
        parent::index_page('viaje/view_viajes_ver', $data);
    }

}
