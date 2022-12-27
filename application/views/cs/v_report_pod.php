	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
	    <div class="container">
	        <!-- Info boxes -->
	        <div class="row">
	            <div class="col-12">
	                <div class="card">
	                    <div class="card-header">
	                        <h2 class="card-title">POD TRACKING
	                            <div class="row">
	                                <form action="<?= base_url('cs/Pod/report') ?>" method="POST">
	                                    <div class="row ml-2">
	                                        <div class="form-group mr-2">
	                                            <label>Start</label><br>
	                                            <input type="date" <?php if ($awal != NULL) { ?> value="<?= $awal ?>" <?php } ?> name="awal" id="awal" class="form-control">


	                                        </div>
	                                        <div class="form-group mr-3">
	                                            <label>End</label> <br>
	                                            <input type="date" <?php if ($akhir != NULL) { ?> value="<?= $akhir ?>" <?php } ?> name="akhir" id="akhir" class="form-control">
	                                        </div>

	                                        <div class="form-group"> <br>
	                                            <button type="submit" class="btn btn-success ml-3">Tampilkan</button>
	                                            <a href="<?= base_url('cs/Pod/export/' . $awal . '/' . $akhir) ?>" class="btn btn-primary ml-3">Export To Excel</a>

	                                        </div>
	                                    </div>

	                                </form>
	                            </div>
	                            <h2 class="text-center"><?= date('d F Y', strtotime($awal)) ?> - <?= date('d F Y', strtotime($akhir)) ?></h2>
	                    </div>

	                    <!-- /.card-header -->
	                    <div class="card-body" style="overflow: auto;">
	                        <div class="row text-center">
	                            <div class="col-xl-3 col-md-6">
	                                <h4>TOTAL SHIPMENT</h4>
	                                <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#35b8e0" data-bgColor="#98a6ad" data-max="<?= $shipment->num_rows() ?>" value="<?= $shipment->num_rows() ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" class="dial" />

	                            </div><!-- end col -->
	                            <div class="col-xl-3 col-md-6">
	                                <h4>TOTAL PENDING</h4>
	                                <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#f05050 " data-bgColor="#F9B9B9" data-max="<?= $shipment->num_rows() ?>" value="<?= $pending->num_rows() ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" class="dial" />

	                            </div><!-- end col -->
	                            <div class="col-xl-3 col-md-6">
	                                <h4>TOTAL PROSES KIRIM</h4>
	                                <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#f9c851" data-bgColor="#98a6ad" data-max="<?= $shipment->num_rows() ?>" value="<?= $proses->num_rows() ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" class="dial" />

	                            </div><!-- end col -->
	                            <div class="col-xl-3 col-md-6">
	                                <h4>TOTAL POD DITERIMA</h4>
	                                <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#10c469 " data-bgColor="#98a6ad" data-max="<?= $shipment->num_rows() ?>" value="<?= $done->num_rows() ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" class="dial" />

	                            </div><!-- end col -->

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