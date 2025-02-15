<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Ap extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('backoffice');
		}
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		$this->load->model('ApModel', 'ap');
		cek_role();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['title'] = 'Account Payable';
		$id_user = $this->session->userdata('id_user');
		$id_atasan = $this->session->userdata('id_atasan');
		// kalo dia atasan
		if ($id_atasan == NULL || $id_atasan == 0) {
			$data['ap'] = $this->ap->getMyApAtasan($id_user)->result_array();
		} else {
			$data['ap'] = $this->ap->getMyAp($id_user)->result_array();
		}
		$this->backend->display('finance/v_ap', $data);
	}
	public function history()
	{
		$data['title'] = 'Account Payable';
		$id_user = $this->session->userdata('id_user');
		$id_atasan = $this->session->userdata('id_atasan');
		// kalo dia atasan
		if ($id_atasan == NULL || $id_atasan == 0) {
			$data['ap'] = $this->ap->getHistoryMyApAtasan($id_user)->result_array();
		} else {
			$data['ap'] = $this->ap->getHistoryMyAp($id_user)->result_array();
		}
		$this->backend->display('finance/v_ap_history', $data);
	}

	public function detail($no_ap)
	{

		$data['title'] = 'Detail Account Payable';
		$data['ap'] = $this->ap->getApByNo($no_ap)->result_array();
		$data['info'] = $this->ap->getApByNo($no_ap)->row_array();
		$data['kategori_ap'] = $this->db->get('tbl_kat_ap')->result_array();
		$data['kategori_pengeluaran'] = $this->db->get('tbl_list_pengeluaran')->result_array();
		$data['jabatan'] = $this->session->userdata('id_jabatan');
		$this->backend->display('finance/v_detail_ap', $data);
	}

	public function add()
	{

		$data['title'] = 'Add Account Payable';
		$data['kategori_pengeluaran'] = $this->db->get('tbl_list_pengeluaran')->result_array();
		$data['kategori_ap'] = $this->db->get('tbl_kat_ap')->result_array();
		$this->backend->display('finance/v_add_ap', $data);
	}

	public function processAdd()
	{
		$id_kategori_pengeluaran = $this->input->post('id_category');
		$description = $this->input->post('descriptions');
		$amount_proposed = $this->input->post('amount_proposed');
		$amount_proposed = preg_replace("/[^0-9]/", "", $amount_proposed);

		$attachment = $this->input->post('attachment');
		$mode = $this->input->post('mode');
		$via = $this->input->post('via');
		$no_ca = trim($this->input->post('no_ca'));
		// var_dump($amount_proposed);
		// die;
		$total = array_sum($amount_proposed);

		$id_kategori = $this->input->post('id_kategori_pengeluaran');
		// 1= po
		// 2= ca
		// 3=car
		// 4 = re
		$no_pengeluaran = '';
		$pre = '';
		$cek_no_invoice = $this->db->select_max('no_pengeluaran')->get_where('tbl_pengeluaran', ['id_kat_ap' => $id_kategori])->row_array();
		$cek_no_external = $this->db->select_max('no_po')->get('tbl_invoice_ap_final')->row_array();
		if ($id_kategori == 1) {
			$pre = 'PO-';
		} elseif ($id_kategori == 2) {
			$pre = 'CA-';
		} elseif ($id_kategori == 3) {
			$pre = 'CAR-';
		} elseif ($id_kategori == 4) {
			$pre = 'RE-';
		}
		if ($cek_no_invoice['no_pengeluaran'] == NULL) {
			$no_pengeluaran = $pre . '000001';
		} else {
			if ($id_kategori == 3) {
				$get_ca = $this->db->get_where('tbl_pengeluaran', ['no_pengeluaran' => $no_ca])->row_array();
				if ($get_ca) {
					$potong =	substr($get_ca['no_pengeluaran'], 4, 6);
					$no_pengeluaran = "CAR-$potong";
				} else {
					$this->session->set_flashdata('message', "<div class='alert
					alert-danger' role='alert'>No CA with This $no_ca</div>");
					redirect('shipper/ap/add');
				}
			} else {
				$potongExternal = substr($cek_no_external['no_po'], 3, 6);
				$potong = substr($cek_no_invoice['no_pengeluaran'], 3, 6);
				if ($id_kategori == 1) {

					if ($potongExternal > $potong) {
						$no = $potongExternal + 1;
					} else {
						$no = $potong + 1;
					}
				} else {
					$no = $potong + 1;
				}
				$kode =  sprintf("%06s", $no);

				$no_pengeluaran  = "$pre$kode";
			}
		}

		$id_atasan = $this->db->get_where('tb_user', ['id_user' => $this->session->userdata('id_user')])->row_array();

		$id_atasan = $id_atasan['id_atasan'];

		if ($id_atasan == 0 || $id_atasan == NULL) {
			$data_status =  2;
		} else {
			$data_status =  0;
		}

		// var_dump($id_atasan);
		// die;

		for ($i = 0; $i < sizeof($id_kategori_pengeluaran); $i++) {
			$data = array(
				'id_kategori_pengeluaran' => $id_kategori_pengeluaran[$i],
				'description' => $description[$i],
				'amount_proposed' => $amount_proposed[$i],
				// 'attachment' => $attachment[$i],
				'purpose' => $this->input->post('purpose'),
				'id_kat_ap' => $this->input->post('id_kategori_pengeluaran'),
				'date' => date('Y-m-d'),
				'total' => $total,
				'payment_mode' => $mode,
				'via_transfer' => $via,
				'no_ca' => $no_ca,
				'no_pengeluaran' => $no_pengeluaran,
				'id_user' => $this->session->userdata('id_user'),
				'id_atasan' => $id_atasan,
				'is_approve_sm' => 0,
				'status' => $data_status
			);
			$folderUpload = "./uploads/ap/";
			$files = $_FILES;

			$namaFile = $files['attachment2']['name'][$i];
			$lokasiTmp = $files['attachment2']['tmp_name'][$i];
			// # kita tambahkan uniqid() agar nama gambar bersifat unik
			$namaBaru = uniqid() . '-' . $namaFile;
			$lokasiBaru = "{$folderUpload}/{$namaBaru}";
			move_uploaded_file($lokasiTmp, $lokasiBaru);
			$ktp = array('attachment' => $namaBaru);
			if ($namaFile != NULL) {
				$data = array_merge($data, $ktp);
			}
			$insert =  $this->db->insert('tbl_pengeluaran', $data);
			if ($insert) {
				$get_last_ap = $this->db->limit(1)->order_by('id_pengeluaran', 'DESC')->get('tbl_pengeluaran')->row_array();
				// $id_atasan = $this->session->userdata('id_atasan');
				if ($id_atasan == 0 || $id_atasan == NULL) {
					$data_approve = array(
						'approve_by_atasan' => $this->session->userdata('id_user'),
						'approve_mgr_finance' => $this->session->userdata('id_user'),
						'created_mgr_finance' => date('Y-m-d H:i:s'),
						'no_pengeluaran' =>  $get_last_ap['no_pengeluaran']
					);

					$this->db->insert('tbl_approve_pengeluaran', $data_approve);
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert
					alert-danger" role="alert">Failed</div>');
				redirect('finance/ap/');
			}
		}
		$this->session->set_flashdata('message', '<div class="alert
		alert-success" role="alert">Success</div>');
		redirect('finance/ap/');
	}

	public function processAddDetail()
	{
		$where = array('no_pengeluaran' => $this->input->post('no_pengeluaran1'));
		$id_kategori_pengeluaran = $this->input->post('id_category');
		$description = $this->input->post('descriptions');

		$amount_proposed = $this->input->post('amount_proposed');
		$amount_proposed = preg_replace("/[^0-9]/", "", $amount_proposed);
		// $attachment = $this->input->post('attachment');
		$total_lama = $this->input->post('total_lama');
		$total = array_sum($amount_proposed);
		$total += $total_lama;

		$mode = $this->input->post('mode');
		$via = $this->input->post('via');
		$no_ca = $this->input->post('no_ca');

		$id_kategori = $this->input->post('id_kategori_pengeluaran1');
		// 1= po
		// 2= ca
		// 3=car
		// 4 = re
		$no_pengeluaran = $this->input->post('no_pengeluaran1');

		if ($id_kategori_pengeluaran[0] == NULL) {
			$data = array(
				'purpose' => $this->input->post('purpose'),
				'payment_mode' => $mode,
				'via_transfer' => $via,
				'no_ca' => $no_ca,
				'total' => $total,
			);
			$update = $this->db->update('tbl_pengeluaran', $data, $where);
			if ($update) {
				// unlink('uploads/ap/' . $attachment_lama);
				$this->session->set_flashdata('message', 'Diedit');
				redirect('finance/ap/detail/' . $no_pengeluaran);
			} else {
				$this->session->set_flashdata('message', 'Diedit');
				redirect('finance/ap/detail/' . $no_pengeluaran);
			}
		} else {
			$id_atasan = $this->db->get_where('tb_user', ['id_user' => $this->session->userdata('id_user')])->row_array();

			for ($i = 0; $i < sizeof($id_kategori_pengeluaran); $i++) {
				$data = array(
					'id_kategori_pengeluaran' => $id_kategori_pengeluaran[$i],
					'description' => $description[$i],
					'amount_proposed' => $amount_proposed[$i],
					// 'attachment' => $attachment[$i],
					'purpose' => $this->input->post('purpose'),
					'id_kat_ap' => $this->input->post('id_kategori_pengeluaran1'),
					'date' => date('Y-m-d'),
					'total' => $total,
					'no_ca' => $no_ca,
					'no_pengeluaran' => $no_pengeluaran,
					'id_user' => $this->session->userdata('id_user'),
					'id_atasan' => $id_atasan['id_atasan']
				);
				$folderUpload = "./uploads/ap/";
				$files = $_FILES;

				$namaFile = $files['attachment2']['name'][$i];
				$lokasiTmp = $files['attachment2']['tmp_name'][$i];
				// # kita tambahkan uniqid() agar nama gambar bersifat unik
				$namaBaru = uniqid() . '-' . $namaFile;
				$lokasiBaru = "{$folderUpload}/{$namaBaru}";
				move_uploaded_file($lokasiTmp, $lokasiBaru);
				$ktp = array('attachment' => $namaBaru);
				$data = array_merge($data, $ktp);
				$insert =  $this->db->insert('tbl_pengeluaran', $data);
				if ($insert) {
				} else {
					$this->session->set_flashdata('message', '<div class="alert
								alert-danger" role="alert">Failed</div>');
					redirect('finance/ap/detail/' . $this->input->post('no_pengeluaran1'));
				}
			}
			$data = array(
				'total' => $total,
			);
			$update = $this->db->update('tbl_pengeluaran', $data, $where);
			$this->session->set_flashdata('message', '<div class="alert
					alert-success" role="alert">Success</div>');
			redirect('finance/ap/detail/' . $this->input->post('no_pengeluaran1'));
		}
		// var_dump($id_kategori_pengeluaran[0]);
		// die;



	}

	public function editApSatuanAjax()
	{
		$id = $this->input->post('id');
		$field = $this->input->post('field');
		$value = $this->input->post('value');
		$ap = $this->db->get_where('tbl_pengeluaran', array('id_pengeluaran' => $id))->row_array();



		$data = array(
			$field => $value,

		);
		$update = $this->db->update('tbl_pengeluaran', $data, array('id_pengeluaran' => $id));
		if ($update) {
			$allAp = $this->db->get_where('tbl_pengeluaran', array('no_pengeluaran' => $ap['no_pengeluaran']))->result_array();
			$total = 0;
			foreach ($allAp as $allAp) {
				$total += $allAp['amount_proposed'];
			}
			$dataTotal = [
				'total' => $total
			];
			if ($this->db->update('tbl_pengeluaran', $dataTotal, array('no_pengeluaran' => $ap['no_pengeluaran']))) {
				$this->session->set_flashdata('message', 'Diedit');
				echo 1;
				exit;
			}

			// redirect('cs/ap/detail/' . $id);
		} else {
			$this->session->set_flashdata('message', 'Gagal');
			// redirect('cs/ap/detail/' . $id);
		}
	}
	public function getKategori()
	{
		$kategori = $this->db->get('tbl_list_pengeluaran')->result_array();
		echo json_encode($kategori);
	}

	public function approve($no_pengeluaran)
	{
		$where = array('no_pengeluaran' => $no_pengeluaran);
		$data = array(
			'no_pengeluaran' => $no_pengeluaran,
			'approve_by_atasan' => $this->session->userdata('id_user'),
			'created_atasan' => date('Y-m-d H:i:s'),
		);
		$insert = $this->db->insert('tbl_approve_pengeluaran', $data);
		if ($insert) {
			$this->db->update('tbl_pengeluaran', ['status' => 2], $where);
			$this->session->set_flashdata('message', 'Success Approve');
			redirect('finance/ap');
		} else {
			$this->session->set_flashdata('message', 'Failed Approve');
			redirect('finance/ap');
		}
	}
	
	public function decline($no_pengeluaran)
	{
		$data = [
			'status' => 6,
			'reason_void' => $this->input->post('reason'),
			'void_date' => date('Y-m-d H:i:s')
		];
		$update = $this->db->update('tbl_pengeluaran', $data, ['no_pengeluaran' => $no_pengeluaran]);
		if ($update) {
			$this->session->set_flashdata('message', 'Success Decline');
			redirect('finance/ap/detail/'.$no_pengeluaran);
		} else {
			$this->session->set_flashdata('message', 'Failed Decline');
			redirect('finance/ap/detail/'.$no_pengeluaran);
		}

	}

	public function delete($id)
	{
		$where = array('id_customer' => $id);
		$delete = $this->db->delete('tb_customer', $where);
		if ($delete) {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('finance/customer');
		} else {
			$this->session->set_flashdata('message', 'Dihapus');
			redirect('finance/customer');
		}
	}
	public function voidAp($no_ap) {
		$void = $this->db->update('tbl_pengeluaran',array('status' => 6),array('no_pengeluaran' => $no_ap));
		if ($void) {
			$this->session->set_flashdata('message', 'Void AP');
			redirect('finance/ap');
		} else {
			$this->session->set_flashdata('message', 'Failed');
			redirect('finance/ap');
		}
	}

	public function takeBackAp($no_ap) {
		if ($this->session->userdata('id_atasan') == NULL) {
			$update = array(
				'approve_by_sm' => NULL,
				'created_sm' => NULL,
				'approve_by_gm' => NULL,
				'created_gm' => NULL,
				'received_by' => NULL,
				'created_received' => NULL,
				'approve_mgr_finance' => NULL,
				'created_mgr_finance' => NULL
			);
			$takeback = $this->db->update('tbl_approve_pengeluaran',$update,array('no_pengeluaran' => $no_ap));
			$updatestatus = $this->db->update('tbl_pengeluaran',array('status' => 2),array('no_pengeluaran' => $no_ap));
		}else{
			$takeback = $this->db->delete('tbl_approve_pengeluaran',array('no_pengeluaran' => $no_ap));
			$updatestatus = $this->db->update('tbl_pengeluaran',array('status' => 0),array('no_pengeluaran' => $no_ap));
		}
		
		if ($takeback && $updatestatus) {
			
			$this->session->set_flashdata('message', 'Success');
			redirect('finance/ap/detail/'.$no_ap);
		} else {
			$this->session->set_flashdata('message', 'Failed');
			redirect('finance/ap/detail/'.$no_ap);
		}
	}
	public function edit()
	{
		// $description = $this->input->post('description');
		// $amount_proposed = $this->input->post('amount_proposed');
		// $attachment_lama = $this->input->post('attachment_lama');
		$id_pengeluaran = $this->input->post('id_pengeluaran');
		$no_pengeluaran = $this->input->post('no_pengeluaran');
		$where = array('id_pengeluaran' => $this->input->post('id_pengeluaran'));
		// $data = array(
		// 	'description' => $description,
		// 	'amount_proposed' => $amount_proposed,
		// );
		$data = [];

		$folderUpload = "./uploads/ap/";
		$files = $_FILES;
		$attachment = $files['attachmentedit']['name'];

		if ($attachment != NULL) {
			$namaFile = $files['attachmentedit']['name'];
			$lokasiTmp = $files['attachmentedit']['tmp_name'];
			// # kita tambahkan uniqid() agar nama gambar bersifat unik
			$namaBaru = uniqid() . '-' . $namaFile;
			$lokasiBaru = "{$folderUpload}/{$namaBaru}";
			move_uploaded_file($lokasiTmp, $lokasiBaru);
			$ktp = array('attachment' => $namaBaru);
			$data = array_merge($data, $ktp);
		}

		$update = $this->db->update('tbl_pengeluaran', $data, $where);
		if ($update) {
			// unlink('uploads/ap/' . $attachment_lama);
			$this->session->set_flashdata('message', 'Diedit');
			redirect('finance/ap/detail/' . $no_pengeluaran);
		} else {
			$this->session->set_flashdata('message', 'Diedit');
			redirect('finance/ap/detail/' . $no_pengeluaran);
		}
	}
	public function print($no_ap)
	{
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [210, 160.3]]);

		$data['ap'] = $this->ap->getApByNo($no_ap)->result_array();
		$data['info'] = $this->ap->getApByNo($no_ap)->row_array();
		$data['approval'] = $this->db->get_where('tbl_approve_pengeluaran', ['no_pengeluaran' => $no_ap])->row_array();

		$data = $this->load->view('superadmin/v_cetak_ap', $data, TRUE);
		$mpdf->WriteHTML($data);
		$mpdf->Output();
	}
	function getCustomerById()
	{
		$ket = $this->input->post('id', TRUE);
		$data = $this->db->get_where('tb_customer', ['id_customer' => $ket])->row_array();
		echo json_encode($data);
	}
}
