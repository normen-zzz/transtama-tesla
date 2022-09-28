<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ap extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('backoffice');
		}
		$this->load->model('ApModel', 'ap');
		cek_role();
		$this->load->library('form_validation');
	}

	public function index()
	{

		$data['title'] = 'Account Payable';
		$id_user = $this->session->userdata('id_user');
		$data['ap'] = $this->ap->getMyAp($id_user)->result_array();
		$this->backend->display('shipper/v_ap', $data);
	}
	public function add()
	{

		$data['title'] = 'Add Account Payable';
		$data['kategori_pengeluaran'] = $this->db->get('tbl_list_pengeluaran')->result_array();
		$data['kategori_ap'] = $this->db->get('tbl_kat_ap')->result_array();
		$this->backend->display('shipper/v_add_ap', $data);
	}

	public function processAdd()
	{
		$id_kategori_pengeluaran = $this->input->post('id_kategori_pengeluaran');
		var_dump($id_kategori_pengeluaran);
		die;

		$data = array(
			'nama_pt' => $this->input->post('nama_pt'),
			'pic' => $this->input->post('pic'),
			'email' => $this->input->post('email'),
			'no_telp' => $this->input->post('no_telp'),
			'alamat' => $this->input->post('alamat'),
			'join_at' => $this->input->post('join_at'),
			'provinsi' => $this->input->post('provinsi'),
			'kota' => $this->input->post('kota'),
			'username' => generatKode(),
			'password' => password_hash("Transtama2022", PASSWORD_DEFAULT),
			'status' => 1
		);
		//insert all together
		$this->db->insert('tb_customer', $data);

		$this->session->set_flashdata('message', 'Ditambahkan');
		redirect('shipper/customer');
	}
	public function getKategori()
	{
		$kategori = $this->db->get('tbl_list_pengeluaran')->result_array();
		echo json_encode($kategori);
	}

	public function delete($id)
	{
		$where = array('id_customer' => $id);
		$delete = $this->db->delete('tb_customer', $where);
		if ($delete) {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('shipper/customer');
		} else {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('shipper/customer');
		}
	}
	public function edit()
	{
		$where = array('id_customer' => $this->input->post('id_customer'));
		$data = array(
			'nama_pt' => $this->input->post('nama_pt'),
			'pic' => $this->input->post('pic'),
			'email' => $this->input->post('email'),
			'no_telp' => $this->input->post('no_telp'),
			'alamat' => $this->input->post('alamat'),
			'provinsi' => $this->input->post('provinsi'),
			'kota' => $this->input->post('kota'),
		);
		$update = $this->db->update('tb_customer', $data, $where);
		if ($update) {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('shipper/customer');
		} else {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('shipper/customer');
		}
	}
	function getCustomerById()
	{
		$ket = $this->input->post('id', TRUE);
		$data = $this->db->get_where('tb_customer', ['id_customer' => $ket])->row_array();
		echo json_encode($data);
	}
}
