<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalesModel extends CI_Model
{

    var $table = 'tbl_so';
    var $column_order = array(null, 'tgl_pickup', 'shipper', 'id_so', 'destination', 'service'); //set column field database for datatable orderable
    var $column_search = array('tgl_pickup', 'shipper', 'id_so', 'destination', 'service'); //set column field database for datatable searchable 
    var $order = array('id_so' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getDataSalesTracker($date, $id_sales)
    {
        $this->db->select('a.*, b.*');
        $this->db->from('tbl_sales_tracker a');
        $this->db->join('tb_user b', 'a.id_sales=b.id_user');
        // $this->db->where('a.start_date', $date);
        $this->db->like('a.start_date', $date);
        $this->db->where('a.id_sales', $id_sales);
        $this->db->where('a.is_deleted', 0);
        return $this->db->get();
    }

    public function getDetailSalesTracker($id)
    {
        $this->db->select('a.*, b.*');
        $this->db->from('tbl_sales_tracker a');
        $this->db->join('tb_user b', 'a.id_sales=b.id_user');
        $this->db->where('a.id_sales_tracker', $id);
        $this->db->where('a.is_deleted', 0);
        // $this->db->like('a.start_date', $date);
        return $this->db->get();
    }

    public function getAllReportSalesTracker($sales)
    {
        $this->db->select('a.*, b.*,a.created_at as dibuat');
        $this->db->from('tbl_sales_tracker a');
        $this->db->join('tb_user b', 'a.id_sales=b.id_user');
        if ($sales != 0) {
            $this->db->where('b.id_user', $sales);
        }
        $this->db->where('a.is_deleted', 0);
        $this->db->order_by('a.start_date', 'desc');
        return $this->db->get();
    }

    public function getReportSalesTracker($awal, $akhir, $sales)
    {
        $this->db->select('a.*, b.*,a.created_at as dibuat');
        $this->db->from('tbl_sales_tracker a');
        $this->db->join('tb_user b', 'a.id_sales=b.id_user');
        if ($sales != 0) {
            $this->db->where('b.id_user', $sales);
        }
        $this->db->where('a.is_deleted', 0);
        $this->db->where('a.start_date >=', $awal);
        $this->db->where('a.start_date <=', $akhir);
        return $this->db->get();
    }



    public function getRequestPriceNotApprove($id, $awal, $akhir)
    {
        $this->db->select('*');
        $this->db->from('tbl_request_price a');
        $this->db->where('a.id_sales', $id);
        $this->db->where('a.date_request <=', $akhir);
        // $this->db->where('a.date_request >=', $awal);
        $this->db->where('a.price', NULL);
        $this->db->order_by('a.id_request_price', 'desc');
        $this->db->group_by('a.group');
        return $this->db->get();
    }
    public function getRequestPriceApprove($id, $awal, $akhir)
    {
        $this->db->select('*');
        $this->db->from('tbl_request_price a');
        $this->db->where('a.id_sales', $id);
        $this->db->where('a.date_request >=', $awal);
        $this->db->where('a.date_request <=', $akhir);
        $this->db->where('a.price !=', NULL);
        $this->db->order_by('a.id_request_price', 'desc');
        return $this->db->get();
    }
}
