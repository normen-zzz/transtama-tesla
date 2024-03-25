<?php


defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RequestPrice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('PengajuanModel', 'order');
        $this->load->model('SalesModel', 'sales');
        $this->load->model('Sendwa', 'wa');
        $this->load->model('WilayahModel', 'wilayah');
        // $this->load->model('RequestPriceModel')

        cek_role();
    }
    public function index()
    {
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $dayNow = date('d');
        $monthNow = date('m');
        $yearNow = date('Y');
        $provinsi = $this->wilayah->getDataProvinsi();






        if ($awal == NULL) {
            $awal = date('Y-m-d H:i:s', strtotime($yearNow . '-' . $monthNow . '-' . '1'));
            $akhir = date('Y-m-t H:i:s');

            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'Request Pricee';
            $data['requestPrice'] = $this->sales->getRequestPriceNotApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['requestPriceApprove'] = $this->sales->getRequestPriceApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['province'] = $this->db->get('tb_province')->result_array();
            $data['provinsi'] = $provinsi;
            $data['city'] = $this->db->get('tb_city')->result_array();
        } else {
            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'Request Price';
            $data['requestPrice'] = $this->sales->getRequestPriceNotApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['requestPriceApprove'] = $this->sales->getRequestPriceApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['province'] = $this->db->get('tb_province')->result_array();
            $data['provinsi'] = $provinsi;
            $data['city'] = $this->db->get('tb_city')->result_array();
        }

        $this->backend->display('sales/v_request_price', $data);
    }

    public function getModalEditRequest()
    {
        $id_request = $this->input->get('id_request'); // Mengambil ID dari parameter GET
        $request = $this->db->get_where('tbl_request_price', array('id_request_price' => $id_request))->row();




        // Kirim data sebagai respons JSON
        echo json_encode($request);
    }

    public function getdate()
    {
        var_dump(date('Y-m-t H:i:s'));
    }

    public function addNewRequest()
    {

        $QuerylastRequest = "SELECT a.group FROM tbl_request_price a ORDER BY a.group DESC LIMIT 1";
        $lastRequest = $this->db->query($QuerylastRequest)->row();
        $code = $this->sales->getCodeRequestPrice();
        // var_dump($lastRequest->group);
        $request = [
            'id_sales' => $this->session->userdata('id_user'),
            'code_request_price' => $code,
            'date_request' => date('Y-m-d H:i:s'),
            'province_from' => $this->input->post('provinsi_from'),
            'city_from' => $this->input->post('kabupaten_from'),
            'subdistrict_from' => $this->input->post('kecamatan_from'),
            'alamat_from' => $this->input->post('alamat_from'),
            'province_to' => $this->input->post('provinsi_to'),
            'city_to' => $this->input->post('kabupaten_to'),
            'subdistrict_to' => $this->input->post('kecamatan_to'),
            'alamat_to' => $this->input->post('alamat_to'),
            'moda' => $this->input->post('moda'),
            'jenis_barang' => $this->input->post('jenis'),
            'berat' => $this->input->post('berat'),
            'panjang' => $this->input->post('panjang'),
            'lebar' => $this->input->post('lebar'),
            'tinggi' => $this->input->post('tinggi'),
            'koli' => $this->input->post('koli'),
            'komoditi' => $this->input->post('komoditi'),
            'notes_sales' => $this->input->post('notes'),
            'is_bulk' => 0,
            'group' => $lastRequest->group + 1
        ];


        $update = $this->db->insert('tbl_request_price', $request);
        if ($update) {
            $pesan = "Hallo CS, ada pengajuan harga baru dari " . $this->session->userdata('nama_user') . " Tolong Segera Cek Ya, Terima Kasih";
            $this->wa->pickup('+6285697780467', "$pesan");
            $this->session->set_flashdata('message', 'Anda Berhasil Menambah Request');
            redirect('sales/RequestPrice');
        } else {
            $this->session->set_flashdata('message', 'Anda Gagal Menambah Request');
            redirect('sales/RequestPrice');
        }
    }

    public function editRequest()
    {

        $request = [
            'id_sales' => $this->session->userdata('id_user'),
            'date_request' => date('Y-m-d H:i:s'),
            'province_from' => $this->input->post('provinsi_from'),
            'city_from' => $this->input->post('kabupaten_from'),
            'subdistrict_from' => $this->input->post('kecamatan_from'),
            'alamat_from' => $this->input->post('alamat_from'),
            'province_to' => $this->input->post('provinsi_to'),
            'city_to' => $this->input->post('kabupaten_to'),
            'subdistrict_to' => $this->input->post('kecamatan_to'),
            'alamat_to' => $this->input->post('alamat_to'),
            'moda' => $this->input->post('moda'),
            'jenis_barang' => $this->input->post('jenis'),
            'berat' => $this->input->post('berat'),
            'panjang' => $this->input->post('panjang'),
            'lebar' => $this->input->post('lebar'),
            'tinggi' => $this->input->post('tinggi'),
            'koli' => $this->input->post('koli'),
            'komoditi' => $this->input->post('komoditi'),
            'notes_sales' => $this->input->post('notes'),
        ];


        $update = $this->db->update('tbl_request_price', $request, array('id_request_price' => $this->input->post('id_request')));
        if ($update) {
            // $pesan = "Hallo Finance, ada pengajuan harga baru dari " . $this->session->userdata('nama_user') . " Tolong Segera Cek Ya, Terima Kasih";
            // $this->wa->pickup('+6285697780467', "$pesan");
            $this->session->set_flashdata('message', 'Anda Berhasil Menambah Request');
            redirect('sales/RequestPrice');
        } else {
            $this->session->set_flashdata('message', 'Anda Gagal Menambah Request');
            redirect('sales/RequestPrice');
        }
    }

    public function editRequestBulk()
    {

        $request = [
            'id_sales' => $this->session->userdata('id_user'),
            'date_request' => date('Y-m-d H:i:s'),
            'province_from' => $this->input->post('provinsi_from'),
            'city_from' => $this->input->post('kabupaten_from'),
            'subdistrict_from' => $this->input->post('kecamatan_from'),
            'alamat_from' => $this->input->post('alamat_from'),
            'province_to' => $this->input->post('provinsi_to'),
            'city_to' => $this->input->post('kabupaten_to'),
            'subdistrict_to' => $this->input->post('kecamatan_to'),
            'alamat_to' => $this->input->post('alamat_to'),
            'moda' => $this->input->post('moda'),
            'jenis_barang' => $this->input->post('jenis'),
            'berat' => $this->input->post('berat'),
            'panjang' => $this->input->post('panjang'),
            'lebar' => $this->input->post('lebar'),
            'tinggi' => $this->input->post('tinggi'),
            'koli' => $this->input->post('koli'),
            'komoditi' => $this->input->post('komoditi'),
            'notes_sales' => $this->input->post('notes'),
        ];


        $update = $this->db->update('tbl_request_price', $request, array('id_request_price' => $this->input->post('id_request')));
        if ($update) {
            // $pesan = "Hallo Finance, ada pengajuan harga baru dari " . $this->session->userdata('nama_user') . " Tolong Segera Cek Ya, Terima Kasih";
            // $this->wa->pickup('+6285697780467', "$pesan");
            $this->session->set_flashdata('message', 'Anda Berhasil Menambah Request');
            redirect('sales/RequestPrice/detailRequestPriceBulk/' . $this->input->post('code'));
        } else {
            $this->session->set_flashdata('message', 'Anda Gagal Menambah Request');
            redirect('sales/RequestPrice/detailRequestPriceBulk/' . $this->input->post('code'));
        }
    }

    public function deleteRequestPrice($id)
    {
        if ($this->db->delete('tbl_request_price', array('id_request_price' => $id))) {
            $this->session->set_flashdata('message', 'Berhasil Menghapus');
            redirect('sales/RequestPrice');
        }
    }

    //untuk ambil wilayah kabupaten

    public function getKabupaten($id_prov = NULL)
    {

        if ($id_prov != NULL) {
            $kabupaten = $this->wilayah->getDataKabupaten($id_prov);
            $data = "<option value=''>- Select Kabupaten -</option>";
            foreach ($kabupaten as $id_kabupaten => $nama_kabupaten) {
                $data .= "<option data-id_prov='" . $id_prov . "'  data-id_kab='" . $id_kabupaten . "' value='" . $nama_kabupaten . "'>" . $nama_kabupaten . "</option>";
            }
        } else {
            $data = "<option value=''>- Select Kabupaten -</option>";
        }
        echo $data;
    }

    public function getKecamatan($id_prov = NULL, $id_kab = NULL)
    {

        if ($id_prov != NULL && $id_kab != NULL) {
            $kecamatan = $this->wilayah->getDataKecamatan($id_prov, $id_kab);
            $data = "<option value=''>- Select Kecamatan -</option>";
            foreach ($kecamatan as $id_kecamatan => $nama_kecamatan) {
                $data .= "<option data-id_prov='" . $id_prov . "'  data-id_kab='" . $id_kab . "' data-id_kec='" . $id_kecamatan . "' value='" . $nama_kecamatan . "'>" . $nama_kecamatan . "</option>";
            }
        } else {
            $data = "<option value=''>- Select Kecamatan -</option>";
        }
        echo $data;
    }

    public function getDesa($id_prov = NULL, $id_kab = NULL,$id_kec = NULL)
    {

        if ($id_prov != NULL && $id_kab != NULL && $id_kec != NULL) {
            $desa = $this->wilayah->getDataDesa()($id_prov, $id_kab,$id_kec);
            $data = "<option value=''>- Select Desa -</option>";
            foreach ($desa as $id_desa => $nama_desa) {
                $data .= "<option data-id_prov='" . $id_prov . "'  data-id_kab='" . $id_kab . "' data-id_kec='" . $id_kec . "' value='" . $nama_desa . "'>" . $nama_desa . "</option>";
            }
        } else {
            $data = "<option value=''>- Select Kecamatan -</option>";
        }
        echo $data;
    }


    public function importRequestPrice()
    {

        $file_mimes = array(
            'text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream',
            'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv',
            'application/excel', 'application/vnd.msexcel', 'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['upload_file']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $getLastRequest = $this->db->limit(1)->order_by('id_request_price', 'DESC')->get('tbl_request_price')->row_array();
            $code = $this->sales->getCodeRequestPrice();
            $queue = 0;
            foreach ($sheetData as $rowdata) {
                if ($queue == 0) {
                    $queue += 1;
                } else {
                    $data = array(
                        'id_sales' => $this->session->userdata('id_user'),
                        'code_request_price' => $code,
                        'date_request' => date('Y-m-d H:i:s'),
                        'province_from' => $rowdata[1],
                        'city_from' => $rowdata[2],
                        'subdistrict_from' => $rowdata[3],
                        'alamat_from' => $rowdata[4],
                        'province_to' => $rowdata[5],
                        'city_to' => $rowdata[6],
                        'subdistrict_to' => $rowdata[7],
                        'alamat_to' => $rowdata[8],
                        'moda' => $rowdata[9],
                        'jenis_barang' => $rowdata[10],
                        'berat' => $rowdata[11],
                        'koli' => $rowdata[12],
                        'komoditi' => $rowdata[13],
                        'panjang' => $rowdata[14],
                        'lebar' => $rowdata[15],
                        'tinggi' => $rowdata[16],
                        'notes_sales' => $rowdata[17],
                        'group' => $getLastRequest['group'] + 1,
                        'is_bulk' => 1
                    );
                    $this->db->insert('tbl_request_price', $data);
                }
            }

            $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
            redirect('sales/RequestPrice');
        }
    }

    public function detailRequestPriceBulk($code)
    {
        $provinsi = $this->wilayah->getDataProvinsi();
        $data['title'] = 'Request Price Detail Bulk';
        $data['requestPrice'] = $this->sales->getDetailRequestPriceBulk($code);
        $data['provinsi'] = $provinsi->data;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $this->backend->display('sales/v_request_price_bulk', $data);
    }
}
