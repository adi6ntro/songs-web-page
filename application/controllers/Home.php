<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['songs']=$this->songs_model->get_all_songs();
		$data['lang']="-";
		$this->load->view('home_view',$data);
	}

	public function example()
	{
		$this->load->view('example_view');
	}

	function get_autocomplete(){
        if (isset($_GET['term'])) {
            $result = $this->songs_model->search_language($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
				$arr_result[] = array(
					"value"=>$row->language_name, "lang_id"=>$row->id, "lang_name"=>$row->language_name
				);
                echo json_encode($arr_result);
            }
        }
	}

	public function search($type)
	{
		if( !isset($_POST['lang_id']) )
		{
			redirect('/', 'refresh');
		}
		$data['songs']=$this->songs_model->get_by_param($type,$this->input->post('lang_id'));
		$data['lang']=$this->songs_model->get_by_id('language','id',$this->input->post('lang_id'))->name;
		$this->load->view('home_view',$data);
	}
}
