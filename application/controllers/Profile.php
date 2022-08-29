<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('backoffice');
		}
		$this->load->model('UserModel');
	}
	public function index()
	{
		$data['title'] = 'My Profile | Siva Sistem Verifikasi dan Pengajuan Ijazah';

		$idSession = $this->session->userdata('id_user');
		$id = $this->uri->segment(4);
		$data = $this->UserModel->getProfile($idSession);
		$row = $data->row_array();
		$x['id_user'] = $row['id_user'];
		$x['username'] = $row['username'];
		$x['email'] = $row['email'];
		$x['nama_user'] = $row['nama_user'];
		$this->backend->display('v_profile', $x);
	}

	public function editProfile()
	{
		$idSession = $this->session->userdata('id_user');
		$idfromPost = $this->input->post('id_user');
		$where = array('id_user' => $idSession);

		$paswword = $this->input->post('password');
		if ($paswword) {
			$data = array(
				// 'id_user' => $this->session->userdata('id_user'),
				'nama_user' => $this->input->post('nama_user'),
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),

			);
			// var_dump($data);
			// die;
		} else {
			$data = array(
				// 'id_user' => $this->session->userdata('id_user'),
				'nama_user' => $this->input->post('nama_user'),
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),

			);
		}
		// var_dump($where);
		// die;
		$update = $this->db->update('tb_user', $data, $where);
		// var_dump($update);
		// die;
		if ($update) {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('profile');
		} else {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('profile');
		}
	}
}
