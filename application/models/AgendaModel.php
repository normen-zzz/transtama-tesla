<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AgendaModel extends CI_Model
{
	// dosen
	public function getAgendaByLectur()
	{
		$id_user = $this->session->userdata('id_user');
		$this->db->select('a.id_kelas, a.nama_kelas, a.kode_kelas, b.nama_agenda,b.id_agenda, b.tgl_mulai, b.jam_mulai, b.jam_selesai');
		$this->db->from('tb_kelas a');
		$this->db->join('tb_agenda b', 'a.id_kelas=b.id_kelas');
		$this->db->where('b.id_user', $id_user);
		$this->db->order_by('b.id_agenda', 'DESC');
		$this->db->limit('6');
		$query = $this->db->get();
		return $query;
	}


	// 
	public function getAgendaByStudent()
	{
		$id_user = $this->session->userdata('id_user');
		$this->db->select('a.id_kelas, a.nama_kelas, a.kode_kelas, b.nama_agenda,b.id_agenda, b.tgl_mulai, b.jam_mulai, b.jam_selesai');
		$this->db->from('tb_kelas a');
		$this->db->join('tb_agenda b', 'a.id_kelas=b.id_kelas');
		$this->db->join('tb_join_kelas c', 'c.id_kelas=b.id_kelas');
		$this->db->where('c.id_user', $id_user);
		$this->db->order_by('b.id_agenda', 'DESC');
		$this->db->limit('4');
		$query = $this->db->get();
		return $query;
	}
	public function getAgendaByIdKelas($id_kelas)
	{
		$this->db->select('*');
		$this->db->from('tb_agenda b');
		$this->db->where('b.id_kelas', $id_kelas);
		$this->db->order_by('b.id_agenda', 'DESC');
		$query = $this->db->get();
		return $query;
	}
}
