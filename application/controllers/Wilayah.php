<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('WilayahModel', 'wilayah');
    }

    public function provinsi()
    {

        $provinsi = $this->wilayah->getDataProvinsi();
        $dataProvinsi = $provinsi->data;
        $data['provinsi'] = $dataProvinsi;

        $this->load->view('provinsi', $data);
    }

    public function kabupaten()
    {
        if ($this->input->post('provinsi') == NULL) {

            $provinsi = $this->wilayah->getDataProvinsi();
            $dataProvinsi = $provinsi->data;
            $data['provinsi'] = $dataProvinsi;
            $data['provinsiselected'] = NULL;
        } else {
            $provinsi = $this->wilayah->getDataProvinsi();
            $dataProvinsi = $provinsi->data;
            $data['provinsi'] = $dataProvinsi;
            $data['provinsiselected'] = $this->input->post('provinsi');

            $kabupaten = $this->wilayah->getDataKabupaten($this->input->post('provinsi'));
            $dataKabupaten = $kabupaten->data;
            $data['kabupaten'] = $dataKabupaten;
        }



        $this->load->view('kabupaten', $data);
    }
    public function kecamatan($id_provinsi, $id_kabupaten)
    {



        $kabupaten = $this->wilayah->getDataKabupaten($id_provinsi);
        $dataKabupaten = $kabupaten->provinsi;
        $data['provinsi'] = $dataKabupaten;

        $kecamatan = $this->wilayah->getDataKecamatan($id_provinsi, $id_kabupaten);
        $dataKecamatan = $kecamatan->data;
        $data['kecamatan'] = $dataKecamatan;
        $data['namaKabupaten'] = $kecamatan->kabupaten;

        $this->load->view('kecamatan', $data);
    }
}
