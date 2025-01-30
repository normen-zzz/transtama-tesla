<?php
 function addZeroNumber($number, $length = 6) {
    return str_pad($number, $length, '0', STR_PAD_LEFT);
}

function getStatusBagging($shipment_id) {
    $CI = &get_instance();

    $shipment = $CI->db->query('SELECT bagging FROM tbl_shp_order WHERE shipment_id = '.$shipment_id.' ')->row_array();

    if ($shipment['bagging'] == NULL) {
        return '';
    } else{
        return' ||On Bagging('.$shipment['bagging'].')';
    }
}

function getStatusBaggingOutbond($idBagging) {
    $CI = &get_instance();
    $bagging  = $CI->db->query('SELECT status_bagging FROM bagging WHERE id_bagging = '.$idBagging.' ')->row_array();

    if ($bagging['status_bagging'] == 1) {
        return 'Bagging berada di Hub jakarta pusat';
    }elseif ($bagging['status_bagging'] == 2) {
        return 'Bagging telah keluar dari Hub jakarta pusat';
    }elseif ($bagging['status_bagging'] == 3) {
        return 'Bagging telah tiba di Hub CGK';
    }elseif ($bagging['status_bagging'] == 4) {
        return 'Bagging telah keluar dari Hub CGK';
    }
}


?>