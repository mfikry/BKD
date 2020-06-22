<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proposal extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('MProposal');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$data['data_proposal'] = $this->MProposal->get_proposal();
		$this->load->view('proposal/tampil_proposal', $data);
	}
	public function Add_User()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('proposal/Add_User', $data);
	}

	public function tambah_user()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tb_users.email]', [
			'is_unique' => 'This email has already registered'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
			'matches' => 'Password dont match!',
			'min_length' => 'Password too short!'
		]);

		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');


		if ($this->form_validation->run() == false) {
			$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
			$this->load->view('proposal/Add_User', $data);
		} else {
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => htmlspecialchars($this->input->post('role_id', true)),
				'is_active' => 1
			];
			$this->db->insert('tb_users', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Your account has been created.</div>');
			redirect('proposal/tambah_user');
		}
	}
	public function edit_user()
	{
		$id = $this->uri->segment(3);
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$data['data_update'] = $this->MProposal->get_user_byid($id);

		$this->load->view('proposal/akses_DST', $data);
	}

	public function ganti_user()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->library('form_validation');

		$this->form_validation->set_rules('oldpass', 'old password', 'required|trim');
		$this->form_validation->set_rules('newpass', 'new password', 'required|trim|min_length[3]|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'new password', 'required|trim|min_length[3]|matches[newpass]');

		if ($this->form_validation->run() == false) {
			$this->load->view('proposal/change_pass', $data);
		} else {
			$oldpass = $this->input->post('oldpass');
			$new = $this->input->post('newpass');
			// $passconf = $this->input->post('passconf');
			if (!password_verify($oldpass, $data['user']['password'])) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong Current password</div>');
				redirect('proposal/ganti_User');
			} else {
				if ($oldpass == $new) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> New Password cannot be the same</div>');
					redirect('proposal/ganti_User');
				} else {

					$password_hash = password_hash($new, PASSWORD_DEFAULT);
					$this->db->set('password', $password_hash);
					$emailnya = $this->session->userdata('email');
					$st = "email = '$emailnya'";
					$this->db->where($st, NULL, FALSE);
					$this->db->update('tb_users');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password Berhasil Terganti</div>');
					redirect('proposal/ganti_User');
				}
			}
		}
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
			redirect('proposal/edit_user');
		} else {
			$this->session->set_flashdata('message1', '<div class="alert alert-danger" role="alert"> <h3>Gagal menjadi Dosen Terpilih</h3></div>');
			redirect('proposal/edit_user');
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
			redirect('proposal/edit_user');
		} else {
			$this->session->set_flashdata('message2', '<div class="alert alert-danger" role="alert"> <h3>Gagal menjadi Dosen </h3></div>');
			redirect('proposal/edit_user');
		}
	}
	public function hapus_data($id)
	{
		$hapus = $this->MProposal->hapus_data($id);

		if ($hapus) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> <h3>Berhasil Di Hapus </h3></div>');
			redirect('proposal');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <h3>Gagal Di Hapus </h3></div>');
			redirect('proposal');
		}
	}

	public function tambah_proposal()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('proposal/tambah_proposal', $data);
	}

	public function simpan()
	{
		$config['upload_path'] = './assets/document';
		$config['allowed_types'] = 'pdf';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('proposal_pdf')) {

			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Format File salah</div>');
			redirect('proposal/tambah_proposal');
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
				redirect('proposal/tambah_proposal');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Proposal Gagal di Upload</div>');
				redirect('proposal/tambah_proposal');
			}
		}
	}


	public function myprofile()
	{
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('proposal/profile_proposal', $data);
	}

	public function edit_data()
	{
		$id = $this->uri->segment(3);
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$data['data_update'] = $this->MProposal->get_data_byid($id);

		$this->load->view('proposal/edit_proposal', $data);
	}

	public function update($id)
	{
		$config['upload_path'] = './assets/document';
		$config['allowed_types'] = 'pdf';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('proposal_pdf')) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Format File salah</div>');
			redirect('proposal/edit_data/' + $id);
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
				redirect('proposal');
			} else {

				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><h3> Proposal Gagal di Upload</h3></div>');
				redirect('proposal/tambah_proposal');
			}
		}
	}

	public function nilai_data()
	{
		$id = $this->uri->segment(3);
		$data['user'] = $this->db->get_where('tb_users', ['email' => $this->session->userdata('email')])->row_array();
		$data['data_update'] = $this->MProposal->get_data_byid($id);

		$this->load->view('proposal/nilai_proposal', $data);
	}

	public function nilai($id)
	{
		$data = array(
			// 'judul'    => $this->input->post('judul'),
			// 'jenis'   => $this->input->post('jenis'),
			// 'file'   => $file_name,
			'nilai'   => $this->input->post('nilai'),
			'id'       => $id
		);

		$simpan = $this->MProposal->update_nilai($data);

		if ($simpan) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> <h3>Proposal Berhasil di beri Nilai</h3></div>');
			redirect('proposal');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <h3>Proposal gagal di beri Nilai</h3></div>');
			redirect('proposal');
		}
	}

	function readfile($file_name)
	{
		//file path
		$filepath = 'assets/document/' . $file_name;
		// EDIT: I added some permission/file checking.
		if (!file_exists($filepath)) {
			throw new Exception("File $filepath does not exist");
		}
		if (!is_readable($filepath)) {
			throw new Exception("File $filepath is not readable");
		}
		http_response_code(200);
		header('Content-Length: ' . filesize($filepath));
		header("Content-Type: application/pdf");
		header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
		readfile($filepath);

		exit;
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

	function json()
	{
		$this->load->library('Datatables');
		$this->datatables->select('id_proposal,judul,jenis,file,nilai');
		$this->datatables->from('tb_proposal');
		$this->datatables->add_column('action', '<a href="proposal/edit_data/$1" class="edit_record btn btn-info">Edit</a>  <a href="proposal/hapus_data/$1" class="delete_record btn btn-danger" >Delete</a> <a href="proposal/download/$1" class="download_record btn btn-primary">Download</a> <a href="proposal/nilai_data/$1" class="edit_record btn btn-info">Nilai</a> ', 'id_proposal');
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
