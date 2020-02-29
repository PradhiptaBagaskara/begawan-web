<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
 
 class User extends REST_Controller {

 	public function __construct()
 	{
 		parent::__construct();
 		$this->load->model('M_userApi','userApi');
 		$this->load->model('M_api', 'api');
 		$this->load->model('M_api2', 'api2');

 	}


 	function index_get(){
 		$auth = $this->get('auth_key');
		$res = array("status" => false,
						"msg" => "Terjadi Kesalahan!",
							"result" => null);
		if (!empty($auth)) {
			$res = array("status" => false,
						"msg" => "Tidak ditemukan",
							"result" => null);
			$cek = $this->api->cek_field("id", $auth, "user");
			if ($cek > 0) {
				$res = array("status" => false,
						"msg" => "Tidak diijinkan",
							"result" => null);
				$cek_level = $this->api->cek_role($auth);
				if ($cek_level == 2 ) {
					$data = $this->userApi->get(["role !=" => 2]);
					$res = array("status" => true,
						"msg" => "success",
							"result" => $data);
				}elseif ($cek_level == 1) {
					$this->db->where('role', 0);
						$data =$this->db->get('user')->result();
					$res = array("status" => true,
						"msg" => "success pemodal",
							"result" => $data);
				}
			}
			
			
		}
		$this->response($res);

 	}
 	public function index_post()
 	{
 		$response = array('status' => false,
 								'msg' => 'authenticate required!',
 								'result' => null);
 		$role = $this->api->cek_role($this->post('auth_key'));
 		if (empty($role)) {
 			$role = 0;
 		}

 		if ($role > 0) {
 			$uname =  $this->api->get_username($this->post('nama'));
 			$arrayName = array('id' => $this->api->gen_uuid(),
 								'nama' => $this->post('nama'),
 								'saldo' => $this->post('saldo'),
 								'username' => $uname,
 								'password' => $this->api->password('123456'),
 								'foto' => 'thumbnail.png',
 								'role' => $this->post('role') );
 			$this->userApi->insert($arrayName);

 			$response = array('status' => true,
 								'msg' => 'success', 
 								'result' => array('username' => $uname,
 													'password' => '123456' ));
 		}
 		$this->response($response);

 		# code...
 	}
 
 }
 
