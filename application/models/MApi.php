<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MApi extends CI_Model
{
	protected $table = 'tb_proposal';

	public function getData()
	{
		return $this->db->get('tb_proposal');
	}

	public function insertData($judul, $jenis, $file)
	{
		$data             = array();
		$data['judul']    = $judul;
		$data['jenis']     = $jenis;
		$data['file'] = $file;

		return $this->db->insert('tb_proposal', $data);
	}

	public function getProposalById($id)
	{
		$this->db->where('id_proposal', $id);
		return $this->db->get('tb_proposal');
	}

	public function updateData($judul, $jenis, $file, $id)
	{
		$data           = array();
		$data['judul']  = $judul;
		$data['jenis']  = $jenis;
		$data['file'] 	= $file;


		$this->db->where('id_proposal', $id);
		return $this->db->update('tb_proposal', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_proposal', $id);
		return $this->db->delete('tb_proposal');
	}

	public function cekusername($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);

		return $this->db->get('tb_users');
	}

	public function insertNewUser($nama, $username, $password, $role)
	{
		$data_insert             = array();
		$data_insert['nama']     = $nama;
		$data_insert['username']    = $username;
		$data_insert['password'] = $password;
		$data_insert['role']    = $role;

		return $this->db->insert('tb_users', $data_insert);
	}
}
