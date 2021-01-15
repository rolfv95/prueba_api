<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('UserModel');
		$this->load->model('UserTypeModel');
		$this->load->helper('url');
	}

	public function index()
	{
		$usuarios =	$this->UserModel->get();
		$tipo_usuarios = $this->UserTypeModel->get();

		$this->load->view('includes/header');
		$this->load->view('usuarios', [
			'usuarios' => $usuarios,
			'tipos' => $tipo_usuarios
		]);
		$this->load->view('includes/footer');
	}
}
