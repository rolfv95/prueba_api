<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}


	public function index()
	{
		$this->load->view('includes/header');
		$this->load->view('inicio');
		$this->load->view('includes/footer');
	}
}
