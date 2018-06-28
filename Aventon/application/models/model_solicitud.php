<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class model_solicitud extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function consulta_id_viaje($viaje) {
        $this->db->select('id_viaje');
        $this->db->from('viaje');
        $this->db->where('fecha', $viaje['fecha']);
        $this->db->where('hora_inicio', $viaje['hora_inicio']);
        $this->db->where('id_chofer', $viaje['id_chofer']);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    public function getSolicitudes($rowno, $rowperpage, $search = "") {

        $this->db->select('origen,destino,fecha,hora_inicio,duracion_horas,nombre,apellido, viaje.id_viaje, user.id_user');
        $this->db->join('viaje', 'viaje.id_viaje = postulacion_viaje.id_viaje', 'inner');
        $this->db->join('user', 'user.id_user = postulacion_viaje.id_user', 'inner');
        $this->db->where('id_chofer', $this->session->userdata('id_user'));
        $this->db->where('id_estado', 1);
        $this->db->order_by('fecha', 'asc');
        $query = $this->db->get('postulacion_viaje', $rowperpage, $rowno);

        return $query->result_array();
    }
    
    public function getSolicitudesAprobadas($rowno, $rowperpage, $search = "") {

        $this->db->select('origen,destino,fecha,hora_inicio,duracion_horas,nombre,apellido, viaje.id_viaje, user.id_user');
        $this->db->join('viaje', 'viaje.id_viaje = postulacion_viaje.id_viaje', 'inner');
        $this->db->join('user', 'user.id_user = postulacion_viaje.id_user', 'inner');
        $this->db->where('id_chofer', $this->session->userdata('id_user'));
        $this->db->where('id_estado', 2);
        $this->db->order_by('fecha', 'asc');
        $query = $this->db->get('postulacion_viaje', $rowperpage, $rowno);

        return $query->result_array();
    }

public function getrecordCountAprobada($search = "") {

        $this->db->select('origen,destino,fecha,hora_inicio,nombre,apellido');
        $this->db->from('postulacion_viaje');
        $this->db->join('viaje', 'viaje.id_viaje = postulacion_viaje.id_viaje', 'inner');
        $this->db->join('user', 'user.id_user = postulacion_viaje.id_user', 'inner');
        $this->db->where('id_chofer', $this->session->userdata('id_user'));
        $this->db->where('id_estado', 2);
        return $this->db->count_all_results();
    }
    // Select total records
    public function getrecordCount($search = "") {

        $this->db->select('origen,destino,fecha,hora_inicio,nombre,apellido');
        $this->db->from('postulacion_viaje');
        $this->db->join('viaje', 'viaje.id_viaje = postulacion_viaje.id_viaje', 'inner');
        $this->db->join('user', 'user.id_user = postulacion_viaje.id_user', 'inner');
        $this->db->where('id_chofer', $this->session->userdata('id_user'));
        $this->db->where('id_estado', 1);
        return $this->db->count_all_results();
    }

    public function getSolicitudesEnviadas($rowno, $rowperpage, $array_estados, $search = "") {
        //$this->db->select('id_estado,postulacion_viaje.id_user,postulacion_viaje.id_viaje');
        $this->db->select('origen,destino,fecha,hora_inicio,duracion_horas,nombre,apellido, viaje.id_viaje, user.id_user');
        $this->db->join('viaje', 'viaje.id_viaje = postulacion_viaje.id_viaje', 'inner');
      //  $this->db->join('user', 'user.id_user = postulacion_viaje.id_user', 'inner');
        $this->db->join('user', 'user.id_user = viaje.id_chofer', 'inner');
        $this->db->where('postulacion_viaje.id_user', $this->session->userdata('id_user'));
        $this->db->where_in('id_estado', $array_estados);
        $this->db->order_by('fecha', 'asc');
        $query = $this->db->get('postulacion_viaje', $rowperpage, $rowno);

        return $query->result_array();
    }

    // Select total records
    public function getrecordCountEnviadas($array_estados, $search = "") {
        $this->db->from('postulacion_viaje');
        $this->db->join('viaje', 'viaje.id_viaje = postulacion_viaje.id_viaje', 'inner');
        $this->db->join('user', 'user.id_user = postulacion_viaje.id_user', 'inner');
        $this->db->where('postulacion_viaje.id_user', $this->session->userdata('id_user'));
        $this->db->where_in('id_estado', $array_estados);
        return $this->db->count_all_results();
    }

    public function costo_viaje($id_viaje) {
        $this->db->where('id_viaje', $id_viaje);
        $this->db->select('costo, plazas_total');
        $this->db->from('viaje');
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    public function setear_postulacion($id_viaje, $id_postulante, $valor) {
        $this->db->where('id_viaje', $id_viaje);
        $this->db->where('id_user', $id_postulante);
        $data['id_viaje'] = $id_viaje;
        $data['id_user'] = $id_postulante;
        $data['id_estado'] = $valor;
        $this->db->update('postulacion_viaje', $data);
    }

    public function get_postulaciones($id_postulante, $fecha, $hora, $dura, $valor, $valorActual) {
        $this->db->select('fecha,hora_inicio,viaje.id_viaje, user.id_user');
        $this->db->join('viaje', 'viaje.id_viaje = postulacion_viaje.id_viaje', 'inner');
        $this->db->join('user', 'user.id_user = postulacion_viaje.id_user', 'inner');
        $this->db->where('postulacion_viaje.id_user', $id_postulante);
        $this->db->where('id_estado', $valorActual);
        $this->db->where('fecha', $fecha);
        $this->db->order_by('fecha', 'asc');
        $query = $this->db->get('postulacion_viaje');

        $resultado = $query->result_array();
        $fecha_inicio = $fecha;
        $hora_inicio = $hora;
        $duracion = $dura;

        foreach ($resultado as $id) {
            if ($this->postulacion_valida_antes($id['id_viaje'], $fecha_inicio, $hora_inicio) or $this->postulacion_valida_despues($id['id_viaje'], $fecha_inicio, $hora_inicio, $duracion) or $this->postulacion_valida_entre($id['id_viaje'], $fecha_inicio, $hora_inicio, $duracion)) {
                //$valor= 4;
                $this->setear_postulacion($id['id_viaje'], $id_postulante, $valor);
            }
        }
    }

    private function postulacion_valida_antes($id, $fecha_inicio, $hora_inicio) {
        //VALIDO SI EL VIAJE QUE QUIERO POSTULARME SE SUPERPONE CON OTRO VIAJE AL CUAL ME POSTULÉ Y FUE APROBADO.
        $superpone_inicio = $this->db->query("SELECT id_viaje FROM viaje WHERE id_viaje=$id AND cast(concat('$fecha_inicio',' ','$hora_inicio') as datetime) BETWEEN cast(concat(fecha,' ',hora_inicio) as datetime) AND DATE_ADD(cast(concat(fecha,' ',hora_inicio) as datetime), INTERVAL duracion_horas hour)");
        if ($superpone_inicio->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function postulacion_valida_despues($id, $fecha_inicio, $hora_inicio, $duracion) {
        //VALIDO SI EL VIAJE QUE QUIERO POSTULARME SE SUPERPONE CON OTRO VIAJE AL CUAL ME POSTULÉ Y FUE APROBADO.
        $superpone_fin = $this->db->query("SELECT id_viaje FROM viaje WHERE id_viaje=$id AND DATE_ADD(cast(concat('$fecha_inicio',' ','$hora_inicio') as datetime),INTERVAL cast('$duracion' as int) hour) AND cast(concat('$fecha_inicio',' ','$hora_inicio') as datetime) BETWEEN cast(concat(fecha,' ',hora_inicio) as datetime) AND DATE_ADD(cast(concat(fecha,' ',hora_inicio) as datetime), INTERVAL duracion_horas hour)");
        if ($superpone_fin->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function postulacion_valida_entre($id, $fecha_inicio, $hora_inicio, $duracion) {
        ///VALIDO SI EL VIAJE QUE QUIERO POSTULARME SE SUPERPONE CON OTRO VIAJE AL CUAL ME POSTULÉ Y FUE APROBADO.
        $superpone_entre = $this->db->query("SELECT id_viaje FROM viaje WHERE id_viaje=$id AND cast(concat('$fecha_inicio',' ','$hora_inicio') as datetime) <= cast(concat(fecha,' ',hora_inicio) as datetime) AND DATE_ADD(cast(concat('$fecha_inicio',' ','$hora_inicio') as datetime),INTERVAL cast('$duracion' as int) hour) >= DATE_ADD(cast(concat(fecha,' ',hora_inicio) as datetime), INTERVAL duracion_horas hour)");
        if ($superpone_entre->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function restar_plaza($id_viaje) {
        $this->db->where('id_viaje', $id_viaje);
        $this->db->select('id_viaje,id_auto, fecha, hora_inicio, duracion_horas, costo, id_chofer, origen, destino, plazas_libre, plazas_total');
        $this->db->from('viaje');
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        $resultado->plazas_libre= $resultado->plazas_libre-1;
        $this->db->where('id_viaje', $id_viaje);
        $this->db->update('viaje', $resultado);

        if ($resultado->plazas_libre == 0) {
            $this->db->where('id_viaje', $id_viaje);
            $this->db->where('id_estado', 1);       
            $this->db->select('id_viaje,id_user');
            $this->db->from('postulacion_viaje');
            $query = $this->db->get();

            $resultado = $query->result_array();
            foreach ($resultado as $id) {
                $this->db->where('id_viaje', $id['id_viaje']);
                $valor = 4;
                $this->setear_postulacion($id['id_viaje'], $id['id_user'], $valor);
            }
        }
    }
    
    public function sumar_plaza($id_viaje) {
        $this->db->where('id_viaje', $id_viaje);
        $this->db->select('id_viaje,id_auto, fecha, hora_inicio, duracion_horas, costo, id_chofer, origen, destino, plazas_libre, plazas_total');
        $this->db->from('viaje');
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        $resultado->plazas_libre= $resultado->plazas_libre+1;
        $this->db->where('id_viaje', $id_viaje);
        $this->db->update('viaje', $resultado);

        if ($resultado->plazas_libre == 1) {
            $this->db->where('id_viaje', $id_viaje);
            $this->db->where('id_estado', 4);       
            $this->db->select('id_viaje,id_user');
            $this->db->from('postulacion_viaje');
            $query = $this->db->get();

            $resultado = $query->result_array();
            foreach ($resultado as $id) {
                $this->db->where('id_viaje', $id['id_viaje']);
                $valor = 1;
                $this->setear_postulacion($id['id_viaje'], $id['id_user'], $valor);
            }
        }
    }

    public function consulta_estado($id_viaje, $id_postulante) {
        $this->db->where('id_viaje', $id_viaje);
        $this->db->where('id_user', $id_postulante);
        $this->db->select('id_estado');
        $this->db->from('postulacion_viaje');
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    function tiene_una_solicitud() {
        $id = $this->session->userdata('id_user');
        $this->db->where('id_user', $id);
        $amount_results = $this->db->count_all_results('postulacion_viaje');
        return ($amount_results >= 1);
    }

}
