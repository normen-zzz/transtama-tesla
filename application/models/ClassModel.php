<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClassModel extends CI_Model
{
	// dosen
	public function getClassByLecture()
	{
		$id_user = $this->session->userdata('id_user');
		$this->db->select('a.id_kelas, a.nama_kelas, a.hari, a.deskripsi_kelas, a.kode_kelas,a.tgl_mulai, a.jam_mulai, a.tgl_selesai, a.jam_selesai, b. nama_semester');
		$this->db->from('tb_kelas a');
		$this->db->join('tb_semester b', 'a.id_semester=b.id_semester');
		$this->db->where('a.id_user', $id_user);
		$this->db->order_by('a.id_kelas', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	public function getClassByLectureOnDashboard()
	{
		$id_user = $this->session->userdata('id_user');
		$this->db->select('a.id_kelas, a.nama_kelas, a.deskripsi_kelas, a.kode_kelas,a.tgl_mulai, a.jam_mulai, a.tgl_selesai, a.jam_selesai, b. nama_semester');
		$this->db->from('tb_kelas a');
		$this->db->join('tb_semester b', 'a.id_semester=b.id_semester');
		$this->db->where('a.id_user', $id_user);
		$this->db->order_by('a.id_kelas', 'DESC');
		$this->db->limit('6');
		$query = $this->db->get();
		return $query;
	}
	public function getClassByCode($kode)
	{
		$this->db->select('a.id_kelas, a.nama_kelas,a.hari, a.deskripsi_kelas, a.id_semester, a.kode_kelas,a.tgl_mulai, a.jam_mulai, c.nama_user, a.tgl_selesai, a.jam_selesai, b. nama_semester');
		$this->db->from('tb_kelas a');
		$this->db->join('tb_semester b', 'a.id_semester=b.id_semester');
		$this->db->join('tb_user c', 'c.id_user=a.id_user');
		$this->db->where('a.kode_kelas', $kode);
		$this->db->order_by('a.id_kelas', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	public function getAllTaskByClass($id_materi)
	{
		$this->db->select('a.jawaban, a.id_jawaban_tugas, a.id_materi, a.created_at, b.nama_user,a.nilai');
		$this->db->from('tb_jawaban_tugas a');
		$this->db->join('tb_user b', 'a.id_user=b.id_user');
		$this->db->where('a.id_materi', $id_materi);
		$query = $this->db->get();
		return $query;
	}

	public function getAllPresensiByMateri($id_materi)
	{
		$this->db->select('b.nama_user, a.created_at,a.nilai,a.id_absen');
		$this->db->from('tb_absensi a');
		$this->db->join('tb_user b', 'a.id_user=b.id_user');
		$this->db->where('a.id_materi', $id_materi);
		$query = $this->db->get();
		return $query;
	}
	public function getAllUsersByKelas($id_kelas)
	{
		$this->db->select('b.nama_user,b.email,a.join_at,a.id_kelas, a.id_join_kelas');
		$this->db->from('tb_join_kelas a');
		$this->db->join('tb_user b', 'a.id_user=b.id_user');
		$this->db->where('a.id_kelas', $id_kelas);
		$query = $this->db->get();
		return $query;
	}

	public function getForumByMateri($id_materi)
	{
		$this->db->select('a.id_materi, a.chat,a.id_forum_comment, a.created_at,a.id_user, c.email, c.nama_user');
		$this->db->from('tb_forum_comment a');
		$this->db->join('tb_materi b', 'a.id_materi=b.id_materi');
		$this->db->join('tb_user c', 'c.id_user=a.id_user');
		$this->db->where('a.id_materi', $id_materi);
		$this->db->order_by('a.id_forum_comment', 'ASC');
		$query = $this->db->get();
		return $query;
	}


	// mahasiswa

	public function getClassByStudent()
	{
		$id_user = $this->session->userdata('id_user');
		$this->db->select('a.id_kelas, a.nama_kelas, a.hari, a.deskripsi_kelas, a.kode_kelas,a.tgl_mulai, a.jam_mulai, a.tgl_selesai, d.nama_user, a.jam_selesai, b. nama_semester');
		$this->db->from('tb_kelas a');
		$this->db->join('tb_semester b', 'a.id_semester=b.id_semester');
		$this->db->join('tb_join_kelas c', 'c.kode_kelas=a.kode_kelas');
		$this->db->join('tb_user d', 'a.id_user=d.id_user');
		$this->db->where('c.id_user', $id_user);
		$this->db->order_by('c.id_join_kelas', 'DESC');
		$this->db->limit('4');
		$query = $this->db->get();
		return $query;
	}
	public function getJawabanQuiz($id_materi)
	{
		$id_user = $this->session->userdata('id_user');
		$this->db->select('a.*, b.soal,b.jawaban_benar,b.a,b.b,b.c, b.poin');
		$this->db->from('tb_jawaban_kuis_pg a');
		$this->db->join('tb_soal_kuis b', 'a.id_soal=b.id_soal');
		$this->db->where('a.id_materi', $id_materi);
		$this->db->where('a.id_user', $id_user);
		$query = $this->db->get();
		return $query;
	}
	public function getJawabanQuizByDosen($id_materi, $id_user)
	{
		$this->db->select('a.*, b.soal,b.jawaban_benar,b.a,b.b,b.c, b.poin');
		$this->db->from('tb_jawaban_kuis_pg a');
		$this->db->join('tb_soal_kuis b', 'a.id_soal=b.id_soal');
		$this->db->where('a.id_materi', $id_materi);
		$this->db->where('a.id_user', $id_user);
		$query = $this->db->get();
		return $query;
	}
	public function getNilaiQuiz($id_materi)
	{
		$this->db->select('a.*, b.nama_materi,b.deskripsi_materi, c.nama_user, c.username');
		$this->db->from('tbl_nilai_quiz a');
		$this->db->join('tb_materi b', 'a.id_materi=b.id_materi');
		$this->db->join('tb_user c', 'a.id_user=c.id_user');
		$this->db->where('a.id_materi', $id_materi);
		$query = $this->db->get();
		return $query;
	}


	function data($id)
	{
		return  $this->db->get_where('tb_soal_kuis', ['id_materi' => $id])->result_array();
	}

	function jumlah_data($id_materi)
	{
		return $this->db->get_where('tb_soal_kuis', ['id_materi' => $id_materi])->num_rows();
	}

	public function getTaskByStudent($id_materi)
	{
		$id_user = $this->session->userdata('id_user');
		$this->db->select('*');
		$this->db->from('tb_materi a');
		// $this->db->join('tb_jawaban_tugas b', 'a.id_materi=b.id_materi', 'LEFT');
		$this->db->where('a.id_materi', $id_materi);
		// $this->db->order_by('b.id_assignment', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	public function getJawabanTugasByStudent($id_materi)
	{
		$id_user = $this->session->userdata('id_user');
		$this->db->select('*');
		$this->db->from('tb_jawaban_tugas a');
		$this->db->where('a.id_materi', $id_materi);
		$this->db->where('a.id_user', $id_user);
		$query = $this->db->get();
		return $query;
	}
}
