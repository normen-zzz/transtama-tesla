<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KpiModel extends CI_Model
{

    public function getTrack($user, $awal, $akhir)
    {
        $this->db->select('*');
        $this->db->from('tbl_sales_tracker a');
        $this->db->where('a.id_sales', $user);
        $this->db->where('a.start_date >=', date('Y-m-d', $awal));
        $this->db->where('a.start_date <=', date('Y-m-d', $akhir));
        return $this->db->get();
    }

    public function getSo($user, $awal, $akhir)
    {
        $this->db->select('*');
        $this->db->from('tbl_so a');
        $this->db->where('a.id_sales', $user);
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        return $this->db->get();
    }

    public function getInvoice($awal, $akhir)
    {
        $this->db->select('a.no_invoice,a.created_at,a.update_at');
        $this->db->from('tbl_invoice a');
        // $this->db->where('a.id_user', $user);
        $this->db->where('a.created_at >=', date('Y-m-d', $awal));
        $this->db->where('a.created_at <=', date('Y-m-d', $akhir));
        $this->db->group_by('a.no_invoice');
        return $this->db->get();
    }

    public function getResiOnJs($awal, $akhir)
    {
        $this->db->select('a.*');
        $this->db->from('tbl_shp_order a');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $this->db->where('a.status_so >=', 2);
        $this->db->where('a.deleted', 0);
        $query = $this->db->get();
        return $query;
    }

    public function getResiOnReservasi($awal, $akhir)
    {
        $this->db->select('a.*');
        $this->db->from('tbl_shp_order a');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $this->db->where('a.status_so >=', 2);
        $this->db->where('a.deleted', 0);
        $this->db->where('service_type', 'f4e0915b-7487-4fae-a04c-c3363d959742');
        $query = $this->db->get();
        return $query;
    }
    public function getResiOnDaerah($awal, $akhir)
    {
        $this->db->select('a.*');
        $this->db->from('tbl_shp_order a');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $this->db->where('a.status_so >=', 2);
        $this->db->where('a.deleted', 0);
        $this->db->where('is_jabodetabek', 2);
        $query = $this->db->get();
        return $query;
    }

    public function getVisitCs($awal, $akhir)
    {
        $this->db->select('a.*,b.nama_user');
        $this->db->from('tbl_sales_tracker a');
        $this->db->join('tb_user b', 'b.id_user = a.id_sales');
        $this->db->where('a.start_date >=', date('Y-m-d', $awal));
        $this->db->where('a.start_date <=', date('Y-m-d', $akhir));
        $this->db->where('b.id_role', 3);
        $query = $this->db->get();
        return $query;
    }

    public function getDeliveryDaerah($awal, $akhir)
    {
        $this->db->select('a.*');
        $this->db->from('tbl_shp_order a');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $this->db->where('a.is_jabodetabek', 2);
        $query = $this->db->get();
        return $query;
    }

    public function getReservasi($awal, $akhir)
    {
        $this->db->select('a.*');
        $this->db->from('tbl_shp_order a');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $this->db->where('a.service_type', 'f4e0915b-7487-4fae-a04c-c3363d959742');
        $query = $this->db->get();
        return $query;
    }

    public function getPickup($bulan, $tahun)
    {
        $this->db->select('a.*');
        $this->db->from('tbl_so a');
        $this->db->where('MONTH(a.tgl_pickup)', $bulan);
        $this->db->where('YEAR(a.tgl_pickup)', $tahun);
        $this->db->where('a.is_incoming', 0);
        $this->db->where('a.cancel_date', NULL);
        $query = $this->db->get();
        return $query;
    }

    public function getOutbond($awal, $akhir)
    {
        $this->db->select('a.*,b.tgl_pickup');
        $this->db->from('tbl_outbond a');
        $this->db->join('tbl_shp_order b', 'b.shipment_id = a.shipment_id');
        $this->db->where('b.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('b.tgl_pickup <=', date('Y-m-d', $akhir));
        $query = $this->db->get();
        return $query;
    }

    public function getGateway($awal, $akhir)
    {
        $this->db->select('a.tgl_pickup,a.service_type');
        $this->db->from('tbl_shp_order a');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $this->db->where('a.service_type', 'f4e0915b-7487-4fae-a04c-c3363d959742');
        $query = $this->db->get();
        return $query;
    }

    public function getPodJabodetabek($awal, $akhir)
    {
        $this->db->select('a.tgl_pickup,a.is_jabodetabek,a.shipment_id,b.tgl_sampe');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tbl_tracking_pod b', 'b.shipment_id = a.shipment_id');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $this->db->where('a.is_jabodetabek', '1');
        $query = $this->db->get();
        return $query;
    }

    public function getHandover($awal, $akhir)
    {
        $this->db->select('a.tgl_pickup,a.shipment_id,a.is_jabodetabek,a.updatesistem_at,b.shipment_id,b.created_at as tgl_tracking,b.time as waktu_tracking');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tbl_tracking_real b', 'b.shipment_id = a.shipment_id');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $this->db->where('a.is_jabodetabek', '2');
        $this->db->where('b.flag', '4');
        $query = $this->db->get();
        return $query;
    }

    public function getDelivery($awal, $akhir)
    {
        $this->db->select('a.tgl_pickup,a.shipment_id,a.is_jabodetabek,a.updatesistem_at,b.shipment_id,b.created_at as tgl_tracking,b.time as waktu_tracking');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tbl_tracking_real b', 'b.shipment_id = a.shipment_id');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $this->db->where('a.is_jabodetabek', '2');
        $this->db->where('b.flag', '4');
        $query = $this->db->get();
        return $query;
    }

    public function getInput($awal, $akhir)
    {
        $this->db->select('a.shipment_id');
        $this->db->from('tbl_shp_order a');
        $this->db->where('a.tgl_pickup >=', date('Y-m-d', $awal));
        $this->db->where('a.tgl_pickup <=', date('Y-m-d', $akhir));
        $query = $this->db->get();
        return $query;
    }

    public function getInputAwal($resi)
    {
        $this->db->select('a.tgl_pickup,a.shipment_id,a.is_jabodetabek,b.shipment_id,b.created_at as tgl_tracking,b.time as waktu_tracking');
        $this->db->from('tbl_tracking_real b');
        $this->db->join('tbl_shp_order a', 'b.shipment_id = a.shipment_id');
        $this->db->where('a.shipment_id', $resi);
        $this->db->where('b.flag', '2');
        $query = $this->db->get();
        return $query;
    }

    public function getInputAkhir($resi)
    {
        $this->db->select('a.tgl_pickup,a.shipment_id,a.is_jabodetabek,b.shipment_id,b.created_at as tgl_tracking,b.time as waktu_tracking');
        $this->db->from('tbl_tracking_real b');
        $this->db->join('tbl_shp_order a', 'b.shipment_id = a.shipment_id');
        $this->db->where('a.shipment_id', $resi);
        $this->db->where('b.flag', '3');
        $query = $this->db->get();
        return $query;
    }

    public function getVisitOps($awal, $akhir)
    {
        $this->db->select('a.*,b.nama_user');
        $this->db->from('tbl_sales_tracker a');
        $this->db->join('tb_user b', 'b.id_user = a.id_sales');
        $this->db->where('a.start_date >=', date('Y-m-d', $awal));
        $this->db->where('a.start_date <=', date('Y-m-d', $akhir));
        $this->db->where('b.id_role', 2);
        $query = $this->db->get();
        return $query;
    }
}
