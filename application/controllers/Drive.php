<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Drive extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        // cek login 
        if (!$this->session->userdata('username')) {
            redirect(base_url());
        }
        $this->load->model('Drive_model', 'drive');
    }

    public function index()
    {
        $drive = $this->db->get_where('drive', ['created_by' => $this->session->userdata('id_user')])->result_array();
        // calculate total size 
        $totalSize = 0;
        foreach ($drive as $d) {
            $totalSize += $d['size'];
        }
        $data = [
            'title' => 'Drive',
            'subtitle' => 'Drive',
            'user' => $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array(),
            'users' => $this->db->get_where('tb_user', ['status' => 1])->result_array(),
            'drive' => $drive,
            'driveShares' => $this->drive->getDriveShares($this->session->userdata('id_user'))->result_array(),
            'totalSize' => $totalSize / 1000
        ];
        $this->load->view('drive/index2', $data);
    }

    public function addDrive()
    {
        //  upload file 
        $config['upload_path'] = './uploads/drive/';
        //    allowed types anything 
        $config['allowed_types'] = '*';
        // max size 10MB
        $config['max_size'] = 10240; // 10MB
        // atur namanya sesuai asal 
        $config['file_name'] = $_FILES['file']['name'];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $file = $this->upload->data();
            $data = [
                'uuid' => uniqid(),
                'description' => $this->input->post('description'),
                'nama_file' =>  $file['file_name'],
                'size' => $file['file_size'],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id_user')
            ];
            $insert = $this->db->insert('drive', $data);
            if ($insert) {
                echo json_encode(['status' => 'success', 'message' => 'File berhasil diupload']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'File gagal diupload']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
        }
    }

    // getAccessDrive
    public function getAccessDrive()
    {
        $id_drive = $this->input->post('id_drive');
        $drive = $this->drive->getAccessDriveById($id_drive)->result();
        echo json_encode($drive);
    }
    // deleteAccess
    public function deleteAccess()
    {
        $id_access  =  $this->input->post('id_access');
        $delete = $this->db->delete('drive_access', ['id_drive_access' => $id_access]);
        if ($delete) {
            echo json_encode(['status' => 'success', 'message' => 'Akses berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Akses gagal dihapus']);
        }
    }

    // addAccess
    public function addAccess()
    {
        $data = [
            'id_drive' => $this->input->post('id_drive'),
            'to' => $this->input->post('userAccess'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $insert = $this->db->insert('drive_access', $data);
        if ($insert) {
            echo json_encode(['status' => 'success', 'message' => 'Akses berhasil ditambahkan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Akses gagal ditambahkan']);
        }
    }
    // deleteDrive
    public function deleteDrive()
    {
        $this->db->trans_start();
        try {

            $id_drive = $this->input->post('id_drive');
            $drive = $this->db->get_where('drive', ['id_drive' => $id_drive])->row_array();
            $delete = $this->db->delete('drive', ['id_drive' => $id_drive]);
            $deleteAccess = $this->db->delete('drive_access', ['id_drive' => $id_drive]);
            $this->db->trans_complete();
            if ($delete && $deleteAccess) {
                $unlink =  unlink(FCPATH . 'uploads/drive/' . $drive['nama_file']);
                if ($unlink) {
                    $response  = json_encode(['status' => 'success', 'message' => 'File berhasil dihapus']);
                } else {
                    throw new Exception('Failed to delete file');
                }
            } else {
                throw new Exception('Failed to delete file');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }
        echo $response;
    }

    // download by uuid 
    public function download($uuid)
    {
        $drive = $this->db->get_where('drive', ['uuid' => $uuid])->row_array();
        $file = FCPATH . 'uploads/drive/' . $drive['nama_file'];
        if (file_exists($file)) {
            $this->load->helper('download');
            force_download($file, NULL);
        } else {
            echo 'File not found';
        }
    }
}
