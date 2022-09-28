<?php

function activity_log($username, $nama_user)
{
    $CI = &get_instance();

    $param['nama_user'] = $nama_user;
    $param['username'] = $username;
    $param['ip_address'] = $CI->input->ip_address();

    //load model log
    $CI->load->model('m_log');

    //save to database
    $CI->m_log->save_log($param);
}
function activity_log_out($username)
{
    date_default_timezone_set('Asia/Jakarta');
    $CI = &get_instance();

    $sql = $CI->db->query("SELECT max(id_log) as id_log FROM tb_log_login WHERE username ='$username'")->row();
    $id = $sql->id_log;

    //load model log
    $CI->load->model('m_log');
    $param['logout_at'] = date('Y-m-d H:i:s');
    //save to database
    $CI->m_log->update_log($id, $param);
}
