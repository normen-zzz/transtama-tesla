<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
<!-- Main content -->
<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12">
                <div class="card card-custom card-stretch">
                    <div class="card-header py-3">
                        <div class="card-title align-items-start flex-column">
                            <h3 class="card-label font-weight-bolder text-dark">Update Tracking</h3>
                            <span class="text-muted font-weight-bold font-size-sm mt-1">Input Shipment Number</span>
                        </div>
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="overflow: auto;">
                        <div class="row">
                            <div class="col-md-4">
                                <form action="<?= base_url('shipper/salesOrder/asign') ?>" method="POST">

                                    <label for="shipment_id">Shipment ID</label>
                                    <input type="text" class="form-control" name="shipment_id" <?php if ($resi != NULL) { ?> value="<?= $resi ?>" <?php } ?>>
                                    <button type="submit" class="btn btn-success mt-2">View</button>

                                </form>
                            </div>
                            <div class="col-md-8">
                                <p><?= $this->session->flashdata('message'); ?></p>
                                <?php if ($resi != NULL) {

                                ?>
                                    <h4 class="title">Milestone AWB <?= $shipment_id ?></h4>
                                    <div class="row">
                                        <div class="col-md-6">Shipper : <b><?= $shipment['shipper'] ?> - <?= $shipment['tree_shipper'] ?></b> </div>
                                        <div class="col-md-6">Consignee : <b><?= $shipment['consigne'] ?> - <?= $shipment['tree_consignee'] ?></b> </div>
                                    </div>
                                    <div class="row">
                                        <?php $user = $this->db->get_where('tb_user', array('id_user' => $shipment['id_user']))->row_array() ?>
                                        <div class="col">Driver : <b><?= $user['nama_user'] ?></b> </div>
                                    </div>
                                    <br>
                                    <?php if ($shipment_id != NULL) {
                                    ?>
                                        <a href="#" class="btn btn-sm text-light" data-toggle="modal" data-target="#modal-lg-dl<?= $resi ?>" style="background-color: #9c223b;">
                                            Assign Driver DL
                                        </a>

                                    <?php   } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<div class="modal fade" id="modal-lg-dl<?= $resi ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign Driver DL <b><?= $resi ?></b> </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('shipper/salesOrder/assignDriverDlDarurat') ?>" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <?php $ship = $this->db->get_where('tbl_shp_order', array('shipment_id' => $resi))->row_array() ?>
                            <input type="text" name="id_so" class="form-control" hidden value="<?= $ship['id_so'] ?>">
                            <input type="text" name="shipment_id" class="form-control" hidden value="<?= $resi ?>">
                            <div class="col-md-12">
                                <label for="id_driver">Choose Driver : </label>
                                <select name="id_driver" class="form-control" style="width: 200px;">
                                    <?php foreach ($users as $u) {
                                    ?>
                                        <option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
                                    <?php    } ?>
                                </select>

                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>