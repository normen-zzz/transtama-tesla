<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MilestoneModel extends CI_Model
{


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
