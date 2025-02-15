<style>
    .datepicker-inline {
        width: auto;
        /*what ever width you want*/
    }
</style>

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

                    <div class="text-center">


                        <div class="form-group" id="datepickid">
                            <div style="width: 100%;"></div>
                            <input type="hidden" name="dt_due" id="dt_due">
                        </div>
                        <!-- <button type="submit" class="btn btn-default">Submit</button> -->

                    </div>
                    <div class="card-toolbar float-right">

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
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Desc</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataSalesTracker as $d) { ?>

                                <tr>
                                    <td><?= $d['subject'] ?></td>
                                    <td><?= $d['description'] ?></td>
                                    <td><?php if ($d['start_date'] != NULL && $d['end_date'] == NULL) {
                                            echo "Planned";
                                        } elseif ($d['start_date'] != NULL && $d['end_date'] != NULL) {
                                            echo "Held";
                                        } ?></td>
                                    <td><?php if ($d['start_date'] != NULL && $d['end_date'] == NULL) { ?>
                                            <a href="#" data-toggle="modal" data-target="#modal-lg-<?= $d['id_sales_tracker'] ?>" class="btn btn-success mt-2">Check Out</a>
                                        <?php } ?><a href="<?= base_url('sales/SalesTracker/detail/' . $d['id_sales_tracker']) ?>" class="btn btn-primary mt-2">Detail</a><a href="<?= base_url('sales/SalesTracker/deleteSalesTracker/' . $d['id_sales_tracker']) ?>" onclick="return confirm_delete()" class="btn btn-danger ml-2 mt-2">Delete</a>
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
                <h4 class="modal-title">New Meeting</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('sales/SalesTracker/addNewMeeting') ?>" method="POST">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputPassword1">Subject</label>
                            <input type="text" placeholder="Cth : Pt. ABC" class="form-control" required name="subject">
                            <input type="text" placeholder="Cth : Pt. ABC" class="form-control" value="<?= $this->session->userdata('id_user') ?>" hidden name="sales">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Location</label>
                            <input type="text" class="form-control" placeholder="Cth: Jl.Pahlawan no.53" required name="location">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Start Date</label>
                            <input type="datetime-local" class="form-control" required name="start_date">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Contact/PIC</label>
                            <input type="text" placeholder="Cth: Kevin" class="form-control" name="contact">
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

<!-- Modal Checkout -->
<?php foreach ($dataSalesTracker as $d) { ?>
    <div class="modal fade" id="modal-lg-<?= $d['id_sales_tracker'] ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Check Out</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-top: -40px;">
                    <form action="<?= base_url('sales/SalesTracker/checkOut') ?>" method="POST" enctype='multipart/form-data'>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputPassword1">Subject</label>
                                <input type="text" value="<?= $d['subject'] ?>" disabled placeholder="Cth : Pt. ABC" class="form-control" required name="subject">
                                <input type="text" name="id_sales_tracker" value="<?= $d['id_sales_tracker'] ?>" hidden>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea class="form-control" disabled name="description" id="description"><?= $d['description'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Summary</label>
                                <input type="text" class="form-control" required name="summary">
                            </div>
                            
                                <input type="text" class="form-control" id="koordinat" name="koordinat" hidden>
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Picture</label>
                                <input type="file" class="form-control" id="attachment<?= $d['id_sales_tracker'] ?>" name="attachmentbefore<?= $d['id_sales_tracker'] ?>" onchange="handleImageUploadTracker(this.id);" accept="image/*" required>
                                <input type="file" class="form-control" id="upload_file-attachment<?= $d['id_sales_tracker'] ?>" name="photo" required hidden>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">End Date</label>
                                <input type="datetime-local" class="form-control" required name="end_date">
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
<?php } ?>