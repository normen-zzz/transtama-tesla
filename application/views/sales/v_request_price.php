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
                                <div class="row ml-2">
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
                                </div>

                            </form>
                        </div>

                    </div>




                    <div class="card-toolbar float-right">

                        <!--begin::Button-->
                        <a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#addRequestBulk" style="background-color: #9c223b;">
                            <span class="svg-icon svg-icon-md">
                                <i class="fa fa-plus text-light"></i>
                                <!--end::Svg Icon-->
                            </span>Add Bulk</a>
                        <a href="#" class="btn font-weight-bolder text-light" data-toggle="modal" data-target="#modal-lg" style="background-color: #9c223b;">
                            <span class="svg-icon svg-icon-md">
                                <i class="fa fa-plus text-light"></i>
                                <!--end::Svg Icon-->
                            </span>Add</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="col-md-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">On Request</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Approved</a>
                        </div>
                    </nav>
                </div>
                <div class="card-body" style="overflow: auto;">

                    <div class="col-md-12">

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <table class="table table-separate table-head-custom table-checkable" id="myTable">

                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Moda</th>
                                            <th>Weight</th>
                                            <th>Collie</th>
                                            <th>Commodity</th>
                                            <th>Dimension (P x L x T) CM</th>
                                            <th>Notes Sales</th>
                                            <th>Notes Cs</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requestPrice->result_array() as $requestPrice1) { ?>
                                            <tr>
                                                <td><?= date('d F Y H:i:s', strtotime($requestPrice1['date_request'])) ?></td>
                                                <td><?= $requestPrice1['subdistrict_from'] . ', ' .  $requestPrice1['city_from'] . ', ' . $requestPrice1['province_from']  ?></td>
                                                <td><?= $requestPrice1['subdistrict_to'] . ', ' .  $requestPrice1['city_to'] . ', ' . $requestPrice1['province_to']  ?></td>
                                                <td><?= $requestPrice1['moda'] ?></td>
                                                <td><?= $requestPrice1['berat'] ?></td>
                                                <td><?= $requestPrice1['koli'] ?></td>
                                                <td><?= $requestPrice1['komoditi'] ?></td>
                                                <td><?= $requestPrice1['panjang'] . ' x ' . $requestPrice1['lebar'] . ' x ' . $requestPrice1['tinggi'] ?></td>
                                                <td><?= $requestPrice1['notes_sales'] ?></td>
                                                <td><?= $requestPrice1['notes_cs'] ?></td>
                                                <td>
                                                    <?php if ($requestPrice1['is_bulk'] == 1) {?>
                                                        <a href="#" class="btn font-weight-bolder text-light"  style="background-color: #9c223b;">
                                                        Detail</a>
                                                   <?php  } else{ ?>
                                                    <button  class="btn font-weight-bolder text-light modalEditRequest" data-toggle="modal" data-id_request="<?= $requestPrice1['id_request_price'] ?>" data-target="#modal-edit-request" style="background-color: #9c223b;">
                                                        Edit</button>
                                                    <?php } ?>
                                                   
                                                </td>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table class="table table-separate table-head-custom table-checkable" id="myTable2">

                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Moda</th>
                                            <th>Weight</th>
                                            <th>Collie</th>
                                            <th>Commodity</th>
                                            <th>Dimension (P x L x T) CM</th>
                                            <th>Notes Sales</th>
                                            <th>Price Approved</th>
                                            <th>Notes Cs</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requestPriceApprove->result_array() as $requestPriceApprove1) { ?>
                                            <tr>
                                                <td><?= date('d F Y H:i:s', strtotime($requestPriceApprove1['date_request'])) ?></td>
                                                <td><?= $requestPriceApprove1['alamat_from'] . ' ' .  $requestPriceApprove1['city_from'] . ', ' . $requestPriceApprove1['province_from']  ?></td>
                                                <td><?= $requestPriceApprove1['alamat_to'] . ' ' .  $requestPriceApprove1['city_to'] . ', ' .  $requestPriceApprove1['province_to'] ?></td>
                                                <td><?= $requestPriceApprove1['moda'] ?></td>
                                                <td><?= $requestPriceApprove1['berat'] ?></td>
                                                <td><?= $requestPriceApprove1['koli'] ?></td>
                                                <td><?= $requestPriceApprove1['komoditi'] ?></td>
                                                <td><?= $requestPriceApprove1['panjang'] . ' x ' . $requestPriceApprove1['lebar'] . ' x ' . $requestPriceApprove1['tinggi'] ?></td>
                                                <td><?= $requestPriceApprove1['notes_sales'] ?></td>
                                                <td><?= rupiah($requestPriceApprove1['price']) ?></td>
                                                <td><?= $requestPriceApprove1['notes_cs'] ?></td>
                                                <!-- <td><a data-toggle="modal" data-target="#modal-lg<?= $requestPriceApprove1['id_request_price'] ?>" class="btn btn-primary ml-2 mt-2">Add Price</a></td> -->
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--begin: Datatable-->

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
                <h4 class="modal-title">New Request Price</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('sales/RequestPrice/addNewRequest') ?>" method="POST">
                    <div class="card-body">
                        <input type="text" placeholder="Cth : Pt. ABC" class="form-control" value="<?= $this->session->userdata('id_user') ?>" hidden name="sales">

                        <div class="row">
                            From
                        </div>
                        <div class="row">

                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Provinsi <span style="color: red;">*</span></label>
                                    <select name="provinsi_from" required id="provinsi" class="form-control" style="width:200px">
                                        <option value="">PIlih Provinsi</option>
                                        <?php foreach ($provinsi as $provinsi1) {
                                        ?>

                                            <option data-id_prov="<?= $provinsi1->id ?>" value="<?= $provinsi1->name ?>"><?= $provinsi1->name ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kabupaten <span style="color: red;">*</span></label>
                                    <select name="kabupaten_from" required id="kabupaten" class="form-control" style="width:200px">
                                        <option value="">Pilih Kabupaten</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kecamatan <span style="color: red;">*</span></label>
                                    <select required name="kecamatan_from" id="kecamatan" class="form-control" style="width:200px">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>

                                </div>
                            </div>



                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Alamat From</label>
                            <textarea class="form-control" name="alamat_from" id="alamat_from"></textarea>

                        </div>

                        <div class="row">
                            To
                        </div>
                        <div class="row">

                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Provinsi <span style="color: red;">*</span></label>
                                    <select required name="provinsi_to" id="provinsi1" class="form-control" style="width:200px">
                                        <option value="">PIlih Provinsi</option>
                                        <?php foreach ($provinsi as $provinsi1) {
                                        ?>

                                            <option data-id_prov="<?= $provinsi1->id ?>" value="<?= $provinsi1->name ?>"><?= $provinsi1->name ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kabupaten <span style="color: red;">*</span></label>
                                    <select required name="kabupaten_to" id="kabupaten1" class="form-control" style="width:200px">
                                        <option value="">Pilih Kabupaten</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kecamatan <span style="color: red;">*</span></label>
                                    <select required name="kecamatan_to" id="kecamatan1" class="form-control" style="width:200px">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>

                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Alamat To</label>
                            <textarea class="form-control" name="alamat_to" id="alamat_to"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Moda</label>
                            <input type="text" class="form-control" name="moda" id="moda"></input>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Jenis Barang</label>
                            <input type="text" class="form-control" name="jenis" id="jenis"></input>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Berat (KG)</label>
                            <input type="text" class="form-control" name="berat" id="berat"></input>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Koli</label>
                            <input type="text" class="form-control" name="koli" id="koli"></input>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Commodity</label>
                            <input type="text" class="form-control" name="komoditi" id="komoditi"></input>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Panjang (Cm)</label>
                            <input type="text" class="form-control" name="panjang" id="panjang"></input>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Lebar (Cm)</label>
                            <input type="text" class="form-control" name="lebar" id="lebar"></input>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tinggi (Cm)</label>
                            <input type="text" class="form-control" name="tinggi" id="tinggi"></input>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Notes</label>
                            <textarea class="form-control" name="notes" id="notes"></textarea>
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


<div class="modal fade" id="modal-edit-request">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Request Price</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('sales/RequestPrice/editRequest') ?>" method="POST">
                    <div class="card-body">
                        <div id="contentEditRequest">

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


<div class="modal fade" id="addRequestBulk">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Request Bulk</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<a href="<?= base_url('sales/RequestPrice/createExcelTemplate') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
					<i class="fas fa-download text-light"> </i>
					Download Template
				</a>

				<div class="card-body">



					<form id="kt_form" novalidate="novalidate" action="<?= base_url('sales/RequestPrice/importRequestPrice') ?>" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label class="col-form-label text-lg-right font-weight-bold">Upload File</label>
							<input type="file" id="input-file-now" required name="upload_file" class="dropify" />
						</div>
						<button type="submit" class="btn mr-2 text-light" style="background-color: #9c223b;">Submit</button>
					</form>
				</div>
			</div>
		</div>
		<div class="modal-footer justify-content-between">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

		</div>

	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function() {
        $('.modalEditRequest').click(function() {
            var id_request = $(this).data('id_request'); // Mendapatkan ID dari atribut data-id tombol yang diklik
            $('#contentEditRequest').html('');
            // Memuat data menggunakan AJAX dengan mengirimkan ID sebagai parameter
            $.ajax({
                url: '<?php echo base_url("sales/RequestPrice/getModalEditRequest"); ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    id_request: id_request
                },
                success: function(response) {
                    // Menampilkan data ke dalam modal
                    var content = '<input type="text" placeholder="Cth : Pt. ABC" class="form-control" value="<?= $this->session->userdata('id_user') ?>" hidden name="sales">' +
                        '<div class="row">' +
                        '<p>' +
                        '**Isi Alamat Jika Ingin Mengubah**' +
                        '</p>' +
                        '</div>' +
                        '<div class="row">' +
                        'From' +
                        '</div>' +
                        '<div class="row">' +
                        '<p>' +
                        'Latest :' + response.subdistrict_from + ' ' + response.city_from + ' ' + response.province_from +
                        '</p>' +
                        '</div>' +
                        '<div class="row">' +

                        '<div class="col">' +
                        '<div class="form-group">' +
                        '<label for="exampleInputEmail1">Provinsi <span style="color: red;">*</span></label>' +
                        '<select name="provinsi_from" id="provinsiModal" class="form-control selectField provinsiModal" style="width:200px">' +
                        '<option value="">PIlih Provinsi</option>' +
                        <?php foreach ($provinsi as $provinsi1) {
                        ?>

                    '<option data-id_prov="<?= $provinsi1->id ?>" value="<?= $provinsi1->name ?>"><?= $provinsi1->name ?></option>' +
                <?php } ?>
                    '</select>' +

                    '</div>' +
                    '</div>' +
                    '<div class="col">' +
                    '<div class="form-group">' +
                    '<label for="exampleInputEmail1">Kabupaten <span style="color: red;">*</span></label>' +
                    '<select name="kabupaten_from" id="kabupatenModal" class="form-control selectField kabupatenModal" style="width:200px">' +
                    '<option value="">Pilih Kabupaten</option>' +
                    '</select>' +

                    '</div>' +
                    '</div>' +

                    '<div class="col">' +
                    '<div class="form-group">' +
                    '<label for="exampleInputEmail1">Kecamatan <span style="color: red;">*</span></label>' +
                    '<select name="kecamatan_from" id="kecamatanModal" class="form-control selectField kecamatanModal" style="width:200px">' +
                    '<option value="">Pilih Kecamatan</option>' +
                    '</select>' +

                    '</div>' +
                    '</div>' +
                    

                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Alamat From</label>' +
                    '<textarea class="form-control" name="alamat_from" id="alamat_from">' + response.alamat_from + '</textarea>' +

                    '</div>' +
                    '<div class="row">' +
                    'To' +
                    '</div>' +
                    '<div class="row">' +
                    '<p>' +
                    'Latest :' + response.subdistrict_to + ' ' + response.city_to + ' ' + response.province_to +
                    '</p>' +
                    '</div>' +
                    '<div class="row">' +

                    '<div class="col">' +
                    '<div class="form-group">' +
                    '<label for="exampleInputEmail1">Provinsi <span style="color: red;">*</span></label>' +
                    '<select name="provinsi_to" id="provinsi1Modal" class="form-control selectField provinsi1Modal" style="width:200px">' +
                    '<option value="">PIlih Provinsi</option>' +
                    <?php foreach ($provinsi as $provinsi1) {
                    ?>

                '<option data-id_prov="<?= $provinsi1->id ?>" value="<?= $provinsi1->name ?>"><?= $provinsi1->name ?></option>' +
                <?php } ?>
                    '</select>' +

                    '</div>' +
                    '</div>' +
                    '<div class="col">' +
                    '<div class="form-group">' +
                    '<label for="exampleInputEmail1">Kabupaten <span style="color: red;">*</span></label>' +
                    '<select name="kabupaten_to" id="kabupaten1Modal" class="form-control selectField kabupaten1Modal" style="width:200px">' +
                    '<option value="">Pilih Kabupaten</option>' +
                    '</select>' +

                    '</div>' +
                    '</div>' +

                    '<div class="col">' +
                    '<div class="form-group">' +

                    '<label for="exampleInputEmail1">Kecamatan <span style="color: red;">*</span></label>' +
                    '<select name="kecamatan_to" id="kecamatan1Modal" class="form-control selectField kecamatan1Modal" style="width:200px">' +
                    '<option value="">Pilih Kecamatan</option>' +
                    '</select>' +

                    '</div>' +
                    '</div>' +

                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Alamat From</label>' +
                    '<textarea class="form-control" name="alamat_to" id="alamat_to">' + response.alamat_to + '</textarea>' +

                    '</div>' +

                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Moda</label>' +
                    '<input type="text" class="form-control" name="moda" value="' + response.moda + '" id="moda"></input>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Jenis Barang</label>' +
                    '<input type="text" class="form-control" name="jenis" value="' + response.jenis_barang + '" id="jenis"></input>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Berat (KG)</label>' +
                    '<input type="text" class="form-control" name="berat" value="' + response.berat + '" id="berat"></input>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Koli</label>' +
                    '<input type="text" class="form-control" name="koli" value="' + response.koli + '" id="koli"></input>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Commodity</label>' +
                    '<input type="text" class="form-control" name="komoditi" value="' + response.komoditi + '" id="komoditi"></input>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Panjang (Cm)</label>' +
                    '<input type="text" class="form-control" name="panjang" value="' + response.panjang + '" id="panjang"></input>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Lebar (Cm)</label>' +
                    '<input type="text" class="form-control" name="lebar" value="' + response.lebar + '" id="lebar"></input>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Tinggi (Cm)</label>' +
                    '<input type="text" class="form-control" name="tinggi" value="' + response.tinggi + '" id="tinggi"></input>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<label for="exampleInputPassword1">Notes</label>' +
                    '<textarea class="form-control" name="notes" value="' + response.notes_sales + '" id="notes"></textarea>' +
                    '</div>';
                $('#contentEditRequest').html(content);
                $('.selectField').select2();

                $(".provinsiModal").change(function() {
                    // $("#modalLoading").modal("show");
                    var url = "<?php echo site_url('sales/RequestPrice/getKabupaten'); ?>/" + $(this).find(':selected').data('id_prov');
                    $('.kabupatenModal').load(url);
                    var kecamatan = "<?php echo site_url('sales/RequestPrice/getKecamatan'); ?>/";
                    $('.kecamatanModal').load(kecamatan);
                    // setTimeout(function() {
                    // 	// $('#modalLoading').modal('hide')
                    // }, 500);



                    return false;
                })

                $(".kabupatenModal").change(function() {
                    // $("#modalLoading").modal("show");
                    var url = "<?php echo site_url('sales/RequestPrice/getKecamatan'); ?>/" + $(this).find(':selected').data('id_prov') + "/" + $(this).find(':selected').data('id_kab');
                    $('.kecamatanModal').load(url);
                    // setTimeout(function() {
                    // 	$('#modalLoading').modal('hide')
                    // }, 500);
                    return false;
                })

                $(".provinsi1Modal").change(function() {
                    // $("#modalLoading").modal("show");
                    var url = "<?php echo site_url('sales/RequestPrice/getKabupaten'); ?>/" + $(this).find(':selected').data('id_prov');
                    $('.kabupaten1Modal').load(url);
                    var kecamatan = "<?php echo site_url('sales/RequestPrice/getKecamatan'); ?>/";
                    $('.kecamatan1Modal').load(kecamatan);
                    // setTimeout(function() {
                    // 	$('#modalLoading').modal('hide')
                    // }, 500);

                    return false;
                })

                $(".kabupaten1Modal").change(function() {
                    // $("#modalLoading").modal("show");
                    var url = "<?php echo site_url('sales/RequestPrice/getKecamatan'); ?>/" + $(this).find(':selected').data('id_prov') + "/" + $(this).find(':selected').data('id_kab');
                    $('.kecamatan1Modal').load(url);
                    // setTimeout(function() {
                    // 	$('#modalLoading').modal('hide')
                    // }, 500);
                    return false;
                })

                },
                error: function() {
                    alert('Terjadi kesalahan dalam memuat data.');
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {



    });
</script>