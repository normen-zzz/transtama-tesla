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

    public function getInvoice($user, $awal, $akhir)
    {
        $this->db->select('a.no_invoice,a.created_at');
        $this->db->from('tbl_invoice a');
        $this->db->where('a.id_user', $user);
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

    public function getVisitCs($bulan, $tahun)
    {
        $this->db->select('a.*,b.nama_user');
        $this->db->from('tbl_sales_tracker a');
        $this->db->join('tb_user b', 'b.id_user = a.id_sales');
        $this->db->where('MONTH(a.start_date)', $bulan);
        $this->db->where('YEAR(a.start_date)', $tahun);
        $this->db->where('b.id_role', 3);
        $query = $this->db->get();
        return $query;
    }

    public function getDeliveryDaerah($bulan, $tahun)
    {
        $this->db->select('a.*');
        $this->db->from('tbl_shp_order a');
        $this->db->where('MONTH(a.tgl_pickup)', $bulan);
        $this->db->where('YEAR(a.tgl_pickup)', $tahun);
        $this->db->where('a.is_jabodetabek', 2);
        $query = $this->db->get();
        return $query;
    }

    public function getReservasi($bulan, $tahun)
    {
        $this->db->select('a.*');
        $this->db->from('tbl_shp_order a');
        $this->db->where('MONTH(a.tgl_pickup)', $bulan);
        $this->db->where('YEAR(a.tgl_pickup)', $tahun);
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
}
