<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

	public function editTreeCodeBulky()
	{
		// from file excel 
		$this->db->trans_start();
		try {
			$file = $_FILES['file']['name'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			if ($ext == 'csv') {
				$reader = new Csv();
			} else {
				$reader = new ReaderXlsx();
			}
			$reader->setReadDataOnly(true);
			$spreadsheet = $reader->load($_FILES['file']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();



			foreach ($sheetData as $key => $value) {
				if ($key > 0) {
					$id_city = $value[0];
					$tree_code = $value[2];
					// remove space tree code 
					$tree_code = str_replace(' ', '', $tree_code);
					if ($tree_code != '' || $tree_code != null) {
						$update = $this->db->update('tb_city', ['tree_code' => $tree_code], ['id_city' => $id_city]);
						if ($update) {
							$response = array('status' => 'success', 'message' => 'Berhasil diupdate');
						} else {
							throw new Exception('City' . $value[1] . ' gagal diupdate');
						}
					}
				}
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Transaction failed');
			} else {
				$response = array('status' => 'success', 'message' => 'Berhasil diupdate');
			}
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$response = array('status' => 'error', 'message' => $e->getMessage());
		}

		if ($response['status'] == 'success') {
			$this->session->set_flashdata('message', 'Berhasil diupdate');
			redirect('superadmin/city');
		} else {
			$this->session->set_flashdata('message', $response['message']);
			redirect('superadmin/city');
		}
	}

	public function editLeadBulky()
	{
		// from file excel 
		$this->db->trans_start();
		try {
			$file = $_FILES['file']['name'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			if ($ext == 'csv') {
				$reader = new Csv();
			} else {
				$reader = new ReaderXlsx();
			}
			$reader->setReadDataOnly(true);
			$spreadsheet = $reader->load($_FILES['file']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();



			foreach ($sheetData as $key => $value) {
				if ($key > 0) {
					$id_city = $value[0];
					$lead_min = $value[3];
					$lead_max = $value[4];
					// remove space tree code 
					$lead_min = str_replace(' ', '', $lead_min);
					$lead_max = str_replace(' ', '', $lead_max);
					if ($lead_min != '' || $lead_min != null) {
						// if lead min max number 
						if (!is_numeric($lead_min) || !is_numeric($lead_max)) {
							throw new Exception('Lead min max harus angka');
						} else {
							$update = $this->db->update('tb_city', ['lead_min' => $lead_min, 'lead_max' => $lead_max], ['id_city' => $id_city]);
							if ($update) {
								$response = array('status' => 'success', 'message' => 'Berhasil diupdate');
							} else {
								throw new Exception('City' . $value[1] . ' gagal diupdate leadnya');
							}
						}
					}
				}
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Transaction failed');
			} else {
				$response = array('status' => 'success', 'message' => 'Berhasil diupdate');
			}
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$response = array('status' => 'error', 'message' => $e->getMessage());
		}

		if ($response['status'] == 'success') {
			$this->session->set_flashdata('message', 'Berhasil diupdate');
			redirect('superadmin/city');
		} else {
			$this->session->set_flashdata('message', $response['message']);
			redirect('superadmin/city');
		}
	}
}
