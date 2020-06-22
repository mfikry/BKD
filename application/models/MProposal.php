<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MProposal extends CI_Model
{

	protected $table = 'tb_proposal';

	public function get_proposal()
	{
		return $this->db->get('tb_proposal');
	}
	

	public function hapus_data($id)
	{
		return $this->db->where('id_proposal', $id)->delete('tb_proposal');
	}

	public function simpan($data)
	{
		$dbdata             = array();
		$dbdata['judul']    = $data['judul'];
		$dbdata['jenis']     = $data['jenis'];
		$dbdata['file']      = $data['file'];



		return $this->db->insert('tb_proposal', $dbdata);
	}

	public function get_data_byid($id)
	{
		return $this->db->where('id_proposal', $id)->get('tb_proposal');
	}
	public function get_user_byid($id)
	{
		return $this->db->where('id_user', $id)->get('tb_users');
	}
	
	function getRows($params = array())
	{
        $this->db->select('*');
        $this->db->from('tb_proposal');
        if(array_key_exists('id_proposal',$params) && !empty($params['id_proposal'])){
            $this->db->where('id_proposal',$params['id_proposal']);
            //get records
            $query = $this->db->get();
            $result = ($query->num_rows() > 0)?$query->row_array():FALSE;
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            //get records
            $query = $this->db->get();
            $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
        }
        //return fetched data
        return $result;
    }

	public function update($data)
	{
		$dbdata             = array();
		$dbdata['judul']    = $data['judul'];
		$dbdata['jenis']     = $data['jenis'];
		$dbdata['file']      = $data['file'];
		$dbdata['nilai']      = $data['nilai'];

		return $this->db->where('id_proposal', $data['id'])->update('tb_proposal', $dbdata);
	}
	public function updateDST($data)
	{
		$dbdata             = array();
		$dbdata['role_id']    = $data['role_id'];

		return $this->db->where('id_user', $data['id'])->update('tb_users', $dbdata);
	}
	public function gantipass($data)
	{
		$dbdata             = array();
		$dbdata['password']    = $data['password'];

		return $this->db->where('id_user', $data['id'])->update('tb_users', $dbdata);
	}
	public function revokeDST($data)
	{
		$dbdata             = array();
		$dbdata['role_id']    = $data['role_id'];

		return $this->db->where('id_user', $data['id'])->update('tb_users', $dbdata);
	}
	public function update_nilai($data)
	{
		$dbdata             = array();
		// $dbdata['judul']    = $data['judul'];
		// $dbdata['jenis']     = $data['jenis'];
		// $dbdata['file']      = $data['file'];
		$dbdata['nilai']      = $data['nilai'];

		return $this->db->where('id_proposal', $data['id'])->update('tb_proposal', $dbdata);
	}
	
}
