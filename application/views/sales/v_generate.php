<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label"><?= $title ?>
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Button-->
                        <a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
                            <span class="svg-icon svg-icon-md">
                                <i class="fa fa-plus text-light"></i>
                                <!--end::Svg Icon-->
                            </span>Add</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body" style="overflow: auto;">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="myTable">

                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <thead>
                            <tr>
                                <th>Nama Customer</th>
                                <th>Total</th>
                                <th>Sisa</th>
                                <th>Created At</th>
                                <th>Notes</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($generate as $gn) {
                                $sisa = $this->db->get_where('tbl_booking_number_resi', array('group' => $gn['group'], 'status' => 0));

                            ?>
                                <tr>

                                    <td><?= $gn['customer'] ?></td>
                                    <td><?= $gn['total'] ?></td>
                                    <td><?= $sisa->num_rows() ?></td>

                                    <td><?= $gn['created_at'] ?></td>
                                    <td><?= $gn['notes'] ?></td>
                                    <td>
                                        <a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/SalesOrder/detailGenerate/' . $gn['group']) ?>" class="btn btn-sm text-light mb-1" style="background-color: #9c223b;">
                                            Detail</a>
                                        <!-- <a href="<?= base_url('superadmin/order/exportGenerateGenerateResi/' . $gn['id_customer'] . '/' . $gn['group']) ?>" class="btn btn-sm text-light mb-1" style="background-color: #9c223b;">
                                            Export Excell</a> -->
                                        <a href="<?= base_url('sales/SalesOrder/generatePdfGenerateResi/' . $gn['group']) ?>" class="btn btn-sm text-light mb-1" style="background-color: #9c223b;">
                                            Print PDF</a>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>


<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Users</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('sales/SalesOrder/generateResiAdd') ?>" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div>
                                <p class="text-danger">*Maksimal generate resi sebanyak 20</p>
                                <p class="text-danger">*Harap Menggunakan Koneksi yang lancar untuk melakukan generate resi</p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleSelectBorder">Customer</label>
                                    <select name="id_customer" class="custom-select form-control-border" style="width: 80%;" id="shipper_id">
                                        <?php foreach ($customers as $cust) { ?>
                                            <option value="<?= $cust['id_customer'] ?>"><?= $cust['nama_pt'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <input type="text" class="form-control" hidden name="customer" value="<?php echo set_value('shipper2'); ?>" id="shipper">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Total Request</label>
                                    <input type="number" class="form-control" required name="total">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Notes</label>
                                    <input type="text" class="form-control" required name="notes">
                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- /.card-body -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->