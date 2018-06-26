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

        $this->db->select('origen,destino,fecha,hora_inicio,nombre,apellido');
        $this->db->join('viaje', 'viaje.id_viaje = postulacion_viaje.id_viaje', 'inner');
        $this->db->join('user', 'user.id_user = postulacion_viaje.id_user', 'inner');
        $this->db->where('id_chofer', $this->session->userdata('id_user'));
        $this->db->where('id_estado', 1);
        $this->db->order_by('fecha', 'asc');
        $query = $this->db->get('postulacion_viaje', $rowperpage, $rowno);

        return $query->result_array();
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

}
