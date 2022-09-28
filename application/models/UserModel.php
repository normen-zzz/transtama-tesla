<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
	public function getUser()
	{
		// $ignore = array(1);
		$this->db->select('a.username, a.id_user, a.nama_user, a.id_atasan, a.id_jabatan, a.email, a.status, b.nama_role, b.id_role,c.nama_jabatan');
		$this->db->from('tb_user a');
		$this->db->join('tb_role b', 'a.id_role=b.id_role');
		$this->db->join('tbl_jabatan c', 'a.id_jabatan=c.id_jabatan', 'LEFT');
		// $this->db->join('tb_user d', 'a.id_user=d.id_atasan', 'LEFT');
		$query = $this->db->get();
		return $query;
	}
	public function getUserAdmin()
	{
		$ignore = array(1);
		$this->db->select('a.username, a.id_user, a.nama_user, a.email, a.status, b.nama_role, b.id_role, c.id_fak, c.nama_fakultas, d.id_prodi, d.nama_prodi');
		$this->db->from('tb_user a');
		$this->db->join('tb_role b', 'a.id_role=b.id_role');
		$this->db->join('fakultas c', 'a.id_fak=c.id_fak');
		$this->db->join('jurusan d', 'a.id_prodi=d.id_prodi');
		$this->db->where_not_in('a.id_role', $ignore);
		$query = $this->db->get();
		return $query;
	}
	public function getProfile($id)
	{

		$hsl = $this->db->query("SELECT * FROM tb_user where id_user='$id'");
		return $hsl;
	}
}
