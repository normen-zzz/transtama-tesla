<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function index()
	{
		$data['layanan'] = $this->db->get('tb_layanan')->result_array();
		$this->frontend->display('frontend/index', $data);
	}
}
