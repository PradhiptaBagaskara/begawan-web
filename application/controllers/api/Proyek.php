<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Proyek extends REST_Controller {
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
		$nama_proyek = $this->post('nama_proyek');
		$modal = $this->post('modal');
		$par = $this->post('param');
		$ket = $this->post('keterangan');

		$res = array("status" => false,
						"msg" => "Terjadi Kesalahan!",
							"result" => null);
		if (!empty($auth) && !empty($par)) {


			$cek = $this->api->cek_field("id", $auth, "user");
			$res = array("status" => false,
						"msg" => "user tidak ditemukan",
							"result" => null);

			if ($cek > 0) {
				$cek_role = $this->api->cek_role($auth);
				$res = array("status" => false,
						"msg" => "user tidak diijinkan",
							"result" => null);
				if ($cek_role == 2) {
						$res = array("status" => false,
								"msg" => "wrong method!",
									"result" => array());
					if (empty($ket)) {
						$keterangan = "Tidak ada diskripsi";
					}else{
						$keterangan = $ket;
					}
					$data = array("nama_proyek" => $nama_proyek, "modal" => $modal,"keterangan" => $keterangan);

					if ($par == "insert") {
						$this->api2->insert("proyek", $data);		
						$res = array("status" => true,
								"msg" => "proyek insert success",
									"result" => array());
					}elseif ($par == "update") {
						$id = $this->post("id");
						$this->api2->update("proyek", $data, ["id" => $id]);
						$res = array("status" => true,
								"msg" => "proyek update success",
									"result" => array());
					}


					
				}
			}

			
		}
		$this->response($res);
	}

}

/* End of file Saldo.php */
/* Location: ./application/controllers/api/Saldo.php */


 ?>