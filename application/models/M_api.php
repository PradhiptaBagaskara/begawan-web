<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_api extends CI_Model {

	function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}


	function sendNotif($id, $token,$title, $body,$halaman){
		$url = "https://fcm.googleapis.com/fcm/send";
	    $token = $token;
	    $serverKey = 'AAAAjVYZDqE:APA91bGcCTrevxdsrr6z21lGuMKXH2ka3SyhxMFnZiP-v13nrRguVL0yZBio5LXXxM8dYPMQfuOiPetjKtHcuXqRBCgZPBmpLHcZda80Fod89FgIYr8jQhofhuhGcEzZQBcfhPEi5VE7';
	    // $title = "Notification title";
	    // $body = "Hello I am from Your php server";
	    $notification = array("sound" => "default", 'android_channel_id' => 'com.pt.begawanpolosoro');
	    $data = array("id_user" => $id, 'title' =>$title , 'message' => $body, "halaman" => $halaman);
	    $arrayToSend = array('to' => $token,'data' => $data);
	    $json = json_encode($arrayToSend);
	    $headers = array();
	    $headers[] = 'Content-Type: application/json';
	    $headers[] = 'Authorization: key='. $serverKey;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

	    //Send the request
	    $response = curl_exec($ch);
	    //Close request
	    if ($response === FALSE) {
	    die('FCM Send Error: ' . curl_error($ch));
	    }else{
	    	return "ss";
	    }
	    curl_close($ch);
	    return;
	  //   return '<meta http-equiv="refresh"
   // content="0; url='.base_url().'">';
#126AAF
	}


	function password($pass = ""){
		$options = [
		    'cost' => 12,
		];
		return password_hash($pass, PASSWORD_BCRYPT, $options);
	}
	function cek_field($field="", $value="", $db=""){
		$this->db->select('count(*)');
		$this->db->where($field, $value);
		$cek = $this->db->get($db);
		$hasil = $cek->row_array();
		return $hasil['count(*)'];
	}


	function cek_pass($field="", $value="", $pass=""){
		$this->db->select('password');		
		$this->db->where($field, $value);
		$dbku = $this->db->get('user');
		$db_pass = $dbku->result_array();
		$isi = $db_pass[0]['password'];
		// return $isi;

		return password_verify($pass, $isi);
	}

	function get_username($value)
	{
		$t = explode(" ", $value);
		$ran = rand(10,99);
		return strtolower($t[0]).$ran;
		# code...
	}

	function cek_role($value)
	{
		$this->db->select('role');
		$this->db->from('user');
		$this->db->where('id', $value);
		return $this->db->get()->row('role');
	}



	function login($username, $pass){
		$key = $this->cek_field('username', $username, 'user');
		if ($key == "1") {
			return $this->cek_pass('username', $username, $pass);
		}else{
			return false;
		}
		return false;
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





 	public function upload_file($name_form='')
 	{
 		$config['upload_path'] = './uploads/';    
 		$config['allowed_types'] = 'jpg|png|jpeg';    
 		      
 		$this->load->library('upload', $config); 
 		// Load konfigurasi uploadnya    
 		if($this->upload->do_upload($name_form)){ 
 		// Lakukan upload dan Cek jika proses upload berhasil      
 		// Jika berhasil :      
 		$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');      
 		return $return;    
 		}else{      
 		// Jika gagal :      
 			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
 			return $return;    
 		}
 	}




}

/* End of file M_api.php */
/* Location: ./application/models/M_api.php */



 ?>