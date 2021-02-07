<?php
class Auth_model extends CI_Model

{
    public function __construct()
    {
		parent::__construct();
    }

	function login($username, $password){
		$que = "SELECT * FROM users
				WHERE (username = ".$this->db->escape($username)." OR email = ".$this->db->escape($username).")
				ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($que);
		// print_r($query);
		if($query -> num_rows() == 1){
			if ($query->row()->user_status == 'deleted') {
				return false;
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
		$options = ['cost' => 10];
		$password = $this->generateRandomString();
		$insert_data = array(
			'username' => $this->db->escape_str($this->input->post('username')),
			'password' => password_hash($password, PASSWORD_DEFAULT, $options),
			'email' => $this->input->post('email'),
			'phone_number' => '',
		);
		if($this->db->insert('users',$insert_data)){
			$insert_id = $this->db->insert_id();
			$currentTimestamp = (new DateTime)->getTimestamp();
			// $userLastActivity = date($date)->getTimestamp();
			// $timeLapse = (($currentDate - $userLastActivity)/60);
			$this->encryption->initialize(
				array(
					'driver' => 'openssl',
					'cipher' => 'aes-256',
					'mode' => 'ctr'
				)
			);
			$plain_text = bin2hex($this->encryption->create_key(16)).'|#|'.$insert_id.'|#|'.$password.'|#|'.$currentTimestamp;
			$ciphertext = $this->encryption->encrypt($plain_text);
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
			$message = '<strong>Here is your password:</strong><br><br>' . $password;
			$message .= '<br><br><strong>Or click here to automatically sign in:</strong><br><br>'. $link;
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
				return "Account Registered successfully";
			}
		}else{
			return "Unable to register";
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
		$this->encryption->initialize(
			array(
				'driver' => 'openssl',
				'cipher' => 'aes-256',
				'mode' => 'ctr'
			)
		);
		$text = $this->encryption->decrypt($cipher);
		$id = explode("|#|",$text)[1];
		$password = explode("|#|",$text)[2];
		$que = "SELECT * FROM users WHERE id = ".$this->db->escape($id);
		$query = $this->db->query($que);
		if (password_verify($password, $query->row()->password)) {
			$this->db->where('id', $query->row()->id);
			$this->db->update('users', array('last_login' => date('Y-m-d H:i:s'),'user_status' => 'active'));
			return $query->result();
		} else {
			return false;
		}
	}

	function update_user($type){
		if($type == 'forgot'){
			$this->db->where("email",$this->db->escape_str($this->input->post('email')));
			$queryr=$this->db->get('users');
			$userInfo = $queryr->row();
			if($queryr->num_rows() != "1"){
				return "Email doesn't exist!";
			}
			$options = ['cost' => 10];
			$password = $this->generateRandomString();
			$insert_data = array(
				'password' => password_hash($password, PASSWORD_DEFAULT, $options)
			);
			$this->db->where('id', $userInfo->id);
			$this->db->update('users', $insert_data);

			$currentTimestamp = (new DateTime)->getTimestamp();
			// $userLastActivity = date($date)->getTimestamp();
			// $timeLapse = (($currentDate - $userLastActivity)/60);
			$this->encryption->initialize(
				array(
					'driver' => 'openssl',
					'cipher' => 'aes-256',
					'mode' => 'ctr'
				)
			);
			$plain_text = bin2hex($this->encryption->create_key(16)).'|#|'.$userInfo->id.'|#|'.$password.'|#|'.$currentTimestamp;
			$ciphertext = $this->encryption->encrypt($plain_text);
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
			$message = '<strong>Here is your password:</strong><br><br><br>' . $password;
			$message .= '<br><br><strong>Or click here to automatically sign in:</strong><br><br>'. $link;
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
				return "Password reset and an email sent with new password!";
			}
		} else if ($type == 'password') {
			$options = ['cost' => 10];
			$insert_data = array(
				'password' => password_hash($this->db->escape_str($this->input->post('password')), PASSWORD_DEFAULT, $options)
			);
			$this->db->where('id', $this->session->userdata('logged_in')['id']);
			$this->db->update('users', $insert_data);
			return true;
		} else if ($type == 'username') {
			$insert_data = array(
				'username' => $this->db->escape_str($this->input->post('username'))
			);
			$this->db->where('id', $this->session->userdata('logged_in')['id']);
			$this->db->update('users', $insert_data);
			return true;
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