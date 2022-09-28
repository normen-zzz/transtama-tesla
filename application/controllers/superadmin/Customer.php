<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('backoffice');
		}
		$this->load->model('UserModel');
		$this->load->helper('kodekelas');
		cek_role();
	}

	public function index()
	{

		$data['title'] = 'Customer';
		$data['customer'] = $this->db->get('tb_customer')->result_array();
		$this->backend->display('superadmin/v_customer', $data);
	}

	public function add()
	{
		$data = array(
			'nama_pt' => $this->input->post('nama_pt'),
			'pic' => $this->input->post('pic'),
			'email' => $this->input->post('email'),
			'no_telp' => $this->input->post('no_telp'),
			'alamat' => $this->input->post('alamat'),
			'join_at' => $this->input->post('join_at'),
			// 'username' => $this->input->post('username'),
			'username' => generatKode(),
			// 'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			'password' => password_hash("Transtama2022", PASSWORD_DEFAULT),
			'status' => 1
		);
		//insert all together
		$this->db->insert('tb_customer', $data);

		$this->session->set_flashdata('message', 'Ditambahkan');
		redirect('superadmin/customer');
	}

	public function delete($id)
	{
		$where = array('id_customer' => $id);
		$delete = $this->db->delete('tb_customer', $where);
		if ($delete) {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('superadmin/customer');
		} else {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('superadmin/customer');
		}
	}
	public function edit()
	{
		$where = array('id_customer' => $this->input->post('id_customer'));
		$password = $this->input->post('password');
		if ($password) {
			$data = array(
				'nama_pt' => $this->input->post('nama_pt'),
				'pic' => $this->input->post('pic'),
				'email' => $this->input->post('email'),
				'no_telp' => $this->input->post('no_telp'),
				'alamat' => $this->input->post('alamat'),
				'join_at' => $this->input->post('join_at'),
				'username' => $this->input->post('username'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			);
		} else {
			$data = array(
				'nama_pt' => $this->input->post('nama_pt'),
				'pic' => $this->input->post('pic'),
				'email' => $this->input->post('email'),
				'no_telp' => $this->input->post('no_telp'),
				'alamat' => $this->input->post('alamat'),
				'join_at' => $this->input->post('join_at'),
				'username' => $this->input->post('username')
			);
		}
		$update = $this->db->update('tb_customer', $data, $where);
		if ($update) {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('superadmin/customer');
		} else {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('superadmin/customer');
		}
	}
}
