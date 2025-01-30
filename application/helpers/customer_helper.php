<?php

function getNameCustomer($id_customer) {
    $CI = &get_instance();
    $query = $CI->db->query('SELECT nama_pt FROM tb_customer WHERE id_customer = '.$id_customer.' ')->row_array();

    return $query['nama_pt'];
}

?>