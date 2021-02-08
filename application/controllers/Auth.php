<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('/', 'refresh');
		}
		$data[] = '';
		// $data['csrf'] = array(
		// 	'name' => $this->security->get_csrf_token_name(),
		// 	'hash' => $this->security->get_csrf_hash()
		// );
		$this->load->view('header',$data);
		$this->load->view('auth/login',$data);
		$this->load->view('footer',$data);
	}
	
	public function signup($cek=null)
	{
		if ($this->session->userdata('logged_in')) {
			redirect('/', 'refresh');
		}
		$data['cek'] = $cek;
		// $data['csrf'] = array(
		// 	'name' => $this->security->get_csrf_token_name(),
		// 	'hash' => $this->security->get_csrf_hash()
		// );
		$this->load->view('header',$data);
		$this->load->view('auth/signup',$data);
		$this->load->view('footer',$data);
	}

	public function myaccount()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		}
		$data['username'] = $this->session->userdata('logged_in')['username'];
		// $data['csrf'] = array(
		// 	'name' => $this->security->get_csrf_token_name(),
		// 	'hash' => $this->security->get_csrf_hash()
		// );
		$this->load->view('header',$data);
		$this->load->view('auth/myaccount',$data);
		$this->load->view('footer',$data);
	}

	function verify(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('result_signup', validation_errors());
			$this->index();
		}else{
			redirect('/', 'refresh');
		}
	}

	function check_database($password){
		$username = $this->input->post('username');
		// print_r($this->input->post('username'));
		$result = $this->auth_model->login($username, $password);
		if($result){
			if ($result == 'deleted') {
				$this->form_validation->set_message('check_database', 'This account has been deleted.');
				return false;
			}
			foreach($result as $row){
				$sess_array = array(
					'id' => $row->id,
					'username' => $row->username,
					'email' => $row->email,
					'phone_number'=> ''
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return true;
		}else{
			$this->form_validation->set_message('check_database', 'Invalid username and password or email address not verified.');
			return false;
		}
	}

	function activate($link) {
		$result = $this->auth_model->autologin($link);
		if($result){
			if ($result == 'pass_change') {
				$this->session->set_flashdata('result_signup', 'This link is no longer working because you changed your password.');
			} else if ($result == 'user_change') {
				$this->session->set_flashdata('result_signup', 'This link is no longer working because you changed your username.');
			} else if ($result == 'deleted') {
				$this->session->set_flashdata('result_signup', 'This link is no longer working because the account has been deleted.');
			} else {
				foreach($result as $row){
					$sess_array = array(
						'id' => $row->id,
						'username' => $row->username,
						'email' => $row->email,
						'phone_number'=> ''
					);
					$this->session->set_userdata('logged_in', $sess_array);
				}
			}
		} else {
			$this->session->set_flashdata('result_signup', 'This link is no longer working.');
		}
		redirect('/', 'refresh');
	}

	public function check_username(){
		$uname=array('username' => $this->db->escape_str($this->input->post('username')));
		$queryr = $this->db->get_where('users', $uname);
		if($queryr->num_rows() > 0){
			echo 'false';
		}else {
			echo 'true';
		}
	}

	public function check_email(){
		$umail=array('email' => $this->db->escape_str($this->input->post('email')));
		$queryr = $this->db->get_where('users', $umail);
		if($queryr->num_rows() > 0){
			echo 'false';
		}else {
			echo 'true';
		}
	}

	public function uname($username){
		$uname=array('username' => $username, 'user_status !=' => 'deleted');
		if ($this->session->userdata('logged_in')) {
			$uname['id !='] = $this->session->userdata('logged_in')['id'];
		}
		$queryr = $this->db->get_where('users', $uname);
		// print_r($this->db->last_query());
		if($queryr->num_rows() > 0){
			if ($this->session->userdata('logged_in')['username']==$username) {
				// print_r('oke');
				return true;
			} else {
				$this->form_validation->set_message('uname', 'That username is taken. Try another.');
				// print_r('salah');
				return false;
			}
		}else {
			// print_r('oke');
			return true;
		}
	}

	function register() {
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[250]|callback_uname');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|matches[reemail]');
		$this->form_validation->set_rules('reemail', 'Rewrite Email', 'required|valid_email');
		if ($this->form_validation->run() == FALSE){
			// $this->session->set_flashdata('result_error', validation_errors());
			echo validation_errors();
		}else{
			$rr = $this->auth_model->register();
			if (strpos($rr, 'successfully') !== false) {
				$this->session->set_flashdata('result_signup', $rr);
			}
			echo $rr;
		}
	}

	function forgot() {
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run() == FALSE){
			// $this->session->set_flashdata('result_error', validation_errors());
			echo validation_errors();
		}else{
			$rr = $this->auth_model->update_user('forgot');
			// $this->session->set_flashdata('result', $rr);
			echo $rr;
		}
	}

	function change_password() {
		$this->form_validation->set_rules('password', 'Password', 'required|callback_password_check_blank');
		if ($this->form_validation->run() == FALSE){
			// $this->session->set_flashdata('result_error', validation_errors());
			echo validation_errors();
		}else{
			$rr = $this->auth_model->update_user('password');
			// $this->session->set_flashdata('result', $rr);
			echo $rr;
		}
	}

	function change_username() {
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[250]|callback_uname');
		if ($this->form_validation->run() == FALSE) {
			// $this->session->set_flashdata('result_error', validation_errors());
			echo validation_errors();
		}else{
			$rr = $this->auth_model->update_user('username');
			// $this->session->set_flashdata('result', $rr);
			echo $rr;
		}
	}

	function password_check_blank($str) {
		$pattern = '/ /';
		$result = preg_match($pattern, $str);
		if ($result) {
			$this->form_validation->set_message('password_check_blank', 'The password can not have a space.');
			return false;
		}
		return true;
	}

	function delete_account() {
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE){
			// $this->session->set_flashdata('result_error', validation_errors());
			echo validation_errors();
		}else{
			$rr = $this->auth_model->update_user('deleted');
			if ($rr) {
				echo 'yes';
			} else {
				echo 'Your password is uncorrect!';
			}
		}
	}

	function logout(){
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('/', 'refresh');
	}
}
