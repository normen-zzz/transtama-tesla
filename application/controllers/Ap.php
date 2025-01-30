<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApModel', 'ap');
        $this->load->model('WilayahModel', 'wilayah');
    }

    public function getDataCa()
    {
        $ca = $this->input->post('nomor_ca');
        $this->db->select('amount_approved')->from('tbl_pengeluaran')->where('no_pengeluaran', $ca);
        $dataCa = $this->db->get();
        $period_array = array();
        foreach ($dataCa->result_array() as $row) {
            $period_array[] = intval($row['amount_approved']); //can it be float also?
        }
        echo array_sum($period_array);
    }

    public function getKabupaten($id_prov = NULL)
    {

        if ($id_prov != NULL) {
            $kabupaten = $this->wilayah->getDataKabupaten($id_prov);
            $data = "<option value=''>- Select Kabupaten -</option>";
            foreach ($kabupaten as $id_kabupaten=>$nama_kabupaten) {
                $data .= "<option data-id_prov='" . $id_prov . "'  data-id_kab='" . $id_kabupaten . "' value='" . $nama_kabupaten . "'>" . $nama_kabupaten . "</option>";
            }
        } else {
            $data = "<option value=''>- Select Kabupaten -</option>";
        }
        echo $data;
    }

    public function getKecamatan($id_prov = NULL, $id_kab = NULL)
    {

        if ($id_prov != NULL && $id_kab != NULL) {
            $kecamatan = $this->wilayah->getDataKecamatan($id_prov, $id_kab);
            $data = "<option value=''>- Select Kecamatan -</option>";
            foreach ($kecamatan as $id_kecamatan => $nama_kecamatan) {
                $data .= "<option data-id_kec='" . $id_kecamatan . "' value='" . $nama_kecamatan . "'>" . $nama_kecamatan . "</option>";
            }
        } else {
            $data = "<option value=''>- Select Kecamatan -</option>";
        }
        echo $data;
    }
}
