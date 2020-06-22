<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dosenterpilih extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('MProposal');
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$data['data_proposal'] = $this->MProposal->get_proposal();
		$this->load->view('dosenterpilih/tampil_dosenterpilih', $data);
	}


	public function tambah_dosenterpilih()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('dosenterpilih/tambah_dosenterpilih', $data);
	}

	public function myprofile()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('dosenterpilih/profile_dosenterpilih', $data);
	}

	public function simpan()
	{
		$config['upload_path'] = './assets/document';
		$config['allowed_types'] = 'pdf|gif|jpg|png';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('proposal_pdf')) {
			$this->session->set_flashdata('gagal', $this->upload->display_errors());
			redirect('dosenterpilih');
		} else {

			$upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];

			$data = array(
				'judul'    => $this->input->post('judul'),
				'jenis'   => $this->input->post('jenis'),
				'file'   => $file_name
			);

			$simpan = $this->MProposal->simpan($data);

			if ($simpan) {
				$this->session->set_flashdata('sukses', 'Data berhasil disimpan');
				redirect('dosenterpilih');
			} else {
				$this->session->set_flashdata('gagal', 'Data gagal disimpan');
				redirect('dosenterpilih');
			}
		}
	}


	function download($id)
	{
		// $this->load->helper('download');

		// $file_pdf =$this->file->getRows(array('id_proposal'=>$id));
		// $file ='assets/document'.$file_pdf['file'];
		if (!empty($id)) {
			//load download helper
			$this->load->helper('download');
			$data = array();

			//get files from database
			$data['file'] = $this->MProposal->getRows();

			//get file info from database
			$fileInfo = $this->MProposal->getRows(array('id_proposal' => $id));

			//file path
			$file = 'assets/document/' . $fileInfo['file'];

			//download file from directory
			force_download($file, NULL);
		}
	}

	public function ganti_user()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->library('form_validation');

		$this->form_validation->set_rules('oldpass', 'old password', 'required|trim');
		$this->form_validation->set_rules('newpass', 'new password', 'required|trim|min_length[3]|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'new password', 'required|trim|min_length[3]|matches[newpass]');

		if ($this->form_validation->run() == false) {
			$this->load->view('dosenterpilih/change_pass', $data);
		} else {
			$oldpass = $this->input->post('oldpass');
			$new = $this->input->post('newpass');
			// $passconf = $this->input->post('passconf');
			if (!password_verify($oldpass, $data['user']['password'])) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong Current password</div>');
				redirect('dosenterpilih/ganti_User');
			} else {
				if ($oldpass == $new) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> New Password cannot be the same</div>');
					redirect('dosenterpilih/ganti_User');
				} else {

					$password_hash = password_hash($new, PASSWORD_DEFAULT);
					$this->db->set('password', $password_hash);
					$emailnya = $this->session->userdata('email');
					$st = "email = '$emailnya'";
					$this->db->where($st, NULL, FALSE);
					$this->db->update('tb_users');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password Berhasil Terganti</div>');
					redirect('dosenterpilih/ganti_User');
				}
			}
		}
	}

	function json()
	{
		$this->load->library('Datatables');
		$this->datatables->select('id_proposal,judul,jenis,file');
		$this->datatables->from('tb_proposal');
		$this->datatables->add_column('action', '<a href="proposal/download/$1" class="download_record btn btn-primary" >Download', 'id_proposal');
		return print_r($this->datatables->generate());
	}
}
