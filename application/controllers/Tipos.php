<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('UserTypeModel');
		$this->load->helper('url');
	}

	public function index()
	{
		$tipo_usuarios = $this->UserTypeModel->get();

		$this->load->view('includes/header');
		$this->load->view('tipos', [
			'tipos' => $tipo_usuarios
		]);
		$this->load->view('includes/footer');
	}
}
