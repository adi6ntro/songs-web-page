<?php
class Auth_model extends CI_Model

{
    public function __construct()
    {
		parent::__construct();
    }

	function login($username, $password){
		$que = "SELECT id, username, password, email, phone_number, user_status FROM users
				WHERE (email = ".$this->db->escape($username).")
				ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($que);
		// print_r($query);
		if($query -> num_rows() == 1){
			if ($query->row()->user_status == 'deleted') {
				return 'deleted';
			}
			if (password_verify($password, $query->row()->password)) {
				$this->db->where('id', $query->row()->id);
				$this->db->update('users', array('last_login' => date('Y-m-d H:i:s'),'user_status' => 'active'));
				return $query->result();
			} else {
				return false;
			}
		}else{
			return false;
		}
	}

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function register(){
		$umail=array('email' => $this->input->post('email'), 'user_status !=' => 'deleted');
		$queryr = $this->db->get_where('users', $umail);
		if($queryr->num_rows() > 0){
			return 'email';
		} 

		$options = ['cost' => 10];
		$password = $this->generateRandomString();
		$insert_data = array(
			'username' => $this->db->escape_str($this->input->post('username')),
			'password' => password_hash($password, PASSWORD_DEFAULT, $options),
			'email' => $this->input->post('email'),
			'phone_number' => '',
			'last_code' => base64_encode($password)
		);
		if($this->db->insert('users',$insert_data)){
			$insert_id = $this->db->insert_id();
			$currentTimestamp = (new DateTime)->getTimestamp();
			// $userLastActivity = date($date)->getTimestamp();
			// $timeLapse = (($currentDate - $userLastActivity)/60);
			// $this->encryption->initialize(
			// 	array(
			// 		'driver' => 'openssl',
			// 		'cipher' => 'aes-256',
			// 		'mode' => 'ctr'
			// 	)
			// );
			$plain_text = base64_encode($insert_data['username']).'|#|'
				.base64_encode($insert_id).'|#|'.$insert_data['password'];
			// $ciphertext = $this->encryption->encrypt($plain_text);
			$ciphertext = base64_encode($plain_text);
			$ciphertext = strtr(
				$ciphertext,
				array(
					'+' => '.',
					'=' => '-',
					'/' => '~'
				)
			);
			$url = site_url() . 'activate/' . $ciphertext;
			$link = '<a href="' . $url . '">' . $url . '</a>';
			$message = '<strong>Here is your account:</strong><br>';
			$message .= '<strong>Username: </strong>'. $insert_data['username'].'<br>';
			$message .= '<strong>Password: </strong>'. $password.'<br>';
			$message .= '<br><br><strong>Or click here to automatically sign in:</strong><br>'. $link;
			$fromemail="myappstesting8@gmail.com";
			$fromname="Admin Song Web Page";
			$subject="Request Account";
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'ssl://smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_user' => 'myappstesting8@gmail.com',
				'smtp_pass' => 'testing12345oke',
				'mailtype'  => 'html',
				'charset'	=> 'utf-8',
				'wordwrap'	=> TRUE
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($fromemail, $fromname);
			$this->email->to($this->input->post('email'));
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
				return "Mailer Error. Please click this link, ".base_url();
			}else{
				return "Your <b>account</b> has been successfully created.
				<br>We have sent a <b>password</b> to your email<br>
				<b style='color:darkred'>".$this->input->post('email')."</b><br>so you can use it to <b>log in</b>.";
			}
		}else{
			return "Unable to register.";
		}
	}
	
	function autologin($cipher){
		$cipher = strtr(
			$cipher,
			array(
				'.' => '+',
				'-' => '=',
				'~' => '/'
			)
		);
		// $this->encryption->initialize(
		// 	array(
		// 		'driver' => 'openssl',
		// 		'cipher' => 'aes-256',
		// 		'mode' => 'ctr'
		// 	)
		// );
		// $text = $this->encryption->decrypt($cipher);
		$text = base64_decode($cipher);
		$data = explode("|#|",$text);
		$username = base64_decode($data[0]);
		$id = base64_decode($data[1]);
		$password = $data[2];
		$que = "SELECT id, username, password, email, phone_number, user_status FROM users WHERE id = ".$this->db->escape($id);
		$query = $this->db->query($que);
		if($query->num_rows() > 0){
			if ($query->row()->user_status == 'deleted') {
				return 'deleted';
			}
			if ($query->row()->username != $username) {
				return 'user_change';
			}
			if ($query->row()->password == $password) {
				$this->db->where('id', $query->row()->id);
				$this->db->update('users', array('last_login' => date('Y-m-d H:i:s'),'user_status' => 'active'));
				return $query->result();
			} else {
				return 'pass_change';
			}
		}
	}

	function update_user($type){
		if($type == 'forgot'){
			$array = array(
				'email' => $this->db->escape_str($this->input->post('email')), 
				'user_status !=' => "deleted"
			);
			$this->db->where($array);
			$queryr=$this->db->get('users');
			$userInfo = $queryr->row();
			if($queryr->num_rows() != "1"){
				return "Email doesn't exist!";
			}
			$password = base64_decode($userInfo->last_code);

			$currentTimestamp = (new DateTime)->getTimestamp();
			// $userLastActivity = date($date)->getTimestamp();
			// $timeLapse = (($currentDate - $userLastActivity)/60);
			// $this->encryption->initialize(
			// 	array(
			// 		'driver' => 'openssl',
			// 		'cipher' => 'aes-256',
			// 		'mode' => 'ctr'
			// 	)
			// );
			// $plain_text = bin2hex($this->encryption->create_key(16)).'|#|'.$userInfo->id.'|#|'.$password.'|#|'.$currentTimestamp;
			$plain_text = base64_encode($userInfo->username).'|#|'
				.base64_encode($userInfo->id).'|#|'.$userInfo->password;
			// $ciphertext = $this->encryption->encrypt($plain_text);
			$ciphertext = base64_encode($plain_text);
			$ciphertext = strtr(
				$ciphertext,
				array(
					'+' => '.',
					'=' => '-',
					'/' => '~'
				)
			);
			$url = site_url() . 'activate/' . $ciphertext;
			$link = '<a href="' . $url . '">' . $url . '</a>';
			$message = '<strong>Here is your account:</strong><br>';
			$message .= '<strong>Username: </strong>'. $userInfo->username.'<br>';
			$message .= '<strong>Password: </strong>'. $password.'<br>';
			$message .= '<br><br><strong>Or click here to automatically sign in:</strong><br>'. $link;
			$fromemail="myappstesting8@gmail.com";
			$fromname="Admin Song Web Page";
			$subject="Reset Password";
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'ssl://smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_user' => 'myappstesting8@gmail.com',
				'smtp_pass' => 'testing12345oke',
				'mailtype'  => 'html',
				'charset'	=> 'utf-8',
				'wordwrap'	=> TRUE
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($fromemail, $fromname);
			$this->email->to($this->input->post('email'));
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
				return "Mailer Error. Please click this link, ".base_url();
			}else{
				return "yes";
			}
		} else if ($type == 'password') {
			$options = ['cost' => 10];
			$insert_data = array(
				'password' => password_hash($this->db->escape_str($this->input->post('password')), PASSWORD_DEFAULT, $options),
				'last_code' => base64_encode($this->input->post('password'))
			);
			$this->db->where('id', $this->session->userdata('logged_in')['id']);
			$this->db->update('users', $insert_data);
			return 'yes';
		} else if ($type == 'username') {
			$insert_data = array(
				'username' => $this->db->escape_str($this->input->post('username'))
			);
			$this->db->where('id', $this->session->userdata('logged_in')['id']);
			$this->db->update('users', $insert_data);
			return 'yes';
		} else if ($type == 'deleted') {
			$que = "SELECT id,password FROM users WHERE id = ".$this->db->escape($this->session->userdata('logged_in')['id']);
			$query = $this->db->query($que);
			if($query -> num_rows() == 1){
				if (password_verify($this->db->escape_str($this->input->post('password')), $query->row()->password)) {
					$insert_data = array(
						'user_status' => 'deleted'
					);
					$this->db->where('id', $this->session->userdata('logged_in')['id']);
					$this->db->update('users', $insert_data);
					return true;
				} 
				return false;
			}
			return false;
		}
	}
}

?>
