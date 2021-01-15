<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserToken extends CI_Controller {

	const MAGIC_KEY = 'SSJ3';

	public function __construct()
    {
		header('Access-Control-Allow-Origin: *');
    	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->model('UserTokenModel');
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

		self::json_output(200, ['status' => 200, 'result' => $res]);

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

		if( !isset($params['user_id']) || empty($params['user_id']) || !is_numeric($params['user_id']) )
			$errors[] = 'user_id: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status'=>400, 'errors' => $errors]);
			return;
		}

		$header = [
			"alg" => "HS256",
			"typ" => "JWT"
		];

		$time = time();

		$payload = [
			'iat' => $time, // Tiempo que inició el token
    		'exp' => $time + (60*60), // Tiempo que expirará el token (+1 hora)
			'data' => [
				'user_id' => $params['user_id']
			]
		];

		$base64Header = base64_encode(json_encode($header));

		$base64Payload = base64_encode(json_encode($payload));
		
		$signature = hash_hmac('sha256', $base64Header.'.'.$base64Payload, 'secret_key');
		
		$token = $base64Header.'.'.$base64Payload.'.'.$signature;

		$params['token'] = $token;
		$params['created_at'] = date('Y-m-d H:i:s', $time);
		$params['expiration_at'] = date('Y-m-d H:i:s', $time + (60*60));
		
		$insert_id = $this->UserTokenModel->create($params);

		$res = $this->UserTokenModel->detail($insert_id);

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
		
		if( !isset($params['user_id']) || empty($params['user_id']) || !is_numeric($params['user_id']) )
			$errors[] = 'user_id: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status'=>400, 'errors' => $errors]);
			return;
		}

		$header = [
			"alg" => "HS256",
			"typ" => "JWT"
		];

		$time = time();

		$payload = [
			'iat' => $time, // Tiempo que inició el token
    		'exp' => $time + (60*60), // Tiempo que expirará el token (+1 hora)
			'data' => [
				'user_id' => $params['user_id']
			]
		];

		$base64Header = base64_encode(json_encode($header));

		$base64Payload = base64_encode(json_encode($payload));
		
		$signature = hash_hmac('sha256', $base64Header.'.'.$base64Payload, 'secret_key');
		
		$token = $base64Header.'.'.$base64Payload.'.'.$signature;

		$params['token'] = $token;
		$params['updated_at'] = date('Y-m-d H:i:s', $time);
		$params['expiration_at'] = date('Y-m-d H:i:s', $time + (60*60));

		$update = $this->UserTokenModel->update($params);

		$res = $this->UserTokenModel->detail($params['id']);

		self::json_output(200, ['status'=> 201, 'message' => 'Registro actualizado.', 'result' => $res]);		
	}

	public function delete()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if( $method != 'DELETE' ){
			self::json_output(400, ['status' => 400, 'message' => 'Solicitud inválida.']);
		}

		$params = json_decode(file_get_contents('php://input'), TRUE);

		if( !isset($params['id']) || empty($params['id']) || !is_numeric($params['id']) )
			$errors[] = 'id: inválido.';

		if( count($errors) > 0 ){
			self::json_output(400, ['status' => 400, 'errors' => $errors]);
			return;
		}

		$resp = $this->UserTokenModel->delete($params['id']);

		self::json_output(200, ['status'=> 201, 'message' => 'Registro eliminado.']);	
	}

	private function json_output($status, $request){
		$this->output
		->set_content_type('application/json')
		->set_status_header($status)
		->set_output(json_encode($request));
	}
}
