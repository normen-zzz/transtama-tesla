<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JobsheetModel extends M_Datatables
{
	function getJs2()
	{
		$query  = "SELECT * FROM tbl_shp_order";
		$search = array('so_id', 'shipper', 'shipment_id', 'consigne');
		// $where  = null;
		$where  = array('status' => 0);
		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		$query = $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
		return $query;
	}
	function getJs()
	{
		$this->db->select('a.tgl_pickup, b.tgl_pickup,b.deadline_pic_js,b.shipment_id,b.so_id,b.shipper,b.tree_consignee,b.id, c.nama_user');
		$this->db->from('tbl_so a');
		$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
		$this->db->join('tb_user c', 'a.id_sales=c.id_user');
		$this->db->where('b.status_so', 1);
		$this->db->where('b.deleted', 0);
		$this->db->order_by('b.id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	public function getPuPoin($id_so)
	{
		$this->db->select('pu_poin');
		$this->db->from('tbl_so');
		$this->db->where('id_so', $id_so);
		$query = $this->db->get();
		return $query;
	}

	function getProformaInvoice()
	{
		$this->db->select('a.no_invoice,a.due_date,a.date,a.status,a.customer,a.customer_pickup,a.id_invoice, b.shipper');
		$this->db->from('tbl_invoice a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->where('a.status', 0);
		$this->db->order_by('a.date', 'ASC');
		$this->db->group_by('a.no_invoice');
		$query = $this->db->get();
		return $query;
	}
	function getProformaInvoiceFinal()
	{
		$this->db->select('a.no_invoice,a.due_date,a.date,a.status,a.customer,a.customer_pickup,a.id_invoice, b.shipper');
		$this->db->from('tbl_invoice a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->where('a.status', 1);
		$this->db->group_by('a.no_invoice');
		$this->db->order_by('a.due_date', 'ASC');
		$query = $this->db->get();
		return $query;
	}
	function getProformaInvoiceTotal()
	{
		$this->db->select('a.no_invoice,a.due_date,a.date,a.status,a.customer,a.customer_pickup,a.id_invoice, b.shipper');
		$this->db->from('tbl_invoice a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		// $this->db->where('a.status >=', 1);
		$this->db->group_by('a.no_invoice');
		$query = $this->db->get();
		return $query;
	}
	function getProformaInvoicePaid()
	{
		$this->db->select('a.no_invoice,a.due_date,a.date,a.status,a.customer,a.customer_pickup,a.id_invoice, b.shipper');
		$this->db->from('tbl_invoice a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->where('a.status =', 2);
		$this->db->group_by('a.no_invoice');
		$query = $this->db->get();
		return $query;
	}

	function getSoa()
	{
		$this->db->select('b.*, a.shipment_id as id_shipment,a.customer,a.ppn,a.invoice,a.pph,a.total_invoice, a.no_invoice,a.due_date, MONTH(b.tgl_pickup) as shipment,a.status,a.id_invoice');
		$this->db->from('tbl_invoice a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->where('a.status >=', 1);
		$this->db->group_by('a.no_invoice');
		$this->db->order_by('a.no_invoice', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	function getSoaFilter($month, $year)
	{
		$this->db->select('b.*, a.shipment_id as id_shipment,a.customer,a.ppn,a.invoice,a.pph,a.total_invoice, a.no_invoice,a.due_date, MONTH(b.tgl_pickup) as shipment,a.status,a.id_invoice');
		$this->db->from('tbl_invoice a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->where('a.status >=', 1);
		$this->db->where('MONTH(b.tgl_pickup)', $month);
		$this->db->where('YEAR(b.tgl_pickup)', $year);
		$this->db->group_by('a.no_invoice');
		$this->db->order_by('a.no_invoice', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function getInvoice($no_invoice)
	{
		$this->db->select('*');
		$this->db->from('tbl_invoice a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->join('tb_service_type c', 'b.service_type=c.code');
		$this->db->order_by('b.tgl_pickup', 'ASC');
		$this->db->where('a.no_invoice', $no_invoice);
		$query = $this->db->get();
		return $query;
	}
	function getInvoiceReimbursment($no_invoice)
	{
		$this->db->select('*');
		$this->db->from('tbl_invoice_reimbursment a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->join('tb_service_type c', 'b.service_type=c.code');
		$this->db->order_by('b.tgl_pickup', 'ASC');
		$this->db->where('a.no_invoice', $no_invoice);
		$query = $this->db->get();
		return $query;
	}
	function getAll($customer = NULL)
	{
		if ($customer == NULL) {
			$this->db->select('a.tgl_pickup, b.shipment_id,b.id,b.so_id,b.jobsheet_id,b.shipper,b.tree_consignee,b.status_so,b.id_so, c.nama_user,d.service_name');
			$this->db->from('tbl_so a');
			$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
			$this->db->join('tb_user c', 'a.id_sales=c.id_user');
			$this->db->join('tb_service_type d', 'b.service_type=d.code');
			$this->db->order_by('b.id', 'DESC');
			// $this->db->where('b.status_so >=', 1);
			$this->db->where('b.status_so', 3);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('a.tgl_pickup, b.shipment_id,b.id,b.so_id,b.jobsheet_id,b.shipper,b.tree_consignee,b.status_so,b.id_so, c.nama_user,d.service_name');
			$this->db->from('tbl_so a');
			$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
			$this->db->join('tb_user c', 'a.id_sales=c.id_user');
			$this->db->join('tb_service_type d', 'b.service_type=d.code');
			$this->db->order_by('b.id', 'DESC');
			$this->db->where('b.shipper', $customer);
			// $this->db->where('b.status_so >=', 1);
			$this->db->where('b.status_so', 3);
			$query = $this->db->get();
			return $query;
		}
	}
	function getAllAdmin($customer = NULL)
	{
		if ($customer == NULL) {
			$this->db->select('a.tgl_pickup, b.*, c.nama_user,d.service_name');
			$this->db->from('tbl_so a');
			$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
			$this->db->join('tb_user c', 'a.id_sales=c.id_user');
			$this->db->join('tb_service_type d', 'b.service_type=d.code');
			$this->db->order_by('b.tgl_pickup', 'ASC');
			$this->db->where('b.status_so >=', 1);
			$this->db->where('b.status_so <=', 3);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('a.tgl_pickup, b.*, c.nama_user,d.service_name');
			$this->db->from('tbl_so a');
			$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
			$this->db->join('tb_user c', 'a.id_sales=c.id_user');
			$this->db->join('tb_service_type d', 'b.service_type=d.code');
			$this->db->order_by('b.tgl_pickup', 'ASC');
			$this->db->where('b.shipper', $customer);
			$this->db->where('b.status_so >=', 1);
			$this->db->where('b.status_so <=', 3);
			$query = $this->db->get();
			return $query;
		}
	}

	function getJsApproveCs()
	{
		$this->db->select('a.tgl_pickup, b.tgl_pickup,b.deadline_pic_js,b.deadline_manager_cs,b.status_so,b.id_so,b.jobsheet_id,b.shipment_id,b.so_id,b.shipper,b.tree_consignee,b.id, c.nama_user');
		$this->db->from('tbl_so a');
		$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
		$this->db->join('tb_user c', 'a.id_sales=c.id_user');
		$this->db->where('b.status_so', 2);
		$this->db->order_by('b.id', 'DESC');
		// $this->db->order('b.id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function getJsApproveMgrFinance()
	{
		$this->db->select('a.tgl_pickup, b.tgl_pickup,b.deadline_pic_js,b.shipment_id,b.so_id,b.shipper,b.tree_consignee,b.id, c.nama_user');
		$this->db->from('tbl_so a');
		$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
		$this->db->join('tb_user c', 'a.id_sales=c.id_user');
		$this->db->where('b.status_so', 4);
		$this->db->order_by('b.id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function getJsApproveInvoice()
	{
		$this->db->select('a.tgl_pickup, b.*, c.nama_user');
		$this->db->from('tbl_so a');
		$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
		$this->db->join('tb_user c', 'a.id_sales=c.id_user');
		$this->db->where('b.status_so', 5);
		$this->db->order_by('b.id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function getJsApproveMgrCs()
	{
		$this->db->select('a.tgl_pickup, b.*, c.nama_user');
		$this->db->from('tbl_so a');
		$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
		$this->db->join('tb_user c', 'a.id_sales=c.id_user');
		$this->db->where('b.status_so', 3);
		$this->db->order_by('b.id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function getJsApproveFinance()
	{
		$this->db->select('a.tgl_pickup, b.shipment_id,b.id,b.so_id,b.jobsheet_id,b.shipper,b.tree_consignee,b.pic_invoice,b.status_so,b.id_so, c.nama_user');
		$this->db->from('tbl_so a');
		$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
		$this->db->join('tb_user c', 'a.id_sales=c.id_user');
		$this->db->where('b.status_so =', 4);
		$this->db->order_by('b.status_so', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	function getShipmentAp()
	{
		$this->db->select('a.tgl_pickup, b.*, c.nama_user');
		$this->db->from('tbl_so a');
		$this->db->join('tbl_shp_order b', 'a.id_so=b.id_so');
		$this->db->join('tb_user c', 'a.id_sales=c.id_user');
		$this->db->order_by('b.status_so', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function getAllMsr($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('a.*, b.service_name, c.nama_user');
			$this->db->from('tbl_shp_order a');
			$this->db->join('tb_service_type b', 'a.service_type=b.code');
			$this->db->join('tbl_so d', 'a.id_so=d.id_so');
			$this->db->join('tb_user c', 'd.id_sales=c.id_user');
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('a.*, b.service_name, c.nama_user');
			$this->db->from('tbl_shp_order a');
			$this->db->join('tb_service_type b', 'a.service_type=b.code');
			$this->db->join('tbl_so d', 'a.id_so=d.id_so');
			$this->db->join('tb_user c', 'd.id_sales=c.id_user');
			$this->db->where('MONTH(a.date_new)', $bulan);
			$this->db->where('YEAR(a.date_new)', $tahun);
			$query = $this->db->get();
			return $query;
		}
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
	function getRevisiJs()
	{
		$this->db->select('a.*, b.created_at as tgl_pengajuan, b.status as status_pengajuan, b.id_request, c.nama_user');
		$this->db->from('tbl_shp_order a');
		$this->db->join('tbl_request_revisi b', 'a.id=b.shipment_id');
		$this->db->join('tbl_so d', 'a.id_so=d.id_so');
		$this->db->join('tb_user c', 'd.id_sales=c.id_user');
		$this->db->order_by('b.id_request', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function getRevisiSoNew()
	{
		$this->db->select('a.shipment_id,a.tgl_pickup,a.so_id,a.jobsheet_id,a.shipper,a.tree_consignee,a.id, b.created_at as tgl_so_new, b.alasan, b.status_revisi, c.nama_user');
		$this->db->from('tbl_shp_order a');
		$this->db->join('tbl_revisi_so b', 'a.id=b.shipment_id');
		$this->db->join('tbl_so d', 'a.id_so=d.id_so');
		$this->db->join('tb_user c', 'd.id_sales=c.id_user');
		$this->db->order_by('b.id_revisi', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function getNamaSales($id_so)
	{
		$this->db->select('b.nama_user, a.created_at, b.ttd');
		$this->db->from('tbl_so a');
		$this->db->join('tb_user b', 'a.id_sales=b.id_user');
		$this->db->where('a.id_so', $id_so);
		$query = $this->db->get();
		return $query;
	}
	function getNamaManagerSales($id_so)
	{
		$this->db->select('b.nama_user, b.ttd');
		$this->db->from('tbl_so a');
		$this->db->join('tb_user b', 'a.id_atasan_sales=b.id_user');
		$this->db->where('a.id_so', $id_so);
		$query = $this->db->get();
		return $query;
	}
	function getApproveSo($id)
	{
		$this->db->select('b.nama_user as pic_js,b.ttd as ttd_pic, c.nama_user as mgr_cs,c.ttd as ttd_mgr_cs, d.nama_user as finance,d.ttd as ttd_finance, a.created_at_cs, a.approve_mgr_cs_date, a.created_at_finance');
		$this->db->from('tbl_approve_so_cs a');
		$this->db->join('tb_user b', 'a.approve_cs=b.id_user');
		$this->db->join('tb_user c', 'a.approve_mgr_cs=c.id_user', 'LEFT');
		$this->db->join('tb_user d', 'a.approve_finance=d.id_user', 'LEFT');
		$this->db->where('a.shipment_id', $id);
		$query = $this->db->get();
		return $query;
	}
	function cekShipment($search)
	{
		$q = $this->db
			->like('shipment_id', $search)
			->or_like('note_cs', $search)
			->get('tbl_shp_order');
		return $q;
	}
	function getInvoiceAp($id_vendor = NULL)
	{
		if ($id_vendor == NULL) {
			$this->db->select('*');
			$this->db->from('tbl_ap a');
			$this->db->join('tbl_vendor b', 'a.vendor=b.id_vendor');
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('*');
			$this->db->from('tbl_ap a');
			$this->db->join('tbl_vendor b', 'a.vendor=b.id_vendor');
			$this->db->where('b.id_vendor', $id_vendor);
			$query = $this->db->get();
			return $query;
		}
	}
	function getShipmentByCost()
	{

		$this->db->select('a.shipment_id as resi, a.id,a.shipper, a.destination, a.tree_consignee,a.tgl_pickup,a.so_id, a.jobsheet_id, b.*');
		$this->db->from('tbl_shp_order a');
		$this->db->join('tbl_modal b', 'a.id=b.shipment_id');
		$query = $this->db->get();
		return $query;
	}
	function getApByVendor($id_vendor)
	{

		$this->db->select('a.shipment_id as resi, a.koli, a.berat_js,c.id_vendor, a.berat_msr, a.id,a.shipper, a.destination, a.tree_consignee,a.tgl_pickup,a.so_id, a.jobsheet_id, b.*, c.id_invoice, c.status');
		$this->db->from('tbl_shp_order a');
		$this->db->join('tbl_modal b', 'a.id=b.shipment_id');
		$this->db->join('tbl_invoice_ap c', 'a.id=c.shipment_id');
		$this->db->where('c.id_vendor', $id_vendor);
		$this->db->where('b.id_vendor', $id_vendor);
		$this->db->where('c.status', 0);
		$query = $this->db->get();
		return $query;
	}

	function getRequestAktivasi()
	{
		$this->db->select('b.*, a.shipper, a.tgl_pickup, a.pu_moda, a.created_at, a.deadline_sales_so');
		$this->db->from('tbl_so a');
		$this->db->join('tbl_aktivasi_so b', 'a.id_so=b.id_so');
		$this->db->order_by('b.id_aktivasi', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function getRequestAktivasiJs()
	{
		$this->db->select('b.*,a.shipment_id, a.shipper,a.id_so,a.id, a.tgl_pickup, a.pu_moda, a.created_at, a.deadline_pic_js, a.deadline_manager_cs');
		$this->db->from('tbl_shp_order a');
		$this->db->join('tbl_aktivasi_cs b', 'a.shipment_id=b.shipment_id');
		$this->db->order_by('b.id_aktivasi', 'DESC');
		$query = $this->db->get();
		return $query;
	}


	// report finance

	function getTotalInvoice($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('a.*, b.shipper');
			$this->db->from('tbl_invoice a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->where('a.status >=', 0);
			$this->db->where('b.deleted', 0);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('a.*, b.shipper');
			$this->db->from('tbl_invoice a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->where('a.status >=', 0);
			$this->db->where('b.deleted', 0);
			$this->db->where('MONTH(b.tgl_pickup)', $bulan);
			$this->db->where('YEAR(b.tgl_pickup)', $tahun);
			$query = $this->db->get();
			return $query;
		}
	}
	function getInvoicePaid($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('a.no_invoice,a.due_date,a.date,a.status,a.customer,a.customer_pickup,a.id_invoice,a.payment_date, b.shipper');
			$this->db->from('tbl_invoice a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->where('a.status', 2);
			$this->db->where('b.deleted', 0);
			$this->db->group_by('a.no_invoice');
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('a.no_invoice,a.due_date,a.date,a.status,a.customer,a.customer_pickup,a.id_invoice,a.payment_date, b.shipper');
			$this->db->from('tbl_invoice a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->where('a.status', 2);
			$this->db->where('b.deleted', 0);
			$this->db->where('MONTH(b.tgl_pickup)', $bulan);
			$this->db->where('YEAR(b.tgl_pickup)', $tahun);
			$this->db->group_by('a.no_invoice');
			$query = $this->db->get();
			return $query;
		}
	}
	function getInvoicePending($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('a.*, b.shipper');
			$this->db->from('tbl_invoice a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->where('a.status', 1);
			$this->db->where('b.deleted', 0);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('a.*, b.shipper');
			$this->db->from('tbl_invoice a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->where('a.status', 1);
			$this->db->where('b.deleted', 0);
			$this->db->where('MONTH(b.tgl_pickup)', $bulan);
			$this->db->where('YEAR(b.tgl_pickup)', $tahun);
			$query = $this->db->get();
			return $query;
		}
	}
	function getInvoiceProforma($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('a.*, b.shipper');
			$this->db->from('tbl_invoice a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->where('a.status', 0);
			$this->db->where('b.deleted', 0);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('a.*, b.shipper');
			$this->db->from('tbl_invoice a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->where('a.status', 0);
			$this->db->where('b.deleted', 0);
			$this->db->where('MONTH(b.tgl_pickup)', $bulan);
			$this->db->where('YEAR(b.tgl_pickup)', $tahun);
			$query = $this->db->get();
			return $query;
		}
	}

	function getInvoiceReport($bulan, $tahun)
	{
		// 0=proforma
		// 1=invoice(pending)
		// 2 = paid
		// 3 = unpaid
		$where = array('YEAR(a.tgl_pickup)' => $tahun, 'MONTH(a.tgl_pickup)' => $bulan, 'a.deleted' => 0);
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('b.*,c.*,a.*,e.nama_user, b.status as status_invoice, d.service_name');
			$this->db->from('tbl_shp_order a');
			$this->db->join('tbl_invoice b', 'b.shipment_id=a.id', 'LEFT');
			$this->db->join('tbl_modal c', 'c.shipment_id=a.id');
			$this->db->join('tb_service_type d', 'a.service_type=d.code');
			$this->db->join('tb_user e', 'a.id_user=e.id_user');
			$this->db->where('a.status_so >=', 1);
			$this->db->where('a.deleted', 0);
			$this->db->order_by('a.tgl_pickup');
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('b.*,c.*,a.*,e.nama_user, b.status as status_invoice, d.service_name');
			$this->db->from('tbl_shp_order a');
			$this->db->join('tbl_invoice b', 'b.shipment_id=a.id', 'LEFT');
			$this->db->join('tbl_modal c', 'c.shipment_id=a.id', 'LEFT');
			$this->db->join('tb_service_type d', 'a.service_type=d.code');
			$this->db->join('tb_user e', 'a.id_user=e.id_user');
			$this->db->where('a.status_so >=', 1);
			$this->db->where($where);
			// $this->db->where('a.deleted', 0);
			// $this->db->where('MONTH(a.tgl_pickup)', $bulan);
			// $this->db->where('YEAR(a.tgl_pickup)', $tahun);
			$this->db->group_by('a.shipment_id');
			$this->db->order_by('a.tgl_pickup');
			$query = $this->db->get();
			return $query;
		}
	}

	function getInvoiceVoidReport($bulan, $tahun)
	{
		// 0=proforma
		// 1=invoice(pending)
		// 2 = paid
		// 3 = unpaid
		$where = array('YEAR(a.tgl_pickup)' => $tahun, 'MONTH(a.tgl_pickup)' => $bulan, 'a.deleted' => 1);
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('a.*,e.nama_user, d.service_name');
			$this->db->from('tbl_shp_order a');
			$this->db->join('tb_service_type d', 'a.service_type=d.code');
			$this->db->join('tb_user e', 'a.id_user=e.id_user');
			$this->db->where('a.status_so >=', 1);
			$this->db->where('a.deleted', 1);
			$this->db->order_by('a.tgl_pickup');
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('a.*,e.nama_user, d.service_name');
			$this->db->from('tbl_shp_order a');
			$this->db->join('tb_service_type d', 'a.service_type=d.code');
			$this->db->join('tb_user e', 'a.id_user=e.id_user');
			$this->db->where('a.status_so >=', 1);
			$this->db->where($where);
			// $this->db->where('a.deleted', 0);
			// $this->db->where('MONTH(a.tgl_pickup)', $bulan);
			// $this->db->where('YEAR(a.tgl_pickup)', $tahun);
			$this->db->order_by('a.tgl_pickup');
			$query = $this->db->get();
			return $query;
		}
	}



	// report cs
	function getTotalShipments($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			// $this->db->where('b.status_so >=', 1);
			$this->db->where('b.deleted', 0);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			// $this->db->where('b.status_so >=', 1);
			$this->db->where('b.deleted', 0);
			$this->db->where('MONTH(b.tgl_pickup)', $bulan);
			$this->db->where('YEAR(b.tgl_pickup)', $tahun);
			$query = $this->db->get();
			return $query;
		}
	}
	function getTotalSo($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			$this->db->where('b.status_so >=', 1);
			$this->db->where('b.deleted', 0);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			$this->db->where('b.status_so >=', 1);
			$this->db->where('b.deleted', 0);
			$this->db->where('MONTH(b.tgl_pickup)', $bulan);
			$this->db->where('YEAR(b.tgl_pickup)', $tahun);
			$query = $this->db->get();
			return $query;
		}
	}
	function getJobsheetPending($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			$this->db->where('b.status_so', 1);
			$this->db->where('b.deleted', 0);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			$this->db->where('b.status_so', 1);
			$this->db->where('b.deleted', 0);
			$this->db->where('MONTH(b.tgl_pickup)', $bulan);
			$this->db->where('YEAR(b.tgl_pickup)', $tahun);
			$query = $this->db->get();
			return $query;
		}
	}
	function getJobsheetApprovePic($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			$this->db->where('b.status_so', 2);
			$this->db->where('b.deleted', 0);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			$this->db->where('b.status_so', 2);
			$this->db->where('b.deleted', 0);
			$this->db->where('MONTH(b.tgl_pickup)', $bulan);
			$this->db->where('YEAR(b.tgl_pickup)', $tahun);
			$query = $this->db->get();
			return $query;
		}
	}
	function getJobsheetApproveMgr($bulan, $tahun)
	{
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			$this->db->where('b.status_so', 3);
			$this->db->where('b.deleted', 0);
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('b.shipment_id');
			$this->db->from('tbl_shp_order b');
			$this->db->where('b.status_so', 3);
			$this->db->where('b.deleted', 0);
			$this->db->where('MONTH(b.tgl_pickup)', $bulan);
			$this->db->where('YEAR(b.tgl_pickup)', $tahun);
			$query = $this->db->get();
			return $query;
		}
	}

	function getReportMsr($bulan, $tahun)
	{
		// 0=proforma
		// 1=invoice(pending)
		// 2 = paid
		// 3 = unpaid
		$where = array('YEAR(a.tgl_pickup)' => $tahun, 'MONTH(a.tgl_pickup)' => $bulan, 'a.deleted' => 0);
		if ($bulan == NULL && $tahun == NULL) {
			$this->db->select('b.*,c.*,a.*,e.nama_user, b.status as status_invoice, d.service_name');
			$this->db->from('tbl_shp_order a');
			$this->db->join('tbl_invoice b', 'b.shipment_id=a.id', 'LEFT');
			$this->db->join('tbl_modal c', 'c.shipment_id=a.id');
			$this->db->join('tb_service_type d', 'a.service_type=d.code');
			$this->db->join('tb_user e', 'a.id_user=e.id_user');
			$this->db->where('a.status_so >=', 1);
			$this->db->where('a.deleted', 0);
			$this->db->order_by('a.tgl_pickup');
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('b.*,c.*,a.*,e.nama_user, b.status as status_invoice, d.service_name');
			$this->db->from('tbl_shp_order a');
			$this->db->join('tbl_invoice b', 'b.shipment_id=a.id', 'LEFT');
			$this->db->join('tbl_modal c', 'c.shipment_id=a.id', 'LEFT');
			$this->db->join('tb_service_type d', 'a.service_type=d.code');
			$this->db->join('tb_user e', 'a.id_user=e.id_user');
			$this->db->where('a.status_so >=', 1);
			$this->db->where($where);
			$this->db->order_by('a.tgl_pickup');
			$query = $this->db->get();
			return $query;
		}
	}

	public function getSales($id_so)
	{
		$this->db->select('b.nama_user');
		$this->db->from('tbl_so a');
		$this->db->join('tb_user b', 'b.id_user=a.id_sales');
		$this->db->where('a.id_so', $id_so);
		$query = $this->db->get();
		return $query;
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

	// ap
	function getApVendor($no_po = NULL)
	{
		if ($no_po == NULL) {
			$this->db->select('a.*, b.shipper,b.shipment_id as resi');
			$this->db->from('tbl_invoice_ap_final a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->group_by('a.no_invoice');
			$this->db->order_by('a.created_at', 'DESC');
			$query = $this->db->get();
			return $query;
		} else {
			$this->db->select('a.*, b.shipper,b.shipment_id as resi');
			$this->db->from('tbl_invoice_ap_final a');
			$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
			$this->db->where('a.no_po', $no_po);
			$this->db->group_by('a.no_invoice');
			$query = $this->db->get();
			return $query;
		}
	}
	function getApVendorByDate($awal, $akhir)
	{

		$this->db->select('a.*, b.shipper,b.shipment_id as resi');
		$this->db->from('tbl_invoice_ap_final a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->where('a.date >=', $awal);
		$this->db->where('a.date <=',  $akhir);
		$this->db->group_by('a.no_invoice');
		$query = $this->db->get();
		return $query;
	}
	function getTotalApVendorIn()
	{
		$this->db->select('a.*, b.shipper');
		$this->db->from('tbl_invoice_ap_final a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->where('a.status', 2);
		$this->db->group_by('a.no_invoice');
		$this->db->order_by('a.due_date', 'ASC');
		$query = $this->db->get();
		return $query;
	}
	function getTotalApVendorFinanceApprove()
	{
		$this->db->select('a.*, b.shipper');
		$this->db->from('tbl_invoice_ap_final a');
		$this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		$this->db->where('a.status', 3);
		$this->db->group_by('a.no_invoice');
		$this->db->order_by('a.due_date', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	function getApByNoInvoice($no_invoice, $id_vendor = NULL)
	{

		$this->db->select('a.shipment_id as resi, a.koli,a.consigne, a.berat_js,c.id_vendor, a.berat_msr, a.id,a.shipper, a.destination, a.tree_consignee,a.tgl_pickup,a.so_id, a.jobsheet_id, b.*,c.*');
		$this->db->from('tbl_shp_order a');
		$this->db->join('tbl_modal b', 'a.id=b.shipment_id');
		$this->db->join('tbl_invoice_ap_final c', 'a.id=c.shipment_id');
		$this->db->where('c.unique_invoice', $no_invoice);
		// $this->db->where('b.id_vendor', $id_vendor);
		$query = $this->db->get();
		return $query;
	}

	function getApByNoInvoice2($no_invoice, $id_vendor = NULL)
	{

		$this->db->select('a.shipment_id as resi, a.koli,a.consigne, a.berat_js,c.id_vendor, a.berat_msr, a.id,a.shipper, a.destination, a.tree_consignee,a.tgl_pickup,a.so_id, a.jobsheet_id, b.*,c.*');
		$this->db->from('tbl_shp_order a');
		$this->db->join('tbl_modal b', 'a.id=b.shipment_id');
		$this->db->join('tbl_invoice_ap_final c', 'a.id=c.shipment_id');
		$this->db->where('c.unique_invoice', $no_invoice);
		$this->db->where('b.id_vendor', $id_vendor);
		$query = $this->db->get();
		return $query;
	}

	public function getVendorByShipment($shipmnent_id)
	{
		$this->db->select('a.nama_vendor, a.type, b.id_invoice,b.shipment_id,b.id_vendor');
		$this->db->from('tbl_vendor a');
		$this->db->join('tbl_invoice_ap b', 'b.id_vendor=a.id_vendor');
		$this->db->where('b.shipment_id', $shipmnent_id);
		$query = $this->db->get();
		return $query;
	}
	function getApInternal()
	{
		$this->db->select('a.*');
		$this->db->from('tbl_invoice_ap_internal a');
		// $this->db->join('tbl_shp_order b', 'a.shipment_id=b.id');
		// $this->db->where('a.status >=', 1);
		$this->db->group_by('a.no_invoice');
		// $this->db->order_by('a.due_date', 'ASC');
		$query = $this->db->get();
		return $query;
	}
}
