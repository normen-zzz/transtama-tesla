<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('dsitbacksystem');
		}
		$this->load->model('UserModel');
		cek_role();
	}

	public function index()
	{

		$data['title'] = 'Users';
		$data['roles'] = $this->db->get('tb_role')->result_array();
		$data['fakultas'] = $this->db->get('tb_fakultas')->result_array();
		$data['jurusan'] = $this->db->get('tb_jurusan')->result_array();
		$data['users'] = $this->UserModel->getUserAdmin()->result_array();
		$this->backend->display('admin/v_users', $data);
	}

	public function addUser()
	{
		$data = array(
			'nama_user' => $this->input->post('nama_user'),
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'id_role' => $this->input->post('id_role'),
			'id_fakultas' => $this->input->post('id_fakultas'),
			'id_jurusan' => $this->input->post('id_jurusan'),
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			'status' => 1,

		);
		//set id column value as UUID
		$this->db->set('id_user', 'UUID()', FALSE);

		//insert all together
		$this->db->insert('tb_user', $data);

		$this->session->set_flashdata('message', 'Ditambahkan');
		redirect('admin/users');
	}

	public function delete($id)
	{
		$where = array('id_user' => $id);
		$delete = $this->db->delete('tb_user', $where);
		if ($delete) {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('admin/users');
		} else {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('admin/users');
		}
	}
	public function editUser()
	{
		$where = array('id_user' => $this->input->post('id_user'));
		$paswword = $this->input->post('password');
		if ($paswword) {
			$data = array(
				'nama_user' => $this->input->post('nama_user'),
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'id_role' => $this->input->post('id_role'),
				'id_fakultas' => $this->input->post('id_fakultas'),
				'id_jurusan' => $this->input->post('id_jurusan'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'status' => $this->input->post('status')

			);
		} else {
			$data = array(
				'nama_user' => $this->input->post('nama_user'),
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'id_role' => $this->input->post('id_role'),
				'id_fakultas' => $this->input->post('id_fakultas'),
				'id_jurusan' => $this->input->post('id_jurusan'),
				'status' => $this->input->post('status')

			);
		}
		$update = $this->db->update('tb_user', $data, $where);
		if ($update) {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('admin/users');
		} else {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('admin/users');
		}
	}
}
