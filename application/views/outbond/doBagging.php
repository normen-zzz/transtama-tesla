<style>
    #scanner-container {
        width: 300px;
        height: 300px;
        border: 1px solid #ccc;
        padding: 10px;
    }

    #scanner-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<!--begin::Content-->

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <div class="row">
                <div class="col-12">
                    <div class="card card-custom card-stretch">

                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

                        <!-- /.box-body -->
                        <div class="row m-4" style="overflow: auto;">
                            <div class="col-md-12">
                                <form action="<?= base_url('shipper/Outbond/processBagging') ?>" method="POST">
                                    <table id="myTabl" class="table table-bordered">
                                        <h3 class="title font-weight-bold">List Shipment Bagging</h3>

                                        <p><?= $this->session->flashdata('message'); ?></p>
                                        <thead>
                                            <tr>

                                                <th style="width: 5%">Shipment ID</th>
                                                <th style="width: 15%;">Shipper</th>
                                                <th style="width: 15%;">Consignee</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($bagging as $bagging1) { ?>

                                                <tr>
                                                    <td> <input class="form-control" type="text" name="shipment_id[]" id="shipment_id" value="<?= $bagging1['shipment_id'] ?>" readonly></td>
                                                    <td><?= $bagging1['shipper'] ?></td>
                                                    <td><?= $bagging1['consigne'] ?></td>

                                                </tr>
                                            <?php } ?>

                                        </tbody>


                                    </table>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>SMU</label>
                                                <input type="text" inputmode="numeric" class="form-control" name="smu" id="smu">
                                            </div>
                                            <p class="text-danger">* Pastikan Semua data sudah benar</p>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                           
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->