<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
    {
		header('Access-Control-Allow-Origin: *');
    	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->model('UserModel');
	}
	
	public function index()
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'GET'){
			self::json_output(400, ['status'=> 400, 'message' => 'Solicitud inválida.']);
			return;
		}

		$res = $this->UserModel->get();

		self::json_output(200, ['status' => 200, 'result' => $res]);
	}

	public function detail()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if( $method != 'POST' ){
			self::json_output(400, ['status' => 400, 'message' => 'Solicitud inválida.']);
			return;
		}

		$params = json_decode(file_get_contents('php://input'), TRUE);
		
		$errors = [];

		if( !isset($params['id']) || empty($params['id']) || !is_numeric($params['id']) )
			$errors[] = 'id: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status' => 400, 'errors' => $errors]);
			return;
		}

		$res = $this->UserModel->detail($params['id']);

		self::json_output(200, ['status' => 201, 'result' => $res]);

	}

	public function create()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			self::json_output(400, ['status' => 400, 'message' => 'Solicitud inválida.']);
			return;
		}
		
		$params = json_decode(file_get_contents('php://input'), TRUE);
		
		$errors = [];

		if( !isset($params['alias']) || empty($params['alias']) )
			$errors[] = 'alias: inválido.';
		
		if( count($params['alias']) > 50 )
			$errors[] = 'alias: máximo 50 caracteres.';

		if( !isset($params['email']) || empty($params['email']) || !filter_var($params['email'], FILTER_VALIDATE_EMAIL) )
			$errors[] = 'email: inválido.';
		
		if( count($params['email']) > 100 )
			$errors[] = 'email: máximo 100 caracteres.';

		if( !isset($params['password']) || empty($params['password']) )
			$errors[] = 'password: inválido.';
		
		if( count($params['password']) > 50 )
			$errors[] = 'password: máximo 50 caracteres.';

		if( !isset($params['user_type_id']) || empty($params['user_type_id']) || !is_numeric($params['user_type_id']) )
			$errors[] = 'user_type_id: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status'=>400, 'errors' => $errors]);
			return;
		}
				
		$insert_id = $this->UserModel->create($params);

		$res = $this->UserModel->detail($insert_id);

		self::json_output(200, ['status'=> 201, 'message' => 'Registro creado.', 'result' => $res ]);
	}

	public function update()
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if( $method != 'PUT' ){
			self::json_output(400, ['status' => 400, 'message' => 'Solicitud inválida.']);
			return;
		}

		$params = json_decode(file_get_contents('php://input'), TRUE);

		$errors = [];

		if( !isset($params['id']) || empty($params['id']) || !is_numeric($params['id']) )
			$errors[] = 'id: inválido.';
		
		if( isset($params['alias']) && count($params['alias']) > 50 )
			$errors[] = 'alias: máximo 50 caracteres.';

		if( isset($params['email']) && ( empty($params['email']) || !filter_var($params['email'], FILTER_VALIDATE_EMAIL) ) )
			$errors[] = 'email: inválido.';
		
		if( isset($params['email']) && count($params['email']) > 100 )
			$errors[] = 'email: máximo 100 caracteres.';

		if( isset($params['password']) && empty($params['password']) )
			$errors[] = 'password: inválido.';
		
		if( isset($params['password']) && count($params['password']) > 50 )
			$errors[] = 'password: máximo 50 caracteres.';

		if( isset($params['user_type_id']) && ( empty($params['user_type_id']) || !is_numeric($params['user_type_id']) ) )
			$errors[] = 'user_type_id: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status' => 400, 'errors' => $errors]);
			return;
		}

		$update = $this->UserModel->update($params);

		$res = $this->UserModel->detail($params['id']);

		self::json_output(200, ['status'=> 201, 'message' => 'Registro actualizado.', 'result' => $res]);		
	}

	public function delete()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if( $method != 'DELETE' ){
			self::json_output(400, ['status' => 400, 'message' => 'Solicitud inválida.']);
		}

		$params = json_decode(file_get_contents('php://input'), TRUE);

		$errors= [];

		if( !isset($params['id']) || empty($params['id']) || !is_numeric($params['id']) )
			$errors[] = 'id: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status' => 400, 'errors' => $errors]);
			return;
		}

		$resp = $this->UserModel->delete($params['id']);

		self::json_output(200, ['status'=> 201, 'message' => 'Registro eliminado.']);	
	}

	private function json_output($status, $request){
		$this->output
		->set_content_type('application/json')
		->set_status_header($status)
		->set_output(json_encode($request));
	}
}
