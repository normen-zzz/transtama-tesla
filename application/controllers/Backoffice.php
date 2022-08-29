<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backoffice extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Login Page';
			$this->load->view('login');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$username = $this->security->xss_clean(trim($this->input->post('username')));
		$password = trim($this->input->post('password'));
		$user = $this->db->get_where('tb_user', ['username' => $username])->row_array();
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
						'id_user' => $user['id_user'],
						'akses' => $user['access_menu'],
						'id_atasan' => $user['id_atasan'],
						'id_jabatan' => $user['id_jabatan'],
					];
					// var_dump($data);
					// die;
					$this->session->set_userdata($data);
					activity_log($user['username'], $user['nama_user']);
					if ($user['id_role'] == 1) {
						redirect('superadmin/dashboard');
					} elseif ($user['id_role'] == 2) {
						redirect('shipper/salesOrder');
					} elseif ($user['id_role'] == 3) {
						redirect('cs/salesOrder');
					} elseif ($user['id_role'] == 4) {
						redirect('sales/salesOrder');
					} elseif ($user['id_role'] == 5) {
						redirect('dispatcher/scan');
					} elseif ($user['id_role'] == 6) {
						redirect('finance/ap');
					} else {
						redirect('dispatcher/salesOrder');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert
                        alert-danger" role="alert">Password salah</div>');
					redirect('backoffice');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Akun ini belum aktif</div>');
				redirect('backoffice');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert
                alert-danger" role="alert">Username tidak terdaptar</div>');
			redirect('backoffice');
		}
	}
	public function logout()
	{

		$this->session->unset_userdata('token');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama_user');
		$this->session->set_flashdata('message', '<div class="alert
        alert-danger" role="alert">Terima Kasih</div>');
		redirect('backoffice');
	}

	public function blocked()
	{
		$data['title'] = '403 Forbidden';
		$this->load->view('errors/index', $data);
	}
}
