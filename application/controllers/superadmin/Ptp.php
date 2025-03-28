<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ptp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
            redirect('backoffice');
        }
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        cek_role();
    }

    public function Customer()
    {
        $data['title'] = 'Ptp';
        $data['customer_ptp'] = $this->db->get('customer_ptp')->result_array();

        $this->backend->display('superadmin/ptp/customer', $data);
    }

    // addCustomerPtp
    public function addCustomerPtp()
    {
        $this->db->trans_start();
        try {
            $nama_customer = $this->input->post('nama_customer');
            $check = $this->db->get_where('customer_ptp', ['nama_customer' => $nama_customer, 'is_deleted' => 0]);
            if ($check->num_rows() > 0) {
                throw new Exception('Data already exists');
            }
            $city = $this->input->post('city');
            $state = $this->input->post('state');
            $address = $this->input->post('address');
            $data = [
                'nama_customer' => $nama_customer,
                'city' => $city,
                'state' => $state,
                'address' => $address,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id_user')
            ];
            $insert = $this->db->insert('customer_ptp', $data);
            if ($insert) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            } else {
                throw new Exception('Data failed to add');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to add');
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to add'
            ];
        }
        echo json_encode($response);
    }

    // editCustomerPtp
    public function editCustomerPtp()
    {
        $this->db->trans_start();
        try {
            $id_customer_ptp = $this->input->post('id_customer_ptp');
            $nama_customer = $this->input->post('nama_customer');
            $city = $this->input->post('city');
            $state = $this->input->post('state');
            $address = $this->input->post('address');
            $data = [
                'nama_customer' => $nama_customer,
                'city' => $city,
                'state' => $state,
                'address' => $address,
            ];
            $this->db->where('id_customer_ptp', $id_customer_ptp);
            $update = $this->db->update('customer_ptp', $data);
            if ($update) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            } else {
                throw new Exception('Data failed to edit');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to edit');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to edit'
            ];
        }
        echo json_encode($response);
    }
    // deleteCustomerPtp 
    public function deleteCustomerPtp()
    {
        $this->db->trans_start();
        try {
            $id_customer_ptp = $this->input->post('id');
            $this->db->where('id_customer_ptp', $id_customer_ptp);
            $delete = $this->db->delete('customer_ptp');
            if ($delete) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            } else {
                throw new Exception('Data failed to delete');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to delete');
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to delete'
            ];
        }
        echo json_encode($response);
    }


    public function state()
    {
        $data['title'] = 'Ptp';
        $data['state'] = $this->db->query('SELECT * FROM state_ptp WHERE is_deleted = 0')->result_array();
        $this->backend->display('superadmin/ptp/state', $data);
    }
    // addStatePtp 
    public function addStatePtp()
    {
        $this->db->trans_start();
        try {
            $name_state = $this->input->post('name_state');
            $check = $this->db->get_where('state_ptp', ['name_state' => $name_state, 'is_deleted' => 0]);
            if ($check->num_rows() > 0) {
                throw new Exception('Data already exists');
               
            }
            $data = [
                'name_state' => $name_state
            ];
            $insert = $this->db->insert('state_ptp', $data);
            if ($insert) {
                $response  = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            } else {
                throw new Exception('Data failed to add');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to add');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Data failed to add'
            ];
        }
        echo json_encode($response);
    }

    // editStatePtp
    public function editStatePtp()
    {
        $this->db->trans_start();
        try {
            $id_state_ptp = $this->input->post('id_state_ptp');
            $name_state = $this->input->post('name_state');
            $data = [
                'name_state' => $name_state
            ];
            $this->db->where('id_state_ptp', $id_state_ptp);
            $update = $this->db->update('state_ptp', $data);
            if ($update) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            } else {
                throw new Exception('Data failed to edit');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to edit');
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to edit'
            ];
        }
        echo json_encode($response);
    }

    // deleteStatePtp
    public function deleteStatePtp()
    {
        $this->db->trans_start();
        try {
            $id_state_ptp = $this->input->post('id_state_ptp');

            $delete = $this->db->update('state_ptp', ['is_deleted' => 1], ['id_state_ptp' => $id_state_ptp]);
            if ($delete) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            } else {
                throw new Exception('Data failed to delete');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to delete');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to delete'
            ];
        }
        echo json_encode($response);
    }
    // city 
    public function city()
    {
        $data['title'] = 'Ptp';
        $data['city'] = $this->db->query('SELECT * FROM city_ptp JOIN state_ptp ON  city_ptp.id_state_ptp = state_ptp.id_state_ptp WHERE city_ptp.is_deleted = 0')->result();
        $data['state'] = $this->db->query('SELECT * FROM state_ptp WHERE is_deleted = 0');
        $this->backend->display('superadmin/ptp/city', $data);
    }

    // addCityPtp 
    public function addCityPtp()
    {
        $this->db->trans_start();
        try {
            $id_state_ptp = $this->input->post('state');
            $name_city = $this->input->post('name');
            $tlc = $this->input->post('tlc');
            $check = $this->db->get_where('city_ptp', ['name' => $name_city, 'is_deleted' => 0]);
            if ($check->num_rows() > 0) {
                throw new Exception('Data already exists');
            }
            $data = [
                'id_state_ptp' => $id_state_ptp,
                'name' => strtoupper($name_city),
                'tlc' => strtoupper($tlc)
            ];

            $insert = $this->db->insert('city_ptp', $data);
            if ($insert) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            } else {
                throw new Exception('Data failed to add');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to add');
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to add'
            ];
        }
        echo json_encode($response);
    }

    // editCityPtp
    public function editCityPtp()
    {
        $this->db->trans_start();
        try {
            $id_city_ptp = $this->input->post('id_city_ptp');
            $id_state_ptp = $this->input->post('id_state_ptp');
            $name_city = $this->input->post('name');
            $tlc = $this->input->post('tlc');
            $data = [
                'id_state_ptp' => $id_state_ptp,
                'name' => strtoupper($name_city),
                'tlc' => strtoupper($tlc)
            ];
            $this->db->where('id_city_ptp', $id_city_ptp);
            $update = $this->db->update('city_ptp', $data);
            if ($update) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            } else {
                throw new Exception('Data failed to edit');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to edit');
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to edit'
            ];
        }
        echo json_encode($response);
    }

    //deleteCityPtp
    public function deleteCityPtp()
    {
        $this->db->trans_start();
        try {
            $id_city_ptp = $this->input->post('id');
            $delete = $this->db->update('city_ptp', ['is_deleted' => 1], ['id_city_ptp' => $id_city_ptp]);
            if ($delete) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            } else {
                throw new Exception('Data failed to delete');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to delete');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to delete'
            ];
        }
        echo json_encode($response);
    }
    //airlines 
    public function airlines()
    {
        $data['title'] = 'Ptp';
        $data['airlines'] = $this->db->query('SELECT * FROM airlines_ptp WHERE is_deleted = 0')->result_array();
        $this->backend->display('superadmin/ptp/airlines', $data);
    }
    // addAirlinesPtp
    public function addAirlinesPtp()
    {
        $this->db->trans_start();
        try {
            $airlines = $this->input->post('airlines');
            $data = [
                'name_airlines' => $airlines
            ];
            $insert = $this->db->insert('airlines_ptp', $data);
            if ($insert) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            } else {
                throw new Exception('Data failed to add');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to add');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to add'
            ];
        }
        echo json_encode($response);
    }
    // editAirlinesPtp
    public function editAirlinesPtp()
    {
        $this->db->trans_start();
        try {
            $id_airlines_ptp = $this->input->post('id');
            $name_airlines = $this->input->post('airlines');
            $check = $this->db->get_where('airlines_ptp', ['name_airlines' => $name_airlines, 'is_deleted' => 0]);
            if ($check->num_rows() > 0) {
               throw new Exception('Data already exists');
            }
            $data = [
                'name_airlines' => $name_airlines
            ];
            $this->db->where('id_airlines', $id_airlines_ptp);
            $update = $this->db->update('airlines_ptp', $data);
            if ($update) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            } else {
                throw new Exception('Data failed to edit');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to edit');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to edit'
            ];
        }
        echo json_encode($response);
    }
    // deleteAirlinesPtp
    public function deleteAirlinesPtp()
    {
        $this->db->trans_start();
        try {
            $id_airlines_ptp = $this->input->post('id');
            $delete = $this->db->update('airlines_ptp', ['is_deleted' => 1], ['id_airlines' => $id_airlines_ptp]);
            if ($delete) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            } else {
                throw new Exception('Data failed to delete');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to delete');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to delete'
            ];
        }
        echo json_encode($response);
    }
    // cost 
    public function cost()
    {
        $data['title'] = 'Ptp';
        $data['cost'] = $this->db->query('SELECT *,city_ptp.name AS name_city FROM cost_ptp JOIN city_ptp ON cost_ptp.id_city_ptp = city_ptp.id_city_ptp JOIN airlines_ptp ON cost_ptp.id_airlines = airlines_ptp.id_airlines WHERE cost_ptp.is_deleted = 0')->result_array();
        $data['city'] = $this->db->query('SELECT * FROM city_ptp WHERE is_deleted = 0')->result_array();
        $data['airlines'] = $this->db->query('SELECT * FROM airlines_ptp WHERE is_deleted = 0')->result_array();
        $this->backend->display('superadmin/ptp/cost', $data);
    }
    // addCostPtp
    public function addCostPtp()
    {
        $this->db->trans_start();
        try {
            $id_city_ptp = $this->input->post('city');
            $id_airlines = $this->input->post('airlines');
            $check = $this->db->get_where('cost_ptp', ['id_city_ptp' => $id_city_ptp, 'id_airlines' => $id_airlines, 'is_deleted' => 0]);
            if ($check->num_rows() > 0) {
                throw new Exception('Data already exists');
            }
            $cost = $this->input->post('cost');
            $data = [
                'id_city_ptp' => $id_city_ptp,
                'id_airlines' => $id_airlines,
                'flight_smu' => $this->input->post('flight_smu'),
                'ra' => $this->input->post('ra'),
                'packing' => $this->input->post('packing'),
                'refund' => $this->input->post('refund'),
                'specialrefund' => $this->input->post('specialrefund'),
                'insurance' => $this->input->post('insurance'),
                'surcharge' => $this->input->post('surcharge'),
                'hand_cgk' => $this->input->post('hand_cgk'),
                'hand_pickup' => $this->input->post('hand_pickup'),
                'hd_daerah' => $this->input->post('hd_daerah'),
                'pph' => $this->input->post('pph'),
                'sdm' => $this->input->post('sdm'),
                'others' => $this->input->post('others'),
            ];
            $insert = $this->db->insert('cost_ptp', $data);
            if ($insert) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            } else {
                throw new Exception('Data failed to add');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to add');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to add'
            ];
        }
        echo json_encode($response);
    }
    // editCostPtp
    public function editCostPtp()
    {
        $this->db->trans_start();
        try {
            $id_cost_ptp = $this->input->post('id_cost_ptp');
            $id_city_ptp = $this->input->post('city');
            $id_airlines = $this->input->post('airlines');
            $data = [
                'id_city_ptp' => $id_city_ptp,
                'id_airlines' => $id_airlines,
                'flight_smu' => $this->input->post('flight_smu'),
                'ra' => $this->input->post('ra'),
                'packing' => $this->input->post('packing'),
                'refund' => $this->input->post('refund'),
                'specialrefund' => $this->input->post('specialrefund'),
                'insurance' => $this->input->post('insurance'),
                'surcharge' => $this->input->post('surcharge'),
                'hand_cgk' => $this->input->post('hand_cgk'),
                'hand_pickup' => $this->input->post('hand_pickup'),
                'hd_daerah' => $this->input->post('hd_daerah'),
                'pph' => $this->input->post('pph'),
                'sdm' => $this->input->post('sdm'),
                'others' => $this->input->post('others'),
            ];
            $this->db->where('id_cost_ptp', $id_cost_ptp);
            $update = $this->db->update('cost_ptp', $data);
            if ($update) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            } else {
                throw new Exception('Data failed to edit');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to edit');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to edit'
            ];
        }
        echo json_encode($response);
    }
    // deleteCostPtp
    public function deleteCostPtp()
    {
        $this->db->trans_start();
        try {
            $id_cost_ptp = $this->input->post('id');
            $delete = $this->db->update('cost_ptp', ['is_deleted' => 1], ['id_cost_ptp' => $id_cost_ptp]);
            if ($delete) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            } else {
                throw new Exception('Data failed to delete');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to delete');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to delete'
            ];
        }
        echo json_encode($response);
    }
    // sales 
    public function sales()
    {
        $data['title'] = 'Ptp';
        $data['sell'] = $this->db->query('SELECT *,b.name as name_city FROM sell_ptp a JOIN city_ptp b ON a.id_city_ptp = b.id_city_ptp JOIN airlines_ptp c ON a.id_airlines = c.id_airlines WHERE a.is_deleted = 0');
        $data['city'] = $this->db->query('SELECT * FROM city_ptp WHERE is_deleted = 0')->result_array();
        $data['airlines'] = $this->db->query('SELECT * FROM airlines_ptp WHERE is_deleted = 0')->result_array();
        $this->backend->display('superadmin/ptp/sales', $data);
    }

    // deleteSellPtp
    public function deleteSellPtp()
    {
        $this->db->trans_start();
        try {
            $id_sell_ptp = $this->input->post('id');
            $delete = $this->db->update('sell_ptp', ['is_deleted' => 1], ['id_sell_ptp' => $id_sell_ptp]);
            if ($delete) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            } else {
                throw new Exception('Data failed to delete');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to delete');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ];
            }
            # code...
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to delete'
            ];
        }
        echo json_encode($response);
    }

    // addSalesPtp
    public function addSellPtp()
    {
        $this->db->trans_start();
        try {
            $id_city_ptp = $this->input->post('id_city_ptp');
            $id_airlines = $this->input->post('id_airlines');
            $check = $this->db->get_where('sell_ptp', ['id_city_ptp' => $id_city_ptp, 'id_airlines' => $id_airlines, 'is_deleted' => 0]);
            if ($check->num_rows() > 0) {
                throw new Exception('Data already exists');
            }
            $data = [
                'id_city_ptp' => $id_city_ptp,
                'id_airlines' => $id_airlines,
                'freight_kg' => $this->input->post('freight_kg'),
                'special_freight' => $this->input->post('special_freight'),
                'packing' => $this->input->post('packing'),
                'others' => $this->input->post('others'),
                'surcharge' => $this->input->post('surcharge'),
                'insurance' => $this->input->post('insurance'),
                'disc' => $this->input->post('disc'),
                'cn' => $this->input->post('cn'),
                'special_cn' => $this->input->post('special_cn'),
                'is_deleted' => 0
            ];
            $insert = $this->db->insert('sell_ptp', $data);
            if ($insert) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            } else {
                throw new Exception('Data failed to add');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to add');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been added'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to add'
            ];
        }
        echo json_encode($response);
    }
    // editSellPtp 
    public function editSellPtp()
    {
        $this->db->trans_start();
        try {
            $id_sell_ptp = $this->input->post('id_sell_ptp');
            $id_city_ptp = $this->input->post('id_city_ptp');
            $id_airlines = $this->input->post('id_airlines');
            $data = [
                'id_city_ptp' => $id_city_ptp,
                'id_airlines' => $id_airlines,
                'freight_kg' => $this->input->post('freight_kg'),
                'special_freight' => $this->input->post('special_freight'),
                'packing' => $this->input->post('packing'),
                'others' => $this->input->post('others'),
                'surcharge' => $this->input->post('surcharge'),
                'insurance' => $this->input->post('insurance'),
                'disc' => $this->input->post('disc'),
                'cn' => $this->input->post('cn'),
                'special_cn' => $this->input->post('special_cn'),
                'is_deleted' => 0
            ];
            $update = $this->db->update('sell_ptp', $data, ['id_sell_ptp' => $id_sell_ptp]);
            if ($update) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            } else {
                throw new Exception('Data failed to edit');
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Data failed to edit');
                # code...
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been edited'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data failed to edit'
            ];
        }
        echo json_encode($response);
    }
}
