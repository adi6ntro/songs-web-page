<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('songs_model');
	}

	public function index()
	{
		$data['picture'] = $this->songs_model->get_all_songs();
		$this->load->view('example_view',$data);
	}
	
}
