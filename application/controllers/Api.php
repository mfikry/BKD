<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/CreatorJwt.php';
class Api extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// load model MApi
		$this->load->model('MApi');
		$this->objOfJwt = new CreatorJwt();
		header('Content-Type: application/json');
	}

	public function index()
	{
		// echo "Hello World !";
	}

	public function loginUser()
	{

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$tokenData['username'] = $username;
		$tokenData['password'] = $password;

		$passwordecrp = md5($password);

		$jwtToken = $this->objOfJwt->GenerateToken($tokenData);
		$cek_user = $this->MApi->cekusername($username, $passwordecrp);
		$response = array(
			'Token' => $jwtToken,
		);
		if ($cek_user) {
			$response['pesan'] = 'Berhasil Login';
			$response['hasil'] = true;
		} else {
			$response['pesan'] = 'Gagal login, coba lagi';
			$response['hasil'] = false;
		}

		echo json_encode($response);
	}

	public function showData()
	{
		// variable untuk menampung value json
		$response = array();

		// siapkan variabe untuk menampung data
		// yg diambil dari model
		$data_berita = $this->MApi->getData();

		// cek apakah datanya kosong apa enggak
		if ($data_berita->num_rows() > 0) {
			$response['pesan'] = '';
			$response['data'] = $data_berita->result();
			$response['hasil'] = true;
		} else {
			$response['pesan'] = 'Data kosong';
			$response['data'] = '';
			$response['hasil'] = false;
		}

		echo json_encode($response);
	}

	public function insertData()
	{

		$response = array();
		$config['upload_path'] = './assets/document/';
		$config['allowed_types'] = 'pdf|gif|jpg|png';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('user_file')) {
			// tampilkan pesan gagal upload
			$response['pesan'] = 'Gagal menyimpan file ' . $this->upload->display_errors();
			$response['hasil'] = false;

			echo json_encode($response);
		} else {
			$data_upload = $this->upload->data();
			$nama_pdf = $data_upload['file_name'];

			// tampilkan pesan berhasil
			// terima data dari client
			$judul = $this->input->post('judul');
			$jenis = $this->input->post('jenis');
			$file = $nama_pdf;

			$simpan_data = $this->MApi->insertData($judul, $jenis, $file);


			if ($simpan_data) {
				$response['pesan'] = 'Data berhasil disimpan';
				$response['hasil'] = true;
			} else {
				$response['pesan'] = 'Gagal menyimpan data, coba lagi';
				$response['hasil'] = false;
			}

			echo json_encode($response);
		}
	}

	public function updateData($id)
	{
		$response = array();
		date_default_timezone_set('Asia/Jakarta');
		$config['upload_path'] = './assets/document/';
		$config['allowed_types'] = 'pdf';


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('user_file')) {
			// tampilkan pesan gagal upload
			$response['pesan'] = 'Gagal menyimpan file ' . $this->upload->display_errors();
			$response['hasil'] = false;

			echo json_encode($response);
		} else {
			$data_upload = $this->upload->data();
			$nama_pdf = $data_upload['file_name'];

			// tampilkan pesan berhasil
			// terima data dari client
			$judul = $this->input->post('judul');
			$jenis = $this->input->post('jenis');
			$file = $nama_pdf;

			// hapus file gambar sebelumnya yang ada di dalam server
			// masukkan data baru
			$get_file = $this->MApi->getProposalById($id);
			$row = $get_file->row();
			$file_before = $row->file;
			$path_file = './assets/document/' . $file_before;
			unlink($path_file);

			$simpan_data = $this->MApi->updateData($judul, $jenis, $file, $id);


			if ($simpan_data) {
				$response['pesan'] = 'Data berhasil diperbarui';
				$response['hasil'] = true;
			} else {
				$response['pesan'] = 'Gagal memperbarui data, coba lagi';
				$response['hasil'] = false;
			}

			echo json_encode($response);
		}
	}

	public function deleteData($id)
	{

		$get_proposal = $this->MApi->getProposalById($id);
		$row = $get_proposal->row();
		$file_before = $row->file;
		$path_file = './assets/document/' . $file_before;


		$response = array();
		if (unlink($path_file)) {
			$hapus_data = $this->MApi->deleteData($id);

			if ($hapus_data) {
				$response['pesan'] = 'Data berhasil dihapus';
				$response['hasil'] = true;
			} else {
				$response['pesan'] = 'Data gagal dihapus';
				$response['hasil'] = true;
			}

			echo json_encode($response);
		} else {
			$response['pesan'] = 'Data gagal dihapus';
			$response['hasil'] = true;

			echo json_encode($response);
		}
	}


	public function registerUser()
	{
		$nama = $this->input->post('nama');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$role = $this->input->post('role');
		$passwordecrp = md5($password);

		$simpan_data = $this->MApi->insertNewUser($nama, $username, $passwordecrp, $role);

		$response = array();

		if ($simpan_data) {
			$response['pesan'] = 'Berhasil register';
			$response['hasil'] = true;
		} else {
			$response['pesan'] = 'Gagal register';
			$response['hasil'] = false;
		}

		echo json_encode($response);
	}
}
