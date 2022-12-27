<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PodModel extends CI_Model
{

    public function getListPod($awal = NULL, $akhir = NULL)
    {
        if ($awal == NULL) {
            $this->db->select('tgl_pickup,shipment_id,shipper,consigne,status_pod,tgl_diterima,no_smu,destination');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        } else {
            $this->db->select('tgl_pickup,shipment_id,shipper,consigne,status_pod,tgl_diterima,no_smu,destination');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->where('tgl_pickup >=', $awal);
            $this->db->where('tgl_pickup <=', $akhir);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        }
    }
}
