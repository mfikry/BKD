<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dosen extends CI_Controller
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
		$this->load->view('dosen/tampil_dosen', $data);
	}

	public function myprofile()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('dosenterpilih/profile_dosenterpilih', $data);
	}

	public function tambah_dosen()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('dosen/tambah_dosen', $data);
	}

	public function simpan()
	{
		$config['upload_path'] = './assets/document';
		$config['allowed_types'] = 'pdf';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('proposal_pdf')) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Format File salah</div>');
			redirect('dosen/tambah_dosen');
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
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Proposal Berhasil di Upload</div>');
				redirect('dosen/tambah_dosen');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Proposal Gagal di Upload</div>');
				redirect('dosen/tambah_dosen');
			}
		}
	}
	public function edit_data()
	{
		$id = $this->uri->segment(3);
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$data['data_update'] = $this->MProposal->get_data_byid($id);

		$this->load->view('dosen/edit_proposal', $data);
	}
	public function update($id)
	{
		$config['upload_path'] = './assets/document';
		$config['allowed_types'] = 'pdf';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('proposal_pdf')) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Format File salah</div>');
			redirect('dosen/edit_data/' . $id);
		} else {
			$upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];

			$data = array(
				'judul'    => $this->input->post('judul'),
				'jenis'   => $this->input->post('jenis'),
				'file'   => $file_name,
				'nilai'	=> $this->input->post('nilai'),
				'id'       => $id
			);

			$simpan = $this->MProposal->update($data);

			if ($simpan) {

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> <h3>Proposal Berhasil di Update</h3></div>');
				redirect('dosen');
			} else {

				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><h3> Proposal Gagal di Upload</h3></div>');
				redirect('dosen/edit_proposal');
			}
		}
	}

	public function hapus_data($id)
	{
		$hapus = $this->MProposal->hapus_data($id);

		if ($hapus) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> <h3>Berhasil Di Hapus </h3></div>');
			redirect('dosen');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <h3>Gagal Di Hapus </h3></div>');
			redirect('dosen');
		}
	}

	public function changepassword()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->library('form_validation');

		$this->form_validation->set_rules('oldpass', 'old password', 'required|trim');
		$this->form_validation->set_rules('newpass', 'new password', 'required|trim|min_length[3]|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'new password', 'required|trim|min_length[3]|matches[newpass]');

		if ($this->form_validation->run() == false) {
			$this->load->view('dosen/change_pass', $data);
		} else {
			$oldpass = $this->input->post('oldpass');
			$new = $this->input->post('newpass');
			// $passconf = $this->input->post('passconf');
			if (!password_verify($oldpass, $data['user']['password'])) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong Current password</div>');
				redirect('dosen/changepassword');
			} else {
				if ($oldpass == $new) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> New Password cannot be the same</div>');
					redirect('dosen/changepassword');
				} else {

					$password_hash = password_hash($new, PASSWORD_DEFAULT);
					$this->db->set('password', $password_hash);
					$emailnya = $this->session->userdata('email');
					$st = "email = '$emailnya'";
					$this->db->where($st, NULL, FALSE);
					$this->db->update('tb_users');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password Berhasil Terganti</div>');
					redirect('dosen/changepassword');
				}
			}
		}
	}
	function json()
	{
		$this->load->library('Datatables');
		$this->datatables->select('judul,jenis,file,id_proposal');
		$this->datatables->from('tb_proposal');
		$this->datatables->add_column('action', '<a href="dosen/edit_data/$1" class="edit_record btn btn-info">Edit</a>  <a href="dosen/hapus_data/$1" class="delete_record btn btn-danger" >Delete</a> <a href="dosen/download/$1" class="download_record btn btn-primary">Download</a> ', 'id_proposal');
		return print_r($this->datatables->generate());
	}
}
