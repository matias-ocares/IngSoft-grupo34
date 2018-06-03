<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';
class auto extends controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('model_auto');
        $this->load->library(array('pagination','table','form_validation'));
        $this->load->helper(array('form','url'));
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
    public function index($rowno = 0) {
        $this->pagination->initialize($this->set_config());
        // Get Results from Data Base 
        $search_text = "";
        $rowperpage = 5;
        //Get all "viajes" with all columns
        $lista_autos = $this->model_auto->getAutos($rowno, $rowperpage, $search_text);
        //Set header for the table
        $header = array('Auto N°','Marca','Modelo','Pantente','Color', 'Acciones');
        $this->table->set_heading($header);
        $tmpl = array('table_open' => '<table class="table table-hover">',
            'heading_row_start' => '<tr style="background-color: #f1f1f1; font-weight:bold; color:black; text-align:left;">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th style="text-align:center;" height=40| width=55>',
            'heading_cell_end' => '</th>',
            'cell_start' => '<td style="text-align:center;" height=25>',
            'cell_end' => '</td>',
            'cell_alt_start' => '<td style="text-align:center;" height=25>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>');
        $this->table->set_template($tmpl);
        //Configure columns to be displayed on table
        foreach ($lista_autos as $auto) {
            $pertenece = $this->model_auto->auto_pertenece_user($auto['id_auto'], $this->session->userdata('id_user'));
            if ($pertenece) {
                $this->table->add_row($auto['id_auto'], $auto['marca'], $auto['modelo'], $auto['num_patente'], $auto['color'], anchor('auto/ver/' . $auto['id_auto'], '<span class="glyphicon glyphicon-eye-open"></span>') . ' | ' . anchor('auto/guardar/' . $auto['id_auto'], '<span class="glyphicon glyphicon-pencil"></span>') . ' | ' . anchor('viaje/ver/' . $auto['id_auto'], '<span class="glyphicon glyphicon-trash"></span>'));
            } 
        }
        //Call view
        $data = array();
        parent::index_page('auto/view_listar_autos', $data);
    }
    private function set_config() { //seteo la configuración 
        //Base properties
        $config['base_url'] = 'http://localhost:1234/IngSoft-grupo34/Aventon/index.php/auto/';
        $config['total_rows'] = $this->model_auto->getrecordCount($this->session->userdata('id_user'));
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
    public function ver($id) {
        //Neccesary to pass "id" as a parameter
        $auto_id = $this->uri->segment(3);
        $data['auto'] = $this->model_auto->auto_por_id($auto_id);
        parent::index_page('auto/view_info_auto', $data);
    }
        
    //AGREGO CONTROLADOR EDITAR AUTO, SIN EL INDEX
     private function set_flash_auto_db($auto) {
        $ult_campos_data = array(
            'marca' => $auto['marca'],
            'modelo' => $auto['modelo'],
            'num_patente' => $auto['num_patente'],
            'color' => $auto['color'],
        );
        $this->session->set_flashdata($ult_campos_data);
    }
    private function set_flash_campos_auto() {
        $campos_data = array(
            'marca' => $this->input->post('marca'),
            'modelo' => $this->input->post('modelo'),
            'num_patente' => $this->input->post('patente'),
            'color' => $this->input->post('color'),
        );
        $this->session->set_flashdata($campos_data);
    }
   
    function existPatente() {
        $patente_post = $this->input->post('patente');
        $id_auto = $this->uri->segment(3);
        if ($id_auto) { //estoy en modo = edición
            //$patente_session = $this->session->flashdata('num_patente');
            $patente_session = $this->model_auto->patente_por_id($id_auto);
            if ($patente_post == $patente_session['num_patente']) {
                return true;
            }
        }
        //verifies patente exists in DB
        return (!$this->model_auto->is_registered($patente_post));
    }
    private function validation_rules() {
        //funcón provada que crea las reglas de validación
        $config = array(
            array(
                'field' => 'marca',
                'label' => 'Marca',
                'rules' => 'required'
            ),
            array(
                'field' => 'modelo',
                'label' => 'Modelo',
                'rules' => 'required'
            ),
            array(
                'field' => 'patente',
                'label' => 'Patente',
                'rules' => 'required|min_length[6]|alpha_numeric|callback_existPatente'
            ),
            array(
                'field' => 'color',
                'label' => 'Color',
                'rules' => 'required|alpha'
            )
        );
        return $config;
    }
    private function array_auto() {
        $auto = array();
        $auto['marca'] = $this->input->post('marca');
        $auto ['modelo'] = $this->input->post('modelo');
        $auto ['num_patente'] = $this->input->post('patente');
        $auto ['color'] = $this->input->post('color');
        $auto['id_user'] = $this->session->userdata('id_user'); //con este guardo el id de usuario que obtuve al guardar la sesion iniciada.
        return $auto;
    }
    
    // Sería el INDEX, desde el listado de autos, mando acá. Luego desde la vista, el formulario tiene en action = auto/editar_auto
       public function guardar($id_auto = null) {
        if ($this->session->userdata('logueado')) {
            if (!$this->input->post()) {
                $id_auto = $this->uri->segment(3);
                $data = array();
                if ($id_auto) {
                    $auto = $this->model_auto->auto_por_id($id_auto);
                } else {
                    $auto = array(
                        'marca' => NULL,
                        'modelo' => NULL,
                        'num_patente' => NULL,
                        'color' => NULL
                    );
                }
                $this->set_flash_auto_db($auto);
            } else {
                $this->set_flash_campos_auto();
            }
            $data['notifico'] = $this->session->flashdata('notifico');
            $data['id_auto'] = $id_auto;
            parent::index_page('/auto/view_editar_auto', $data);
        } else {
            redirect('login');
        }
    }
    public function guardar_post($id_auto=null) {
        if ($this->input->post()) {
            $id_auto = $this->uri->segment(3);
            $this->form_validation->set_rules($this->validation_rules());
            $this->set_flash_campos_auto();
            if ($this->form_validation->run() == TRUE) {
                $auto = $this->array_auto();
                if ($this->model_auto->guardar($auto, $id_auto) == TRUE) {
                    $this->session->set_flashdata('notifico', 'Se modificó el auto exitosamente.');
                    redirect('auto/');
                } else {
                    $this->session->set_flashdata('notifico', 'Por el momento no pudo realizar la modificación.');
                    redirect('auto/');
                }
            } else {
                $this->session->set_flashdata('notifico', validation_errors());
                $data['notifico'] = $this->session->flashdata('notifico');
                $data['id_auto'] = $id_auto;
                // $this->set_flash_campos_auto();
                parent::index_page('/auto/view_editar_auto', $data);
                //$this->guardar();
            }
        }
    }
    
}