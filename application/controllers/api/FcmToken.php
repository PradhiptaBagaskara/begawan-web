<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class FcmToken extends REST_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_userApi', 'userApi');
		$this->load->model('M_api2', 'api2');
		$this->load->model('M_api', 'api');

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
				$id = $this->get("id");


				if (!empty($id)) {
				$this->db->select('ifnull(sum(transaksi.dana), "0") as total_dana, proyek.modal - ifnull(sum(transaksi.dana),"0") as sisa_modal ,proyek.id,proyek.nama_proyek,ifnull(proyek.keterangan, "Tidak Ada Catatan") as keterangan,proyek.modal, DATE_FORMAT(proyek.created_date, "%a, %d %M %Y") as created_date');
				$this->db->from('proyek');
				$this->db->join('transaksi', 'transaksi.id_proyek = proyek.id', 'left');
				$this->db->where('proyek.id', $id);
				$this->db->order_by('created_date', 'desc');
				$proyek = $this->db->get()->result();

				$tx = $this->api2->getTx(['id_proyek' => $id]);
					
				}else{

				$proyek=$this->db->get('proyek')->result();


				$tx = null;		

				
				}

				$res = array("status" => true,
							"msg" => "success",
							"transaksi" => $tx,
								"result" => $proyek);
				
			}
			
		}
		$this->response($res);
		
	}

	public function index_post()
	{
		$auth = $this->post('auth_key');
		$token = $this->post('token');
	
		$res = array("status" => false,
						"msg" => "Terjadi Kesalahan!",
							"result" => null);
		if (!empty($auth)) {


			$cek = $this->api->cek_field("id", $auth, "user");
			$res = array("status" => false,
						"msg" => "user tidak ditemukan",
							"result" => null);

			if ($cek > 0) {
				$this->api2->update("user", ["device_token" => $token], ["id"=>$auth]);
				$res = array("status" => true,
						"msg" => "token update",
							"result" => null);
			}

			
		}
		$this->response($res);
	}

}

/* End of file Saldo.php */
/* Location: ./application/controllers/api/Saldo.php */


 ?>