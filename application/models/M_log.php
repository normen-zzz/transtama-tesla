<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_log extends CI_Model
{
    public function save_log($param)
    {
        $sql        = $this->db->insert_string('tb_log_login', $param);
        $ex         = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }
    public function update_log($id, $param)
    {
        $sql        = $this->db->update('tb_log_login', $param, ['id_log' => $id]);
        return $sql;
    }
}
