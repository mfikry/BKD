<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function index()
	{

		$this->load->model('MWelcome');
		$data = $this->MWelcome->get_data();

		$this->load->view('test', $data);
	}
}
