<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approval extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sendwa', 'wa');
        $this->load->model('ApModel', 'ap');
    }
    public function testWa($nomor = NULL)
    {
        // $this->wa->pickup('+6281808008082', "Tester Message Whatsapp");
        $this->wa->pickup('+6285697780467', "Tester Message Whatsapp");
        if ($nomor != NULL) {
            $this->wa->pickup($nomor, "Tester Message Whatsapp");
        }
        //$this->wa->pickup('+62895358288395', "Tester Message Whatsapp Api");
    }

    public function detailCs($no_ap)
    {
        $data['title'] = 'Detail Account Payable';
        $data['ap'] = $this->ap->getApByNo($no_ap)->result_array();
        $data['info'] = $this->ap->getApByNo($no_ap)->row_array();
        $data['kategori_ap'] = $this->db->get('tbl_kat_ap')->result_array();
        $data['kategori_pengeluaran'] = $this->db->get('tbl_list_pengeluaran')->result_array();
        $this->load->view('v_detail_ap_cs', $data);
    }
    public function detailOps($no_ap)
    {
        $data['title'] = 'Detail Account Payable';
        $data['ap'] = $this->ap->getApByNo($no_ap)->result_array();
        $data['info'] = $this->ap->getApByNo($no_ap)->row_array();
        $data['kategori_ap'] = $this->db->get('tbl_kat_ap')->result_array();
        $data['kategori_pengeluaran'] = $this->db->get('tbl_list_pengeluaran')->result_array();
        $this->load->view('v_detail_ap_ops', $data);
    }
    public function detailSales($no_ap, $id_atasan)
    {
        $data['title'] = 'Detail Account Payable';
        $data['ap'] = $this->ap->getApByNo($no_ap)->result_array();
        $data['info'] = $this->ap->getApByNo($no_ap)->row_array();
        $data['id_atasan'] = $id_atasan;
        $data['kategori_ap'] = $this->db->get('tbl_kat_ap')->result_array();
        $data['kategori_pengeluaran'] = $this->db->get('tbl_list_pengeluaran')->result_array();
        $this->load->view('v_detail_ap_sales', $data);
    }
    // ap approval mgr cs
    public function approveMgrCs($no_pengeluaran)
    {
        $where = array('no_pengeluaran' => $no_pengeluaran);
        $cek_data = $this->db->get_where('tbl_pengeluaran', $where)->row_array();
        if ($cek_data) {
            $data = array(
                'no_pengeluaran' => $no_pengeluaran,
                'approve_by_atasan' => 12,
                'created_atasan' => date('Y-m-d H:i:s'),
            );
            $insert = $this->db->insert('tbl_approve_pengeluaran', $data);
            //var_dump($data); die;
            if ($insert) {
                $this->db->update('tbl_pengeluaran', ['status' => 1], $where);

                $get_ap = $this->db->get_where('tbl_pengeluaran', $where)->row_array();
                $no_ap = $get_ap['no_pengeluaran'];
                $purpose = $get_ap['purpose'];
                $date = $get_ap['date'];
                $link = "https://jobsheet.transtama.com/approval/detail/$no_ap";
                // $link = "http://jobsheet.test/approval/ap/$no_ap";
                // echo "<li><a href='whatsapp://send?text=$actual_link'>Share</a></li>";
                $pesan = "Hallo, ada pengajuan Ap No. *$no_ap* Dengan Tujuan *$purpose* Tanggal *$date*. Silahkan approve melalui link berikut : $link . Terima Kasih";
                // no pak sam
                $this->wa->pickup('+6281808008082', "$pesan");
                $this->wa->pickup('+6285157906966', "$pesan");
                //Norman
                $this->wa->pickup('+6285697780467', "$pesan");

                echo "<script>alert('Success Approve')</script>";
                echo "<script>window.close();</script>";
            } else {
                echo "<script>alert('Failed Approve')</script>";
                echo "<script>window.close();</script>";
            }
        } else {
            echo "<script>alert('Failed Approve, No Data Selected')</script>";
            echo "<script>window.close();</script>";
        }
    }

    // approve mgr ops

    public function approveMgrOps($no_pengeluaran)
    {
        $where = array('no_pengeluaran' => $no_pengeluaran);
        $cek_data = $this->db->get_where('tbl_pengeluaran', $where)->row_array();
        if ($cek_data) {
            $data = array(
                'no_pengeluaran' => $no_pengeluaran,
                'approve_by_atasan' => 25,
                'created_atasan' => date('Y-m-d H:i:s'),
            );
            $insert = $this->db->insert('tbl_approve_pengeluaran', $data);
            if ($insert) {
                $this->db->update('tbl_pengeluaran', ['status' => 1], $where);
                $get_ap = $this->db->get_where('tbl_pengeluaran', $where)->row_array();
                $no_ap = $get_ap['no_pengeluaran'];
                $purpose = $get_ap['purpose'];
                $date = $get_ap['date'];
                $link = "https://jobsheet.transtama.com/approval/detail/$no_ap";
                // $link = "http://jobsheet.test/approval/ap/$no_ap";
                // echo "<li><a href='whatsapp://send?text=$actual_link'>Share</a></li>";
                $pesan = "Hallo, ada pengajuan Ap No. *$no_ap* Dengan Tujuan *$purpose* Tanggal *$date*. Silahkan approve melalui link berikut : $link . Terima Kasih";
                // no pak sam

                $this->wa->pickup('+6281808008082', "$pesan");
                $this->wa->pickup('+6285157906966', "$pesan");
                //Norman
                $this->wa->pickup('+6285697780467', "$pesan");

                echo "<script>alert('Success Approve')</script>";
                echo "<script>window.close();</script>";
            } else {
                echo "<script>alert('Failed Approve')</script>";
                echo "<script>window.close();</script>";
            }
        } else {
            echo "<script>alert('Failed Approve, No Data Selected')</script>";
            echo "<script>window.close();</script>";
        }
    }
    // approve sales
    public function approveMgrSales($no_pengeluaran, $id_atasan)
    {
        $where = array('no_pengeluaran' => $no_pengeluaran);
        $data = array(
            'no_pengeluaran' => $no_pengeluaran,
            'approve_by_atasan' => $id_atasan,
            'created_atasan' => date('Y-m-d H:i:s'),
        );
        $insert = $this->db->insert('tbl_approve_pengeluaran', $data);
        if ($insert) {
            $get_ap = $this->db->get_where('tbl_pengeluaran', $where)->row_array();

            $no_ap = $get_ap['no_pengeluaran'];
            $purpose = $get_ap['purpose'];
            $date = $get_ap['date'];
            $pesan = "Hallo Finance, ada pengajuan Ap No. *$no_ap* Dengan Tujuan *$purpose* Tanggal *$date*. Tolong Segera Cek Ya, Terima Kasih";
            // no finance
            // $this->wa->pickup('+6285157906966', "$pesan");
            $this->wa->pickup('+6289629096425', "$pesan");
            $this->wa->pickup('+6287771116286', "$pesan");

            //Norman
            $this->wa->pickup('+6285697780467', "$pesan");

            $this->db->update('tbl_pengeluaran', ['status' => 2], $where);
            echo "<script>alert('Success Approve')</script>";
            echo "<script>window.close();</script>";
        } else {
            echo "<script>alert('Failed Approve')</script>";
            echo "<script>window.close();</script>";
        }
    }
    // approve aktivasi
    public function approveRequest($id_request)
    {
        $data = array(
            'status' => 1,
        );
        $update = $this->db->update('tbl_request_revisi', $data, ['id_request' => $id_request]);
        if ($update) {
            echo "<script>alert('Success Approve')</script>";
            echo "<script>window.close();</script>";
        } else {
            echo "<script>alert('Failed Approve')</script>";
            echo "<script>window.close();</script>";
        }
    }
}
