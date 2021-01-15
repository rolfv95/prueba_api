<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserType extends CI_Controller {

	public function __construct()
    {
		header('Access-Control-Allow-Origin: *');
    	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->model('UserTypeModel');
	}
	
	public function index()
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'GET'){
			self::json_output(400, ['status'=> 400, 'message' => 'Solicitud inválida.']);
			return;
		}

		$res = $this->UserTypeModel->get();

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

		$res = $this->UserTypeModel->detail($params['id']);

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

		if( !isset($params['name']) || empty($params['name']) )
			$errors[] = 'name: inválido.';
		
		if( count($params['name']) > 50 )
			$errors[] = 'name: máximo 50 caracteres.';

		if( !isset($params['description']) )
			$errors[] = 'description: inválido.';

		if( count($params['description']) > 1550 )
			$errors[] = 'description: máximo 1550 caracteres.';

		if( isset($params['is_admin']) && !is_bool($params['is_admin']) )
			$errors[] = 'is_admin: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status'=>400, 'errors' => $errors]);
			return;
		}
		
		$params['is_admin'] = isset($params['is_admin']) ? $params['is_admin'] : 0;
		
		$insert_id = $this->UserTypeModel->create($params);

		$res = $this->UserTypeModel->detail($insert_id);
		
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
		
		if( isset($params['name']) && count($params['name']) > 50 )
			$errors[] = 'name: máximo 50 caracteres.';

		if( isset($params['description']) && count($params['description']) > 1550 )
			$errors[] = 'description: máximo 1550 caracteres.';

		if( isset($params['is_admin']) && !is_bool($params['is_admin']) )
			$errors[] = 'is_admin: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status' => 400, 'errors' => $errors]);
			return;
		}

		$update = $this->UserTypeModel->update($params);

		$res = $this->UserTypeModel->detail($params['id']);

		self::json_output(200, ['status'=> 201, 'message' => 'Registro actualizado.', 'result' => $res]);		
	}

	public function delete()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if( $method != 'DELETE' ){
			self::json_output(400, ['status' => 400, 'message' => 'Solicitud inválida.']);
		}

		$params = json_decode(file_get_contents('php://input'), TRUE);
		
		$errors = [];
		
		if( !isset($params['id']) || empty($params['id']) || !is_numeric($params['id']) )
			$errors[] = 'id: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status' => 400, 'errors' => $errors]);
			return;
		}

		$this->load->model('UserModel');
		$users = $this->UserModel->getById($params['id']);
		

		if( count($users) > 0){
			self::json_output(400, ['status' => 400, 'message' => 'El registro no puede ser eliminado.']);
			return;
		}

		$resp = $this->UserTypeModel->delete($params['id']);

		self::json_output(200, ['status'=> 201, 'message' => 'Registro eliminado.']);	
	
	}

	private function json_output($status, $request){
		$this->output
		->set_content_type('application/json')
		->set_status_header($status)
		->set_output(json_encode($request));
	}
}
