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
                    <table class="table table-bordered table-hover table-head-custom table-checkable" id="myTable">
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
                        <thead>
                            <tr class="bg-light">
                                <th class="font-weight-bold">Subject</th>
                                <th class="font-weight-bold">Description</th>
                                <th class="font-weight-bold">Status</th>
                                <th class="font-weight-bold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataSalesTracker as $d) { ?>
                                <tr>
                                    <td class="font-weight-bold"><?= $d['subject'] ?></td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 300px;" title="<?= $d['description'] ?>">
                                            <?= $d['description'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($d['start_date'] != NULL && $d['end_date'] == NULL) { ?>
                                            <span class="badge badge-warning px-3 py-2">Planned</span>
                                        <?php } elseif ($d['start_date'] != NULL && $d['end_date'] != NULL) { ?>
                                            <span class="badge badge-success px-3 py-2">Held</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <?php if ($d['start_date'] != NULL && $d['end_date'] == NULL) { ?>
                                                <a href="#" data-toggle="modal" data-target="#modal-lg-<?= $d['id_sales_tracker'] ?>" class="btn btn-sm btn-success mr-1">
                                                    <i class="fa fa-check-circle mr-1"></i> Check Out
                                                </a>
                                            <?php } ?>
                                            <a href="<?= base_url('sales/SalesTracker/detail/' . $d['id_sales_tracker']) ?>" class="btn btn-sm btn-info mr-1">
                                                <i class="fa fa-eye mr-1"></i> Detail
                                            </a>
                                            <a href="<?= base_url('sales/SalesTracker/deleteSalesTracker/' . $d['id_sales_tracker']) ?>" 
                                               onclick="return confirm_delete()" 
                                               class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash mr-1"></i> Delete
                                            </a>
                                        </div>
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
        <div class="modal-content" style="border-radius: 15px; overflow: hidden; box-shadow: 0 15px 30px rgba(0,0,0,0.2);">
            <div class="modal-header bg-gradient-primary" style="background: linear-gradient(135deg, #9c223b, #c92e54); color: white; border-bottom: none; padding: 20px 25px;">
                <h4 class="modal-title font-weight-bold">
                    <i class="fa fa-calendar-plus mr-2"></i>New Meeting
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 25px;">
                <form action="<?= base_url('sales/SalesTracker/addNewMeeting') ?>" method="POST">
                    <div class="card-body p-0">
                        <div class="form-group">
                            <label for="subject" class="font-weight-bold"><i class="fa fa-tag mr-2"></i>Subject</label>
                            <input type="text" placeholder="Cth : Pt. ABC" class="form-control form-control-lg" required name="subject" style="border-radius: 8px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $this->session->userdata('id_user') ?>" hidden name="sales">
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="font-weight-bold"><i class="fa fa-align-left mr-2"></i>Description</label>
                            <textarea class="form-control" name="description" id="description" style="border-radius: 8px; min-height: 100px; border: 1px solid #ddd;"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location" class="font-weight-bold"><i class="fa fa-map-marker-alt mr-2"></i>Location</label>
                                    <input type="text" class="form-control" placeholder="Cth: Jl.Pahlawan no.53" required name="location" style="border-radius: 8px; border: 1px solid #ddd;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date" class="font-weight-bold"><i class="fa fa-clock mr-2"></i>Start Date</label>
                                    <input type="datetime-local" class="form-control" required name="start_date" style="border-radius: 8px; border: 1px solid #ddd;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact" class="font-weight-bold"><i class="fa fa-user mr-2"></i>Contact/PIC</label>
                            <input type="text" placeholder="Cth: Kevin" class="form-control" name="contact" style="border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between border-0 pt-4">
                        <button type="button" class="btn btn-light font-weight-bold px-4 py-2" data-dismiss="modal" style="border-radius: 8px;">
                            <i class="fa fa-times mr-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn font-weight-bold text-white px-5 py-2" style="background-color: #9c223b; border-radius: 8px;">
                            <i class="fa fa-check mr-1"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- Modal Checkout -->
<?php foreach ($dataSalesTracker as $d) { ?>
    <div class="modal fade" id="modal-lg-<?= $d['id_sales_tracker'] ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 15px; overflow: hidden; box-shadow: 0 15px 30px rgba(0,0,0,0.2);">
                <div class="modal-header bg-gradient-primary" style="background: linear-gradient(135deg, #9c223b, #c92e54); color: white; border-bottom: none; padding: 20px 25px;">
                    <h4 class="modal-title font-weight-bold">
                        <i class="fa fa-check-circle mr-2"></i>Check Out
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 25px;">
                    <form action="<?= base_url('sales/SalesTracker/checkOut') ?>" method="POST" enctype='multipart/form-data'>
                        <div class="card-body p-0">
                            <div class="form-group">
                                <label for="subject" class="font-weight-bold"><i class="fa fa-tag mr-2"></i>Subject</label>
                                <input type="text" value="<?= $d['subject'] ?>" disabled class="form-control form-control-lg" style="border-radius: 8px; border: 1px solid #ddd; background-color: #f8f9fa;">
                                <input type="text" name="id_sales_tracker" value="<?= $d['id_sales_tracker'] ?>" hidden>
                            </div>
                            
                            <div class="form-group">
                                <label for="description" class="font-weight-bold"><i class="fa fa-align-left mr-2"></i>Description</label>
                                <textarea class="form-control" disabled style="border-radius: 8px; min-height: 80px; border: 1px solid #ddd; background-color: #f8f9fa;"><?= $d['description'] ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="summary" class="font-weight-bold"><i class="fa fa-file-alt mr-2"></i>Meeting Summary</label>
                                <input type="text" class="form-control" required name="summary" placeholder="Enter meeting results/summary" style="border-radius: 8px; border: 1px solid #ddd;">
                            </div>

                            <div class="form-group">
                                <label for="koordinat" class="font-weight-bold"><i class="fa fa-map-marker-alt mr-2"></i>Geo Location</label>
                                <input type="text" class="form-control" id="koordinat" name="koordinat" readonly>
                            </div>
                            
                       
                            
                            <div class="form-group">
                                <label for="attachment" class="font-weight-bold"><i class="fa fa-camera mr-2"></i>Meeting Photo</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="attachment<?= $d['id_sales_tracker'] ?>" name="attachmentbefore<?= $d['id_sales_tracker'] ?>" onchange="handleImageUploadTracker(this.id);" accept="image/*" required>
                                    <label class="custom-file-label" for="attachment<?= $d['id_sales_tracker'] ?>" style="border-radius: 8px;">Choose file</label>
                                    <input type="file" class="form-control" id="upload_file-attachment<?= $d['id_sales_tracker'] ?>" name="photo" required hidden>
                                </div>
                                <small class="text-muted">Please upload a photo from your meeting</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="end_date" class="font-weight-bold"><i class="fa fa-calendar-check mr-2"></i>End Date</label>
                                <input type="datetime-local" class="form-control" required name="end_date" style="border-radius: 8px; border: 1px solid #ddd;">
                            </div>
                        </div>
                        
                        <div class="modal-footer justify-content-between border-0 pt-4">
                            <button type="button" class="btn btn-light font-weight-bold px-4 py-2" data-dismiss="modal" style="border-radius: 8px;">
                                <i class="fa fa-times mr-1"></i> Cancel
                            </button>
                            <button type="submit" class="btn font-weight-bold text-white px-5 py-2" style="background-color: #9c223b; border-radius: 8px;">
                                <i class="fa fa-check mr-1"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
<?php } ?>