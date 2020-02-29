<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_api', 'api');
$this->load->model('M_api2', 'api2');
$this->load->model('M_userApi', 'userApi');
	
		//Do your magic here
	}

	public function index()
	{
		// $t = explode(" ", "ahmad saphi i");
		// var_dump($t);
		// echo $this->api->cek_role("a48524be21c94d52b1338dd01b73b08a");
		$this->db->select('sum(dana)');
		$this->db->from('transaksi');
		var_dump($this->db->get()->row_array());

		// $pass = $this->api->password("password");
		
		// $arrayName = array('nama' => "Super Admin",
		// 						'nomer'=> '085655082415',
		// 						'username' => "admin123",
		// 						'password' => $pass,
		// 						'saldo' => 0,
		// 						'role' => 2,
		// 						'id' => $this->gen_uuid() );
		// $this->db->insert('user', $arrayName);
		
		
	}
function gen_uuid() {
    return sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}


	
}
