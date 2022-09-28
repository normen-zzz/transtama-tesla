<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        require_once APPPATH . 'third_party/vendor/autoload.php';
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('frontend/login');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->security->xss_clean(trim($this->input->post('username')));
        $password = trim($this->input->post('password'));
        $user = $this->db->get_where('tb_user', ['username' => $username])->row_array();
        // var_dump($user);
        // die;
        if ($user) {
            //cek aktif atau tidak
            if ($user['status'] == 1) {
                //cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'username' => $user['username'],
                        'id_role' => $user['id_role'],
                        'nama_user' => $user['nama_user'],
                        'email' => $user['email'],
                        'id_user' => $user['id_user']
                    ];
                    $this->session->set_userdata($data);
                    activity_log($user['username'], $user['nama_user']);
                    if ($user['id_role'] == 5) {
                        redirect('mahasiswa/dashboard');
                    } else {
                        echo 'You have no Role';
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert
                        alert-danger" role="alert">Password salah</div>');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Akun ini belum aktif</div>');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Username tidak terdaptar</div>');
            redirect('login');
        }
    }
    public function logout()
    {
        $client = new Google_Client();
        $client->revokeToken();
        $this->session->unset_userdata('token');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('nama_user');
        $this->session->set_flashdata('message', '<div class="alert
        alert-success" role="alert">Terima Kasih</div>');
        redirect('login');
    }

    public function blocked()
    {
        $data['title'] = '403 Forbidden';
        $this->load->view('errors/index', $data);
    }
}
