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
		// $this->db->select('last_insert_id()');
		// $this->db->from('user');
		// $this->db->where('id', "LAST_INSERT_ID()");
		// $token = $this->db->get()->result();
		$today = date("Y-m-d");
		$token = $this->db->query("select * from transaksi where created_date like '$today'")->result();
		// $token = $this->api2->getAll("transaksi", ["id" => "32e927bed2384fca88fd86458c2a9e30", 
		// 	'month(created_date)=' => $today]);
		// $token ="e3gT6ll4bYE:APA91bFf3LqQctzs4THGjxzNPIePhmxdXjUOysrSZCZS8TZJ70SSIu6XMNb8V7wOJfaR34VgY-_kI4HIzBbKcy37taLL0hBK5KOpy3rSIQcPnM8py0crUYhXnMVodrmbW0zGi5hYcKN1";
		// $token = "topics/Gaji";
		// $this->api->sendNotif("222", $token, "titel", "9000",2);
		// echo $token;
		// $this->db->select('nama,username,ifnull(device_token,"abcd") as device_token, created_date,role,id,foto,is_active,nomer,is_active');
		// 			$this->db->where('username','bon321');
		// 			$result = $this->db->get("user")->result();
		// var_dump($token);
		echo json_encode($token);

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
