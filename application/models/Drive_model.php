<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drive_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // getDriveShares
    public function getDriveShares($id_user) {
        $this->db->select('drive_access.*, drive.*,tb_user.nama_user AS pembuat');
        $this->db->from('drive_access');
        // join drive 
        $this->db->join('drive', 'drive.id_drive = drive_access.id_drive', 'left');
        // join user 
        $this->db->join('tb_user', 'tb_user.id_user = drive.created_by', 'left');
    //  where using or 
        $this->db->where('drive_access.to', $id_user);
        $this->db->or_where('drive_access.to', 0);
        // where not in  
        $this->db->where_not_in('drive.created_by', $id_user);
        return $this->db->get();
    }

    // getAccessDriveById
    public function getAccessDriveById($id_drive) {
        $this->db->select('drive_access.*,tb_user.nama_user AS penerima');
        $this->db->from('drive_access');
        $this->db->join('tb_user', 'tb_user.id_user = drive_access.to', 'left');
        $this->db->where('drive_access.id_drive', $id_drive);
        return $this->db->get();
    }
}
