<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('dsitbacksystem');
		}
		cek_role();
	}

	public function index()
	{

		$data['title'] = 'Role';
		$data['role'] = $this->db->get('tb_role')->result_array();
		$this->backend->display('admin/v_role', $data);
	}

	public function addRole()
	{
		$data = array(
			'nama_role' => $this->input->post('nama_role')
		);

		$this->db->insert('tb_role', $data);

		$this->session->set_flashdata('message', 'Ditambahkan');
		redirect('admin/role');
	}

	public function delete($id)
	{
		$where = array('id_role' => $id);
		$delete = $this->db->delete('tb_role', $where);
		if ($delete) {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('admin/role');
		} else {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('admin/role');
		}
	}
	public function edit()
	{
		$where = array('id_role' => $this->input->post('id_role'));
		$data = array(
			'nama_role' => $this->input->post('nama_role')
		);
		$update = $this->db->update('tb_role', $data, $where);
		if ($update) {

			$this->session->set_flashdata('message', 'Diedit');
			redirect('admin/role');
		} else {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('admin/role');
		}
	}
}
