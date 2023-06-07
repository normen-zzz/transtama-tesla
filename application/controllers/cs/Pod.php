<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Pod extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->load->model('PengajuanModel');
        $this->load->model('PodModel', 'pod');
        cek_role();
    }
    public function index()
    {
        if ($this->input->post('shipment_id') == NULL) {
            $data['title'] = 'POD';
            $data['resi'] = NULL;
            $data['shipment'] = NULL;
            $this->backend->display('cs/v_scan_pod', $data);
        } else {
            redirect('cs/Pod/scan/' . $this->input->post('shipment_id'));
        }
    }

    public function list()
    {
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $dayNow = date('d');
        $monthNow = date('m');
        $yearNow = date('Y');
        if ($awal == NULL) {
            $awal = date('Y-m-d', strtotime($yearNow . '-' . $monthNow . '-' . '1'));
            $akhir = date('Y-m-t');

            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'POD';
            $data['shipment'] = $this->pod->getListPod($awal, $akhir);
            
            $this->backend->display('cs/v_list_pod', $data);
        } else {
            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'POD';
            $data['shipment'] = $this->pod->getListPod($awal, $akhir);
          
            $this->backend->display('cs/v_list_pod', $data);
        }
    }

    public function getModalPod()
    {
        $shipment_id = $this->input->get('shipment_id'); // Mengambil ID dari parameter GET
        
		$pod = $this->pod->getModalPod($shipment_id)->row();
        // Kirim data sebagai respons JSON
        echo json_encode($pod);
    }

    public function scan($resi = NULL)
    {
        $data['title'] = 'POD';
        $data['resi'] = $resi;
        if ($resi != NULL){
            $queryshipment = "SELECT shipment_id,shipper,tgl_diterima,no_smu,status_pod,consigne,destination,tgl_pickup FROM tbl_shp_order WHERE shipment_id = $resi";
            // $data['shipment'] = $this->db->get_where('tbl_shp_order', array('shipment_id' => $resi))->row_array();
            $data['shipment'] = $this->db->query($queryshipment)->row_array();
        } else{
            $data['shipment'] = NULL;
        }
        $this->backend->display('cs/v_scan_pod', $data);
    }

    public function otw()
    {
        $dataPod = [
            'created_by' => $this->session->userdata('nama_user'),
            'shipment_id' => $this->input->post('shipment_id'),
            'tgl_otw' => $this->input->post('tgl_otw'),
            'provider' => $this->input->post('provider'),
            'resi' => $this->input->post('resi'),
        ];
        if ($this->db->insert('tbl_tracking_pod', $dataPod)) {
            if ($this->db->update('tbl_shp_order', array('status_pod' => 1), array('shipment_id' => $this->input->post('shipment_id')))) {
                $this->session->set_flashdata("success", "Update Success");
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function arrive()
    {
        $dataArrive = array(
            'tgl_sampe' => $this->input->post('tgl_sampe'),
            'penerima' => $this->input->post('penerima'),
        );
        if ($this->db->update('tbl_tracking_pod', $dataArrive, array('shipment_id' => $this->input->post('shipment_id')))) {
            if ($this->db->update('tbl_shp_order', array('status_pod' => 2), array('shipment_id' => $this->input->post('shipment_id')))) {
                $this->session->set_flashdata("success", "Update Success");
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function report()
    {
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $dayNow = date('d');
        $monthNow = date('m');
        $yearNow = date('Y');
        if ($awal == NULL) {
            $awal = date('Y-m-d', strtotime($yearNow . '-' . $monthNow . '-' . '1'));
            $akhir = date('Y-m-t');

            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'POD';
            $data['shipment'] = $this->pod->getListPod($awal, $akhir);
            $data['pending'] = $this->pod->getPendingPod($awal, $akhir);
            $data['proses'] = $this->pod->getProsesPod($awal, $akhir);
            $data['done'] = $this->pod->getDonePod($awal, $akhir);
            $this->backend->display('cs/v_report_pod', $data);
        } else {
            $data['awal'] = $awal;
            $data['akhir'] = $akhir;
            $data['title'] = 'POD';

            $data['shipment'] = $this->pod->getListPod($awal, $akhir);
            $data['pending'] = $this->pod->getPendingPod($awal, $akhir);
            $data['proses'] = $this->pod->getProsesPod($awal, $akhir);
            $data['done'] = $this->pod->getDonePod($awal, $akhir);
            $this->backend->display('cs/v_report_pod', $data);
        }
    }

    public function export($awal, $akhir)
    {
        $spreadsheet = new Spreadsheet();
        $where = ['deleted' => 0, 'so_id !=' => NULL, 'tgl_pickup >=' => "$awal", 'tgl_pickup <=' => "$akhir"];
        $data =  $this->pod->getListPodReport($awal, $akhir);
        // $sheet =  $spreadsheet->getActiveSheet();
        $sheet =  $spreadsheet->setActiveSheetIndex(0)->setTitle("PRIORITAS");

        $sheet->setCellValue('A1', 'REQUEST PICKUP')->getColumnDimension('A')->setWidth(150, 'pt');
        $sheet->setCellValue('B1', 'SHIPMENT ID')->getColumnDimension('B')->setWidth(80, 'pt');
        $sheet->setCellValue('C1', 'CUSTOMER')->getColumnDimension('C')->setAutoSize(true);
        $sheet->setCellValue('D1', 'CONSIGNEE')->getColumnDimension('D');
        $sheet->setCellValue('E1', 'NO DO/DN')->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F1', 'NO SO/PO')->getColumnDimension('F')
            ->setAutoSize(true);
        $sheet->setCellValue('G1', 'STP')->getColumnDimension('G')
            ->setAutoSize(true);
        $sheet->setCellValue('H1', 'DEST')->getColumnDimension('H')
            ->setAutoSize(true);
        $sheet->setCellValue('I1', 'SERVICE')->getColumnDimension('I')
            ->setAutoSize(true);
        $sheet->setCellValue('J1', 'COMM')->getColumnDimension('J')
            ->setAutoSize(true);
        $sheet->setCellValue('K1', 'COLLY')->getColumnDimension('K')
            ->setAutoSize(true);
        $sheet->setCellValue('L1', 'WEIGHT')->getColumnDimension('L')
            ->setAutoSize(true);
        $sheet->setCellValue('M1', 'SPECIAL WEIGHT')->getColumnDimension('M')
            ->setAutoSize(true);
        $sheet->setCellValue('N1', 'PETUGAS PICKUP')->getColumnDimension('N')
            ->setAutoSize(true);
        $sheet->setCellValue('O1', 'NO FLIGHT')->getColumnDimension('O')
            ->setAutoSize(true);
        $sheet->setCellValue('P1', 'NO SMU')->getColumnDimension('P')
            ->setAutoSize(true);
        $sheet->setCellValue('Q1', 'STATUS POD')->getColumnDimension('Q')
            ->setAutoSize(true);
        $sheet->setCellValue('R1', 'TANGGAL DITERIMA')->getColumnDimension('R')
            ->setAutoSize(true);
        $sheet->setCellValue('S1', 'TANGGAL POD DIKIRIM')->getColumnDimension('S')
            ->setAutoSize(true);
        $sheet->setCellValue('T1', 'TANGGAL POD DITERIMA')->getColumnDimension('T')
            ->setAutoSize(true);
        $sheet->setCellValue('U1', 'LEADTIME STP BALIK AGEN')->getColumnDimension('U')
            ->setAutoSize(true);
        $sheet->setCellValue('V1', 'SCORE')->getColumnDimension('V')
            ->setAutoSize(true);

        $x = 2;

        $total_reguler = 0;
        $total_agen = 0;
        $total_eh = 0;

        $total_pri_a = 0;
        $total_pri_b = 0;
        $total_pri_c = 0;
        $total_pri_d = 0;

        $total_reg_a = 0;
        $total_reg_b = 0;
        $total_reg_c = 0;
        $total_reg_d = 0;

        $total_agen_a = 0;
        $total_agen_b = 0;
        $total_agen_c = 0;
        $total_agen_d = 0;

        $total_eh_a = 0;
        $total_eh_b = 0;
        $total_eh_c = 0;
        $total_eh_d = 0;


        foreach ($data->result_array() as $o) {
            $presentase_kpi = 0;
            $total_terstatus = 0;
            $total_prioritas = 0;
            // get service

            $service = $this->db->get_where('tb_service_type', array('code' => $o['service_type']))->row();
            if ($service == NULL) {
                $service = '';
            } else {
                $service = $service->service_name;
            }

            // petugas pickup


            $petugas = $this->pod->getPetugas($o['shipment_id'])->row();

            if (isset($petugas->nama_user) == NULL) {
                $petugas = '';
            } else {
                $petugas = $petugas->nama_user;
            }



            $get_do = $this->db->get_where('tbl_no_do', array('shipment_id' => $o['shipment_id']));
            $jumlah = $get_do->num_rows();

            $no_do = '';
            $no_so = '';
            if ($get_do) {
                $i = 1;
                foreach ($get_do->result_array() as $d) {
                    $no_do = ($i == $jumlah) ? $d['no_do'] : $d['no_do'] . '/';
                    $i++;
                }
            } else {
                $no_do =  $o['note_cs'];
            }

            // no so
            if ($get_do) {
                $i = 1;
                foreach ($get_do->result_array as $d) {

                    $no_so =  ($i == $jumlah) ? $d['no_so'] : $d['no_so'] . '/';
                    $i++;
                }
            } else {
                $no_so =  $o['no_so'];
            }

            $query = $this->db->get_where('tbl_tracking_pod', array('shipment_id' => $o['shipment_id']))->row();
            if (isset($query->tgl_sampe) == NULL) {
                $tgl_sampe_pod = 'POD Pending';
                $tgl_dikirim_pod = 'POD Pending';
            } else {
                $tgl_sampe_pod = $query->tgl_sampe;
                $tgl_dikirim_pod = $query->tgl_otw;
            }
            // note
            // 1. P = tgl_pickup - tgl_pod_tiba
            // 2. R,A = tgl_diterima - tgl_pod_tiba
            $prioritas_cek = $o['shipper'];
            $tgl1 = '';
            $kategori = '';
            $is_agen = '';
            if (customerPrioritas($prioritas_cek)) {
                $tgl1 = strtotime($o['tgl_diterima']);
                $kategori = 'Prioritas';
                $total_prioritas += 1;
            } elseif (customerReguler($prioritas_cek)) {
                $tgl1 = strtotime($o['tgl_diterima']);
                $kategori = 'Reguler';
                $total_reguler += 1;
            } else {
                $tgl1 = strtotime($o['tgl_diterima']);
                $kategori = 'Agen';
                // $total_agen += 1;
            }

            // KPI
            $tgl2 = strtotime($tgl_sampe_pod);
            $jarak = $tgl2 - $tgl1;
            $hari = $jarak / 60 / 60 / 24;
            $kpi = cekJenisCustomer($o['shipper'], $hari, $o['no_smu']);
            $status_pod = $o['status_pod'];

            $status = '';
            $kpi_result = '';
            if ($status_pod == 0) {
                $status = 'Pending';
                $hari = '';
            } elseif ($status_pod == 1) {
                $status = 'On Delivery';
                $hari = '';
            } else {
                $status = 'Arrive';
                $kpi_result = $kpi;
                $hari = $hari . ' Hari';
            }

            // hitung jumlah score berdasarkan kategori

            if (customerPrioritas($prioritas_cek)) {
                if ($kpi_result == "A") {
                    $total_pri_a += 1;
                } elseif ($kpi_result == "B") {
                    $total_pri_b += 1;
                } elseif ($kpi_result == "C") {
                    $total_pri_c += 1;
                } elseif ($kpi_result == "D") {
                    $total_pri_d += 1;
                }

                // cek apakah dia dikirim ke agen
                if ($o['no_smu'] != "TLX") {
                    if ($kpi_result == "A") {
                        $total_agen_a += 1;
                    } elseif ($kpi_result == "B") {
                        $total_agen_b += 1;
                    } elseif ($kpi_result == "C") {
                        $total_agen_c += 1;
                    } elseif ($kpi_result == "D") {
                        $total_agen_d += 1;
                    }
                    $total_agen += 1;
                    $is_agen = '- Agen';
                }
                // cek apakah custumer EH
                if (customerEndress($o['shipper'])) {
                    if ($kpi_result == "A") {
                        $total_eh_a += 1;
                    } elseif ($kpi_result == "B") {
                        $total_eh_b += 1;
                    } elseif ($kpi_result == "C") {
                        $total_eh_c += 1;
                    } elseif ($kpi_result == "D") {
                        $total_eh_d += 1;
                    }
                    $total_eh += 1;
                }
            } elseif (customerReguler($prioritas_cek)) {
                if ($kpi_result == "A") {
                    $total_reg_a += 1;
                } elseif ($kpi_result == "B") {
                    $total_reg_b += 1;
                } elseif ($kpi_result == "C") {
                    $total_reg_c += 1;
                } elseif ($kpi_result == "D") {
                    $total_pri_d += 1;
                }
                // cek apakah dia dikirim ke agen
                if ($o['no_smu'] != "TLX") {
                    if ($kpi_result == "A") {
                        $total_agen_a += 1;
                    } elseif ($kpi_result == "B") {
                        $total_agen_b += 1;
                    } elseif ($kpi_result == "C") {
                        $total_agen_c += 1;
                    } elseif ($kpi_result == "D") {
                        $total_agen_d += 1;
                    }
                    $total_agen += 1;
                    $is_agen = '- Agen';
                }
                // cek apakah custumer EH
                if (customerEndress($o['shipper'])) {
                    if ($kpi_result == "A") {
                        $total_eh_a += 1;
                    } elseif ($kpi_result == "B") {
                        $total_eh_b += 1;
                    } elseif ($kpi_result == "C") {
                        $total_eh_c += 1;
                    } elseif ($kpi_result == "D") {
                        $total_eh_d += 1;
                    }
                    $total_eh += 1;
                }
            } else {
                // if ($kpi_result == "A") {
                //     $total_agen_a += 1;
                // } elseif ($kpi_result == "B") {
                //     $total_agen_b += 1;
                // } elseif ($kpi_result == "C") {
                //     $total_agen_c += 1;
                // } elseif ($kpi_result == "D") {
                //     $total_pri_d += 1;
                // }
            }

            $sheet->setCellValue('A' . $x, $o['tgl_pickup'])->getColumnDimension('A')
                ->setAutoSize(true);
            $sheet->setCellValue('B' . $x, $o['shipment_id'])->getColumnDimension('B')
                ->setAutoSize(true);
            $sheet->setCellValue('C' . $x,  $o['shipper'] . '-' . $kategori)->getColumnDimension('C')
                ->setAutoSize(true);
            $sheet->setCellValue('D' . $x,  $o['consigne'])->getColumnDimension('D');
            $sheet->setCellValue('E' . $x,  $no_do)->getColumnDimension('E')
                ->setAutoSize(true);
            $sheet->setCellValue('F' . $x,  $no_so)->getColumnDimension('F')
                ->setAutoSize(true);
            $sheet->setCellValue('G' . $x,  $o['no_stp'])->getColumnDimension('G')
                ->setAutoSize(true);
            $sheet->setCellValue('H' . $x,  $o['tree_consignee'])->getColumnDimension('H')
                ->setAutoSize(true);
            $sheet->setCellValue('I' . $x,  $service)->getColumnDimension('I')
                ->setAutoSize(true);
            $sheet->setCellValue('J' . $x,  $o['pu_commodity'])->getColumnDimension('J')
                ->setAutoSize(true);
            $sheet->setCellValue('K' . $x,  $o['koli'])->getColumnDimension('K')
                ->setAutoSize(true);
            $sheet->setCellValue('L' . $x,  $o['berat_js'])->getColumnDimension('L')
                ->setAutoSize(true);
            $sheet->setCellValue('M' . $x,  $o['berat_msr'])->getColumnDimension('M')
                ->setAutoSize(true);
            $sheet->setCellValue('N' . $x,  $petugas)->getColumnDimension('N')
                ->setAutoSize(true);
            $sheet->setCellValue('O' . $x,  $o['no_flight'])->getColumnDimension('O')
                ->setAutoSize(true);
            $sheet->setCellValue('P' . $x,  $o['no_smu'])->getColumnDimension('P')
                ->setAutoSize(true);
            $sheet->setCellValue('Q' . $x,  $status)->getColumnDimension('Q')
                ->setAutoSize(true);
            $sheet->setCellValue('R' . $x,  $o['tgl_diterima'])->getColumnDimension('R')
                ->setAutoSize(true);
            $sheet->setCellValue('S' . $x,  $tgl_dikirim_pod)->getColumnDimension('S')
                ->setAutoSize(true);
            $sheet->setCellValue('T' . $x,  $tgl_sampe_pod)->getColumnDimension('T')
                ->setAutoSize(true);
            $sheet->setCellValue('U' . $x,  $hari)->getColumnDimension('U')
                ->setAutoSize(true);
            $sheet->setCellValue('V' . $x,  $kpi_result)->getColumnDimension('V')
                ->setAutoSize(true);
            $x++;
        }

        // KPI PRIORITAS
        $x = $x + 2;
        // $total_terstatus = 0;
        $total_terstatus = $total_pri_a + $total_pri_b + $total_pri_c + $total_pri_d;
        if ($total_terstatus == 0) {
            $total_terstatus = 1;
        }
        // var_dump($total_terstatus);
        // die;
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '10c469'],
                ],
            ],
            'background' => [
                'color' => ['argb' => '10c469']
            ]
        ];
        $sheet->getStyle('B' . $x . ':' . 'F' . $x)
            ->applyFromArray($styleArray);
        $sheet->setCellValue('B' . $x, "STP")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, "A")->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  "B")->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x,  "C")->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x,  "D")->getColumnDimension('F')
            ->setAutoSize(true);

        $x = $x + 1;

        $sheet->setCellValue('B' . $x, $total_prioritas)->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, $total_pri_a)->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  $total_pri_b)->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x,  $total_pri_c)->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x,  $total_pri_d)->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;
        $sheet->setCellValue('B' . $x, "")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, round(($total_pri_a / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x, round(($total_pri_b / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x, round(($total_pri_c / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x, round(($total_pri_d / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('F')
            ->setAutoSize(true);

        $x = $x + 1;
        $sheet->setCellValue('B' . $x, "TERSTATUS")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, $total_terstatus)->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  "BLANK")->getColumnDimension('D')
            ->setAutoSize(true);
        $x = $x + 1;

        $presentase_kpi = ($total_terstatus / $total_prioritas) * 100;
        $total_blank = $total_prioritas - $total_terstatus;
        $sheet->setCellValue('B' . $x, "KPI (PRIORITAS)")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, round($presentase_kpi, 2) . ' %')->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  $total_blank)->getColumnDimension('D')
            ->setAutoSize(true);

        // KPI REGULER
        $x = $x + 2;
        $total_terstatus = $total_reg_a + $total_reg_b + $total_reg_c + $total_reg_d;
        if ($total_terstatus == 0) {
            $total_terstatus = 1;
        }
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'FFFF0000'],
                ],
            ],
            'background' => [
                'color' => ['argb' => 'FFFF0000']
            ]
        ];
        $sheet->getStyle('B' . $x . ':' . 'F' . $x)
            ->applyFromArray($styleArray);

        $sheet->setCellValue('B' . $x, "STP")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, "A")->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  "B")->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x,  "C")->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x,  "D")->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;

        $sheet->setCellValue('B' . $x, $total_reguler)->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, $total_reg_a)->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  $total_reg_b)->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x,  $total_reg_c)->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x,  $total_reg_d)->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;

        $sheet->setCellValue('B' . $x, "")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, round(($total_reg_a / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x, round(($total_reg_b / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x, round(($total_reg_c / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x, round(($total_reg_d / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;

        $sheet->setCellValue('B' . $x, "TERSTATUS")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, $total_terstatus)->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  "BLANK")->getColumnDimension('D')
            ->setAutoSize(true);
        $x = $x + 1;

        $presentase_kpi = ($total_terstatus / $total_reguler) * 100;
        $total_blank = $total_reguler - $total_terstatus;
        $sheet->setCellValue('B' . $x, "KPI (REGULER)")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, round($presentase_kpi, 2) . ' %')->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  $total_blank)->getColumnDimension('D')
            ->setAutoSize(true);



        // KPI AGEN
        $x = $x + 2;
        $total_terstatus = $total_agen_a + $total_agen_b + $total_agen_c + $total_agen_d;
        if ($total_terstatus == 0) {
            $total_terstatus = 1;
        }
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '71b6f9'],
                ],
            ],
            'background' => [
                'color' => ['argb' => '71b6f9']
            ]
        ];
        $sheet->getStyle('B' . $x . ':' . 'F' . $x)
            ->applyFromArray($styleArray);

        $sheet->setCellValue('B' . $x, "STP")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, "A")->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  "B")->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x,  "C")->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x,  "D")->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;

        $sheet->setCellValue('B' . $x, $total_agen)->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, $total_agen_a)->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  $total_agen_b)->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x,  $total_agen_c)->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x,  $total_agen_d)->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;

        $sheet->setCellValue('B' . $x, "")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, round(($total_agen_a / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x, round(($total_agen_b / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x, round(($total_agen_c / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x, round(($total_agen_d / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;

        $sheet->setCellValue('B' . $x, "TERSTATUS")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, $total_terstatus)->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  "BLANK")->getColumnDimension('D')
            ->setAutoSize(true);
        $x = $x + 1;

        $presentase_kpi = ($total_terstatus / $total_agen) * 100;
        $total_blank = $total_agen - $total_terstatus;
        $sheet->setCellValue('B' . $x, "KPI (AGEN)")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, round($presentase_kpi, 2) . ' %')->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  $total_blank)->getColumnDimension('D')
            ->setAutoSize(true);



        // KPI EH
        $x = $x + 2;
        $total_terstatus = $total_eh_a + $total_eh_b + $total_eh_c + $total_eh_d;
        if ($total_terstatus == 0) {
            $total_terstatus = 1;
        }
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'f9c851'],
                ],
            ],
            'background' => [
                'color' => ['argb' => 'f9c851']
            ]
        ];
        $sheet->getStyle('B' . $x . ':' . 'F' . $x)
            ->applyFromArray($styleArray);

        $sheet->setCellValue('B' . $x, "STP")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, "A")->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  "B")->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x,  "C")->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x,  "D")->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;

        $sheet->setCellValue('B' . $x, $total_eh)->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, $total_eh_a)->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  $total_eh_b)->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x,  $total_eh_c)->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x,  $total_eh_d)->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;

        $sheet->setCellValue('B' . $x, "")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, round(($total_eh_a / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x, round(($total_eh_b / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('D')
            ->setAutoSize(true);
        $sheet->setCellValue('E' . $x, round(($total_eh_c / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('E')
            ->setAutoSize(true);
        $sheet->setCellValue('F' . $x, round(($total_eh_d / $total_terstatus) * 100, 2) . ' %')->getColumnDimension('F')
            ->setAutoSize(true);
        $x = $x + 1;

        $sheet->setCellValue('B' . $x, "TERSTATUS")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, $total_terstatus)->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  "BLANK")->getColumnDimension('D')
            ->setAutoSize(true);
        $x = $x + 1;

        $presentase_kpi = ($total_terstatus / $total_eh) * 100;
        $total_blank = $total_eh - $total_terstatus;
        $sheet->setCellValue('B' . $x, "KPI (ENDRESS)")->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('C' . $x, round($presentase_kpi, 2) . ' %')->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('D' . $x,  $total_blank)->getColumnDimension('D')
            ->setAutoSize(true);


        $filename = "export-pod-$awal-$akhir";


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
