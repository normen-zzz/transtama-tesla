<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Milestone extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id_user')) {
			redirect('backoffice');
		}
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		$this->load->model('MilestoneModel', 'milestone');
		$this->load->model('M_DatatablesGroup');
		$this->load->model('Sendwa', 'wa');
		 $this->load->library('upload');
		cek_role();
		$this->load->library('form_validation');
	}

	public function index()
	{

		$data['title'] = 'Milestone';
		$this->backend->display('cs/milestone/milestone', $data);
	}

	public function detailMilestone($shipment_id)
	{

		$data['title'] = 'Milestone';
		$data['shipment'] = $this->db->query('SELECT * FROM tbl_shp_order WHERE shipment_id = '.$shipment_id.' ')->row_array();
		$data['tracking'] = $this->db->get_where('tbl_tracking_real',['shipment_id' => $shipment_id])->result_array();
		$this->backend->display('cs/milestone/detailMilestone', $data);
	}

	function getDataMilestone()
    {
        $query  = "SELECT a.shipment_id, a.tgl_pickup, a.time, a.shipper, a.destination, a.pu_poin, a.is_incoming, a.id_so, a.status_so, a.deleted, a.tgl_diterima FROM tbl_shp_order AS a";
        $search = array('shipment_id');
		$where = array('a.deleted' => 0);
        // jika memakai IS NULL pada where sql
        $isWhere = 'a.tgl_diterima IS NULL AND a.status_so >= 1';
        $group = '';
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_DatatablesGroup->get_tables_query($query, $search, $where, $isWhere,$group);
    }

	public function deleteShipmentTracking($id_tracking, $shipment_id)
    {
        $delete = $this->db->delete('tbl_tracking_real', ['id_tracking' => $id_tracking]);
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Sukses');
			redirect('cs/Milestone/detailMilestone/' . $shipment_id);
        } else {
            $this->session->set_flashdata('message', 'Delete Gagal');
            redirect('cs/Milestone/detailMilestone/' . $shipment_id);
        }
    }

	public function updateShipmentTracking()
    {
        $status = $this->input->post('status');
        $flag = '';
        if ($status == 'Shipment Telah Tiba Di Hub') {
            $flag = 9;
        } else if ($status == 'Shipment Keluar Di Hub Tujuan') {
            $flag = 10;
        } else if ($status == 'Shipment Dalam Proses Delivery') {
            $flag = 11;
        } else {
            $flag = 12;
        }

        $id_so = $this->input->post('id_so');
        $shipment_id = $this->input->post('shipment_id');
        $data = array(
            'status' => $this->input->post('status') . ' ' . $this->input->post('note'),
            'note' => $this->input->post('note'),
            'created_at' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'pic_task' => $this->input->post('note')
        );
        $config['upload_path'] = './uploads/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        $folderUpload = "./uploads/berkas_uncompress/";
        $files = $_FILES;
        $files = $_FILES;
        $jumlahFile = count($files['ktp']['name']);
        if (!empty($_FILES['ktp']['name'][0])) {
            $listNamaBaru = array();
            for ($i = 0; $i < $jumlahFile; $i++) {
                $namaFile = $files['ktp']['name'][$i];
                $lokasiTmp = $files['ktp']['tmp_name'][$i];

                # kita tambahkan uniqid() agar nama gambar bersifat unik
                $namaBaru = uniqid() . '-' . $namaFile;

                array_push($listNamaBaru, $namaBaru);
                $lokasiBaru = "{$folderUpload}/{$namaBaru}";
                $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

                # jika proses berhasil
                if ($prosesUpload) {
                } else {
                    $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                    redirect('cs/Milestone/detailMilestone/' . $shipment_id);
                }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $this->resizeImage($namaBaru);
            $ktp = array('bukti' => $namaBaru);
            $data = array_merge($data, $ktp);
        }
        $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
        $this->session->set_flashdata('message', 'Update Sukses');
		redirect('cs/Milestone/detailMilestone/' . $shipment_id);
    }
	public function updateShipmentTrackingAdd()
    {
        $status = $this->input->post('status');
        $flag = '';
        if ($status == 'Shipment Telah Tiba Di Hub') {
            $flag = 9;
        } else if ($status == 'Shipment Keluar Di Hub Tujuan') {
            $flag = 10;
        } else if ($status == 'Shipment Dalam Proses Delivery') {
            $flag = 11;
        } elseif ($status == 'Shipment Telah Diterima Oleh') {
            $flag = 12;
        } elseif ($status == 'Request Pickup From Shipper') {
            $flag = 1;
        } elseif ($status == 'Driver Menuju Lokasi Pickup') {
            $flag = 2;
        } elseif ($status == 'Driver Telah Sampai Di Lokasi Pickup') {
            $flag = 3;
        } elseif ($status == 'Shipment Telah Dipickup Dari Shipper') {
            $flag = 4;
        } elseif ($status == 'Shipment Telah Tiba Di Hub Jakarta Pusat') {
            $flag = 5;
        } elseif ($status == 'Shipment Keluar Dari Hub Jakarta Pusat') {
            $flag = 6;
        } elseif ($status == 'Shipment Telah Tiba Di Hub CGK' || $status == 'Shipment Telah Tiba Di Hub Jakarta Utara') {
            $flag = 7;
        } elseif ($status == 'Shipment Keluar Dari Hub CGK' || $status == 'Shipment Keluar Dari Hub Jakarta Utara') {
            $flag = 8;
        }

        $id_so = $this->input->post('id_so');
        $shipment_id = $this->input->post('shipment_id');
        $data = array(
            'status' => $this->input->post('status') . ' ' . $this->input->post('note'),
            'note' => $this->input->post('note'),
            'id_so' => $id_so,
            'shipment_id' => $shipment_id,
            'created_at' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'flag' => $flag,
            'id_user' => $this->input->post('id_user'),
            'status_eksekusi' => 1
        );
        $config['upload_path'] = './uploads/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        $folderUpload = "./uploads/berkas_uncompress/";
        $files = $_FILES;
        $files = $_FILES;
        $jumlahFile = count($files['ktp']['name']);
        if (!empty($_FILES['ktp']['name'][0])) {
            $listNamaBaru = array();
            for ($i = 0; $i < $jumlahFile; $i++) {
                $namaFile = $files['ktp']['name'][$i];
                $lokasiTmp = $files['ktp']['tmp_name'][$i];

                # kita tambahkan uniqid() agar nama gambar bersifat unik
                $namaBaru = uniqid() . '-' . $namaFile;

                array_push($listNamaBaru, $namaBaru);
                $lokasiBaru = "{$folderUpload}/{$namaBaru}";
                $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

                # jika proses berhasil
                if ($prosesUpload) {
                } else {
                    $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                    redirect('cs/Milestone/detailMilestone/' . $shipment_id);
                }
            }
        }
        $namaBaru = implode("+", $listNamaBaru);
        $this->resizeImage($namaBaru);
        $ktp = array('bukti' => $namaBaru);
        $data = array_merge($data, $ktp);

        $this->db->insert('tbl_tracking_real', $data);
        if ($status == "Shipment Telah Diterima Oleh") {
            // update tgl diterima
            $data = array(
                'tgl_diterima' => $this->input->post('date')
            );
            $this->db->update('tbl_shp_order', $data, ['shipment_id' => $shipment_id]);
        }
        $this->session->set_flashdata('message', 'Update Sukses');
		redirect('cs/Milestone/detailMilestone/' . $shipment_id);
    }
	public function resizeImage($filename)
    {
        $files = explode("+", $filename);
        // var_dump($files);
        // die;
        for ($i = 0; $i < sizeof($files); $i++) {
            $source_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/berkas_uncompress/' . $files[$i];
            $target_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/berkas/';
            $config_manip = array(
                'image_library' => 'gd2',
                'source_image' => $source_path,
                'new_image' => $target_path,
                'maintain_ratio' => TRUE,
                'width' => 500,
            );

            $this->load->library('image_lib');
            $this->image_lib->initialize($config_manip);
            $this->image_lib->resize();
            $this->image_lib->clear();
            // if (!$this->image_lib->resize()) {
            //     echo $this->image_lib->display_errors();
            // }
            // $this->image_lib->resize();
        }
    }
}
