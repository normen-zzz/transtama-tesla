<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Finish extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        require_once APPPATH . 'third_party/vendor/autoload.php';
    }
    public function index()
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $code = $_GET['code'];
        $data['title'] = 'Integrasi LMS';

        $client = new Google_Client();
        $url = APPPATH . 'third_party/oauth-credential4.json';
        $id = $url;
        $client->setAccessType("offline");
        $client->setAuthConfig($id);
        // $client->addScope(Google_Service_Drive::DRIVE);
        $client->addScope("https://www.googleapis.com/auth/drive");

        $token = $client->fetchAccessTokenWithAuthCode($code);
        $data2 = [
            'token' => $token,
        ];
        // var_dump($data2);
        // die;
        $this->session->set_userdata($data2);
        $this->load->view('finish', $data);
        // $this->backend->display('integrasi', $data);

    }

    public function cekCode()
    {
        $id_role = $this->session->userdata('id_role');
        if ($id_role == 4) {
            redirect('dosen/integrasi');
        } else {
            redirect('mahasiswa/integrasi');
        }
    }
}
