<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Invoice extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_Datatables');
        $this->load->model('JobsheetModel','cs');
       
        require_once APPPATH . 'third_party/vendor/autoload.php';
    }

    public function printProforma($no_invoice)
    {
        $data['invoice'] = $this->cs->getInvoice($no_invoice)->result_array();
        $data['info'] = $this->cs->getInvoice($no_invoice)->row_array();
        $get_alamat_customer = $this->db->get_where('tb_customer', ['nama_pt' => $data['info']['shipper']])->row_array();
      
        $data['total_invoice'] = $this->cs->getInvoice($no_invoice)->num_rows();
		
		//var_dump($data); die;
		
        // kalo dia ada reimbursment
        if ($data['info']['is_reimbursment'] == 1) {
			$data['reimbursment'] = $this->cs->getInvoiceReimbursment($no_invoice)->row_array();
            $this->load->view('superadmin/v_cetak_invoice_reimbursment', $data);
            $html = $this->output->get_output();
            $this->load->library('dompdf_gen');
            $this->dompdf->set_paper("legal", 'potrait');
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            // $sekarang = date("d:F:Y:h:m:s");
            $this->dompdf->stream("Invoice$no_invoice.pdf", array('Attachment' => 0));
        } else {
            $this->load->view('superadmin/v_cetak_invoice', $data);
            $html = $this->output->get_output();
            $this->load->library('dompdf_gen');
            $this->dompdf->set_paper("legal", 'potrait');
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            // $sekarang = date("d:F:Y:h:m:s");
            $this->dompdf->stream("Invoice$no_invoice.pdf", array('Attachment' => 0));
        }
    }

    public function printProformaExcell($no_invoice)
    {
        $spreadsheet = new Spreadsheet();
        $invoice = $this->cs->getInvoice($no_invoice)->result_array();
        $total_invoice = $this->cs->getInvoice($no_invoice)->num_rows();
        $info = $this->cs->getInvoice($no_invoice)->row_array();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', '')->mergeCells('A1:A3')->getColumnDimension('A')->setWidth(150, 'pt');
        $sheet->setCellValue('B1', 'Customer')->getColumnDimension('B')->setWidth(80, 'pt');
        $sheet->setCellValue('B2', 'Address')->getColumnDimension('B');
        $sheet->setCellValue('B3', 'No. Telp')->getColumnDimension('B');
        $sheet->setCellValue('C1', $info['customer'])->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('C2', $info['address'])->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('C3', $info['no_telp'])->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('A4', 'INVOICE')->mergeCells('A4:E4')->getStyle('A4')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A4', 'INVOICE')->mergeCells('A4:E4')->getStyle('A4')->getFont()->setBold(true);

        $sheet->setCellValue('A5', 'PT. TRANSTAMA LOGISTICS EXPRESS')->getColumnDimension('A')
            ->setAutoSize(true);
        $sheet->setCellValue('A6', 'JL. PENJERNIHAN II NO. III B')->getColumnDimension('A')
            ->setAutoSize(true);
        $sheet->setCellValue('A7', 'JAKARTA PUSAT 10210')->getColumnDimension('A')
            ->setAutoSize(true);
        $sheet->setCellValue('A8', 'PHONE : (021) 57852609 (HUNTING)')->getColumnDimension('A')
            ->setAutoSize(true);
        $sheet->setCellValue('A9', 'FAX : (021) 57852608')->getColumnDimension('A')
            ->setAutoSize(true);

        $sheet->setCellValue('B5', 'INVOICE No')->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('B6', 'DATE')->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('B7', 'DUE DATE')->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('B8', '')->getColumnDimension('B')
            ->setAutoSize(true);
        $sheet->setCellValue('B9', 'PIC')->getColumnDimension('B')
            ->setAutoSize(true);

        $sheet->setCellValue('C5',   $info['no_invoice'])->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('C6', tanggal_invoice2($info['date']))->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('C7',  tanggal_invoice2($info['due_date']))->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('C8', '')->getColumnDimension('C')
            ->setAutoSize(true);
        $sheet->setCellValue('C9', $info['pic'])->getColumnDimension('C')
            ->setAutoSize(true);

        // data
        $sheet->setCellValue('A12', 'AWB')->getStyle('A12')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('B12', 'No DO')->getStyle('B12')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('C12', 'Date')->getStyle('C12')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('D12', 'DEST')->getStyle('D12')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('E12', 'SERVICE')->getStyle('E12')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('F12', 'COLLIE')->getStyle('F12')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('G12', 'WEIGHT')->getStyle('G12')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('H12', 'RATE')->getStyle('H12')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('I12', 'OTHERS')->getStyle('I12')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('J12', 'TOTAL AMOUNT')->getColumnDimension('J')->setAutoSize(true);
		
		

        $no = 1;
        $x = 13;
        $total_koli = 0;
        $total_weight = 0;
        $total_special_weight = 0;
        $total_amount = 0;

        foreach ($invoice as $inv) {
            $get_do = $this->db->get_where('tbl_no_do', ['shipment_id' => $inv['shipment_id']]);
            $data_do = $get_do->result_array();
            $total_do = $get_do->num_rows();


            $no = 1;
            $service =  $inv['service_name'];
            if ($service == 'Charter Service') {
                $packing = $inv['packing'];
                $total_sales = ($inv['freight_kg'] + $packing +  $inv['special_freight'] +  $inv['others'] + $inv['surcharge'] + $inv['insurance']);
            } else {
                $disc = $inv['disc'];
                // kalo gada disc
                if ($disc == 0) {
                    $freight  = $inv['berat_js'] * $inv['freight_kg'];
                    $special_freight  = $inv['berat_msr'] * $inv['special_freight'];
                } else {
                    $freight_discount = $inv['freight_kg'] * $disc;
                    $special_freight_discount = $inv['special_freight'] * $disc;
                    $freight = $freight_discount * $inv['berat_js'];
                    $special_freight  = $special_freight_discount * $inv['berat_msr'];
                }
                $packing = $inv['packing'];
                $total_sales = ($freight + $packing + $special_freight +  $inv['others'] + $inv['surcharge'] + $inv['insurance']);
            }
            $m =  $total_do;
            $m = $m + $x;
            if ($inv['service_name'] == 'Charter Service') {
                $service = $inv['service_name'] . '-' . $inv['pu_moda'];
            } else {
                $service =  $inv['service_name'];;
            }


            if ($service == 'Charter Service') {
                $rate = $inv['special_freight'];
            } else {
                $rate =  $inv['freight_kg'];
            }

            if ($total_do == 0) {
                if ($inv['no_so'] != NULL && $inv['no_stp'] != NULL) {
                    $no_do = $inv['note_cs'] . '<br>/' . $inv['no_so'] . '/' . $inv['no_stp'];
                } else {
                    $no_do = $inv['note_cs'];
                }
                $sheet->setCellValue('A' . $x, $inv['shipment_id'])->getColumnDimension('A')
                    ->setAutoSize(true);
                $sheet->setCellValue('B' . $x, $no_do)->getColumnDimension('B')
                    ->setAutoSize(true);
                $sheet->setCellValue('C' . $x,  tanggal_invoice($inv['tgl_pickup']))->getColumnDimension('C')
                    ->setAutoSize(true);
                $sheet->setCellValue('D' . $x, $inv['tree_consignee'])->getColumnDimension('D')
                    ->setAutoSize(true);
                $sheet->setCellValue('E' . $x, $service)->getColumnDimension('E')
                    ->setAutoSize(true);

                $sheet->setCellValue('F' . $x, $inv['koli'])->getColumnDimension('F')
                    ->setAutoSize(true);
                $sheet->setCellValue('G' . $x,  $inv['berat_js'])->getColumnDimension('G')
                    ->setAutoSize(true);
                if ($rate != 0) {
                    $sheet->getStyle("H" . $x)->getNumberFormat()->setFormatCode("(\"Rp.\"* #,##0);(\"Rp.\"* \(#,##0\);(\"$\"* \"-\"??);(@_)");
                    $sheet->setCellValue('H' . $x, $rate)->getColumnDimension('H')
                        ->setAutoSize(true);
                } else {
                    $sheet->setCellValue('H' . $x, $rate)->getColumnDimension('H')
                        ->setAutoSize(true);
                }
                 $sheet->setCellValue('I' . $x, rupiah($inv['others']))->getColumnDimension('I')
                    ->setAutoSize(true);
                if ($total_sales != 0) {
                    $sheet->getStyle("J" . $x)->getNumberFormat()->setFormatCode("(\"Rp.\"* #,##0);(\"Rp.\"* \(#,##0\);(\"$\"* \"-\"??);(@_)");
                    $sheet->setCellValue('J' . $x, $total_sales)->getColumnDimension('J')
                        ->setAutoSize(true);
                } else {
                    $sheet->setCellValue('J' . $x, $rate)->getColumnDimension('J')
                        ->setAutoSize(true);
                }
                $total_koli = $total_koli + $inv['koli'];
            } else {

                $rowspan = 'A' . $x . ':A' . $m;

                foreach ($data_do as $d) {
                    $sheet->setCellValue('A' . $x, $inv['shipment_id'])->getColumnDimension('A')
                        ->setAutoSize(true);

                    $sheet->setCellValue('B' . $x, $d['no_do'])->getColumnDimension('B')
                        ->setAutoSize(true);

                    $sheet->setCellValue('C' . $x, tanggal_invoice($inv['tgl_pickup']))->getColumnDimension('C')
                        ->setAutoSize(true);
                    $sheet->setCellValue('D' . $x, $inv['tree_consignee'])->getColumnDimension('D')
                        ->setAutoSize(true);
                    $sheet->setCellValue('E' . $x, $service)->getColumnDimension('E')
                        ->setAutoSize(true);
                    $sheet->setCellValue('F' . $x, $d['koli'])->getColumnDimension('F')
                        ->setAutoSize(true);
                    $sheet->setCellValue('G' . $x,  $d['berat'])->getColumnDimension('G')
                        ->setAutoSize(true);

                    if ($rate != 0) {
                        $sheet->getStyle("H" . $x)->getNumberFormat()->setFormatCode("(\"Rp.\"* #,##0);(\"Rp.\"* \(#,##0\);(\"$\"* \"-\"??);(@_)");
                        $sheet->setCellValue('H' . $x, $rate)->getColumnDimension('H')
                            ->setAutoSize(true);
                    } else {
                        $sheet->setCellValue('H' . $x, $rate)->getColumnDimension('H')
                            ->setAutoSize(true);
                    }
                    $sheet->setCellValue('I' . $x, rupiah($inv['others']))->getColumnDimension('I')
                    ->setAutoSize(true);
                if ($total_sales != 0) {
                    $sheet->getStyle("J" . $x)->getNumberFormat()->setFormatCode("(\"Rp.\"* #,##0);(\"Rp.\"* \(#,##0\);(\"$\"* \"-\"??);(@_)");
                    $sheet->setCellValue('J' . $x, $total_sales)->getColumnDimension('J')
                        ->setAutoSize(true);
                } else {
                    $sheet->setCellValue('J' . $x, $rate)->getColumnDimension('J')
                        ->setAutoSize(true);
                }
                    $total_koli = $total_koli + $d['koli'];
                }
            }
            $total_weight = $total_weight + $inv['berat_js'];
            $total_special_weight = $total_special_weight + $inv['berat_msr'];
            $total_amount = $total_amount + $total_sales;
            $x++;
            $no++;
        }
        $rowspan = $x;
        if ($info['print_do'] == 1) {
            $rowspan = 'A' . $rowspan . ':E' . $rowspan;
            $sheet->setCellValue('A' . $x, 'TOTAL ' . $total_invoice . ' AWB')->mergeCells($rowspan)->getStyle('A' . $x)->getAlignment()->setHorizontal('center');
        } else {
            $rowspan = 'A' . $rowspan . ':D' . $rowspan;
            $sheet->setCellValue('A' . $x, 'TOTAL ' . $total_invoice . ' AWB')->mergeCells($rowspan)->getStyle('A' . $x)->getAlignment()->setHorizontal('center');
        }
        $sheet->setCellValue('F' . $x, $total_koli);
        $sheet->setCellValue('G' . $x, $total_weight);
        $sheet->setCellValue('H' . $x, 'SUB TOTAL');
        $sheet->setCellValue('I' . $x, rupiah($total_amount));

        // ppn
        $ppn = $x + 1;
        if ($info['print_do'] == 1) {
            $rowspan = 'A' . $ppn . ':H' . $ppn;
            $sheet->setCellValue('A' . $ppn, 'PPN 1,1 %')->mergeCells($rowspan)->getStyle('A' . $ppn)->getAlignment()->setHorizontal('right');
        } else {
            $rowspan = 'A' . $ppn . ':G' . $ppn;
            $sheet->setCellValue('A' . $ppn, 'PPN 1,1 %')->mergeCells($rowspan)->getStyle('A' . $ppn)->getAlignment()->setHorizontal('right');
        }

        $ppn_total =  $total_amount * 0.011;
        $sheet->setCellValue('I' . $ppn, rupiah($ppn_total));

        // ppn
        $total = $x + 2;
        if ($info['print_do'] == 1) {
            $rowspan = 'A' . $total . ':H' . $total;
            $sheet->setCellValue('A' . $total, 'TOTAL')->mergeCells($rowspan)->getStyle('A' . $total)->getAlignment()->setHorizontal('right');
        } else {
            $rowspan = 'A' . $total . ':G' . $total;
            $sheet->setCellValue('A' . $total, 'TOTAL')->mergeCells($rowspan)->getStyle('A' . $total)->getAlignment()->setHorizontal('right');
        }

        $total_amount = $total_amount + $ppn_total;
        $sheet->setCellValue('I' . $total, rupiah($total_amount));

        // said

        $said = $total + 2;
        $said_word = $said + 1;
        $say = "#" . $info['terbilang'] . "#";
        $sheet->setCellValue('A' . $said, 'SAID :')->getColumnDimension('A')
            ->setAutoSize(true);
        $sheet->setCellValue('A' . $said_word,   $say)->getColumnDimension('A')
            ->setAutoSize(true);

        // footer

        $said_word = $said_word + 2;
        $sheet->setCellValue('A' . $said_word, 'Please remit payment to our account with Full Amount:')->getColumnDimension('A')
            ->setAutoSize(true);

        $said_word = $said_word + 1;
        $sheet->setCellValue('A' . $said_word, 'PT. TRANSTAMA LOGISTICS EXPRESS')->getColumnDimension('A')
            ->setAutoSize(true);
        $sheet->setCellValue('B' . $said_word, 'Jakarta, ' . bulan_indo($info['date']))->getColumnDimension('B')
            ->setAutoSize(true);

        $said_word = $said_word + 1;
        $sheet->setCellValue('A' . $said_word, 'Bank Details: ')->getColumnDimension('A')
            ->setAutoSize(true);

        $said_word = $said_word + 1;
        $sheet->setCellValue('A' . $said_word, '-BANK CENTRAL ASIA (BCA)')->getColumnDimension('A')
            ->setAutoSize(true);
        $said_word = $said_word + 1;
        $sheet->setCellValue('A' . $said_word, 'Cab. Wisma GKBI, Jakarta')->getColumnDimension('A')
            ->setAutoSize(true);
        $said_word = $said_word + 1;
        $sheet->setCellValue('A' . $said_word, 'A/C No : 006 306 7374 (IDR)')->getColumnDimension('A')
            ->setAutoSize(true);
        $said_word = $said_word + 1;
        $sheet->setCellValue('B' . $said_word, 'FINANCE')->getColumnDimension('A')
            ->setAutoSize(true);
        $said_word = $said_word + 1;
        $sheet->setCellValue('A' . $said_word, '* INTEREST CHARGEST AT 10 % PER MONTH WILL BE LEVIED ON OVERDUE INVOICES')->getColumnDimension('A')
            ->setAutoSize(true);

        $filename = "export-invoice-$no_invoice";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }


}
