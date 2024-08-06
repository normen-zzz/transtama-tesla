	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
	    <div class="container">
	        <!-- Info boxes -->
	        <div class="row">


	            <div class="col-12">
	                <div class="card card-custom gutter-b">
	                    <div class="card-body">
	                        <form action="<?= base_url('shipper/SalesOrder/processDeliveryCharter/' . $shipment_id) ?>" method="POST">
	                            <h3><b> Delivery Charter/SDS DETAIL</b></h3>
	                            <p><b>Resi : <?= $shipment_id ?></b></p>
	                            <span>Tanggal Diterima</span>
	                            <input class="form-control" type="datetime-local" name="tgl_diterima" id="tgl_diterima">
	                            <br>
	                            <span>Penerima</span>
	                            <input class="form-control" type="text" name="penerima" id="penerima" placeholder="nama penerima">
                                <br>
                                <button type="submit" class="btn btn-primary">Submit</button>
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>



	    </div>
	    <!-- /.card -->
	    </div>
	    <!--/. container-fluid -->
	</section>
	<!-- /.content -->