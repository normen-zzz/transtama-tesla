<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CsModel extends CI_Model
{

    public function getRequestPriceNotApprove($awal, $akhir)
    {
        $this->db->select('*');
        $this->db->from('tbl_request_price a');

        $this->db->where('a.date_request >=', $awal);
        $this->db->where('a.date_request <=', $akhir);
        $this->db->where('a.price', NULL);
        $this->db->order_by('a.id_request_price', 'desc');
        $this->db->group_by('a.group');
        return $this->db->get();
    }
    public function getRequestPriceApprove($awal, $akhir)
    {
        $this->db->select('*');
        $this->db->from('tbl_request_price a');

        $this->db->where('a.date_request >=', $awal);
        $this->db->where('a.date_request <=', $akhir);
        $this->db->where('a.price !=', NULL);
        $this->db->order_by('a.id_request_price', 'desc');
        $this->db->group_by('a.group');
        return $this->db->get();
    }
}
