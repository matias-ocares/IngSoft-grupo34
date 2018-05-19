<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index_page ($view) {
        //load view and pass the data
        $this->load->view('templates/header');
        $this->load->view($view);
        $this->load->view('templates/footer');
    }

}
