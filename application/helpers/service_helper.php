<?php
 

function getServiceName($code) {
    $CI = &get_instance();
    $service  = $CI->db->query("SELECT service_name FROM tb_service_type WHERE code = ?", array($code))->row_array();

    return $service['service_name'];
}


?>