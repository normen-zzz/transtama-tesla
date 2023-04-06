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
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="<?= base_url('sales/SalesTracker/index/' . date('d/m/y', strtotime($dataSalesTracker['start_date']))) ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
                            <span class="svg-icon svg-icon-md">
                                <i class="fas fa-chevron-circle-left text-light"> </i>
                                <!--end::Svg Icon-->
                            </span>Back</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body" style="overflow: auto;">
                    <form action="<?= base_url('sales/SalesTracker/editSalesTracker') ?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputPassword1">Subject</label>
                                <input type="text" value="<?= $dataSalesTracker['subject'] ?>" placeholder="Cth : Pt. ABC" class="form-control" required name="subject">
                                <input type="text" name="id_sales_tracker" value="<?= $dataSalesTracker['id_sales_tracker'] ?>" hidden>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea class="form-control" name="description" id="description"><?= $dataSalesTracker['description'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Location</label>

                                <input type="text" class="form-control" value="<?= $dataSalesTracker['location'] ?>" placeholder="Cth: Jl.Pahlawan no.53" required name="location">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Start Date</label>
                                <input type="datetime-local" value="<?= date('Y-m-d\TH:i:s', strtotime($dataSalesTracker['start_date'])) ?>" class="form-control" required name="start_date">
                            </div>
                            <?php if ($dataSalesTracker['end_date'] != NULL) { ?>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">End Date</label>
                                    <input type="datetime-local" value="<?= date('Y-m-d\TH:i:s', strtotime($dataSalesTracker['end_date'])) ?>" class="form-control" required name="end_date">
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Contact/PIC</label>
                                <input type="text" value="<?= $dataSalesTracker['contact'] ?>" placeholder="Cth: Kevin" class="form-control" name="contact">
                            </div>

                            <?php if ($dataSalesTracker['end_date'] != NULL) { ?>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Summary</label>
                                    <input type="text" value="<?= $dataSalesTracker['summary'] ?>" placeholder="Cth: Kevin" class="form-control" name="summary">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Gps</label>
                                    <a href="https://maps.google.com?q=<?= $dataSalesTracker['geo_location'] ?>" class="link-info">maps</a>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Image</label>
                                    <img class="img-fluid" src="<?= base_url('uploads/salestracker/' . $dataSalesTracker['image']) ?>" alt="<?= $dataSalesTracker['image'] ?>" width="400px">
                                    <label class="text-danger" for="">*Isi Jika Ingin Mengubah Photo*</label>
                                    <input type="file" id="attachment1" class="form-control mt-2" accept="image/png, image/gif, image/jpeg" onchange="handleImageUpload(this.id);" name="photoBefore">
                                    <input type="file" class="form-control" id="upload_file2" name="photo" hidden>
                                </div>
                            <?php } ?>


                            <div class="form-group">
                                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                                <button type="submit" class="btn btn-primary float-right">Edit</button>
                            </div>



                        </div>



                        <!-- /.card-body -->
                </div>

                </form>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
</div>