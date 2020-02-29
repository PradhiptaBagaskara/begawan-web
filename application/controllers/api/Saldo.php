<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Saldo extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_userApi', 'userApi');
		$this->load->model('M_api', 'api');
		$this->load->model('M_api2', 'api2');

	}

	public function index_get()
	{
		$auth = $this->get('auth_key');
		$res = array("status" => false,
						"msg" => "Terjadi Kesalahan!",
							"result" => null);
		if (!empty($auth)) {
			$cek = $this->api->cek_field("id", $auth, "user");
			$res = array("status" => false,
						"msg" => "user tidak ditemukan",
							"result" => null);
			if ($cek > 0) {
				$saldo = $this->api2->get("user",['id' => $auth]);
				$res = array("status" => true,
							"msg" => "success",
								"result" => array('saldo' => $saldo->saldo));
			}
			
		}
		$this->response($res);
		
	}

	public function index_post()
	{
		$auth = $this->post('auth_key');
		$id = $this->post('id');
		$postSaldo = $this->post('saldo');
		$res = array("status" => false,
						"msg" => "Terjadi Kesalahan!",
							"result" => null);
		$param = $this->post('param');
		if (!empty($auth) && !empty($param)) {


			$cek = $this->api->cek_field("id", $id, "user");
			$res = array("status" => false,
						"msg" => "user tidak ditemukan",
							"result" => null);
			if ($cek > 0) {

				$saldoParr = $this->api2->get("user",['id' => $id])->saldo;


				if ($param == "tambah") {
						$saldo = $saldoParr;

					if ($postSaldo != "0") {
						$saldo = $saldoParr + $postSaldo;
							# code...
						$this->api2->insert("khas_history", ["id_user" => $id, "id_pemodal" => $auth,
										"saldo_awal" => $saldoParr, "saldo_masuk" => $postSaldo, "saldo_total" => $saldo,
										"keterangan" => "Menambahkan Saldo"]);			

					}

					# code...
				} elseif ($param == "kurang") {
					$saldo = $saldoParr - $postSaldo;

					# code...
				}
				$saldo = $this->api2->update("user", ["saldo" => $saldo], ['id' => $id]);

				$res = array("status" => true,
							"msg" => "saldo update success",
								"result" => array());
			}
			
		}
		$this->response($res);
	}

}

/* End of file Saldo.php */
/* Location: ./application/controllers/api/Saldo.php */


 ?>