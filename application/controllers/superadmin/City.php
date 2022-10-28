<?php
defined('BASEPATH') or exit('No direct script access allowed');

class City extends CI_Controller
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

		$data['title'] = 'City';
		$data['city'] = $this->db->order_by('id_city', 'DESC')->get('tb_city')->result_array();
		$this->backend->display('superadmin/v_city', $data);
	}

	public function add()
	{
		$data = array(
			'city_name' => $this->input->post('city_name'),
			'tree_code' => $this->input->post('tree_code')
		);
		//insert all together
		$this->db->insert('tb_city', $data);

		$this->session->set_flashdata('message', 'Ditambahkan');
		redirect('superadmin/city');
	}

	public function delete($id)
	{
		$where = array('id_city' => $id);
		$delete = $this->db->delete('tb_city', $where);
		if ($delete) {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('superadmin/city');
		} else {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('superadmin/city');
		}
	}
	public function edit()
	{
		$where = array('id_city' => $this->input->post('id_city'));

		$data = array(
			'city_name' => $this->input->post('city_name'),
			'tree_code' => $this->input->post('tree_code'),
		);

		$update = $this->db->update('tb_city', $data, $where);
		if ($update) {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('superadmin/city');
		} else {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('superadmin/city');
		}
	}
}
