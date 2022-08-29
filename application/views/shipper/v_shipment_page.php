	<!-- Main content -->
	<section class="content d-flex flex-column flex-column-fluid" id="kt_content">
	    <div class="container">
	        <!-- Info boxes -->
	        <div class="row">
	            <h1>Data <strong>Mahasiswa</strong></h1>

	            <table class="table table-striped">
	                <thead>
	                    <tr>
	                        <th>ShipmentID</th>
	                        <th>NAMA</th>
	                        <th>PRODI</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <!--Fetch data dari database-->
	                    <?php foreach ($data->result() as $row) : ?>
	                        <tr>
	                            <td><?php echo $row->shipment_id; ?></td>
	                            <td><?php echo $row->shipper; ?></td>
	                            <td><?php echo $row->destination; ?></td>
	                        </tr>
	                    <?php endforeach; ?>
	                </tbody>
	            </table>
	            <div class="row">
	                <div class="col">
	                    <!--Tampilkan pagination-->
	                    <?php echo $pagination; ?>
	                </div>
	            </div>
	        </div>

	        <!-- /.card -->
	    </div>
	    <!--/. container-fluid -->
	</section>
	<!-- /.content -->