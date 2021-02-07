<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Songs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function detail($id)
	{
		$data['songs'] = $this->songs_model->get_by_param('songs.id',$id,1);
		$this->load->view('header',$data);
		$this->load->view('song_view',$data);
		$this->load->view('footer',$data);
	}
}
