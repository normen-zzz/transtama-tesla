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
		$this->load->model('PengajuanModel');
		cek_role();
	}
	public function index()
	{

		$data['title'] = 'Dashboard';
		$data['order'] = $this->db->get('tbl_so')->num_rows();
		$this->backend->display('finance/index', $data);
	}
}
