<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaprodi extends CI_Controller
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
		$this->load->view('kaprodi/tampil_kaprodi', $data);
	}

	public function update_user($id)
	{
		$data = array(
			'role_id'    => 3,
			'id'       => $id
		);

		$simpan = $this->MProposal->updateDST($data);

		if ($simpan) {
			$this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert"> <h3>Berhasil menjadi Dosen Terpilih</h3></div>');
			redirect('kaprodi/edit_user');
		} else {
			$this->session->set_flashdata('message1', '<div class="alert alert-danger" role="alert"> <h3>Gagal menjadi Dosen Terpilih</h3></div>');
			redirect('kaprodi/edit_user');
		}
	}

	public function jadi_dosen($id)
	{
		$data = array(
			'role_id'    => 2,
			'id'       => $id
		);

		$simpan = $this->MProposal->revokeDST($data);

		if ($simpan) {
			$this->session->set_flashdata('message2', '<div class="alert alert-success" role="alert"> <h3>Berhasil menjadi Dosen</h3> </div>');
			redirect('kaprodi/edit_user');
		} else {
			$this->session->set_flashdata('message2', '<div class="alert alert-danger" role="alert"> <h3>Gagal menjadi Dosen </h3></div>');
			redirect('kaprodi/edit_user');
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
			$this->load->view('kaprodi/change_pass', $data);
		} else {
			$oldpass = $this->input->post('oldpass');
			$new = $this->input->post('newpass');
			// $passconf = $this->input->post('passconf');
			if (!password_verify($oldpass, $data['user']['password'])) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong Current password</div>');
				redirect('kaprodi/ganti_User');
			} else {
				if ($oldpass == $new) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> New Password cannot be the same</div>');
					redirect('kaprodi/ganti_User');
				} else {

					$password_hash = password_hash($new, PASSWORD_DEFAULT);
					$this->db->set('password', $password_hash);
					$emailnya = $this->session->userdata('email');
					$st = "email = '$emailnya'";
					$this->db->where($st, NULL, FALSE);
					$this->db->update('tb_users');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password Berhasil Terganti</div>');
					redirect('kaprodi/ganti_User');
				}
			}
		}
	}


	public function edit_user()
	{
		$id = $this->uri->segment(3);
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$data['data_update'] = $this->MProposal->get_user_byid($id);

		$this->load->view('kaprodi/akses_DST', $data);
	}


	public function myprofile()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('kaprodi/profile_kaprodi', $data);
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

	function json()
	{
		$this->load->library('Datatables');
		$this->datatables->select('id_proposal,judul,jenis,file,nilai');
		$this->datatables->from('tb_proposal');
		$this->datatables->add_column('action', ' <a href="proposal/download/$1" class="download_record btn btn-primary" >Download', 'id_proposal');
		return print_r($this->datatables->generate());
	}
	function dsjson()
	{
		$this->load->library('Datatables');
		$this->datatables->select('id_user,name,email');
		$this->datatables->where('role_id', 2);
		$this->datatables->from('tb_users');
		$this->datatables->add_column('action', '<a href="update_user/$1" class="edit_record btn btn-info">Change to Dosen Terpilih</a>', 'id_user');
		return print_r($this->datatables->generate());
	}
	function dstjson()
	{
		$this->load->library('Datatables');
		$this->datatables->select('id_user,name,email');
		$this->datatables->where('role_id', 3);
		$this->datatables->from('tb_users');
		$this->datatables->add_column('action', '<a href="jadi_dosen/$1" class="delete_record btn btn-danger" >Revoke acces</a> ', 'id_user');
		return print_r($this->datatables->generate());
	}
}
