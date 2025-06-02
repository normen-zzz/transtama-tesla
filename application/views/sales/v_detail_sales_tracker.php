<style>
    :root {
        --primary-color: #9c223b;
        --secondary-color: #f8f9fa;
        --text-color: #3f4254;
        --border-color: #e4e6ef;
    }

    .card {
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #7d1c30 100%);
        color: white;
        border-radius: 0 !important;
    }

    .card-title h3 {
        color: white;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .form-group label {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(156, 34, 59, 0.1);
        border-color: var(--primary-color);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: 0.5rem;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #7d1c30;
        border-color: #7d1c30;
        transform: translateY(-2px);
    }

    .back-btn {
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        transform: translateY(-2px);
    }

    .form-section {
        background-color: var(--secondary-color);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-section-title {
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: var(--primary-color);
    }

    .img-preview {
        border-radius: 0.5rem;
        border: 3px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .img-preview:hover {
        transform: scale(1.02);
    }

    .map-link {
        display: inline-flex;
        align-items: center;
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .map-link:hover {
        color: #7d1c30;
        text-decoration: none;
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
                <div class="card-header flex-wrap border-0 pt-6 pb-6">
                    <div class="card-title">
                        <h3 class="card-label"><?= $title ?>
                            <span class="d-block text-white-50 pt-2 font-size-sm">Sales Tracking Details</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="<?= base_url('sales/SalesTracker/index/' . date('d/m/y', strtotime($dataSalesTracker['start_date']))) ?>" 
                           class="btn back-btn mr-2 text-light" style="background-color: #9c223b;">
                            <span class="svg-icon svg-icon-md">
                                <i class="fas fa-chevron-circle-left text-light mr-2"></i>
                            </span>Back</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body" style="overflow: auto;">
                    <form action="<?= base_url('sales/SalesTracker/editSalesTracker') ?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body p-0">
                            
                            <div class="form-section">
                                <h4 class="form-section-title"><i class="fas fa-info-circle mr-2"></i>Basic Information</h4>
                                
                                <div class="form-group">
                                    <label for="subject"><i class="fas fa-tag mr-1"></i> Subject</label>
                                    <input type="text" value="<?= $dataSalesTracker['subject'] ?>" placeholder="Cth : Pt. ABC" class="form-control" required name="subject">
                                    <input type="text" name="id_sales_tracker" value="<?= $dataSalesTracker['id_sales_tracker'] ?>" hidden>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description"><i class="fas fa-align-left mr-1"></i> Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="4"><?= $dataSalesTracker['description'] ?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h4 class="form-section-title"><i class="fas fa-map-marked-alt mr-2"></i>Location Details</h4>
                                
                                <div class="form-group">
                                    <label for="location"><i class="fas fa-map-pin mr-1"></i> Location</label>
                                    <input type="text" class="form-control" value="<?= $dataSalesTracker['location'] ?>" placeholder="Cth: Jl.Pahlawan no.53" required name="location">
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact"><i class="fas fa-user mr-1"></i> Contact/PIC</label>
                                    <input type="text" value="<?= $dataSalesTracker['contact'] ?>" placeholder="Cth: Kevin" class="form-control" name="contact">
                                </div>
                                
                                <?php if ($dataSalesTracker['end_date'] != NULL && !empty($dataSalesTracker['geo_location'])) { ?>
                                    <div class="form-group">
                                        <label for="gps"><i class="fas fa-location-arrow mr-1"></i> GPS Location</label>
                                        <div>
                                            <a target="_blank" href="https://maps.google.com?q=<?= $dataSalesTracker['geo_location'] ?>" class="map-link">
                                                <i class="fas fa-map-marker-alt mr-2"></i> View on Google Maps
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            
                            <div class="form-section">
                                <h4 class="form-section-title"><i class="fas fa-calendar-alt mr-2"></i>Schedule Information</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date"><i class="fas fa-hourglass-start mr-1"></i> Start Date</label>
                                            <input type="datetime-local" value="<?= date('Y-m-d\TH:i:s', strtotime($dataSalesTracker['start_date'])) ?>" class="form-control" required name="start_date">
                                        </div>
                                    </div>
                                    
                                    <?php if ($dataSalesTracker['end_date'] != NULL) { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="end_date"><i class="fas fa-hourglass-end mr-1"></i> End Date</label>
                                                <input type="datetime-local" value="<?= date('Y-m-d\TH:i:s', strtotime($dataSalesTracker['end_date'])) ?>" class="form-control" required name="end_date">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <?php if ($dataSalesTracker['end_date'] != NULL) { ?>
                                <div class="form-section">
                                    <h4 class="form-section-title"><i class="fas fa-file-alt mr-2"></i>Results & Documentation</h4>
                                    
                                    <div class="form-group">
                                        <label for="summary"><i class="fas fa-tasks mr-1"></i> Summary</label>
                                        <input type="text" value="<?= $dataSalesTracker['summary'] ?>" placeholder="Enter summary here" class="form-control" name="summary">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="image"><i class="fas fa-camera mr-1"></i> Image</label>
                                        <div class="text-center mb-3">
                                            <img class="img-fluid img-preview" src="<?= base_url('uploads/salestracker/' . $dataSalesTracker['image']) ?>" alt="<?= $dataSalesTracker['image'] ?>" style="max-width: 400px;">
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" id="attachment1" class="custom-file-input" accept="image/png, image/gif, image/jpeg" onchange="handleImageUpload(this.id);" name="photoBefore">
                                            <label class="custom-file-label" for="attachment1">Choose new image (optional)</label>
                                            <small class="form-text text-danger">*Fill only if you want to change the photo</small>
                                            <input type="file" class="form-control" id="upload_file2" name="photo" hidden>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>