<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cronjob extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApModel', 'ap');
        $this->load->model('WilayahModel', 'wilayah');
    }

    public function updateMilestoneAfterBagging()
    {
        $bagging = $this->db->query('SELECT flight_at,id_bagging FROM bagging WHERE is_milestoneupdate IS NULL AND flight_at IS NOT NULL');

        if ($bagging->num_rows() != 0) {
            foreach ($bagging->result_array() as $bagging1) {

                $tanggalSekarang = time();
                $tanggalFlight = strtotime($bagging1['flight_at']);

                if ($tanggalSekarang > $tanggalFlight) {
                    $resi = $this->db->query('SELECT shipment_id,id_so FROM tbl_shp_order WHERE bagging = ' . $bagging1['id_bagging'] . ' AND deleted = 0 ');
                    if ($resi->num_rows() != 0) {
                        foreach ($resi->result_array() as $resi1) {
                            $dataTracking = [
                                'status' => ucwords(strtolower("paket telah keluar dari hub CGK")),
                                'id_so' => $resi1['id_so'],
                                'shipment_id' => $resi1['shipment_id'],
                                'created_at' => date('Y-m-d',strtotime($bagging1['flight_at'])),
                                'time' =>date('H:i:s',strtotime($bagging1['flight_at'])),
                                'flag' => 8,
                                'status_eksekusi' => 1,
                                'id_user' => $this->session->userdata('id_user'),
                            ];
                            $this->db->insert('tbl_tracking_real', $dataTracking);
                           
                        }
                        $this->db->update('bagging', ['is_milestoneupdate' => 1], ['id_bagging' => $bagging1['id_bagging']]);
                    }
                }
            }
        }
    }
}
