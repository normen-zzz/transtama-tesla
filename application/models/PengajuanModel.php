<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengajuanModel extends CI_Model
{

     public function order($id = NULL)
    {
        $this->db->select('a.pu_moda,a.id,a.shipment_id,a.order_id,a.shipper,a.id_so,a.destination,a.is_weight_print,a.consigne,a.koli,a.sender,a.berat_js,a.tree_shipper,a.tree_consignee,a.flight_at,a.state_shipper,a.city_shipper,a.service_type,a.pu_commodity,a.no_stp,a.signature,a.state_consigne,a.city_consigne,a.no_smu,a.image,a.note_shipment, b.nama_user,a.note_driver');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_user b', 'a.id_user=b.id_user');
        if ($id == NULL) {
            $this->db->order_by('a.id', 'Desc');
        } else {
            $this->db->where('a.id', $id);
            
        }
        return $this->db->get();
    }
    public function getLastTracking($shipmnent_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_tracking_real a');
        $this->db->where('a.shipment_id', $shipmnent_id);
        $this->db->order_by('a.id_tracking', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
    }
	public function getLastTracking2($shipmnent_id)
    {
        $this->db->select('flag,status');
        $this->db->from('tbl_tracking_real a');
        $this->db->where('a.shipment_id', $shipmnent_id);
        $this->db->order_by('a.id_tracking', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
    }
    public function getLastTrackingOutbond($shipmnent_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_tracking_real a');
        $this->db->join('tbl_shp_order b', 'a.shipment_id=b.shipment_id');
        $this->db->where('a.shipment_id', $shipmnent_id);
        $this->db->order_by('a.id_tracking', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
    }
    public function dispatch()
    {
        $this->db->select('a.shipper,a.consigne,a.tree_shipper,a.tree_consignee,b.status as sts,b.is_incoming,b.id_gateway, b.created_at, b.shipment_id, b.status_eksekusi');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tbl_gateway b', 'a.shipment_id=b.shipment_id');
        $this->db->where('b.status_eksekusi', 0);
        $this->db->order_by('b.shipment_id', 'DESC');
        return $this->db->get();
    }

   public function outbond()
    {
        $this->db->select('b.id,a.shipment_id,b.shipper,b.consigne,b.tree_shipper,b.tree_consignee,b.id_so,b.is_jabodetabek,b.is_incoming');
        $this->db->from('tbl_outbond a');
        $this->db->join('tbl_shp_order b','a.shipment_id=b.shipment_id');
        $this->db->where("DATE_FORMAT(b.tgl_pickup,'%Y')", 2024);
        $this->db->where('b.deleted',0);
        $this->db->where('b.tgl_diterima',NULL);
        $this->db->where('a.out_date',NULL);
        $this->db->order_by('b.shipment_id', 'DESC');
        return $this->db->get();
    }
    public function dispatchHistory()
    {
        $this->db->select('a.shipper,a.consigne,a.tree_shipper,a.tree_consignee,b.status as sts,b.is_incoming,b.id_gateway, b.created_at, b.shipment_id, b.status_eksekusi');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tbl_gateway b', 'a.shipment_id=b.shipment_id');
        $this->db->where('b.status_eksekusi', 1);
        $this->db->order_by('a.tgl_pickup', 'ASC');
        return $this->db->get();
    }
    public function orderBySo($id)
    {
        $this->db->select('a.pu_moda,a.shipment_id,a.mark_shipper,a.koli,a.shipper,a.tree_shipper,a.consigne,a.created_at,a.note_cs,a.tree_consignee,a.id,a.id_so,a.destination,a.city_consigne,a.state_consigne,a.is_jabodetabek,c.pickup_by, b.service_name');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_service_type b', 'a.service_type=b.code','left');
        $this->db->join('tbl_so c', 'a.id_so=c.id_so' ,'left'); 
        $this->db->where('a.id_so', $id);
        $this->db->where('a.shipment_id !=', NULL);
        $this->db->where('a.deleted', 0);
        return $this->db->get();
    }
	public function orderBySoSales($id)
    {
        $this->db->select('a.shipment_id,a.pu_moda,a.shipper,a.tree_shipper,a.consigne,a.created_at,a.note_cs,a.tree_consignee,a.id,a.id_so,a.destination,a.city_consigne,a.state_consigne,a.is_jabodetabek,a.freight_kg,a.special_freight,a.packing,a.insurance,a.surcharge,a.disc,a.cn,a.specialcn,a.others,a.pic_invoice,a.so_note,a.status_so, b.service_name');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_service_type b', 'a.service_type=b.code');
        $this->db->where('a.id_so', $id);
        $this->db->where('a.shipment_id !=', NULL);
        $this->db->where('a.deleted', 0);
        return $this->db->get();
    }
    public function orderBySoAdmin($id)
    {
        $this->db->select('a.*, b.service_name');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_service_type b', 'a.service_type=b.code');
        $this->db->where('a.id_so', $id);
        $this->db->where('a.shipment_id !=', NULL);
        // $this->db->where('a.deleted', 0);
        return $this->db->get();
    }
    public function getGenerate()
    {
        // $query = "SELECT t.*,(SELECT COUNT(id_booking) FROM tbl_booking_number_resi WHERE status=0) sisa FROM tbl_booking_number_resi t  GROUP BY id_customer, created";
        // return  $this->db->query($query);
        $this->db->select('*');
        $this->db->from('tbl_booking_number_resi');
        $this->db->group_by('group');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get();
    }
    public function orderFilter($start, $end, $id_user)
    {

        if ($id_user != 0) {
            $this->db->select('a.*, b.nama_user');
            $this->db->from('tbl_shp_order a');
            $this->db->join('tb_user b', 'a.id_user=b.id_user');
            $this->db->where('a.date_new >=', $start);
            $this->db->where('a.date_new <=',  $end);
            $this->db->where('a.id_user =',  $id_user);
            $this->db->order_by('a.id', 'Desc');
            return $this->db->get();
        } else {
            $this->db->select('a.*, b.nama_user');
            $this->db->from('tbl_shp_order a');
            $this->db->join('tb_user b', 'a.id_user=b.id_user');
            $this->db->where('a.date_new >=', $start);
            $this->db->where('a.date_new <=',  $end);
            $this->db->order_by('a.id', 'Desc');
            return $this->db->get();
        }
    }


    function search_blog($title)
    {
        $this->db->like('consigne', $title, 'both');
        $this->db->order_by('consigne', 'ASC');
        $this->db->limit(10);
        return $this->db->get('tbl_shp_order')->result();
    }

    function get_data_consigne($kode)
    {
        $hsl = $this->db->query("SELECT * FROM tbl_shp_order WHERE consigne='$kode' ORDER BY id ASC");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'consigne' => $data->consigne,
                    'destination' => $data->destination,
                );
            }
        }
        return $hasil;
    }

    function fetch_data($query)
    {
        $this->db->like('consigne', $query);
        $this->db->group_by('consigne');
        $query = $this->db->get('tbl_shp_order');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $output[] = array(
                    'consigne'  => $row["consigne"],
                    'destination'  => $row["destination"]
                );
            }
            echo json_encode($output);
        }
    }
    public function getLaporanTransaksiFilter($bulan, $tahun)
{
    $this->db->select('a.shipment_id, a.tgl_pickup, a.no_stp, 
                       a.shipper, a.consigne, a.tree_consignee, 
                       a.pu_commodity, a.koli, a.berat_js, a.berat_msr, 
                       a.no_flight, a.no_smu, a.tgl_diterima, a.status_pod, 
                       a.mark_shipper, a.update_at, 
                       b.nama_user, c.service_name, c.prefix,a.note_cs,a.no_so');
    $this->db->from('tbl_shp_order a');
    $this->db->join('tb_user b', 'a.id_user = b.id_user', 'left');
    $this->db->join('tb_service_type c', 'a.service_type = c.code', 'left');
    $this->db->where([
        'YEAR(a.tgl_pickup)' => $tahun,
        'MONTH(a.tgl_pickup)' => $bulan,
        'a.deleted' => 0
    ]);
    $this->db->order_by('a.tgl_pickup', 'ASC');
    return $this->db->get();
}

    public function getLaporanTransaksiVoidFilter($bulan, $tahun)
    {
        // $where = array('a.shipment_id' != NULL, 'YEAR(a.tgl_pickup)' => $tahun, 'MONTH(a.tgl_pickup)' => $bulan);
        $where = array('YEAR(a.tgl_pickup)' => $tahun, 'MONTH(a.tgl_pickup)' => $bulan, 'a.deleted' => 1);
        $this->db->select('a.*, b.nama_user, c.service_name, c.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_user b', 'a.id_user=b.id_user');
        $this->db->join('tb_service_type c', 'a.service_type=c.code');
        $this->db->where($where);
        // $this->db->or_where('a.s')
        $this->db->order_by('a.tgl_pickup', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    public function getLaporan()
    {
        $this->db->select('a.*, b.nama_user, c.service_name, c.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_user b', 'a.id_user=b.id_user');
        $this->db->join('tb_service_type c', 'a.service_type=c.code');
        $this->db->where('a.deleted', 0);
        $this->db->order_by('a.tgl_pickup', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    public function getLaporanVoid()
    {
        $this->db->select('a.*, b.nama_user, c.service_name, c.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_user b', 'a.id_user=b.id_user');
        $this->db->join('tb_service_type c', 'a.service_type=c.code');
        $this->db->where('a.deleted', 1);
        $this->db->order_by('a.tgl_pickup', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    function get_mahasiswa_list($limit, $start)
    {
        $query = $this->db->get('tbl_shp_order', $limit, $start);
        return $query;
    }
    function getRevisiJs()
    {
        $this->db->select('a.*, b.created_at as tgl_pengajuan, b.status as status_pengajuan, b.id_request,e.status_revisi');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tbl_request_revisi b', 'a.id=b.shipment_id');
        $this->db->join('tbl_so d', 'a.id_so=d.id_so');
        $this->db->join('tbl_revisi_so e', 'a.id=e.shipment_id');
        $this->db->where('d.id_sales', $this->session->userdata('id_user'));
        $this->db->order_by('b.id_request', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    function getRevisiSoNew()
    {
        $this->db->select('a.*, b.created_at as tgl_so_new, b.alasan, b.status_revisi, c.nama_user');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tbl_revisi_so b', 'a.id=b.shipment_id');
        $this->db->join('tbl_so d', 'a.id_so=d.id_so');
        $this->db->join('tb_user c', 'd.id_sales=c.id_user');
        $this->db->order_by('b.id_revisi', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    function getDetailSo($id)
    {
        $this->db->select('a.*, b.service_name, c.nama_user');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_service_type b', 'a.service_type=b.code');
        $this->db->join('tbl_so d', 'a.id_so=d.id_so');
        $this->db->join('tb_user c', 'd.id_sales=c.id_user');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        return $query;
    }

     public function getLaporanTransaksiFilterByDate($start, $end)
    {
        // $where  = array('c.id_sales' => $this->session->userdata('id_user'));
        $this->db->select('a.tgl_pickup,a.is_jabodetabek,a.shipment_id,a.shipper,a.consigne,a.tree_consignee,a.no_stp,a.city_consigne,d.service_name,a.pu_commodity,a.koli,a.berat_js,a.berat_msr,a.note_cs,a.no_so,, b.nama_user, c.pu_poin,d.service_name, d.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_user b', 'a.id_user=b.id_user');
        $this->db->join('tbl_so c', 'c.id_so=a.id_so');
        $this->db->join('tb_service_type d', 'a.service_type=d.code');
        $this->db->where('a.tgl_pickup >=', $start);
        $this->db->where('a.tgl_pickup <=',  $end);
        $this->db->where('c.id_sales', $this->session->userdata('id_user'));
        $this->db->where('a.deleted', 0);
        $this->db->order_by('a.tgl_pickup', 'ASC');
        return $this->db->get();
    }
  public function getLaporanSales()
    {
        $this->db->select('a.shipment_id,a.tgl_pickup,a.shipper,a.consigne,a.tree_consignee,a.city_consignee,a.pu_commodity,a.koli,a.berat_js,a.berat_msr,b.nama_user,c.pu_poin,d.service_name,d.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tb_user b', 'a.id_user=b.id_user');
        $this->db->join('tbl_so c', 'c.id_so=a.id_so');
        $this->db->join('tb_service_type d', 'a.service_type=d.code');
        $this->db->where('c.id_sales', $this->session->userdata('id_user'));
        $this->db->where('a.deleted', 0);
        $this->db->order_by('a.tgl_pickup', 'ASC');
        return $this->db->get();
    }
    function getShipmentBySales($bulan = null, $tahun = null)
    {
        $where = array('YEAR(a.tgl_pickup)' => $tahun, 'MONTH(a.tgl_pickup)' => $bulan, 'a.deleted' => 0);
        $id_sales = $this->session->userdata('id_user');
        if ($bulan != NULL && $tahun != NULL) {
            $this->db->select('a.*, b.service_name, c.nama_user');
            $this->db->from('tbl_shp_order a');
            $this->db->join('tb_service_type b', 'a.service_type=b.code');
            $this->db->join('tbl_so d', 'a.id_so=d.id_so');
            $this->db->join('tb_user c', 'd.id_sales=c.id_user');
            $this->db->where('d.id_sales', $id_sales);
            $this->db->where($where);
            $this->db->where('a.status_so >=', 1);
            $query = $this->db->get();
            return $query;
        } else {
            $this->db->select('a.*, b.service_name, c.nama_user');
            $this->db->from('tbl_shp_order a');
            $this->db->join('tb_service_type b', 'a.service_type=b.code');
            $this->db->join('tbl_so d', 'a.id_so=d.id_so');
            $this->db->join('tb_user c', 'd.id_sales=c.id_user');
            $this->db->where('d.id_sales', $id_sales);
            $this->db->where('a.status_so >=', 1);
            $this->db->where('a.deleted', 0);
            $query = $this->db->get();
            return $query;
        }
    }
    public function getLaporanTransaksiFilterAdmin($bulan, $tahun, $id_user)
    {
        if ($id_user == 0) {
            $where = array('YEAR(a.tgl_pickup)' => $tahun, 'MONTH(a.tgl_pickup)' => $bulan, 'a.deleted' => 0);
            $this->db->select('a.*, b.nama_user, c.service_name, c.prefix');
            $this->db->from('tbl_shp_order a');
            $this->db->join('tb_user b', 'a.id_user=b.id_user');
            $this->db->join('tb_service_type c', 'a.service_type=c.code');
            $this->db->where($where);
            $this->db->order_by('a.tgl_pickup', 'ASC');
            $query = $this->db->get();
            return $query;
        } else {
            $where = array('YEAR(a.tgl_pickup)' => $tahun, 'MONTH(a.tgl_pickup)' => $bulan, 'a.deleted' => 0, 'd.id_sales' => $id_user);
            $this->db->select('a.*, b.nama_user, c.service_name, c.prefix,d.id_sales');
            $this->db->from('tbl_shp_order a');
            $this->db->join('tbl_so d', 'a.id_so=d.id_so');
            $this->db->join('tb_user b', 'd.id_sales=b.id_user');
            $this->db->join('tb_service_type c', 'a.service_type=c.code');
            $this->db->where($where);
            $this->db->order_by('a.tgl_pickup', 'ASC');
            $query = $this->db->get();
            return $query;
        }
    }
    public function getLaporanAdmin()
    {
        $this->db->select('a.*, b.nama_user, c.service_name, c.prefix');
        $this->db->from('tbl_shp_order a');
        $this->db->join('tbl_so d', 'a.id_so=d.id_so');
        $this->db->join('tb_user b', 'd.id_sales=b.id_user');
        $this->db->join('tb_service_type c', 'a.service_type=c.code');
        $this->db->where('a.deleted', 0);
        $this->db->order_by('a.tgl_pickup', 'ASC');
        $query = $this->db->get();
        return $query;
    }
}
