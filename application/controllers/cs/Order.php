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
        $data['p'] = $this->order->order($id)->row_array();
		 $data['invoice'] = $this->db->query('SELECT status FROM tbl_invoice WHERE shipment_id = ' . $id . '')->row_array();
		  $data['dimension'] = $this->db->get_where('tbl_dimension',array('shipment_id' => $data['p']['shipment_id']))->result_array();
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
        $query  = "SELECT a.tgl_pickup,a.shipper,a.consigne,a.shipment_id,a.created_at,a.id_so,a.id, b.nama_user FROM tbl_shp_order a JOIN tb_user b ON a.id_user=b.id_user";
        $search = array('shipment_id', 'shipper');
        $where  = array('a.deleted' => 0);
        // $where  = array('a.id_user' => $this->session->userdata('id_user'));

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }
	public function deleteDo($id_do)
    {
        $do = $this->db->get_where('tbl_no_do', ['id_berat' => $id_do])->row_array();
        $shipment = $this->db->query('SELECT berat_js,koli FROM tbl_shp_order WHERE shipment_id = ' . $do['shipment_id'] . ' ')->row_array();
        $updateshipment = $this->db->update('tbl_shp_order', array('berat_js' =>(int)$shipment['berat_js'] - (int)$do['berat'],'koli' => (int)$shipment['koli'] - (int)$do['koli']),array('shipment_id' => $do['shipment_id']));
         
        if ($updateshipment) {
            $delete = $this->db->delete('tbl_no_do',array('id_berat' => $id_do));
            if ($delete) {
                $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect($_SERVER['HTTP_REFERER']);
            }

        }
    }
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
            'berat_js' => $total_weight,
            'weight' => $total_weight,
            'destination' => $this->input->post('destination'),
            'state_shipper' => $this->input->post('state_shipper'),
            'mark_shipper' => $this->input->post('mark_shipper'),
            // 'city_shipper' => $this->input->post('city_shipper'),
            'consigne' => $this->input->post('consigne'),
            'state_consigne' => $this->input->post('state_consigne'),
            'city_consigne' => $this->input->post('city_consigne'),
            'pu_commodity' => $this->input->post('pu_commodity'),
            'sender' => $this->input->post('sender'),
            'service_type' => $this->input->post('service_type'),
            'tree_shipper' => $this->input->post('tree_shipper'),
            'tree_consignee' => $this->input->post('tree_consignee'), 
            'koli' => $total_koli,
            'note_cs' => $no_do,
            // 'no_so' => $this->input->post('no_so'),
            'no_stp' => $this->input->post('no_stp'),
            'no_smu' => $this->input->post('no_smu'),
            'flight_at' => $this->input->post('flight_at'),
            'note_shipment' => $this->input->post('note_shipment'),
            'is_weight_print' => $this->input->post('is_weight_print'),
        );
        $shipment = $this->db->get_where('tbl_shp_order', array('id' => $this->input->post('id')))->row_array();
        $dataEdit = array(
            'shipment_id' => $shipment['shipment_id'],
            'berat_js' => $total_weight,
            'destination' => $this->input->post('destination'),
            'state_shipper' => $this->input->post('state_shipper'),
            // 'city_shipper' => $this->input->post('city_shipper'),
            'consigne' => $this->input->post('consigne'),
            'state_consigne' => $this->input->post('state_consigne'),
            'city_consigne' => $this->input->post('city_consigne'),
            'pu_commodity' => $this->input->post('pu_commodity'),
            'sender' => $this->input->post('sender'),
            'service_type' => $this->input->post('service_type'),
            'tree_shipper' => $this->input->post('tree_shipper'),
            'tree_consignee' => $this->input->post('tree_consignee'), 
            'koli' => $total_koli,
            'note_cs' => $no_do,
            // 'no_so' => $this->input->post('no_so'),
            'no_stp' => $this->input->post('no_stp'),
            'no_smu' => $this->input->post('no_smu'),
            'flight_at' => $this->input->post('flight_at'),
            'note_shipment' => $this->input->post('note_shipment'),
            'is_weight_print' => $this->input->post('is_weight_print'),
            'edited_at' => date('Y-m-d H:i:s'),
            'edited_by' => $this->session->userdata('id_user')
        );
        
        if ($shipment['updatesistem_at'] == NULL) {
            $data['updatesistem_at'] = date('Y-m-d H:i:s');
        }

        $update =  $this->db->update('tbl_shp_order', $data, ['id' => $this->input->post('id')]);
        $this->db->insert('tbl_shp_order_edit',$dataEdit);
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

    // buat orang selanjutnya yang lanjutin ni codingan, sumpah sy nyerah kalo benerin bugnya sendirian semua wkwkwkkw #norman

    public function tambahDo()
    {
        $dataDo = [
            'shipment_id' => $this->input->post('tambahShipmentId'),
            'no_do' => $this->input->post('tambahNoDo'),
            'no_so' => $this->input->post('tambahNoSo'),
        ];
        if ($this->db->insert('tbl_no_do', $dataDo)) {
            $this->session->set_flashdata('message', '<div class="alert
                alert-success" role="alert">Success</div>');
            redirect($_SERVER['HTTP_REFERER']);
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
        $data = $this->load->view('superadmin/v_cetak', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }
   public function printAll($id)
    {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [74, 105]]);

        $where = array('id_so' => $id);
        $this->db->select('a.berat_js,a.shipment_id,a.id_so,a.shipper,a.tree_shipper,a.tree_consignee,a.consigne,a.destination,a.city_consigne,a.state_consigne,a.city_shipper,a.koli,a.is_weight_print,a.state_shipper,a.signature,a.created_at,a.sender,a.tgl_pickup, b.service_name, b.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_service_type b', 'a.service_type=b.code');
        $this->db->where('a.id_so', $id);
        $this->db->where('a.deleted', 0);
        $data['orders'] = $this->db->get()->result_array();
        $data = $this->load->view('shipper/v_cetak_all', $data, TRUE);
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
        //$data['order'] = $this->pengajuan->getLaporan()->result_array();
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
            $data['title'] = "Laporan Order Dari Bulan $bulan-$tahun";
            $order = $this->pengajuan->getLaporanTransaksiFilter($bulan, $tahun)->result_array();
        } else {
            $data['title'] = "Laporan Order Keseluruhan";
            $order = $this->pengajuan->getLaporan()->result_array();
        }
        
        // Optimasi Query untuk no_do dan no_so dalam satu query
        $shipment_ids = array_column($order, 'shipment_id');
        if (!empty($shipment_ids)) {
            $shipment_data = $this->db->select('shipment_id, GROUP_CONCAT(no_do SEPARATOR "/") as no_do, GROUP_CONCAT(no_so SEPARATOR "/") as no_so')
                                      ->from('tbl_no_do')
                                      ->where_in('shipment_id', $shipment_ids)
                                      ->group_by('shipment_id')
                                      ->get()
                                      ->result_array();
            $shipment_map = array_column($shipment_data, null, 'shipment_id');
        }
        
        // Buat Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['NO', 'DATE', 'SHIPMENT ID', 'NO DO/DN', 'NO SO/PO', 'STP', 'CUSTOMER', 'CONSIGNEE', 'DEST', 'SERVICE',
                    'COMM', 'COLLY', 'WEIGHT', 'SPECIAL WEIGHT', 'PETUGAS PICKUP', 'NO FLIGHT', 'NO SMU', 'TANGGAL DITERIMA',
                    'STATUS DELIVERY', 'LEADTIME', 'REALISASI LEADTIME', 'STATUS POD', 'LEADTIME KPI SCORE', 
                    'REALISASI LEADTIME AGEN DAERAH', 'KPI LEADTIME AGEN DAERAH', 'TANGGAL PENGISIAN NAMA PENERIMA', 
                    'REALISASI LEADTIME INPUT NAMA PENERIMA', 'KPI LEADTIME INPUT NAMA PENERIMA', 'KASUS', 'MILESTONE DIBUAT'];
        
        $sheet->fromArray([$headers], null, 'A1');
        
        // Isi Data
        $dataRows = [];
        $no = 1;
        foreach ($order as $row) {
            $shipment_id = $row['shipment_id'];
            $no_do = isset($shipment_map[$shipment_id]) ? $shipment_map[$shipment_id]['no_do'] : $row['note_cs'];
            $no_so = isset($shipment_map[$shipment_id]) ? $shipment_map[$shipment_id]['no_so'] : $row['no_so'];
            $tracking = $this->pengajuan->getLastTracking($row['shipment_id'])->row_array();

            if ($row['tgl_diterima'] == NULL) {
                if (strpos($tracking['status'], 'Diterima') !== false) {
                    $row['tgl_diterima'] = $tracking['created_at'];
                } else {
                    $row['tgl_diterima'] = '';
                }
            } else{
                $row['tgl_diterima'] = $row['tgl_diterima'];
            }

        
            $diterima = new DateTime($row['tgl_diterima'] ?? 'now');
            $pickup = new DateTime($row['tgl_pickup'] ?? 'now');
            $leadtime = $diterima->diff($pickup)->d;
        
            $pod_status = ['Pending', 'Dikirim', 'Diterima'];
            $pod = $pod_status[$row['status_pod']] ?? 'Unknown';
        
            $mark = ' (' . $row["mark_shipper"] . ')';
        
            $dataRows[] = [
                $no++, $row['tgl_pickup'], $shipment_id, $no_do, $no_so, $row['no_stp'],
                $row['shipper'] . $mark, $row['consigne'], $row['tree_consignee'], 
                $row['service_name'], $row['pu_commodity'], $row['koli'], $row['berat_js'], 
                $row['berat_msr'], $row['nama_user'], $row['no_flight'], $row['no_smu'], 
                $row['tgl_diterima'], $tracking['status'], $leadtime, '', $pod, '', '', '', '', '', '', '', $tracking['update_at']
            ];
        }
        
        // Masukkan data ke Excel
        $sheet->fromArray($dataRows, null, 'A2');
        
        // Set Header dan Simpan File
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $data['title'] . '.xlsx"');
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
