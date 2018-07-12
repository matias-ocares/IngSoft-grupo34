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
            $data['title'] = 'Auto';
            $data['groups'] = $this->model_viaje->getMisAutos();
            $data['notifico'] = $this->session->flashdata('notifico');
            $data['error'] = $this->session->flashdata('error');
            $data['exito'] = $this->session->flashdata('exito');
            parent::index_page('/viaje/view_crear_viaje', $data);
        } else if (!$this->session->userdata('logueado')) {

            redirect('login');
        } else {
            $this->session->set_flashdata('notifico', '');
            // redirect('login/logueado');

            $this->session->set_flashdata('exito', '');
            $this->session->set_flashdata('error', 'NO POSEE AUTO REGISTRADO PARA CREAR UN VIAJE');

            $data['error'] = $this->session->flashdata('error');
            $data['exito'] = $this->session->flashdata('exito');
            redirect('viaje/');
        }
    }

    private function set_flash_campos_viaje() {
        $campos_data = array(
            'origen' => $this->input->post('origen'),
            'destino' => $this->input->post('destino'),
            'fecha' => $this->input->post('fecha'),
            'hora' => $this->input->post('hora'),
            'duracion' => $this->input->post('duracion'),
            'costo' => $this->input->post('costo'),
            'plazas' => $this->input->post('plazas'),
            'auto' => $this->input->post('auto')
        );
        $this->session->set_flashdata($campos_data);
    }

    function existFecha() {
        // uso un array de array, porque cuando tenga los viajes con periodicidad, voy a tener que pasarle más de un viaje
        $viaje = array(
            'array_fechas' => $this->crear_array_fechas(),
            'hora' => $this->input->post('hora'),
            'duracion' => $this->input->post('duracion'),
            'id_chofer' => $this->session->userdata('id_user')
        );
        $resultado = $this->model_viaje->is_registered($viaje);

        if ($resultado > 0)
            return false;
        else
            return true;

        /* if (sizeof($resultado) >= 1) {
          return false;
          }
          return true;
         */
    }

    function alpha_num_spaces($str) {
        return (!preg_match(" /^[a-zA-Z\s0-9]*$/", $str)) ? FALSE : TRUE;
    }

    //Un destino es válido si es diferente al orígen, en el formulario de creación
    function destino_valido_create() {
        $origen = strtoupper(trim($this->input->post('origen')));
        $destino = strtoupper(trim($this->input->post('destino')));
        return ( $origen != $destino );
    }

    private function validation_rules() {
        $origen = $this->input->post('origen');
        $destino = $this->input->post('destino');
        //funcón provada que crea las reglas de validación
        $config = array(
            array(
                'field' => 'origen',
                'label' => 'Origen',
                'rules' => 'required|callback_alpha_num_spaces[' . $origen . ']'
            ),
            array(
                'field' => 'destino',
                'label' => 'Destino',
                'rules' => 'required|callback_alpha_num_spaces[' . $destino . ']|callback_destino_valido_create'
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

    private function crear_array_fechas() {
        //Agrego al array la primer fecha
        $fecha_desde = date_create($this->input->post('fecha'));
        $array_fechas = array($fecha_desde->format('Y-m-d'));


        if ($this->input->post('frequencia') != "unico") {
            $fecha_hasta = date_create($this->input->post('fecha_hasta'));
            $cantDias = date_diff($fecha_desde, $fecha_hasta)->format("%a");

            // Si tiene frequencia semanal
            if ($this->input->post('frequencia') == "semanal") {
                $cantSemanas = intdiv($cantDias, 7);

                for ($i = 1; $i <= $cantSemanas; $i++) {
                    $fecha_desde->add(new DateInterval('P7D'));
                    array_push($array_fechas, $fecha_desde->format('Y-m-d'));
                }
            } else { //Si tiene frequencia diaria  
                //obtengo los días seleccionados (checkeados en el formulario) en un array
                $dias_checked = $this->input->post('days');
                for ($i = 1; $i <= $cantDias; $i++) {
                    $fecha_desde->add(new DateInterval('P1D'));
                    $day = $fecha_desde->format('l'); //obtengo el día convertido en día de la semana, y verifico si fue uno de los marcados
                    if (in_array($day, $dias_checked)) {
                        array_push($array_fechas, $fecha_desde->format('Y-m-d'));
                    }
                }
            }
        }
        return $array_fechas;
    }

    private function crear_array_viajes($array_fechas) {

        $array_viajes = array();
        foreach ($array_fechas as $una_fecha) {
            $viaje['id_auto'] = $this->input->post('auto');
            $viaje['fecha'] = $una_fecha;
            $viaje ['hora_inicio'] = $this->input->post('hora');
            $viaje ['duracion_horas'] = $this->input->post('duracion');
            $viaje ['costo'] = $this->input->post('costo');
            $viaje ['plazas_total'] = $this->input->post('plazas');
            $viaje ['plazas_libre'] = $this->input->post('plazas');
            $viaje ['id_chofer'] = $this->session->userdata('id_user'); //con este guardo el id de usuario que obtuve al guardar la sesion iniciada.
            $viaje ['origen'] = $this->input->post('origen');
            $viaje ['destino'] = $this->input->post('destino');
            array_push($array_viajes, $viaje);
        }
        return $array_viajes;
    }

    public function clean_session() {
        //limpio sesión
        $array_items = array('origen', 'destino', 'busqueda', 'fecha', 'solo_mis_viajes');
        $this->session->unset_userdata($array_items);
    }

    private function registrar_viaje() {
        // Creo arreglos de fechas 
        $array_fechas = $this->crear_array_fechas();
        // Creo arreglo de viajes, para cada una de las fechas
        $array_viajes = $this->crear_array_viajes($array_fechas);
        //Inserto en la Base de Datos
        if ($this->model_viaje->registrar_viaje($array_viajes) == TRUE) {//guardo el viaje en la BD
            $this->session->set_flashdata('exito', 'Se cargó el viaje exitosamente.');
            $this->clean_session();
            redirect('viaje/');
        } else {
            $this->session->set_flashdata('error', 'Por el momento no pudo cargarse el viaje.');
            $this->clean_session();
            redirect('viaje/');
        }
    }

    public function crear_viaje() {
        //si hubo post
        if ($this->input->post()) {
            $this->set_flash_campos_viaje(); //guarado en mem flashdata, los datos del POST
            $this->form_validation->set_rules($this->validation_rules()); //seteo reglas de validación
            if ($this->form_validation->run() == TRUE) { //si paso validaciones
                $this->registrar_viaje();
            } else {
                $this->session->set_flashdata('notifico', validation_errors());
                redirect('crear_viaje/');
            }
        }
    }

}
