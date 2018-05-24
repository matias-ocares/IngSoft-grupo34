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

    public function index($rowno = 0) {

        $this->pagination->initialize($this->set_config());

        // Get Results from Data Base 
        $search_text = "";
        $rowperpage = 5;
        $data['lista_viajes'] = $this->model_viaje->getData($rowno, $rowperpage, $search_text);

        //Set header for the table
        $header = array('ID', 'Origen', 'Destino', 'Fecha Viaje', 'Hora Inicio', 'Duración Viaje (en horas)');
        $this->table->set_heading($header);

        parent::index_page('view_tabla_viajes', $data);
    }

}
