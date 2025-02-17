<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alertcs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sendwa', 'wa');
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    public function alertSubmitSo()
    {


        $user = $this->db->query("SELECT id_user,no_hp,id_role,nama_user FROM tb_user WHERE id_role = 4");
        foreach ($user->result_array() as $user1) {
            $so = $this->db->query("SELECT id_so,shipper,tgl_pickup,status FROM tbl_so WHERE tgl_pickup = '" . date('Y-m-d') . "' AND cancel_date IS NULL AND submitso_at IS NULL AND id_sales = " . $user1['id_user'] . " AND status > 0 AND status != 5");

            if ($so->num_rows() != NULL) {
                $listSo = '';
                foreach ($so->result_array() as $so1) {
                    $cekResi = $this->db->query("SELECT shipment_id FROM tbl_shp_order WHERE id_so = " . $so1['id_so'] . " LIMIT 1 ");
                    if ($cekResi->num_rows() != 0) {
                        $listSo .= '\r\n' . $so1['shipper'] . ' Tanggal Pickup: ' . $so1['tgl_pickup'];
                    }
                }
                $pesan = "Halo " . $user1['nama_user'] . ", Ada SO yang belum di submit harganya, berikut SO yang terlampir $listSo";
                // var_dump($listSo);
                $this->wa->pickup('+' . $user1['no_hp'], "$pesan");
                $this->wa->pickup('+6285697780467', "$pesan");
            }
        }
    }

    public function alertSubmitSoIncoming()
    {


        $user = $this->db->query("SELECT id_user,no_hp,id_role,nama_user FROM tb_user WHERE id_role = 4");
        foreach ($user->result_array() as $user1) {
            $so = $this->db->query("SELECT id_so,shipper,tgl_pickup,status FROM tbl_so WHERE DATE(created_at) = '" . date('Y-m-d') . "' AND cancel_date IS NULL AND is_incoming = 1 AND submitso_at IS NULL AND id_sales = " . $user1['id_user'] . " AND status > 0 AND status != 5");

            if ($so->num_rows() != NULL) {
                $listSo = '';
                foreach ($so->result_array() as $so1) {
                    $cekResi = $this->db->query("SELECT shipment_id FROM tbl_shp_order WHERE id_so = " . $so1['id_so'] . " LIMIT 1 ");
                    if ($cekResi->num_rows() != 0) {
                        $listSo .= '\r\n' . $so1['shipper'] . ' Tanggal Pickup: ' . $so1['tgl_pickup'];
                    }
                }
                $pesan = "Halo " . $user1['nama_user'] . ", Ada SO Incoming yang belum di submit harganya, berikut SO yang terlampir $listSo";
                // var_dump($listSo);
                $this->wa->pickup('+' . $user1['no_hp'], "$pesan");
                $this->wa->pickup('+6285697780467', "$pesan");
            }
        }
    }

    // alertLeadTime 
    public function alertLeadTime()
    {
        $this->db->trans_start();
        try {
            $resi = $this->db->query("SELECT a.shipment_id,a.shipper,a.city_consigne,a.tgl_pickup,b.lead_min,b.lead_max  FROM tbl_shp_order a JOIN tb_city b on a.city_consigne = b.city_name WHERE a.deleted = 0 AND a.tgl_diterima IS NULL AND b.lead_min != 0 AND b.lead_max != 0 AND YEAR(a.tgl_pickup) >= 2025");
            $listResi = '';
            foreach ($resi->result_array() as $resi1) {
                $tgl_pickup = date('Y-m-d', strtotime($resi1['tgl_pickup']));
                $tgl_sekarang = date('Y-m-d');

                // JARAK DARI TANGGAL SEKARANG KE TANGGAL PICKUP 
                $jarak = (strtotime($tgl_sekarang) - strtotime($tgl_pickup)) / (60 * 60 * 24);
                if ($jarak >= $resi1['lead_max']) {
                    $listResi .= '\r\n\r\n' . $resi1['shipment_id'] . ' Customer ' . $resi1['shipper'] . ' Tujuan ' . $resi1['city_consigne'] . ' Pickup tanggal ' . date('d-m-Y', strtotime($resi1['tgl_pickup'])) . ' Max Pengiriman : ' . $resi1['lead_max'] . ' Hari, Waktu yang telah dilewati : ' . $jarak . ' Hari';
                }
            }
            $pesan = "Halo CS, Ada Resi yang sudah melewati lead time, berikut resi yang terlampir $listResi ";
            $wa = $this->wa->pickup('+6285697780467', "$pesan");
            if ($wa) {
                var_dump('Berhasil');
            } else{
                throw new Exception($wa);
            }
            $this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Transaction failed');
			} else {
                var_dump('Berhasil');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            var_dump($e->getMessage());
        }
    }
}
