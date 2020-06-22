<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewer extends CI_Controller
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
		$this->load->view('viewer/tampil_viewer', $data);
	}

	public function myprofile()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('viewer/profile_viewer', $data);
	}

	public function nilai_data()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$id = $this->uri->segment(3);
		$data['data_update'] = $this->MProposal->get_data_byid($id);

		$this->load->view('viewer/nilai_viewer', $data);
	}

	public function nilai($id)
	{
		$data = array(
			// 'judul'    => $this->input->post('judul'),
			'nilai'   => $this->input->post('nilai'),
			'id'       => $id
		);

		$simpan = $this->MProposal->update_nilai($data);

		if ($simpan) {
			$this->session->set_flashdata('sukses', 'Data berhasil diperbarui');
			redirect('viewer');
		} else {
			$this->session->set_flashdata('gagal', 'Data gagal diperbarui');
			redirect('viewer');
		}
	}

	function download($id)
	{
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
			$this->load->view('viewer/change_pass', $data);
		} else {
			$oldpass = $this->input->post('oldpass');
			$new = $this->input->post('newpass');
			// $passconf = $this->input->post('passconf');
			if (!password_verify($oldpass, $data['user']['password'])) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong Current password</div>');
				redirect('viewer/ganti_User');
			} else {
				if ($oldpass == $new) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> New Password cannot be the same</div>');
					redirect('viewer/ganti_User');
				} else {

					$password_hash = password_hash($new, PASSWORD_DEFAULT);
					$this->db->set('password', $password_hash);
					$emailnya = $this->session->userdata('email');
					$st = "email = '$emailnya'";
					$this->db->where($st, NULL, FALSE);
					$this->db->update('tb_users');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password Berhasil Terganti</div>');
					redirect('viewer/ganti_User');
				}
			}
		}
	}

	function json()
	{
		$this->load->library('Datatables');
		$this->datatables->select('id_proposal,judul,jenis,file,nilai');
		$this->datatables->from('tb_proposal');
		$this->datatables->add_column('action', '<a href="viewer/nilai_data/$1" class="edit_record btn btn-info">Nilai</a>&nbsp <a href="viewer/download/$1" class="download_record btn btn-primary" >Download', 'id_proposal');
		return print_r($this->datatables->generate());
	}
}
