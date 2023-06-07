<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PodModel extends CI_Model
{

    public function getListPod($awal = NULL, $akhir = NULL)
    {
        if ($awal == NULL) {
            $this->db->select('so_id,tgl_pickup,shipment_id,shipper,consigne,status_pod,tgl_diterima,no_smu,destination');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        } else {
            $this->db->select('so_id,tgl_pickup,shipment_id,shipper,consigne,status_pod,tgl_diterima,no_smu,destination');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->where('tgl_pickup >=', $awal);
            $this->db->where('tgl_pickup <=', $akhir);
            $this->db->where('so_id !=', NULL);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        }
    }

    public function getModalPod($shipment_id)
    {
            $this->db->select('so_id,tgl_pickup,shipment_id,shipper,consigne,status_pod,tgl_diterima,no_smu,destination');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->where('shipment_id', $shipment_id);
            $this->db->where('so_id !=', NULL);
            return $this->db->get();
    }

    public function getPendingPod($awal = NULL, $akhir = NULL)
    {
        if ($awal == NULL) {
            $this->db->select('so_id,tgl_pickup,shipment_id,status_pod,deleted');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        } else {
            $this->db->select('so_id,tgl_pickup,shipment_id,status_pod,deleted');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->where('tgl_pickup >=', $awal);
            $this->db->where('tgl_pickup <=', $akhir);
            $this->db->where('so_id !=', NULL);
            $this->db->where('status_pod', 0);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        }
    }

    public function getProsesPod($awal = NULL, $akhir = NULL)
    {
        if ($awal == NULL) {
            $this->db->select('so_id,tgl_pickup,shipment_id,status_pod,deleted');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->where('status_pod', 1);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        } else {
            $this->db->select('so_id,tgl_pickup,shipment_id,status_pod,deleted');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->where('tgl_pickup >=', $awal);
            $this->db->where('tgl_pickup <=', $akhir);
            $this->db->where('so_id !=', NULL);
            $this->db->where('status_pod', 1);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        }
    }

    public function getDonePod($awal = NULL, $akhir = NULL)
    {
        if ($awal == NULL) {
            $this->db->select('so_id,tgl_pickup,shipment_id,status_pod,deleted');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->where('status_pod', 2);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        } else {
            $this->db->select('so_id,tgl_pickup,shipment_id,status_pod,deleted');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->where('tgl_pickup >=', $awal);
            $this->db->where('tgl_pickup <=', $akhir);
            $this->db->where('so_id !=', NULL);
            $this->db->where('status_pod', 2);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        }
    }

    public function getPetugas($shipment)
    {

        $this->db->select('b.nama_user,a.shipment_id');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_user b', 'b.id_user = a.id_user');
        $this->db->where('a.shipment_id', $shipment);
        return $this->db->get();
    }

    public function getListPodReport($awal = NULL, $akhir = NULL)
    {
        if ($awal == NULL) {
            $this->db->select('*');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        } else {
            $this->db->select('*');
            $this->db->from('tbl_shp_order');
            $this->db->where('deleted !=', 1);
            $this->db->where('tgl_pickup >=', $awal);
            $this->db->where('tgl_pickup <=', $akhir);
            $this->db->where('so_id !=', NULL);
            $this->db->order_by('tgl_pickup', 'DESC');
            return $this->db->get();
        }
    }
}
