<!--begin::Content-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
<script type="text/javascript">
	function showHideRow(row) {
		$('#' + row).toggle();
		var icon = document.getElementById('icon' + row);
		icon.classList.toggle('fa-chevron-right');
		icon.classList.toggle('fa-chevron-down');
	}
</script>
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
						<form action="<?= base_url('dispatcher/Scan/processSubmitHistory') ?>" method="post">
						
								<div class="row mb-5 ml-2" id="hide" style="visibility:hidden" >
									<div class="col-xs-12 ml-2">
										<label for="Panjang">Flight No</label>
										<input type="text" name="no_flight" class="form-control" placeholder="Ex: GA-077">
									</div>
									<div class="col-xs-12 ml-2">
										<label for="Lebar">No Smu</label>
										<input type="text" name="no_smu" class="form-control" placeholder="No Smu">
									</div>
									<div class="col-xs-12 ml-2">
										<label for="Lebar">Status</label>
										<input type="text" name="status_flight" class="form-control" placeholder="Status">
									</div>

									<div class="col-xs-12 ml-2">
										<label for="Berat">ETD</label>
										<input type="datetime-local" name="etd" class="form-control"  placeholder="ETD">
									</div>
									<div class="col-xs-12 ml-2">
										<label for="Berat">ETA</label>
										<input type="datetime-local" name="eta" class="form-control"  placeholder="ETA">
									</div>

									

								</div>
								<button type="submit" id="submitMerge" style="visibility:hidden" class="btn btn-primary mb-2 ml-4">Submit</button>
                        <div class="row m-4" style="overflow: auto;">
                            <div class="col-md-12">
                            <table id="mytablehistorydispatcherr" class="table table-bordered datatabledispatcher">
								
								<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
								<p style="color:red"><?= $this->session->flashdata('message'); ?></p>
								<thead>
									<tr>
										<th style="width: 15%;">#</th>
										<th style="width: 15%;">Shipment Id</th>
										<th style="width: 15%">Date</th>
										<th style="width: 15%;">Shipper</th>
										<th style="width: 15%;">Consignee</th>
										<th style="width: 15%;">Note</th>
										<th >Detail</th>

										<th style="width: 15%;">Execution Status</th>
										
									</tr>
								</thead>
								<tbody>

								<?php foreach ($order as $order1 ) {?>

								<tr>
									<?php if ($order1['no_flight'] == NULL) {?>
									<td><input type="checkbox" class="form-control" onchange="checkTotalCheckedBoxesDispatcher()" id="check" name="shipment_id[]" value="<?= $order1['shipment_id'] ?>"></td>
									<?php } else{ ?>
										<td><input type="checkbox" disabled class="form-control" onchange="checkTotalCheckedBoxesDispatcher()" id="check" name="shipment_id[]" value="<?= $order1['shipment_id'] ?>"></td>
										<?php } ?>
									<td><?= $order1['shipment_id'] ?></td>
									<td><?= $order1['created_at'] ?></td>
									<td><?= $order1['shipper'] ?></td>
									<td><?= $order1['consigne'] ?></td>
									<td><?= $order1['sts'] ?></td>
									<td><?php if ($order1['no_flight'] != NULL) {
										
									?><?= $order1['no_flight'].' / SMU: '.$order1['no_smu'].'/ ETD: '.date('d M Y H:i:s',strtotime($order1['etd'])) .'/ ETA: '.date('d M Y H:i:s',strtotime($order1['eta']))  ?><?php } ?></td>
									<td><?php if ($order1['status_eksekusi'] == 1) { ?>
										<span class="btn btn-sm btn-success">Success</span><?php } else{ ?> <span class="btn btn-sm btn-danger">Pending</span><?php } ?></td>
										
									
								</tr>
								<?php } ?>

								</tbody>

							</table>
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
