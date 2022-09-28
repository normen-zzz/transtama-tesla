<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('backoffice');
		}
		cek_role();
	}
	public function index()
	{
		$data['total_users'] = $this->db->get('tb_user')->num_rows();
		$data['order'] = $this->db->get('tbl_shp_order')->num_rows();
		$data['city'] = $this->db->get('tb_city')->num_rows();
		$data['province'] = $this->db->get('tb_province')->num_rows();
		$data['title'] = 'Dashboard';
		$this->backend->display('superadmin/index', $data);
	}
}
