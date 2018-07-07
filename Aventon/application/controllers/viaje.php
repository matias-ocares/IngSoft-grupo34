<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/controller.php';

class viaje extends controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_viaje');
        $this->load->library(array('pagination', 'table','form_validation'));
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

    private function set_config() { //seteo la configuración 
        //Filtros de búsqueda a aplicar en el listado
        $search_array = $this->array_search_viaje();
        //Obtengo el total de registros para guardar en sesión y en la variable $config['total_rows'] que permite la paginación
        $total_records = $this->model_viaje->getrecordCount($search_array);
        // Almaceno el total de resultados en la sesión
        $this->session->set_userdata('total', $total_records);
//Base properties
        $config['base_url'] = 'http://localhost:1234/IngSoft-grupo34/Aventon/index.php/viaje/';
        $config['total_rows'] = $total_records;
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
        $viaje_id = $this->uri->segment(3);
        $chofer= $this->model_viaje->chofer_por_id($viaje_id);
         $data['nombre']=$chofer->nombre;
         $data['apellido']=$chofer->apellido;
        $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);
        $data['error'] = $this->session->flashdata('error');
        $data['exito'] = $this->session->flashdata('exito');
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

    function eliminar($id) {
        $id = $this->input->post('id_viaje');
        $data = array();
        $this->model_viaje->consulta_estado_postulacion($id);
        $this->model_viaje->eliminar_viaje($id);

        $this->session->set_flashdata('exito', 'SE ELIMINÓ EL VIAJE EXITOSAMENTE.');
        $data['exito'] = $this->session->flashdata('exito');
        $data['error'] = $this->session->flashdata('error');

        redirect('viaje/');
    }

    public function ver_postularse($id) {
        //Neccesary to pass "id" as a parameter
        $viaje_id = $this->uri->segment(3);
        $chofer= $this->model_viaje->chofer_por_id($viaje_id);
        $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);
         $data['nombre']=$chofer->nombre;
         $data['apellido']=$chofer->apellido;
         
        $data['error'] = $this->session->flashdata('error');
        $data['exito'] = $this->session->flashdata('exito');
        //parent::index_page('viaje/view_viaje_info', $data);
        $this->load->model('model_viaje');
        $ids['id_viaje'] = $data['viaje']->id_viaje;
        $ids['id_user'] = $this->session->userdata('id_user');
        $resultado = $this->model_viaje->ya_postulado($ids);
        if ($resultado == true) {
            parent::index_page('viaje/view_postular_viaje', $data);
        } else {
            $this->session->set_flashdata('error', 'YA ESTÁ POSTULADO PARA ESTE VIAJE');
            $data['error'] = $this->session->flashdata('error');
            parent::index_page('viaje/view_viaje_info', $data);
        }
    }

    public function exist_tarjeta() {
        $this->load->model('model_tarjeta');
        $id = $this->session->userdata('id_user');
        //verifies tarjeta exists in DB
        return (($this->model_tarjeta->is_registered_por_id($id)));
    }

    public function hay_superposicion() {
        $this->load->model('model_viaje');

        $miviaje = array(
            'id_user' => $this->session->userdata('id_user'),
            'id_viaje' => $this->input->post('id_viaje'),
            'fecha' => $this->input->post('fecha'),
            'hora' => $this->input->post('hora'),
            'duracion' => $this->input->post('duracion'),
            'id_chofer' => $this->input->post('id_chofer'),
        );
        $resultado = $this->model_viaje->superposicion_postulacion($miviaje);
        if ($resultado == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function hay_superposicion_mi_viaje() {
        $this->load->model('model_viaje');

        $miviaje = array(
            'id_user' => $this->session->userdata('id_user'),
            'id_viaje' => $this->input->post('id_viaje'),
            'fecha' => $this->input->post('fecha'),
            'hora' => $this->input->post('hora'),
            'duracion' => $this->input->post('duracion'),
            'id_chofer' => $this->input->post('id_chofer'),
        );
        $resultado = $this->model_viaje->superposicion_postulacion_con_mi_viaje($miviaje);
        if ($resultado == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function postularse() {
        $bool = $this->exist_tarjeta();
        if ($bool == TRUE) {
            $postulacion['id_user'] = $this->session->userdata('id_user');
            $postulacion['id_viaje'] = $this->input->post('id_viaje');
            $viaje_id = $this->input->post('id_viaje');
            $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);
            $data['nombre']=$this->input->post('nombre');
            $data['apellido']= $this->input->post('apellido');       
            $sup = $this->hay_superposicion();
            $otrasup = $this->hay_superposicion_mi_viaje();
            if ($otrasup == False) {
                if ($sup == FALSE) { //NO HAY SUPERSPOSICION CON POSTULACIÓN APROBADA, ENTONCES SE GUARDA LA POSTULACION VISIBLE
                    $postulacion['id_estado'] = 1;
                    $this->model_viaje->postular($postulacion);
                    $this->session->set_flashdata('exito', 'SOLICITUD ENVIADA EXITOSAMENTE, ESPERANDO CONFIRMACIÓN.');
                    $data['exito'] = $this->session->flashdata('exito');
                    $data['error'] = $this->session->flashdata('error');
                    parent::index_page('viaje/view_viaje_info', $data);
                } else { //HAY SUPERPOSICION CON POSTULACION APROBADA, ENTONCES SE GUARDA LA POSTUALACION INVISIBLE
                    $postulacion['id_estado'] = 4;
                    $this->model_viaje->postular($postulacion);
                    $this->session->set_flashdata('error', 'La postulación se superpone con un viaje ya aprobado, y por tal permanecerá invisible para el chofer mientras que la postulación aprobada siga vigente.');
                    $data['error'] = $this->session->flashdata('error');
                    $this->session->set_flashdata('exito', 'SOLICITUD ENVIADA EXITOSAMENTE.');
                    $data['exito'] = $this->session->flashdata('exito');

                    parent::index_page('viaje/view_viaje_info', $data);
                }
            } else {
                $this->session->set_flashdata('error', 'La postulación se superpone con un viaje creado por usted.');
                $data['error'] = $this->session->flashdata('error');
                $this->session->set_flashdata('exito', '');
                $data['exito'] = $this->session->flashdata('exito');

                parent::index_page('viaje/view_viaje_info', $data);
            }
        } else { //NO HAY TARJETA REGISTRADA PARA ESTE USUARIO
            $viaje_id = $this->input->post('id_viaje');
            $data['viaje'] = $this->model_viaje->viaje_por_id($viaje_id);
            $this->session->set_flashdata('error', 'NO POSEE UNA TARJETA DE CRÉDITO REGISTRADA.');
            $data['error'] = $this->session->flashdata('error');
            $data['exito'] = $this->session->flashdata('exito');

            parent::index_page('viaje/view_viaje_info', $data);
        }
    }

    // ------------------COMIENZAN METODOS DE BUSQUEDA --------------------------------
    
    function alpha_spaces($str) {
        return (!preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
    }
    
    //Un destino es válido si es diferente al orígen
    function destino_valido() {
        $origen = strtoupper(trim($this->input->post('search_origen')));
        $destino = strtoupper(trim($this->input->post('search_destino')));
        return ( $origen != $destino );
    }
    
    private function validation_rules() {
        $origen = $this->input->post('search_origen');
        $destino = $this->input->post('search_destino');
        //funcón provada que crea las reglas de validación
        $config = array(
            array(
                'field' => 'search_origen',
                'label' => 'Origen',
                'rules' => 'required|callback_alpha_spaces['.$origen.']'
            ),
            array(
                'field' => 'search_destino',
                'label' => 'Destino',
                'rules' => 'required|callback_alpha_spaces['.$destino.']|callback_destino_valido'
            )
        );
        return $config;
    }
    
    //valida campos del search
    public function verificar_search() {
        if ($this->input->post()) {
            //guardo en la sesión los datos del post
            $this->session_search_viaje();
            //valido los datos del formulario
            $this->form_validation->set_rules($this->validation_rules());
            if ($this->form_validation->run() == FALSE) {
               $this->session->set_flashdata('notifico', validation_errors());
            }
        }
        redirect('viaje/', 'refresh');
    }

    // Para limpiar la búsqueda
    public function mostrar_todos(){
        
        if ($this->session->userdata('busqueda')) {
            //limpio sesión
            $array_items = array('origen', 'destino', 'busqueda','fecha');
            $this->session->unset_userdata($array_items);     
        }
         redirect('viaje/', 'refresh');
    }
    
    // Guardo criterios de búsqueda en la sesión, para usar en el paginado
    private function session_search_viaje() {
        $search = array(
            'origen' => trim($this->input->post('search_origen')),  //trim elimina espacios al principio y al final
            'destino' => trim($this->input->post('search_destino')),
            'fecha' => $this->input->post('search_fecha'),
            'busqueda' => true,
            'total' => 0,
        );
        //Guardo en la sesión de usuario, porque si uso flashdata solo permanece en el próximo server request y luego se borra,
        //y al tener paginación necesito que persista a lo largo de las páginas
        $this->session->set_userdata($search);
    }
    
    // Armo un arreglo con los criterios de búsqueda, a partir de lo guardado en la sesión
    private function array_search_viaje() {

        $hubo_busqueda =$this->session->userdata('busqueda');
        $hubo_error = $this->session->flashdata('notifico');
        //Si hubo búsqueda y no hubo error
        if ( $hubo_busqueda AND !$hubo_error) {
            $search = array(
                'origen' => $this->session->userdata('origen'),
                'destino' => $this->session->userdata('destino'),
                'fecha' => $this->session->userdata('fecha'),
            );
        } else { // No hubo búsqueda
            $search = NULL;
        }
        return $search;
    }
    
  
    // ------------------TERMINAN METODOS DE BUSQUEDA --------------------------------
    public function index($rowno = 0) {

        $this->pagination->initialize($this->set_config());

        // Get Results from Data Base ;
        $rowperpage = 5;
        
       //Filtros de búsqueda a aplicar en el listado
        $search_array = $this->array_search_viaje();
        
        //Get all "viajes" with all columns
        $lista_viajes = $this->model_viaje->getViajes($rowno, $rowperpage, $search_array);

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
            $hora_inicio = substr($viaje['hora_inicio'], 0, -3);
            $newDate = date("d-m-Y", strtotime($viaje['fecha']));
            if ($pertenece) {
                $this->table->add_row($viaje['origen'], $viaje['destino'], $newDate, $hora_inicio, anchor('viaje/ver/' . $viaje['id_viaje'], '<span class="glyphicon glyphicon-eye-open"></span>') . ' | ' . anchor('viaje/ver/' . $viaje['id_viaje'], '<span class="glyphicon glyphicon-pencil"></span>') . ' | ' . anchor('viaje/ver_eliminar/' . $viaje['id_viaje'], '<span class="glyphicon glyphicon-trash"></span>') . ' | ' . '<span class>Postularme</span>');
            } else {
                $this->table->add_row($viaje['origen'], $viaje['destino'], $newDate, $hora_inicio, anchor('viaje/ver_postularse/' . $viaje['id_viaje'], '<span class="glyphicon glyphicon-eye-open"></span>') . ' | ' . '<span class="glyphicon glyphicon-pencil"></span>' . ' | ' . '<span class="glyphicon glyphicon-trash"></span>' . ' | ' . anchor('viaje/ver_postularse/' . $viaje['id_viaje'], '<span class>Postularme</span>'));
            }
        }
        //Call view
        $data = array();
        $data['error'] = $this->session->flashdata('error');
        $data['exito'] = $this->session->flashdata('exito');   
        parent::index_page('viaje/view_listar_viajes', $data);
    }

}
