<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Province extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('backoffice');
		}
		$this->load->model('UserModel');
		cek_role();
	}

	public function index()
	{

		$data['title'] = 'Province';
		$data['province'] = $this->db->order_by('id_province', 'DESC')->get('tb_province')->result_array();
		$this->backend->display('superadmin/v_province', $data);
	}

	public function add()
	{
		$data = array(
			'name' => $this->input->post('name'),

		);
		//insert all together
		$this->db->insert('tb_province', $data);

		$this->session->set_flashdata('message', 'Ditambahkan');
		redirect('superadmin/province');
	}

	public function delete($id)
	{
		$where = array('id_province' => $id);
		$delete = $this->db->delete('tb_province', $where);
		if ($delete) {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('superadmin/province');
		} else {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('superadmin/province');
		}
	}
	public function edit()
	{
		$where = array('id_province' => $this->input->post('id_province'));

		$data = array(
			'name' => $this->input->post('name'),
		);

		$update = $this->db->update('tb_province', $data, $where);
		if ($update) {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('superadmin/province');
		} else {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('superadmin/province');
		}
	}
}
