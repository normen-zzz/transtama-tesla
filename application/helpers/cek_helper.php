<?php

function cek_role()
{
    $CI = &get_instance();
    $menu = $CI->uri->segment(1);

    $queryMenu = $CI->db->get_where('tb_role', ['nama_role' => $menu])->row_array();

    $id_role = $queryMenu['id_role'];
    $role = $CI->session->userdata('id_role');
    // var_dump($role);
    // die;

    $user = $CI->session->userdata('id_user');
    $cek_data = $CI->db->get_where('tb_user', ['id_user' => $user])->row_array();
    // var_dump($cek_data);
    // die;
    if ($role != $id_role) {
        redirect('backoffice');
    }
}
