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
            $data['provinsi'] = $provinsi->data;
            $data['city'] = $this->db->get('tb_city')->result_array();
        } else {
            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'Request Price';
            $data['requestPrice'] = $this->sales->getRequestPriceNotApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['requestPriceApprove'] = $this->sales->getRequestPriceApprove($this->session->userdata('id_user'), $awal, $akhir);
            $data['province'] = $this->db->get('tb_province')->result_array();
            $data['provinsi'] = $provinsi->data;
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

        $QuerylastRequest = "SELECT a.group_request FROM tbl_request_price a ORDER BY a.group_request DESC LIMIT 1";
        $lastRequest = $this->db->query($QuerylastRequest)->row();
        // var_dump($lastRequest->group);
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
            'is_bulk' => 0,
            'group_request' => $lastRequest->group_request + 1
        ];


        $update = $this->db->insert('tbl_request_price', $request);
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

    public function editRequest()
    {

        $QuerylastRequest = "SELECT a.group FROM tbl_request_price a ORDER BY a.group DESC LIMIT 1";
        $lastRequest = $this->db->query($QuerylastRequest)->row();
        // var_dump($lastRequest->group)
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
            'is_bulk' => 0,
            'group' => $lastRequest->group_request + 1
        ];


        $update = $this->db->insert('tbl_request_price', $request);
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
            foreach ($kabupaten->data as $value) {
                $data .= "<option data-id_prov='" . $id_prov . "'  data-id_kab='" . $value->id . "' value='" . $value->name . "'>" . $value->name . "</option>";
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
            foreach ($kecamatan->data as $value) {
                $data .= "<option data-id_kec='" . $value->id . "' value='" . $value->name . "'>" . $value->name . "</option>";
            }
        } else {
            $data = "<option value=''>- Select Kecamatan -</option>";
        }
        echo $data;
    }


    public function import()
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
            $deadline_sales = date('Y-m-d');

            foreach ($sheetData as $rowdata) {
                $date = date('Y-m-d');
                $pickup_start = date('Y-m-d', strtotime('+1 days', strtotime($date)));

                $koli = $rowdata[8];
                $img = $this->input->post('ttd');
                $img = str_replace('data:image/png;base64,', '', $img);
                $service_type = $this->input->post('service_type');
                $date = date('Y-m-d');
                $tahun = date("y");
                $bulan = date("m");
                $tgl = date("d");
                // var_dump($tgl);
                // die;

                $sql = $this->db->query("SELECT max(no_resi) as shipment_id FROM tbl_no_resi  ORDER BY id_no_resi DESC LIMIT 1")->row_array();
                // var_dump($sql);
                // die;
                 if ($sql == NULL) {
                    $noUrut = 1;
                    $shipment_id  = "$noUrut";
                } else {
                    $last_shipment_id = $sql['shipment_id'];
                    $no = $last_shipment_id + 1;
                    $shipment_id =  ltrim($no, '0');
                }
                // input no shipment
                $this->db->insert('tbl_no_resi', ['no_resi' => $shipment_id, 'created_by' => $this->session->userdata('id_user')]);

                // kode referensi so
                $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
                $no = $sql['kode'];
                // SO - 0 0 0 0 0 0 0 0 9;
                $potongSO = ltrim($no, 'SO-');
                $potong = ltrim($potongSO, '0');
                $noUrut = $potong + 1;
                // $kode =  sprintf("%09s", $noUrut);
                $kode  = "SO-$noUrut";

                $img = $this->input->post('ttd');
                $img = str_replace('data:image/png;base64,', '', $img);
                $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();


                // kode referensi so
                $sql = $this->db->query("SELECT max(so_id) as kode FROM tbl_shp_order")->row_array();
                $no = $sql['kode'];
                // SO - 0 0 0 0 0 0 0 0 9;
                $potongSO = ltrim($no, 'SO-');
                $potong = ltrim($potongSO, '0');
                $noUrut = $potong + 1;
                // $kode =  sprintf("%09s", $noUrut);
                $kode  = "SO-$noUrut";

                $img = $this->input->post('ttd');
                $img = str_replace('data:image/png;base64,', '', $img);
                $city_shipper = $rowdata[2];
                $city_consigne = $rowdata[6];
				
                $get_pickup = $this->db->limit(1)->order_by('id', 'DESC')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();

                $data = array(
                    'shipper' => strtoupper($rowdata[0]),
                    'origin' => $this->input->post('origin'),
                    'city_shipper' => $rowdata[2],
                    'state_shipper' => $rowdata[1],
                    'consigne' => strtoupper($rowdata[4]),
                    'destination' => $rowdata[3],
                    'city_consigne' => $rowdata[6],
                    'state_consigne' => $rowdata[5],
                    'koli' => $rowdata[8],
                    'sender' => $rowdata[9],
                    'note_cs' => $rowdata[10],
                    'id_user' => $this->session->userdata('id_user'),
                    'signature' => $img,
                    'so_id' => $kode,
                     
                    'shipment_id' => $shipment_id,
                    // 'order_id' => $order_id,
                    'service_type' =>  $rowdata[7],
                    'is_jabodetabek' =>  $rowdata[10],
                    'date_new' => date('Y-m-d'),
                    'id_so' => $this->input->post('id_so'),
                    'tgl_pickup' => $get_pickup['tgl_pickup'],
                    'pu_moda' => $get_pickup['pu_moda'],
                    'pu_poin' => $get_pickup['pu_poin'],
                    'time' => $get_pickup['time'],
                    'pu_commodity' => $get_pickup['pu_commodity'],
                    'pu_service' => $get_pickup['pu_service'],
                    'pu_note' => $get_pickup['pu_note'],
                   // 'city_shipper' => $get_pickup['city_shipper'],
                    'payment' => $get_pickup['payment'],
                    'packing_type' => $get_pickup['packing_type'],
                    'is_incoming' => $get_pickup['is_incoming'],

                );
                // cek order berdasarkan id_so
                $get_last_order = $this->db->limit(1)->order_by('id', 'desc')->get_where('tbl_shp_order', ['id_so' => $this->input->post('id_so')])->row_array();
                // var_dump($get_last_order);
                // die;
                // kalo shipment id nya null, maka update tbl nya
                if ($get_last_order['so_id'] == NULL) {
                    // echo 'kosong';
                    $update =  $this->db->update('tbl_shp_order', $data, ['id_so' => $this->input->post('id_so')]);
                    if ($update) {
                       
                        $data = array(
                            'shipment_id' => $shipment_id,
                            'status' => 'Shipment Telah Dipickup Dari Shipper',
                            'id_so' => $this->input->post('id_so'),
                            'created_at' => date('Y-m-d'),
                            'id_user' => $this->session->userdata('id_user'),
                            'pic_task' => $this->input->post('sender'),
                            'time' => date('H:i:s'),
                            'flag' => 3,
                            'status_eksekusi' => 0,
                        );
                        $this->db->insert('tbl_tracking_real', $data);
                        $data = array(
                            'status' => 2,
                            'deadline_sales_so' => $deadline_sales
                        );
                        $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
                        $data = array(
                            'status_eksekusi' => 1,
                        );
                        $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
                        $data = array(
                            'shipment_id' => $shipment_id,
                        );
                        $this->db->update('tbl_tracking_real', $data, ['id_so' => $this->input->post('id_so')]);
                    } else {
                    }
                } else {
                    // kalo shipment id nya ada, maka insert tbl nya 
                    $insert =  $this->db->insert('tbl_shp_order', $data);
                    if ($insert) {
                       
                        $get_tracking = $this->db->limit(3)->order_by('id_tracking', 'ASC')->get_where('tbl_tracking_real', ['id_so' => $this->input->post('id_so')])->result_array();
                        foreach ($get_tracking as $track) {
                            $data = array(
                                'shipment_id' => $shipment_id,
                                'status' => $track['status'],
                                'id_so' => $this->input->post('id_so'),
                                'created_at' => $track['created_at'],
                                'note' => $track['note'],
                                'bukti' => $track['bukti'],
                                'id_user' => $track['id_user'],
                                'update_at' => $track['update_at'],
                                'pic_task' => $track['pic_task'],
                                'time' => $track['time'],
                                'flag' => $track['flag'],
                                'status_eksekusi' => $track['status_eksekusi'],
                            );
                            $this->db->insert('tbl_tracking_real', $data);
                        }

                        $data = array(
                            'status' => 2,
                            'deadline_sales_so' => $deadline_sales
                        );
                        $this->db->update('tbl_so', $data, ['id_so' => $this->input->post('id_so')]);
                    } else {
                    }
                }
            }
            $this->session->set_flashdata('message', '<div class="alert
                        alert-success" role="alert">Success</div>');
            redirect('shipper/order/view/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                    alert-danger" role="alert">Silahkan Upload File</div>');
            redirect('shipper/order/bulk/' . $this->input->post('id_so') . '/' . $this->input->post('id_tracking'));
        }
    }
}
