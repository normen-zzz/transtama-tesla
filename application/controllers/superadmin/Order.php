<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->load->model('PengajuanModel', 'pengajuan');
        $this->load->model('UserModel');
        $this->load->model('M_Datatables');
        $this->load->model('Api');
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        cek_role();
    }

    public function index()
    {
        $data['title'] = 'Order';
        $data['order'] = $this->pengajuan->order()->result_array();
        $this->backend->display('superadmin/v_pengajuan', $data);
    }
    public function generate()
    {
        $cek_api = $this->Api->kirim();
        $cek_api = json_decode($cek_api);
        $cek_api = $cek_api->accessToken;
        $data = [
            'token' => $cek_api,
        ];
        $this->session->set_userdata($data);
        $data['title'] = 'Generate Resi';
        $data['customers'] = $this->db->get('tb_customer')->result_array();
        $data['generate'] = $this->pengajuan->getGenerate()->result_array();
        $this->backend->display('superadmin/v_generate', $data);
    }
    public function generateResi()
    {
        $shipper = $this->input->post('customer');
        $id_customer = $this->input->post('id_customer');
        $total = $this->input->post('total');
        for ($j = 0; $j < $total; $j++) {
            $koli = 1;
            $package = array();
            for ($i = 0; $i < $koli; $i++) {
                $p = $i + 1;
                $package_list = array(
                    'weight' => '5',
                    'length' => '10',
                    'height' => '20',
                    'width' => '5',
                    'description' => "Package $p",
                    'package_type_id' => "7db61ef4-5c0f-4965-8eec-3fd938f5d16f",
                    'commodities_packages_attributes' => array(
                        '0' => array(
                            "commodity_id" => "dd7eb77d-431b-48a2-85b8-0c4a132c9bef",
                            "items_count" => "1",
                            "value_of_goods" => "1"
                        )
                    )
                );
                array_push($package, $package_list);
            }

            $img = $this->input->post('ttd');
            $img = str_replace('data:image/png;base64,', '', $img);
            $service_type = "9194a22e-392f-4940-8229-e5df3557c2ac";

            $date = date('Y-m-d');
            $pickup_start = date('Y-m-d', strtotime('+1 days', strtotime($date)));
            $delivery_start = date('Y-m-d', strtotime('+1 days', strtotime($pickup_start)));
            $delivery_commit = date('Y-m-d', strtotime('+3 days', strtotime($delivery_start)));

            $startTime = date("H:i:s", time() + 600);
            // var_dump($startTime);
            // die;
            $data = array(
                'order' => array(
                    'user_id' => "6a85fa9d-154f-49ac-8710-35bf19122c31",
                    'reference_id' => '',
                    'service_type_id' => "$service_type",
                    'measurement_units' => "metric",
                    'pickup_start_time' => $date . "T$startTime.000Z",
                    'pickup_commit_time' => $pickup_start . 'T23:59:00.000',
                    'delivery_start_time' => $delivery_start . 'T00:00:00.000Z',
                    'delivery_commit_time' => $delivery_commit . 'T23:59:00.000Z',
                    // 'state_consigne' => $this->input->post('state_consigne'),
                    'shipper_name' => $shipper,
                    'shipper_phone' => "0000",
                    'shipper_email' => "sender@gmail.com",
                    'consignee_name' => "DUMMY",
                    'consignee_phone' => "00000",
                    'consignee_email' => "consigne@gmail.com",
                    'delivery_timezon' => "Asia/Jakarta",
                    'origin_attributes' => array(
                        'country' => 'Indonesia',
                        'state' => ucwords(strtolower("JAKARTA")),
                        // 'state' => 'South Kalimantan',
                        'city' => ucwords(strtolower("CENTRAL JAKARTA")),
                        // 'city' => 'Kabupaten Kota Baru',
                        'postal_code' => "12345",
                        'address_line1' => "JAKARTA",
                        // 'address_line1' => 'JL MH Thamrin no 51 Jakarta Pusat',
                        'address_line2' => "JAKARTA",
                        'address_line3' => "JAKARTA",
                        'latitude' => "",
                        'longitude' => ""
                    ),
                    'destination_attributes' => array(
                        'country' => "Indonesia",
                        'state' => ucwords(strtolower("JAKARTA")),
                        // 'state' => 'Jakarta',
                        'city' => ucwords(strtolower("WEST JAKARTA")),
                        // 'city' => 'West jakarta',
                        'postal_code' => '000',
                        'address_line1' => "JAKARTA",
                        'address_line2' => "JAKARTA",
                        'address_line3' => "JAKARTA",

                    ),
                    'packages_attributes' => $package,
                    'pricing_info_attributes' => array(
                        "currency" => "IDR"
                    )
                )
            );
            // echo '<pre>';
            // print_r($data);
            // var_dump($data);
            // die;

            $data = json_encode($data);
            $send = $this->Api->order($data);
            // echo $send;
            // die;
            $jsonIterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator(json_decode($send, TRUE)),
                RecursiveIteratorIterator::SELF_FIRST
            );

            $new = array();
            foreach ($jsonIterator as $key => $val) {
                if (is_array($val)) {
                } else {
                    if ($key == 'order_id_label' || $key == 'shipment_id_label') {
                        array_push($new, $val);
                    }
                }
            }
            if ($new) {

                $order_id = $new[0];
                $shipment_id  = $new[1];
                $data = array(
                    'id_customer' => $id_customer,
                    'shipment_id' => $shipment_id,
                    'qr_id' => $order_id,
                    'customer' => $shipper,
                    'total' => $total,
                    'created' => date('Y-m-d')
                );
                $this->db->insert('tbl_booking_number_resi', $data);
                $this->barcode($shipment_id);
                $this->qrcode($shipment_id);
            } else {
                $this->session->set_flashdata('message', '<div class="alert
                            alert-danger" role="alert">Failed</div>');
                redirect('superadmin/order/generate');
            }
        }
        $this->session->set_flashdata('message', '<div class="alert
                    alert-success" role="alert">Success</div>');
        redirect('superadmin/order/generate');
    }
    public function barcode($id)
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents("uploads/barcode/$id.jpg", $generator->getBarcode($id, $generator::TYPE_CODE_128));
    }
    public function qrcode($id)
    {
        $this->load->library('ciqrcode');
        $params['data'] = $id;
        $params['level'] = 'H';
        $params['size'] = 4;
        $params['savename'] = FCPATH . "uploads/qrcode/" . $id . '.png';
        $this->ciqrcode->generate($params);
    }
    public function detail($id)
    {
        $data['title'] = 'Detail Order';
        $data['p'] = $this->pengajuan->order($id)->row_array();
        $this->backend->display('superadmin/v_detail_pengajuan', $data);
    }
    public function detailGenerate($id_customer, $tgl)
    {
        $data['title'] = 'Detail Generate Resi';
        $data['generate'] = $this->db->get_where('tbl_booking_number_resi', ['id_customer' => $id_customer, 'created' => "$tgl"])->result_array();
        $this->backend->display('superadmin/v_detail_generate', $data);
    }
    public function exportGenerate($id_customer, $tgl)
    {
        $data['title'] = 'Detail Generate Resi';
        $customer = $this->db->get_where('tbl_booking_number_resi', ['id_customer' => $id_customer, 'created' => "$tgl"])->row_array();
        $data['generate'] = $this->db->get_where('tbl_booking_number_resi', ['id_customer' => $id_customer, 'created' => "$tgl"])->result_array();
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment;Filename=export-generate-resi-$customer[customer].xls");
        $this->load->view('superadmin/v_export_generate', $data);
    }
    public function delete()
    {
        $id_order = $this->input->post('id_order');
        $id_so = $this->input->post('id_so');
        $where = array('id' => $id_order);
        $data = array(
            'deleted' => 1,
            'reason_delete' => $this->input->post('reason_delete'),
            'status_so' => 0
        );
        $delete = $this->db->update('tbl_shp_order', $data, $where);
        if ($delete) {
            $this->session->set_flashdata('message', 'Success');
            redirect('superadmin/salesOrder/detail/' . $id_so);
        } else {
            $this->session->set_flashdata('message', 'Failed');
            redirect('superadmin/salesOrder/detail/' . $id_so);
        }
    }

    function view_data_query()
    {
        $query  = "SELECT a.*, b.nama_user FROM tbl_shp_order a JOIN tb_user b ON a.id_user=b.id_user";
        $search = array('nama_user', 'shipment_id', 'order_id', 'shipper', 'consigne');
        $where  = null;
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }


    public function report()
    {
        $data['title'] = 'Report Order';
        $data['start'] = 'null';
        $data['end'] = 'null';
        // var_dump($data);
        // die;
        $data['users'] = $this->db->get_where('tb_user', ['id_role' => 4])->result_array();
        $data['order'] = $this->pengajuan->order()->result_array();
        $this->backend->display('superadmin/v_report', $data);
    }
    // public function filterLaporan()
    // {
    //     $data['title'] = 'Laporan Keseluruhan';
    //     // perbulan dan tahun
    //     $start = $_POST['start'];
    //     $end = $_POST['end'];
    //     $id_user = $_POST['id_user'];
    //     // var_dump($end);
    //     // die;
    //     $data['start'] = $_POST['start'];
    //     $data['end'] = $_POST['end'];
    //     $data['id_user'] = $id_user;
    //     $data['users'] = $this->db->get_where('tb_user', ['id_role' => 2])->result_array();
    //     $data['order'] = $this->pengajuan->orderFilter($start, $end, $id_user)->result_array();
    //     $this->backend->display('superadmin/v_report_filter', $data);
    // }
    public function generatePdf($id_customer, $date)
    {
        $this->db->select('*, b.nama_pt,b.provinsi, b.kota');
        $this->db->from('tbl_booking_number_resi a');
        $this->db->join('tb_customer b', 'a.id_customer=b.id_customer');
        $this->db->where('a.id_customer', $id_customer);
        $this->db->where('a.created', $date);
        $this->db->where('a.status', 0);
        $data['orders'] = $this->db->get()->result_array();
        $this->load->view('superadmin/v_cetak_resi', $data);
        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');
        $this->dompdf->set_paper("A7", 'potrait');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $sekarang = date("d:F:Y:h:m:s");
        // return $this->dompdf->output();
        $output = $this->dompdf->output();
        // file_put_contents('uploads/barcode' . '/' . "$shipment_id.pdf", $output);
        $this->dompdf->stream("Cetak" . $sekarang . ".pdf", array('Attachment' => 0));
    }
    public function print($start = null, $end = null, $id_user = 0)
    {
        if ($start != null && $end != null && $id_user != 0) {
            $data['title'] = "Laporan Order dari $start sampai $end ";
            $data['order'] = $this->pengajuan->orderFilter($start, $end, $id_user)->result_array();
        } else {
            $data['title'] = "Laporan Order Keseluruhan";
            $data['order'] = $this->pengajuan->order()->result_array();
        }
        $this->load->view('superadmin/v_cetak_laporan', $data);
        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');
        $this->dompdf->set_paper("A3", 'landscape');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        // $sekarang = date("d:F:Y:h:m:s");
        $this->dompdf->stream("Print_Order" . $start . '-' . $end . ".pdf", array('Attachment' => 0));
    }
    public function printAll($id)
    {
        $where = array('id_so' => $id);
        $this->db->select('*, b.service_name, b.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_service_type b', 'a.service_type=b.code');
        $this->db->where('a.id_so', $id);
        $data['orders'] = $this->db->get()->result_array();
        $this->load->view('superadmin/v_cetak_all', $data);
        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');
        $this->dompdf->set_paper("A7", 'potrait');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $sekarang = date("d:F:Y:h:m:s");
        // return $this->dompdf->output();
        $output = $this->dompdf->output();
        // file_put_contents('uploads/barcode' . '/' . "$shipment_id.pdf", $output);
        $this->dompdf->stream("Cetak" . $sekarang . ".pdf", array('Attachment' => 0));
    }
    // public function Exportexcel($start = null, $end = null, $id_user = 0)
    // {
    //     if ($start != null && $end != null || $id_user != 0) {
    //         $data['title'] = "Laporan Order dari $start sampai $end ";
    //         $data['order'] = $this->pengajuan->orderFilter($start, $end, $id_user)->result_array();
    //     } else {
    //         $data['title'] = "Laporan Order Keseluruhan";
    //         $data['order'] = $this->pengajuan->order()->result_array();
    //     }
    //     header("Content-type: application/octet-stream");
    //     header("Content-Disposition: attachment;Filename=export-laporan.xls");
    //     $data['title'] = "Report Order";
    //     $data['order'] = $this->pengajuan->order()->result_array();
    //     $this->load->view('superadmin/v_cetak_laporan', $data);
    // }

    public function tracking($shipment_id = Null)
    {
        if ($shipment_id == NULL) {
            $shipment_id = $this->input->post('shipment_id');
            $data['shipment_id'] = $shipment_id;
            $data['tracking'] = $this->db->get_where('tbl_tracking_real', ['shipment_id' => $shipment_id])->result_array();
            $data['shipment'] = $this->db->get_where('tbl_shp_order', ['shipment_id' => $shipment_id])->row_array();
            $data['title'] = 'Sales Order';
            $this->backend->display('superadmin/v_tracking', $data);
        } else {
            $data['shipment_id'] = $shipment_id;
            $data['tracking'] = $this->db->get_where('tbl_tracking_real', ['shipment_id' => $shipment_id])->result_array();
            $data['shipment'] = $this->db->get_where('tbl_shp_order', ['shipment_id' => $shipment_id])->row_array();
            $data['title'] = 'Sales Order';
            $this->backend->display('superadmin/v_tracking', $data);
        }
    }
    public function updateShipmentTracking()
    {
        $status = $this->input->post('status');
        $flag = '';
        if ($status == 'Shipment Telah Tiba Di Hub') {
            $flag = 8;
        } else if ($status == 'Shipment Keluar Di Hub Tujuan') {
            $flag = 9;
        } else if ($status == 'Shipment Dalam Proses Delivery') {
            $flag = 10;
        } else {
            $flag = 11;
        }

        $id_so = $this->input->post('id_so');
        $shipment_id = $this->input->post('shipment_id');
        $data = array(
            'status' => $this->input->post('status') . ' ' . $this->input->post('note'),
            'note' => $this->input->post('note'),
            'created_at' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'flag' => $this->input->post('flag'),
            'status_eksekusi' => $this->input->post('status_eksekusi'),
            'pic_task' => $this->input->post('note')
        );
        $config['upload_path'] = './uploads/berkas/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        $folderUpload = "./uploads/berkas/";
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
                    // $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                    // redirect('cs/salesOrder/detail/' . $id_so);
                }
            }
            $namaBaru = implode("+", $listNamaBaru);
            $ktp = array('bukti' => $namaBaru);
            $data = array_merge($data, $ktp);
        }
        $this->db->update('tbl_tracking_real', $data, ['id_tracking' => $this->input->post('id_tracking')]);
        $this->session->set_flashdata('message', 'Update Sukses');
        redirect('superadmin/order/tracking/' . $shipment_id);
    }

    public function updateShipmentTrackingAdd()
    {
        $status = $this->input->post('status');
        $flag = '';
        if ($status == 'Shipment Telah Tiba Di Hub') {
            $flag = 8;
        } else if ($status == 'Shipment Keluar Di Hub Tujuan') {
            $flag = 9;
        } else if ($status == 'Shipment Dalam Proses Delivery') {
            $flag = 10;
        } elseif ($status == 'Shipment Telah Diterima Oleh') {
            $flag = 11;
        } elseif ($status == 'Request Pickup From Shipper') {
            $flag = 1;
        } elseif ($status == 'Driver Menuju Lokasi Pickup') {
            $flag = 2;
        } elseif ($status == 'Shipment Telah Dipickup Dari Shipper') {
            $flag = 3;
        } elseif ($status == 'Shipment Telah Tiba Di Hub Jakarta Pusat') {
            $flag = 4;
        } elseif ($status == 'Shipment Keluar Dari Hub Jakarta Pusat') {
            $flag = 5;
        } elseif ($status == 'Shipment Telah Tiba Di Hub CGK' || $status == 'Shipment Telah Tiba Di Hub Jakarta Utara') {
            $flag = 6;
        } elseif ($status == 'Shipment Keluar Dari Hub CGK' || $status == 'Shipment Keluar Dari Hub Jakarta Utara') {
            $flag = 7;
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

        $folderUpload = "./uploads/berkas/";
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
                    // $this->session->set_flashdata('message', 'Gambar gagal Ditambahkan');
                    // redirect('cs/salesOrder/tracking/' . $shipment_id);
                }
            }
        }
        $namaBaru = implode("+", $listNamaBaru);
        $ktp = array('bukti' => $namaBaru);
        $data = array_merge($data, $ktp);

        $this->db->insert('tbl_tracking_real', $data);
        $this->session->set_flashdata('message', 'Update Sukses');
        redirect('superadmin/order/tracking/' . $shipment_id);
    }

    public function deleteShipmentTracking($id_tracking, $shipment_id)
    {
        $delete = $this->db->delete('tbl_tracking_real', ['id_tracking' => $id_tracking]);
        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Sukses');
            redirect('superadmin/order/tracking/' . $shipment_id);
        } else {
            $this->session->set_flashdata('message', 'Delete Gagal');
            redirect('superadmin/order/tracking/' . $shipment_id);
        }
    }
    public function print2($id)
    {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [74, 105]]);

        $where = array('shipment_id' => $id);
        $data['order'] = $this->db->get_where('tbl_shp_order', $where)->row_array();
        $where2 = array('code' => $data['order']['service_type']);
        $data['service'] = $this->db->get_where('tb_service_type', $where2)->row_array();
        // var_dump($data['order']);
        // die;
        // $this->load->view('superadmin/v_cetak', $data);


        $data = $this->load->view('superadmin/v_cetak', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }

    public function filterLaporan()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $id_user = $this->input->post('id_user');
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['id_sales'] = $id_user;
        $data['title'] = "Laporan Order Tahun $tahun Bulan $bulan";
        $data['users'] = $this->db->get_where('tb_user', ['id_role' => 4])->result_array();
        $data['order'] = $this->pengajuan->getLaporanTransaksiFilterAdmin($bulan, $tahun, $id_user)->result_array();
        $this->backend->display('superadmin/v_report_filter', $data);
    }

    public function Exportexcel($bulan = null, $tahun = null, $id_sales)
    {

        if ($bulan != null && $tahun != null) {
            $data['title'] = "Laporan Order Dari Bulan $bulan-$tahun ";
            $data['order'] = $this->pengajuan->getLaporanTransaksiFilterAdmin($bulan, $tahun, $id_sales)->result_array();
        } else {
            $data['title'] = "Laporan Order Keseluruhan";
            $data['order'] = $this->pengajuan->getLaporanAdmin()->result_array();
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment;Filename=export-laporan-order$bulan-$tahun.xls");
        $this->load->view('superadmin/v_cetak_laporan', $data);
    }
}
