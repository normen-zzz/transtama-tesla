<?php






    function moda($id_moda)
    {
        $CI = &get_instance();
        $queryModa = $CI->db->query('SELECT nama_moda FROM tbl_moda WHERE id_moda = ' . $id_moda . ' ')->row_array();
        return $queryModa['nama_moda'];
    }

