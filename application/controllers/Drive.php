<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alertsales extends CI_Controller
{
    public function __construct()
    {
        
        parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        
    }
    
    public function index()
    {

        $this->load->view('drive/index');
    }

   
    public function upload()
    {
        
// upload file dari input file post ke google drive





    }

}
