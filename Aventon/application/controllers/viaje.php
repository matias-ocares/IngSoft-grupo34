<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class viaje extends controller {

    public function __construct() {
        parent::__construct();
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
        $config['base_url'] = 'http://localhost:1234/IngSoft-grupo34/Aventon/index.php/viaje/';
        $config['total_rows'] = $this->model_viaje->getrecordCount();
        $config['per_page'] = '5';
        //Additional properties
        $config['num_links'] = 2;

        /* Properties that allow to applied css to pagination elements
          $config['first_link'] = 'Primero';
          $config['last_link'] = 'Ultimo';
          $config['cur_tag_open'] = '<b class = "actual">';
          $config['cur_tag_close'] = '</b>';
          $config['full_tag_open'] = '<div class="pagination">';
          $config['full_tag_close'] = '</div>';
         */
        // --- PROBANDO ALGO NUEVO
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
        $viaje_id = $this->uri->segment(3);
        $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);
        $data['error'] = $this->session->flashdata('error');
        $data['exito'] = $this->session->flashdata('exito');
        //parent::index_page('viaje/view_viaje_info', $data);
        parent::index_page('viaje/view_viaje_info', $data);
    }
    
    public function ver_eliminar($id) {
        //Neccesary to pass "id" as a parameter
        $viaje_id = $this->uri->segment(3);
        $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);
        $data['error'] = $this->session->flashdata('error');
        $data['exito'] = $this->session->flashdata('exito');
        //parent::index_page('viaje/view_viaje_info', $data);
        parent::index_page('viaje/view_eliminar_viaje', $data);
    }
    function eliminar($id){
        $id = $this->input->post('id_viaje');
        $this->model_viaje->consulta_estado_postulacion($id);
        $this->model_viaje->eliminar_viaje($id);
        
        
        redirect('viaje/');
    }
    
    public function ver_postularse($id) {
        //Neccesary to pass "id" as a parameter
        $viaje_id = $this->uri->segment(3);
        $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);
        $data['error'] = $this->session->flashdata('error');
        $data['exito'] = $this->session->flashdata('exito');
        //parent::index_page('viaje/view_viaje_info', $data);
        $this->load->model('model_viaje');
        $ids['id_viaje'] = $data['viaje']->id_viaje;
        $ids['id_user'] = $this ->session-> userdata('id_user');
        $resultado = $this->model_viaje->ya_postulado($ids);
        if($resultado == true){
        parent::index_page('viaje/view_postular_viaje', $data);}
        else{
           $this->session->set_flashdata('error', 'YA ESTÁ POSTULADO PARA ESTE VIAJE');
           $data['error'] = $this->session->flashdata('error');
           parent::index_page('viaje/view_viaje_info', $data);  
        }
    }
    
    public function exist_tarjeta(){
        $this->load->model('model_tarjeta');
        $id = $this->session->userdata('id_user');
        //verifies tarjeta exists in DB
        return (($this->model_tarjeta->is_registered_por_id($id)));
        
    }
    public function hay_superposicion(){
   $this->load->model('model_viaje');
   
    $miviaje = array(
            'id_user'=>$this ->session-> userdata('id_user'),
            'id_viaje'=>$this->input->post('id_viaje'),
            'fecha' => $this->input->post('fecha'),
            'hora' => $this->input->post('hora'),
            'duracion' => $this->input->post('duracion'),
            'id_chofer' => $this->input->post('id_chofer'),
        );
        $resultado = $this->model_viaje->superposicion_postulacion($miviaje);
        if ($resultado == 0){
        return false;}
        else
        { return true;}
    }
    
    public function postularse(){
        $bool = $this-> exist_tarjeta();
        if($bool== TRUE){            
            $postulacion['id_user']= $this->session -> userdata('id_user');
            $postulacion['id_viaje']= $this->input->post('id_viaje');
            $viaje_id = $this->input->post('id_viaje');
            $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);        
            $sup= $this->hay_superposicion();
            if($sup == FALSE){ //NO HAY SUPERSPOSICION CON POSTULACIÓN APROBADA, ENTONCES SE GUARDA LA POSTULACION VISIBLE
               $postulacion['id_estado']= 1; 
               $this->model_viaje->postular($postulacion); 
               $this->session->set_flashdata('exito', 'SOLICITUD ENVIADA EXITOSAMENTE, ESPERANDO CONFIRMACIÓN.');
               $data['exito'] = $this->session->flashdata('exito');
               $data['error'] = $this->session->flashdata('error');
               parent::index_page('viaje/view_viaje_info', $data); 
               
            }else{ //HAY SUPERPOSICION CON POSTULACION APROBADA, ENTONCES SE GUARDA LA POSTUALACION INVISIBLE
               $postulacion['id_estado']= 4; 
               $this->model_viaje->postular($postulacion); 
               $this->session->set_flashdata('error', 'La postulación se superpone con un viaje ya aprobado, y por tal permanecerá invisible para el chofer mientras que la postulación aprobada siga vigente.');
               $data['error'] = $this->session->flashdata('error');
               $this->session->set_flashdata('exito', 'SOLICITUD ENVIADA EXITOSAMENTE.');
               $data['exito'] = $this->session->flashdata('exito');

               parent::index_page('viaje/view_viaje_info', $data); 
            }
        }
        else{ //NO HAY TARJETA REGISTRADA PARA ESTE USUARIO
             $viaje_id = $this->input->post('id_viaje');
             $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);     
             $this->session->set_flashdata('error','NO POSEE UNA TARJETA DE CRÉDITO REGISTRADA.'); 
             $data['error'] = $this->session->flashdata('error');
             $data['exito'] = $this->session->flashdata('exito');

               parent::index_page('viaje/view_viaje_info', $data);
        }
        
    }

    public function index($rowno = 0) {

        $this->pagination->initialize($this->set_config());

        // Get Results from Data Base 
        $search_text = "";
        $rowperpage = 5;
        //Get all "viajes" with all columns
        $lista_viajes = $this->model_viaje->getViajes($rowno, $rowperpage, $search_text);

        //Set header for the table
        $header = array('Origen', 'Destino', 'Fecha Viaje', 'Hora Inicio', 'Acciones');
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
        foreach ($lista_viajes as $viaje) {
            $pertenece = $this->model_viaje->viaje_pertenece_user($viaje['id_viaje'], $this->session->userdata('id_user'));
            $hora_inicio= substr($viaje['hora_inicio'], 0, -3);
            $newDate = date("d-m-Y", strtotime($viaje['fecha']));
            if ($pertenece) {
                $this->table->add_row($viaje['origen'], $viaje['destino'], $newDate, $hora_inicio, anchor('viaje/ver/' . $viaje['id_viaje'], '<span class="glyphicon glyphicon-eye-open"></span>') . ' | ' . anchor('viaje/ver/' . $viaje['id_viaje'], '<span class="glyphicon glyphicon-pencil"></span>') . ' | ' . anchor('viaje/ver_eliminar/' . $viaje['id_viaje'], '<span class="glyphicon glyphicon-trash"></span>') . ' | ' .'<span class>Postularme</span>' );
            } else {
                $this->table->add_row($viaje['origen'], $viaje['destino'], $newDate, $hora_inicio, anchor('viaje/ver_postularse/' . $viaje['id_viaje'], '<span class="glyphicon glyphicon-eye-open"></span>') . ' | ' . '<span class="glyphicon glyphicon-pencil"></span>' . ' | ' . '<span class="glyphicon glyphicon-trash"></span>' . ' | ' . anchor('viaje/ver_postularse/' . $viaje['id_viaje'], '<span class>Postularme</span>'));
            }
        }
        //Call view
        $data = array();
        parent::index_page('viaje/view_listar_viajes', $data);
    }

}
