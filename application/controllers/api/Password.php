<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
 
 class Password extends REST_Controller {

 	public function __construct()
 	{
 		parent::__construct();
 		$this->load->model('M_api','api');
 		$this->load->model('M_api2','api2');
 		$this->load->model('M_userApi', 'userApi');
 	}


 	function index_get(){
 		$this->response(array('msg' => false, 'result' => null));

 	}
 
 	public function index_post()
 	{
 		$auth = $this->post("auth_key");
 		$id = $this->post("id");
 		$pass = $this->post("password");

			$out = array('status' => false,
			 								'msg' => 'terjadi kesalahan',
			 								'result' => null);
		if (empty($auth)) {
			$out = array('status' => false,
			 								'msg' => 'terjadi kesalahan',
			 								'result' => null);

		}


 		$uname = $this->api->cek_field("id", $id,"user");
 		// echo $uname;

 		if ($uname > 0 ) {

 			if ($this->api->cek_role($auth) > 1) {
 				$password = $this->api->password($pass);

	 			$var =  $this->api2->update('user', ["password"=>$password], ["id"=>$id]);

	 			if ($var) {
	 				
	 				$out = array('status' => true,
	 								'msg' => 'success',
	 								'result' => null);
	 				$this->response($out);
	 			}else{
	 				$this->response(array("status" => false,
			 											"msg" => "tidak diizinkan!",
			 			 								"result" => null));
	 			}
 			}
		 	
 		}else{
 			$this->response(array("status" => false,
		 											"msg" => "user tidak ditemukan!",
		 			 								"result" => null));
 		}

			 $this->response($out);

 	
 			
 	}

 	
 
 }
 
