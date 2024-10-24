<?php


function getNamaUser($id = null)
{
    $CI = &get_instance();
    

    
    if ($id != NULL) {
        $user = $CI->db->query('SELECT nama_user FROM tb_user WHERE id_user = '.$id.' ')->row_array();
        return $user['nama_user'];
    } else{
        return '';
    }

    
}
?>