<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_Datatables extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function get_tables($tables, $cari, $iswhere)
  {
    // Ambil data yang di ketik user pada textbox pencarian
    $search = htmlspecialchars($_POST['search']['value']);
    // Ambil data limit per page
    $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
    // Ambil data start
    $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

    $query = $tables;

    if (!empty($iswhere)) {
      $sql = $this->db->query("SELECT * FROM " . $query . " WHERE " . $iswhere);
    } else {
      $sql = $this->db->query("SELECT * FROM " . $query);
    }

    $sql_count = $sql->num_rows();

    $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";


    // Untuk mengambil nama field yg menjadi acuan untuk sorting
    $order_field = $_POST['order'][0]['column'];

    // Untuk menentukan order by "ASC" atau "DESC"
    $order_ascdesc = $_POST['order'][0]['dir'];
    $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

    if (!empty($iswhere)) {
      $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
    } else {
      $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
    }

    if (isset($search)) {
      if (!empty($iswhere)) {
        $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere (" . $cari . ")");
      } else {
        $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE (" . $cari . ")");
      }
      $sql_filter_count = $sql_cari->num_rows();
    } else {
      if (!empty($iswhere)) {
        $sql_filter = $this->db->query("SELECT * FROM " . $query . "WHERE " . $iswhere);
      } else {
        $sql_filter = $this->db->query("SELECT * FROM " . $query);
      }
      $sql_filter_count = $sql_filter->num_rows();
    }
    $data = $sql_data->result_array();

    $callback = array(
      'draw' => $_POST['draw'], // Ini dari datatablenya    
      'recordsTotal' => $sql_count,
      'recordsFiltered' => $sql_filter_count,
      'data' => $data
    );
    return json_encode($callback); // Convert array $callback ke json
  }

  function get_tables_where($tables, $cari, $where, $iswhere)
  {
    // Ambil data yang di ketik user pada textbox pencarian
    $search = htmlspecialchars($_POST['search']['value']);
    // Ambil data limit per page
    $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
    // Ambil data start
    $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

    $setWhere = array();
    foreach ($where as $key => $value) {
      $setWhere[] = $key . "='" . $value . "'";
    }

    $fwhere = implode(' AND ', $setWhere);

    if (!empty($iswhere)) {
      $sql = $this->db->query("SELECT * FROM " . $tables . " WHERE $iswhere AND " . $fwhere);
    } else {
      $sql = $this->db->query("SELECT * FROM " . $tables . " WHERE " . $fwhere);
    }
    $sql_count = $sql->num_rows();

    $query = $tables;
    $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

    // Untuk mengambil nama field yg menjadi acuan untuk sorting
    $order_field = $_POST['order'][0]['column'];

    // Untuk menentukan order by "ASC" atau "DESC"
    $order_ascdesc = $_POST['order'][0]['dir'];
    $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

    if (!empty($iswhere)) {
      $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
    } else {
      $sql_data = $this->db->query("SELECT * FROM " . $query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
    }

    if (isset($search)) {
      if (!empty($iswhere)) {
        $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
      } else {
        $sql_cari =  $this->db->query("SELECT * FROM " . $query . " WHERE " . $fwhere . " AND (" . $cari . ")");
      }
      $sql_filter_count = $sql_cari->num_rows();
    } else {
      if (!empty($iswhere)) {
        $sql_filter = $this->db->query("SELECT * FROM " . $tables . " WHERE $iswhere AND " . $fwhere);
      } else {
        $sql_filter = $this->db->query("SELECT * FROM " . $tables . " WHERE " . $fwhere);
      }
      $sql_filter_count = $sql_filter->num_rows();
    }

    $data = $sql_data->result_array();

    $callback = array(
      'draw' => $_POST['draw'], // Ini dari datatablenya    
      'recordsTotal' => $sql_count,
      'recordsFiltered' => $sql_filter_count,
      'data' => $data
    );
    return json_encode($callback); // Convert array $callback ke json
  }

  function get_tables_query($query, $cari, $where, $iswhere)
  {
    // Ambil data yang di ketik user pada textbox pencarian
    $search = htmlspecialchars($_POST['search']['value']);
    // Ambil data limit per page
    $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
    // Ambil data start
    $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

    if ($where != null) {
      $setWhere = array();
      foreach ($where as $key => $value) {
        $setWhere[] = $key . "='" . $value . "'";
      }
      $fwhere = implode(' AND ', $setWhere);

      if (!empty($iswhere)) {
        $sql = $this->db->query($query . " WHERE  $iswhere AND " . $fwhere);
      } else {
        $sql = $this->db->query($query . " WHERE " . $fwhere);
      }
      $sql_count = $sql->num_rows();

      $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

      // Untuk mengambil nama field yg menjadi acuan untuk sorting
      $order_field = $_POST['order'][0]['column'];

      // Untuk menentukan order by "ASC" atau "DESC"
      $order_ascdesc = $_POST['order'][0]['dir'];
      $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;


      if (!empty($iswhere)) {
        $sql_data = $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
      } else {
        $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
      }

      if (isset($search)) {
        if (!empty($iswhere)) {
          $sql_cari =  $this->db->query($query . " WHERE $iswhere AND " . $fwhere . " AND (" . $cari . ")");
        } else {
          $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
        }
        $sql_filter_count = $sql_cari->num_rows();
      } else {
        if (!empty($iswhere)) {
          $sql_filter = $this->db->query($query . " WHERE $iswhere AND " . $fwhere);
        } else {
          $sql_filter = $this->db->query($query . " WHERE " . $fwhere);
        }
        $sql_filter_count = $sql_filter->num_rows();
      }
      $data = $sql_data->result_array();
    } else {
      if (!empty($iswhere)) {
        $sql = $this->db->query($query . " WHERE  $iswhere ");
      } else {
        $sql = $this->db->query($query);
      }
      $sql_count = $sql->num_rows();

      $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

      // Untuk mengambil nama field yg menjadi acuan untuk sorting
      $order_field = $_POST['order'][0]['column'];

      // Untuk menentukan order by "ASC" atau "DESC"
      $order_ascdesc = $_POST['order'][0]['dir'];
      $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

      if (!empty($iswhere)) {
        $sql_data = $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
      } else {
        $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
      }

      if (isset($search)) {
        if (!empty($iswhere)) {
          $sql_cari =  $this->db->query($query . " WHERE $iswhere AND (" . $cari . ")");
        } else {
          $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
        }
        $sql_filter_count = $sql_cari->num_rows();
      } else {
        if (!empty($iswhere)) {
          $sql_filter = $this->db->query($query . " WHERE $iswhere");
        } else {
          $sql_filter = $this->db->query($query);
        }
        $sql_filter_count = $sql_filter->num_rows();
      }
      $data = $sql_data->result_array();
    }

    $callback = array(
      'draw' => $_POST['draw'], // Ini dari datatablenya    
      'recordsTotal' => $sql_count,
      'recordsFiltered' => $sql_filter_count,
      'data' => $data
    );
    return json_encode($callback); // Convert array $callback ke json
  }

  function get_tables_query2($query, $cari, $where, $iswhere)
  {
    $search = $_POST['search']['value'] ?? '';
    $limit = intval($_POST['length'] ?? 10);
    $start = intval($_POST['start'] ?? 0);

    // Build WHERE clause
    $whereClause = '';
    if ($where != null) {
      $setWhere = array();
      foreach ($where as $key => $value) {
        $setWhere[] = "$key = '" . $this->db->escape_str($value) . "'";
      }
      $whereClause = implode(' AND ', $setWhere);
    }

    if (!empty($iswhere)) {
      $whereClause = $whereClause ? "$whereClause AND $iswhere" : $iswhere;
    }

    // Build search clause
    $searchClause = '';
    if (!empty($search)) {
      $searchConditions = array();
      foreach ($cari as $column) {
        $searchConditions[] = "$column LIKE '%" . $this->db->escape_str($search) . "%'";
      }
      $searchClause = implode(' OR ', $searchConditions);
    }

    // Build ORDER BY clause
    $orderField = $_POST['columns'][$_POST['order'][0]['column']]['data'] ?? 'a.shipment_id';
    $orderDirection = $_POST['order'][0]['dir'] ?? 'ASC';
    $orderClause = " ORDER BY $orderField $orderDirection";

    // Build final query
    $finalQuery = $query;
    if ($whereClause) {
      $finalQuery .= " WHERE $whereClause";
    }
    if ($searchClause) {
      $finalQuery .= $whereClause ? " AND ($searchClause)" : " WHERE ($searchClause)";
    }
    $finalQuery .= $orderClause . " LIMIT $limit OFFSET $start";

    // Execute query
    $sql_data = $this->db->query($finalQuery);
    $data = $sql_data->result_array();

    // Count total records
    $countQuery = $query;
    if ($whereClause) {
      $countQuery .= " WHERE $whereClause";
    }
    $sql_count = $this->db->query($countQuery)->num_rows();

    // Count filtered records
    $filterQuery = $query;
    if ($whereClause) {
      $filterQuery .= " WHERE $whereClause";
    }
    if ($searchClause) {
      $filterQuery .= $whereClause ? " AND ($searchClause)" : " WHERE ($searchClause)";
    }
    $sql_filter_count = $this->db->query($filterQuery)->num_rows();

    $callback = array(
      'draw' => intval($_POST['draw'] ?? 1),
      'recordsTotal' => $sql_count,
      'recordsFiltered' => $sql_filter_count,
      'data' => $data
    );
    return json_encode($callback);
  }


  function get_tables_query_csrf($query, $cari, $where, $csrf_name, $csrf_hash)
  {
    // Ambil data yang di ketik user pada textbox pencarian
    $search = htmlspecialchars($_POST['search']['value']);
    // Ambil data limit per page
    $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
    // Ambil data start
    $start = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}");

    if ($where != null) {
      $setWhere = array();
      foreach ($where as $key => $value) {
        $setWhere[] = $key . "='" . $value . "'";
      }

      $fwhere = implode(' AND ', $setWhere);

      $sql = $this->db->query($query . " WHERE " . $fwhere);
      $sql_count = $sql->num_rows();

      $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

      // Untuk mengambil nama field yg menjadi acuan untuk sorting
      $order_field = $_POST['order'][0]['column'];

      // Untuk menentukan order by "ASC" atau "DESC"
      $order_ascdesc = $_POST['order'][0]['dir'];
      $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

      $sql_data = $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
      $sql_filter = $this->db->query($query . " WHERE " . $fwhere);

      if (isset($search)) {
        $sql_cari =  $this->db->query($query . " WHERE " . $fwhere . " AND (" . $cari . ")");
        $sql_filter_count = $sql_cari->num_rows();
      } else {
        $sql_filter_count = $sql_filter->num_rows();
      }

      $data = $sql_data->result_array();
    } else {

      $sql = $this->db->query($query);
      $sql_count = $sql->num_rows();

      $cari = implode(" LIKE '%" . $search . "%' OR ", $cari) . " LIKE '%" . $search . "%'";

      // Untuk mengambil nama field yg menjadi acuan untuk sorting
      $order_field = $_POST['order'][0]['column'];

      // Untuk menentukan order by "ASC" atau "DESC"
      $order_ascdesc = $_POST['order'][0]['dir'];
      $order = " ORDER BY " . $_POST['columns'][$order_field]['data'] . " " . $order_ascdesc;

      $sql_data = $this->db->query($query . " WHERE (" . $cari . ")" . $order . " LIMIT " . $limit . " OFFSET " . $start);
      $sql_filter = $this->db->query($query);

      if (isset($search)) {
        $sql_cari =  $this->db->query($query . " WHERE (" . $cari . ")");
        $sql_filter_count = $sql_cari->num_rows();
      } else {
        $sql_filter_count = $sql_filter->num_rows();
      }

      $data = $sql_data->result_array();
    }

    $callback = array(
      'draw' => $_POST['draw'], // Ini dari datatablenya    
      'recordsTotal' => $sql_count,
      'recordsFiltered' => $sql_filter_count,
      'data' => $data
    );
    $callback[$csrf_name] = $csrf_hash;

    return json_encode($callback); // Convert array $callback ke json
  }
}
