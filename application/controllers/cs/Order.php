<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->load->library('upload');
        $this->load->model('M_Datatables');
        $this->load->library('form_validation');
        $this->load->model('PengajuanModel', 'pengajuan');
        // $this->getDataWisuda();

        $this->load->model('PengajuanModel', 'order');
        $this->load->model('Api');
        cek_role();
    }

    public function index()
    {
        $data['title'] = 'My Shipment';
        $data['order'] = $this->db->order_by('id', 'DESC')->get('tbl_shp_order')->result_array();
        $this->backend->display('cs/v_order', $data);
    }

    public function detail($id, $id_so)
    {
        $data['title'] = 'Detail Order';
        $data['id_so'] = $id_so;
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('cs/v_detail_pengajuan', $data);
    }
    public function edit($id, $id_so)
    {
        $data['title'] = 'Edit Order';
        $data['id_so'] = $id_so;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['agents'] = $this->db->get_where('tbl_vendor', ['type' => 1])->result_array();
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('cs/v_edit_order', $data);
    }
    public function editOrder($id, $id_so)
    {
        $data['title'] = 'Edit Order';
        $data['id_so'] = $id_so;
        $data['city'] = $this->db->get('tb_city')->result_array();
        $data['province'] = $this->db->get('tb_province')->result_array();
        $data['service'] = $this->db->get('tb_service_type')->result_array();
        $data['p'] = $this->order->order($id)->row_array();
        $this->backend->display('cs/v_edit_order_dua', $data);
    }

    function view_data_query()
    {
        $query  = "SELECT a.*, b.nama_user FROM tbl_shp_order a JOIN tb_user b ON a.id_user=b.id_user";
        $search = array('nama_user', 'shipment_id', 'order_id', 'shipper', 'consigne');
        $where  = array('a.deleted' => 0);
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }

    // public function processEdit()
    // {
    //     $id_do = $this->input->post('id_do');
    //     if ($id_do == NULL) {
    //         $total_weight = $this->input->post('weight');
    //     } else {
    //         $total_weight = 0;
    //         $weight = $this->input->post('weight');
    //         $collie = $this->input->post('collie');
    //         $no_so = $this->input->post('no_so');
    //         for ($i = 0; $i < sizeof($id_do); $i++) {
    //             $data = array(
    //                 'berat' => $weight[$i],
    //                 'koli' => $collie[$i],
    //                 'no_so' => $no_so[$i],
    //                 'no_do' => $this->input->post('note_cs')[$i],
    //             );
    //             $this->db->update('tbl_no_do', $data, ['id_berat' => $id_do[$i]]);
    //             $total_weight += $weight[$i];
    //         }
    //     }
    //     $data = array(
    //         'weight' => $total_weight,
    //         'destination' => $this->input->post('destination'),
    //         'state_shipper' => $this->input->post('state_shipper'),
    //         // 'city_shipper' => $this->input->post('city_shipper'),
    //         'consigne' => $this->input->post('consigne'),
    //         'state_consigne' => $this->input->post('state_consigne'),
    //         'city_consigne' => $this->input->post('city_consigne'),
    //         'pu_commodity' => $this->input->post('pu_commodity'),
    //         'sender' => $this->input->post('sender'),
    //         'service_type' => $this->input->post('service_type'),
    //         'tree_shipper' => $this->input->post('tree_shipper'),
    //         'tree_consignee' => $this->input->post('tree_consignee'),
    //         'berat_js' => $total_weight,
    //         'koli' => $this->input->post('koli'),
    //         // 'note_cs' => $this->input->post('note_cs'),
    //         // 'no_so' => $this->input->post('no_so'),
    //         'no_stp' => $this->input->post('no_stp'),
    //         'note_shipment' => $this->input->post('note_shipment'),
    //         'is_weight_print' => $this->input->post('is_weight_print'),
    //     );

    //     $update =  $this->db->update('tbl_shp_order', $data, ['id' => $this->input->post('id')]);
    //     if ($update) {
    //         $this->session->set_flashdata('message', '<div class="alert
    //             alert-success" role="alert">Success</div>');
    //         redirect('cs/order/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so'));
    //     } else {
    //         $this->session->set_flashdata('message', '<div class="alert
    //             alert-danger" role="alert">Failed</div>');
    //         redirect('cs/order/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so'));
    //     }
    // }
    public function processEdit()
    {
        $id_do = $this->input->post('id_do');
        if ($id_do == NULL) {
            $total_weight = $this->input->post('weight');
            $total_koli = $this->input->post('koli');
        } else {
            $total_weight = 0;
            $total_koli = 0;
            $weight = $this->input->post('weight');
            $collie = $this->input->post('collie');
            $no_so = $this->input->post('no_so');
            for ($i = 0; $i < sizeof($id_do); $i++) {
                $data = array(
                    'berat' => $weight[$i],
                    'koli' => $collie[$i],
                    'no_so' => $no_so[$i],
                    'no_do' => $this->input->post('note_cs')[$i],
                );
                $this->db->update('tbl_no_do', $data, ['id_berat' => $id_do[$i]]);
                $total_weight += $weight[$i];
                $total_koli += $collie[$i];
            }
        }

        $no_do = $this->input->post('note_cs');
        $no_do = implode(',', $no_do);
        $data = array(
            'weight' => $total_weight,
            'destination' => $this->input->post('destination'),
            'state_shipper' => $this->input->post('state_shipper'),
            // 'city_shipper' => $this->input->post('city_shipper'),
            'consigne' => $this->input->post('consigne'),
            'state_consigne' => $this->input->post('state_consigne'),
            'city_consigne' => $this->input->post('city_consigne'),
            'pu_commodity' => $this->input->post('pu_commodity'),
            'sender' => $this->input->post('sender'),
            'id_agent' => $this->input->post('id_agent'),
            'service_type' => $this->input->post('service_type'),
            'tree_shipper' => $this->input->post('tree_shipper'),
            'tree_consignee' => $this->input->post('tree_consignee'),
            'berat_js' => $total_weight,
            'koli' => $total_koli,
            'note_cs' => $no_do,
            // 'no_so' => $this->input->post('no_so'),
            'no_stp' => $this->input->post('no_stp'),
            'note_shipment' => $this->input->post('note_shipment'),
            'is_weight_print' => $this->input->post('is_weight_print'),
        );

        $update =  $this->db->update('tbl_shp_order', $data, ['id' => $this->input->post('id')]);
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('cs/order/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Failed</div>');
            redirect('cs/order/edit/' . $this->input->post('id') . '/' . $this->input->post('id_so'));
        }
    }

    public function processEditOrder()
    {
        $data = array(
            'weight' => $this->input->post('weight'),
            'destination' => $this->input->post('destination'),
            //'state_shipper' => $this->input->post('state_shipper'),
            //'city_shipper' => $this->input->post('city_shipper'),
            'consigne' => $this->input->post('consigne'),
            //'state_consigne' => $this->input->post('state_consigne'),
            'pu_commodity' => $this->input->post('pu_commodity'),
            'sender' => $this->input->post('sender'),
            'service_type' => $this->input->post('service_type'),
            'tree_shipper' => $this->input->post('tree_shipper'),
            'tree_consignee' => $this->input->post('tree_consignee'),
            'berat_js' => $this->input->post('weight'),
            'koli' => $this->input->post('koli'),
            'note_cs' => $this->input->post('note_cs'),
            'note_shipment' => $this->input->post('note_shipment'),
            'is_weight_print' => $this->input->post('is_weight_print'),
        );

        $update =  $this->db->update('tbl_shp_order', $data, ['id' => $this->input->post('id')]);
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect('cs/order/report');
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Failed</div>');
            redirect('cs/order/report');
        }
    }
    public function addMasterCustomer()
    {
        $nama_pt = strtoupper($this->input->post('shipper'));
        $query = $this->db->get_where('tb_customer', ['nama_pt' => $nama_pt])->row_array();
        if ($query == NULL) {
            $data = array(
                'nama_pt' => $nama_pt,
                'pic' => $this->input->post('sender'),
            );
            $this->db->insert('tb_customer', $data);
        }
    }

    public function print($id)
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
    public function printAll($id)
    {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [74, 105]]);

        $where = array('id_so' => $id);
        $this->db->select('*, b.service_name, b.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_service_type b', 'a.service_type=b.code');
        $this->db->where('a.id_so', $id);
        $data['orders'] = $this->db->get()->result_array();
        $data = $this->load->view('superadmin/v_cetak_all', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }
    public function barcode($id)
    {
        // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        // $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG(); // Pixel based PNG
        // echo $generatorPNG->getBarcode($id, $generatorPNG::TYPE_CODE_128);
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents("uploads/barcode/$id.jpg", $generator->getBarcode($id, $generator::TYPE_CODE_128));
        // echo $image;
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

    public function report()
    {
        $data['title'] = 'Report Order';
        $data['order'] = $this->pengajuan->getLaporan()->result_array();
        $this->backend->display('cs/v_report', $data);
    }
    public function filterLaporan()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['title'] = "Laporan Order Tahun $tahun Bulan $bulan";
        $data['order'] = $this->pengajuan->getLaporanTransaksiFilter($bulan, $tahun)->result_array();
        $this->backend->display('cs/v_report_filter', $data);
    }

    public function Exportexcel($bulan = null, $tahun = null)
    {

        if ($bulan != null && $tahun != null) {
            $data['title'] = "Laporan Order Dari Bulan $bulan-$tahun ";
            $order = $this->pengajuan->getLaporanTransaksiFilter($bulan, $tahun)->result_array();
        } else {
            $data['title'] = "Laporan Order Keseluruhan";
            $order = $this->pengajuan->getLaporan()->result_array();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'DATE');
        $sheet->setCellValue('C1', 'SHIPMENT ID');
        $sheet->setCellValue('D1', 'NO DO/DN');
        $sheet->setCellValue('E1', 'NO SO/PO');
        $sheet->setCellValue('F1', 'STP');
        $sheet->setCellValue('G1', 'CUSTOMER');
        $sheet->setCellValue('H1', 'CONSIGNEE');
        $sheet->setCellValue('I1', 'DEST');
        $sheet->setCellValue('J1', 'SERVICE');
        $sheet->setCellValue('K1', 'COMM');
        $sheet->setCellValue('L1', 'COLLY');
        $sheet->setCellValue('M1', 'WEIGHT');
        $sheet->setCellValue('N1', 'SPECIAL WEIGHT');
        $sheet->setCellValue('O1', 'PETUGAS PICKUP');
        $sheet->setCellValue('P1', 'NO FLIGHT');
        $sheet->setCellValue('Q1', 'NO SMU');
        $sheet->setCellValue('R1', 'TANGGAL TIBA DI DAERAH');
        $sheet->setCellValue('S1', 'STATUS DELIVERY');
        $sheet->setCellValue('T1', 'LEADTIME');
        $sheet->setCellValue('U1', 'REALISASI LEADTIME');
        $sheet->setCellValue('V1', 'LEADTIME KPI SCORE');
        $sheet->setCellValue('W1', 'REALISASI LEADTIME AGEN DAERAH');
        $sheet->setCellValue('X1', 'KPI LEADTIME AGEN DAERAH');
        $sheet->setCellValue('Y1', 'TANGGAL PENGISIAN NAMA PENERIMA');
        $sheet->setCellValue('Z1', 'REALISASI LEADTIME INPUT NAMA PENERIMA');
        $sheet->setCellValue('AA1', 'KPI LEADTIME INPUT NAMA PENERIMA');
        $sheet->setCellValue('AB1', 'KASUS');

        $no = 1;
        $x = 2;
        foreach ($order as $row) {
            $get_do = $this->db->select('no_do,no_so, berat, koli')->get_where('tbl_no_do', ['shipment_id' => $row['shipment_id']])->result_array();
            $jumlah = $this->db->select('no_do')->get_where('tbl_no_do', ['shipment_id' => $row['shipment_id']])->num_rows();
            $no_do = '';
            $no_so = '';
            if ($get_do) {
                $i = 1;
                foreach ($get_do as $d) {
                    $no_do = ($i == $jumlah) ? $d['no_do'] : $d['no_do'] . '/';
                    $i++;
                }
            } else {
                $no_do =  $row['note_cs'];
            }

            // no so
            if ($get_do) {
                $i = 1;
                foreach ($get_do as $d) {
                    $no_so =  ($i == $jumlah) ? $d['no_so'] : $d['no_so'] . '/';
                    $i++;
                }
            } else {
                $no_so =  $row['no_so'];
            }

            $sheet->setCellValue('A' . $x, $no)->getColumnDimension('A')
                ->setAutoSize(true);
            $sheet->setCellValue('B' . $x, $row['tgl_pickup'])->getColumnDimension('B')
                ->setAutoSize(true);
            $sheet->setCellValue('C' . $x, $row['shipment_id'])->getColumnDimension('C')
                ->setAutoSize(true);
            $sheet->setCellValue('D' . $x, $no_do)->getColumnDimension('D')
                ->setAutoSize(true);
            $sheet->setCellValue('E' . $x, $no_so)->getColumnDimension('E')
                ->setAutoSize(true);
            $sheet->setCellValue('F' . $x, $row['no_stp'])->getColumnDimension('F')
                ->setAutoSize(true);
            $sheet->setCellValue('G' . $x, $row['shipper'])->getColumnDimension('G')
                ->setAutoSize(true);
            $sheet->setCellValue('H' . $x, $row['consigne'])->getColumnDimension('H')
                ->setAutoSize(true);
            $sheet->setCellValue('I' . $x, $row['tree_consignee'])->getColumnDimension('I')
                ->setAutoSize(true);
            $sheet->setCellValue('J' . $x, $row['service_name'])->getColumnDimension('J')
                ->setAutoSize(true);
            $sheet->setCellValue('K' . $x, $row['pu_commodity'])->getColumnDimension('K')
                ->setAutoSize(true);
            $sheet->setCellValue('L' . $x, $row['koli'])->getColumnDimension('L')
                ->setAutoSize(true);
            $sheet->setCellValue('M' . $x, $row['berat_js'])->getColumnDimension('M')
                ->setAutoSize(true);
            $sheet->setCellValue('N' . $x, $row['berat_msr'])->getColumnDimension('N')
                ->setAutoSize(true);
            $sheet->setCellValue('O' . $x, $row['nama_user'])->getColumnDimension('O')
                ->setAutoSize(true);
            $sheet->setCellValue('P' . $x, $row['no_flight'])->getColumnDimension('P')
                ->setAutoSize(true);
            $sheet->setCellValue('Q' . $x, $row['no_smu'])->getColumnDimension('Q')
                ->setAutoSize(true);
            $sheet->setCellValue('R' . $x, '')->getColumnDimension('R')
                ->setAutoSize(true);
            $sheet->setCellValue('S' . $x, '')->getColumnDimension('S')
                ->setAutoSize(true);
            $sheet->setCellValue('T' . $x, '')->getColumnDimension('T')
                ->setAutoSize(true);
            $sheet->setCellValue('U' . $x, '')->getColumnDimension('U')
                ->setAutoSize(true);
            $sheet->setCellValue('V' . $x, '')->getColumnDimension('V')
                ->setAutoSize(true);
            $sheet->setCellValue('W' . $x, '')->getColumnDimension('W')
                ->setAutoSize(true);
            $sheet->setCellValue('X' . $x, '')->getColumnDimension('X')
                ->setAutoSize(true);
            $sheet->setCellValue('Y' . $x, '')->getColumnDimension('Y')
                ->setAutoSize(true);
            $sheet->setCellValue('Z' . $x, '')->getColumnDimension('Z')
                ->setAutoSize(true);
            $sheet->setCellValue('AA' . $x, '')->getColumnDimension('AA')
                ->setAutoSize(true);
            $sheet->setCellValue('AB' . $x, '')->getColumnDimension('AB')
                ->setAutoSize(true);
            $x++;
            $no++;
        }
        $filename = $data['title'];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    public function ExportexcelVoid($bulan = null, $tahun = null)
    {

        if ($bulan != null && $tahun != null) {
            $data['title'] = "Laporan Order Void Dari Bulan $bulan-$tahun ";
            $order = $this->pengajuan->getLaporanTransaksiVoidFilter($bulan, $tahun)->result_array();
        } else {
            $data['title'] = "Laporan Order Void Keseluruhan";
            $order = $this->pengajuan->getLaporanVoid()->result_array();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'DATE');
        $sheet->setCellValue('C1', 'SHIPMENT ID');
        $sheet->setCellValue('D1', 'NO DO/DN');
        $sheet->setCellValue('E1', 'NO SO/PO');
        $sheet->setCellValue('F1', 'STP');
        $sheet->setCellValue('G1', 'CUSTOMER');
        $sheet->setCellValue('H1', 'CONSIGNEE');
        $sheet->setCellValue('I1', 'DEST');
        $sheet->setCellValue('J1', 'SERVICE');
        $sheet->setCellValue('K1', 'COMM');
        $sheet->setCellValue('L1', 'COLLY');
        $sheet->setCellValue('M1', 'WEIGHT');
        $sheet->setCellValue('N1', 'SPECIAL WEIGHT');
        $sheet->setCellValue('O1', 'PETUGAS PICKUP');
        $sheet->setCellValue('P1', 'NO FLIGHT');
        $sheet->setCellValue('Q1', 'NO SMU');
        $sheet->setCellValue('R1', 'Alasan Delete');


        $no = 1;
        $x = 2;
        foreach ($order as $row) {
            $get_do = $this->db->select('no_do,no_so, berat, koli')->get_where('tbl_no_do', ['shipment_id' => $row['shipment_id']])->result_array();
            $jumlah = $this->db->select('no_do')->get_where('tbl_no_do', ['shipment_id' => $row['shipment_id']])->num_rows();
            $no_do = '';
            $no_so = '';
            if ($get_do) {
                $i = 1;
                foreach ($get_do as $d) {
                    $no_do = ($i == $jumlah) ? $d['no_do'] : $d['no_do'] . '/';
                    $i++;
                }
            } else {
                $no_do =  $row['note_cs'];
            }

            // no so
            if ($get_do) {
                $i = 1;
                foreach ($get_do as $d) {
                    $no_so =  ($i == $jumlah) ? $d['no_so'] : $d['no_so'] . '/';
                    $i++;
                }
            } else {
                $no_so =  $row['no_so'];
            }

            $sheet->setCellValue('A' . $x, $no)->getColumnDimension('A')
                ->setAutoSize(true);
            $sheet->setCellValue('B' . $x, $row['tgl_pickup'])->getColumnDimension('B')
                ->setAutoSize(true);
            $sheet->setCellValue('C' . $x, $row['shipment_id'])->getColumnDimension('C')
                ->setAutoSize(true);
            $sheet->setCellValue('D' . $x, $no_do)->getColumnDimension('D')
                ->setAutoSize(true);
            $sheet->setCellValue('E' . $x, $no_so)->getColumnDimension('E')
                ->setAutoSize(true);
            $sheet->setCellValue('F' . $x, $row['no_stp'])->getColumnDimension('F')
                ->setAutoSize(true);
            $sheet->setCellValue('G' . $x, $row['shipper'])->getColumnDimension('G')
                ->setAutoSize(true);
            $sheet->setCellValue('H' . $x, $row['consigne'])->getColumnDimension('H')
                ->setAutoSize(true);
            $sheet->setCellValue('I' . $x, $row['tree_consignee'])->getColumnDimension('I')
                ->setAutoSize(true);
            $sheet->setCellValue('J' . $x, $row['service_name'])->getColumnDimension('J')
                ->setAutoSize(true);
            $sheet->setCellValue('K' . $x, $row['pu_commodity'])->getColumnDimension('K')
                ->setAutoSize(true);
            $sheet->setCellValue('L' . $x, $row['koli'])->getColumnDimension('L')
                ->setAutoSize(true);
            $sheet->setCellValue('M' . $x, $row['berat_js'])->getColumnDimension('M')
                ->setAutoSize(true);
            $sheet->setCellValue('N' . $x, $row['berat_msr'])->getColumnDimension('N')
                ->setAutoSize(true);
            $sheet->setCellValue('O' . $x, $row['nama_user'])->getColumnDimension('O')
                ->setAutoSize(true);
            $sheet->setCellValue('P' . $x, $row['no_flight'])->getColumnDimension('P')
                ->setAutoSize(true);
            $sheet->setCellValue('Q' . $x, $row['no_smu'])->getColumnDimension('Q')
                ->setAutoSize(true);
            $sheet->setCellValue('R' . $x, $row['reason_delete'])->getColumnDimension('R')
                ->setAutoSize(true);

            $x++;
            $no++;
        }
        $filename = $data['title'];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    function get_autocomplete()
    {
        if (isset($_GET['term'])) {
            $result = $this->order->search_blog($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'nama_pt'         => $row->nama_pt,
                        'pic'   => $row->pic,
                    );
                echo json_encode($arr_result);
            }
        }
    }
}
