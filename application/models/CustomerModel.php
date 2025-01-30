<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerModel extends CI_Model
{

    public function getCustomer()
    {
   
            $this->db->select('a.nama_pt,a.username,a.provinsi,a.kota,a.alamat,a.no_telp,a.join_at,a.id_customer,a.email,a.pic,');
            $this->db->from('tb_customer a');
            return $this->db->get();
        
    }
        
    

}
