<?php


function getNamaUser($id)
{
    $CI = &get_instance();
    

    $user = $CI->db->query('SELECT nama_user FROM tb_user WHERE id_user = '.$id.' ')->row_array();
return $user['nama_user'];
    
}
?>