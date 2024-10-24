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
                                <form action="<?= base_url('dispatcher/Scan/processScanOut/'.$bagging['id_bagging']) ?>" method="POST">
                                    <table id="myTabl" class="table table-bordered">
                                        <h3 class="title font-weight-bold">Detail Scan OUT</h3>

                                        <p><?= $this->session->flashdata('message'); ?></p>
                                        <thead>
                                            <tr>

                                                <th style="width: 5%">No Bagging</th>
                                                <th style="width: 15%;">Created At</th>
                                                <th style="width: 15%;">Time Scan In</th>
                                                <th style="width: 15%;">Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           

                                                <tr>
                                                    <td><?= $bagging['id_bagging'] ?></td>
                                                    <td><?= date('d-m-Y H:i:s',strtotime($bagging['created_at'])) ?></td>
                                                    <td><?= date('d-m-Y H:i:s',strtotime($bagging['dispatcher_in']))  ?></td>
                                                    <td><?= getNamaUser($bagging['created_by'])  ?></td>

                                                </tr>
                                            
                                        </tbody>
                                    </table>

                                    <table id="myTabl" class="table table-bordered">
                                        <h3 class="title font-weight-bold">Resi</h3>

                                        <p><?= $this->session->flashdata('message'); ?></p>
                                        <thead>
                                            <tr>

                                                <th style="width: 5%">No Resi</th>
                                                <th style="width: 15%;">Shipper</th>
                                                <th>Consigne</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($resi->result_array() as $resi1) {?>
                                                <tr>
                                                    <td><?= $resi1['shipment_id'] ?></td>
                                                    <td><?= $resi1['shipper'] ?></td>
                                                    <td><?= $resi1['city_consigne'].','.$resi1['state_consigne'] ?></td>
                                                    

                                                </tr>
                                                <?php } ?>
                                            
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>No Flight</label>
                                                <input type="text" class="form-control" name="no_flight" id="no_flight">
                                            </div>
                                            <div class="form-group">
                                                <label>Flight At</label>
                                                <input type="datetime-local" class="form-control" name="flight_at" id="flight_at">
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