<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApModel extends CI_Model
{

    public function getMyAp($id_user = NULL)
    {
        if ($id_user == NULL) {
            $this->db->select('a.no_pengeluaran,a.id_kat_ap,a.purpose,a.date,a.total,a.status,a.is_approve_sm,a.total_approved, b.nama_kategori, c.nama_user');
            $this->db->from('tbl_pengeluaran a');
            $this->db->join('tbl_kat_ap b', 'a.id_kat_ap=b.id_kategori_ap');
            $this->db->join('tb_user c', 'a.id_user=c.id_user');
            $this->db->where('a.status !=', 4);
            $this->db->order_by('a.id_pengeluaran', 'DESC');
            return $this->db->get();
        } else {
            $this->db->select('a.no_pengeluaran,a.id_kat_ap,a.purpose,a.date,a.total,a.status,a.is_approve_sm,a.total_approved, b.nama_kategori, c.nama_user');
            $this->db->from('tbl_pengeluaran a');
            $this->db->join('tbl_kat_ap b', 'a.id_kat_ap=b.id_kategori_ap');
            $this->db->join('tb_user c', 'a.id_user=c.id_user');
            $this->db->where('a.id_user', $id_user);
            $this->db->group_by('a.no_pengeluaran');
            $this->db->where('a.status !=', 4);
            $this->db->order_by('a.id_pengeluaran', 'DESC');
            return $this->db->get();
        }
    }
    public function getHistoryMyAp($id_user = NULL)
    {
        if ($id_user == NULL) {
           $this->db->select('a.no_pengeluaran,a.id_kat_ap,a.purpose,a.date,a.total,a.status,a.is_approve_sm,a.total_approved, b.nama_kategori, c.nama_user');
            $this->db->from('tbl_pengeluaran a');
            $this->db->join('tbl_kat_ap b', 'a.id_kat_ap=b.id_kategori_ap');
            $this->db->join('tb_user c', 'a.id_user=c.id_user');
            $this->db->where('a.status', 4);
            $this->db->order_by('a.id_pengeluaran', 'DESC');
            return $this->db->get();
        } else {
           $this->db->select('a.no_pengeluaran,a.id_kat_ap,a.purpose,a.date,a.total,a.status,a.is_approve_sm,a.total_approved, b.nama_kategori, c.nama_user');
            $this->db->from('tbl_pengeluaran a');
            $this->db->join('tbl_kat_ap b', 'a.id_kat_ap=b.id_kategori_ap');
            $this->db->join('tb_user c', 'a.id_user=c.id_user');
            $this->db->where('a.id_user', $id_user);
            $this->db->where('a.status', 4);
            $this->db->group_by('a.no_pengeluaran');
            $this->db->order_by('a.id_pengeluaran', 'DESC');
            return $this->db->get();
        }
    }
    public function getApByNo($no_ap)
    {

        $this->db->select('a.*, b.nama_kategori, b.keterangan,c.nama_kategori_pengeluaran');
        $this->db->from('tbl_pengeluaran a');
        $this->db->join('tbl_kat_ap b', 'a.id_kat_ap=b.id_kategori_ap');
        $this->db->join('tbl_list_pengeluaran c', 'a.id_kategori_pengeluaran=c.id_kategori');
        $this->db->where('a.no_pengeluaran', $no_ap);
        return $this->db->get();
    }
    public function getMyApAtasan($id_atasan)
    {
        // var_dump($id_atasan);
        // die;
        $this->db->select('a.*, b.nama_kategori, c.nama_user');
        $this->db->from('tbl_pengeluaran a');
        $this->db->join('tbl_kat_ap b', 'a.id_kat_ap=b.id_kategori_ap');
        $this->db->join('tb_user c', 'a.id_user=c.id_user');
        $this->db->where('a.id_atasan', $id_atasan);
        $this->db->where('a.status !=', 4);
        $this->db->or_where('a.id_user', $id_atasan);
        $this->db->group_by('a.no_pengeluaran');
        $this->db->order_by('a.id_pengeluaran', 'DESC');
        return $this->db->get();
    }
    public function getHistoryMyApAtasan($id_atasan)
    {
        // var_dump($id_atasan);
        // die;
        $this->db->select('a.*, b.nama_kategori, c.nama_user');
        $this->db->from('tbl_pengeluaran a');
        $this->db->join('tbl_kat_ap b', 'a.id_kat_ap=b.id_kategori_ap');
        $this->db->join('tb_user c', 'a.id_user=c.id_user');
        $this->db->where('a.id_atasan', $id_atasan);
        $this->db->where('a.status', 4);
        $this->db->or_where('a.id_user', $id_atasan);
        $this->db->group_by('a.no_pengeluaran');
        $this->db->order_by('a.id_pengeluaran', 'DESC');
        return $this->db->get();
    }
}
