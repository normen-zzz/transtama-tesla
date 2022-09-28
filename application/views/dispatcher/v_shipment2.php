<!--begin::Content-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Dashboard-->
			<div class="row">
				<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
				<div class="col-md-6">
					<div class="panel-heading">
						<div class="navbar-form navbar-left">
							<h4>SCAN IN & SCAN OUT</h4>
						</div>
						<div class="navbar-form navbar-center">
							<select class="form-control" id="camera-select" style="width: 80%;"></select>
						</div>

					</div>
				</div>
				<div class="col-md-6">
					<div class="well" style="position: middle;">
						<form action="<?php echo base_url('scan1/cek_id'); ?>" method="POST">
							<canvas width="400" height="400" id="webcodecam-canvas"></canvas>
							<br>
							<input type="text" name="id_karyawan" autofocus>
							<input type="submit">
						</form>

					</div>

				</div>
				<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/scans/jquery.min.js"></script> -->

			</div><!-- /.box-body -->
		</div>


	</div>
	<!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->