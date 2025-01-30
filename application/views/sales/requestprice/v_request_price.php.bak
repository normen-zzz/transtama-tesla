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
                        <div class="row">
                            <form action="<?= base_url('sales/RequestPrice') ?>" method="POST">
                                <!-- <div class="row ml-2">
                                    <div class="form-group mr-2">
                                        <label>Start</label><br>
                                        <input type="datetime-local" <?php if ($awal != NULL) { ?> value="<?= $awal ?>" <?php } ?> name="awal" id="awal" class="form-control">


                                    </div>
                                    <div class="form-group mr-3">
                                        <label>End</label> <br>
                                        <input type="datetime-local" <?php if ($akhir != NULL) { ?> value="<?= $akhir ?>" <?php } ?> name="akhir" id="akhir" class="form-control">
                                    </div>



                                    <div class="form-group"> <br>
                                        <button type="submit" class="btn btn-success ml-3">Tampilkan</button>
                                    </div>
                                </div> -->

                            </form>
                        </div>

                    </div>




                    <div class="card-toolbar float-right">


                    <a href="#" class="btn mr-2 text-light" data-toggle="modal" data-target="#modal-import" style="background-color: #9c223b;">
															<i class="fas fa-upload text-light"> </i>
														Bulk Add
														</a>

                        <a href="<?= base_url('sales/RequestPrice/addRequestPrice') ?>" class="btn font-weight-bolder text-light" style="background-color: #9c223b;">
                            <span class="svg-icon svg-icon-md">
                                <i class="fa fa-plus text-light"></i>
                                <!--end::Svg Icon-->
                            </span>Add</a>
                        <!--end::Button-->
                    </div>
                </div>

                <div class="card-body" style="overflow: auto;">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom" id="myTable">
                        <thead>
                            <tr>
                                <!-- <th>NO</th> -->
                                <th>ID Request</th>
                                <th>Created At</th>
                                <th>Customer</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Moda</th>
                                <th>Jenis</th>
                                <th>Berat (KG)</th>
                                <th>Koli</th>
                                <th>Dimension</th>
                                <th>Price Submitted</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($detailRequestPrice->result_array() as $detailRequestPrice1) { ?>
                                <tr>
                                    <!-- <td><?= $no  ?></td> -->
                                    <td>REQP - <?= $detailRequestPrice1['id_detailrequest'] ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($detailRequestPrice1['created_at']))  ?></td>
                                    <td><?= getNameCustomer($detailRequestPrice1['customer']) ?></td>
                                    <td><?= $detailRequestPrice1['alamat_from'] . ', ' . $detailRequestPrice1['kecamatan_from'] . ', ' . $detailRequestPrice1['kota_from'] . ', ' . $detailRequestPrice1['provinsi_from'] ?></td>
                                    <td><?= $detailRequestPrice1['alamat_to'] . ', ' . $detailRequestPrice1['kecamatan_to'] . ', ' . $detailRequestPrice1['kota_to'] . ', ' . $detailRequestPrice1['provinsi_to'] ?></td>
                                    <td><?= moda($detailRequestPrice1['moda'])  ?></td>
                                    <td><?= $detailRequestPrice1['jenis'] ?></td>
                                    <td><?= $detailRequestPrice1['berat'] ?></td>
                                    <td><?= $detailRequestPrice1['koli'] ?></td>
                                    <td><?= (int)$detailRequestPrice1['panjang'] . ' X ' . (int)$detailRequestPrice1['lebar'] . ' X ' . (int)$detailRequestPrice1['tinggi'] ?><br> Air :<?= ((int)$detailRequestPrice1['panjang'] * (int)$detailRequestPrice1['lebar'] * (int)$detailRequestPrice1['tinggi']) / 6000 ?> KG<br>Land :<?= ((int)$detailRequestPrice1['panjang'] * (int)$detailRequestPrice1['lebar'] * (int)$detailRequestPrice1['tinggi']) / 4000 ?> KG</td>
                                    <td><?= rupiah($detailRequestPrice1['price']) ?> </td>
                                    <td>Sales : <?= $detailRequestPrice1['notes_sales'] ?> <br> Cs :<?= $detailRequestPrice1['notes_cs'] ?>  </td>
                                   
                                    <td><?= statusRequestPrice($detailRequestPrice1['status']).'<br>'.$detailRequestPrice1['notes_decline_cs'].$detailRequestPrice1['notes_decline_sales']  ?></td>
                                    <td><a href="<?= base_url('sales/RequestPrice/detailRequestPrice/'.$detailRequestPrice1['id_detailrequest']) ?>"  class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
                                    <?php if ($detailRequestPrice1['status'] == 0) { ?>
                                        <a href="<?= base_url('Sales/RequestPrice/deleteRequestPrice/'.$detailRequestPrice1['id_detailrequest']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Delete</a>
                                    <?php } elseif ($detailRequestPrice1['status'] == 1) {?>
                                        <a href="<?= base_url('sales/RequestPrice/confirmSales/'.$detailRequestPrice1['id_detailrequest']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Confirm</a>
                                        <button type="button" href="#" class="btn btn-sm text-light mb-1 modalDeclineSales" data-toggle="modal" data-target="#modalDeclineSales" data-id_detailrequest="<?= $detailRequestPrice1['id_detailrequest'] ?>" style="background-color: #9c223b;">Decline</button>
                                    <?php } elseif ($detailRequestPrice1['status'] == 2) { ?>
                                        <a href="<?= base_url('sales/RequestPrice/addSo/'.$detailRequestPrice1['id_detailrequest']) ?>" onclick="return confirm('Are You Sure ?')" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Create So</a>
                                   <?php  } ?>
                                       </td>
                                </tr>
                            <?php $no++;
                            } ?>

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
</div>

<div class="modal fade" id="modalDeclineSales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Decline Request Price </b> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('sales/RequestPrice/declineSales') ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row" id="content-declinesales">

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

<div class="modal fade" id="modal-import">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Import Sales Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('sales/RequestPrice/import') ?>" method="POST" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label class="col-form-label text-lg-right font-weight-bold">Upload File</label>
							<input type="file" id="input-file-now" name="upload_file" class="dropify" required />
							
						</div>
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

<script>
    $(document).ready(function() {
        $('.modalDeclineSales').click(function() {
            
            var id_detailrequest = $(this).data('id_detailrequest'); // Mendapatkan ID dari atribut data-id tombol yang diklik
            // $('#content-tracking').html('');
            // Memuat data menggunakan AJAX dengan mengirimkan ID sebagai parameter
            var content = '<div class="col">' +

                '<span>ID REQUEST : <b>REQP - ' + id_detailrequest + '</b></span>' +

                '<input type="text" name="id_detailrequest" value="' + id_detailrequest + '" hidden>' +

                
                '<div class="form-group mt-2">' +
                '<label for="notes_decline_sales">Notes Decline</label>' +
                ' <textarea name="notes_decline_sales" id="notes_decline_sales" class="form-control"></textarea>' +
                '</div>' +
                '</div>';
            $('#content-declinesales').html(content);




        });
    })
</script>