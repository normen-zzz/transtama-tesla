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
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/RequestPrice') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
									<i class="fas fa-chevron-circle-left text-light"> </i>
									Back
								</a>
							</div>




                  
                </div>
              
                <div class="card-body" style="overflow: auto;">

                    <div class="col-md-12">

                        
                                <table class="table table-separate table-head-custom table-checkable" id="myTable">

                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('error_upload'); ?>"></div>
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Moda</th>
                                            <th>Weight</th>
                                            <th>Collie</th>
                                            <th>Commodity</th>
                                            <th>Dimension (P x L x T) CM</th>
                                            <th>Notes Sales</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requestPrice->result_array() as $requestPrice1) { ?>
                                            <tr>
                                                <td><?= $requestPrice1['code_request_price'] ?></td>
                                                <td><?= date('d F Y H:i:s', strtotime($requestPrice1['date_request'])) ?></td>
                                                <td><?= $requestPrice1['subdistrict_from'] . ', ' .  $requestPrice1['city_from'] . ', ' . $requestPrice1['province_from']  ?></td>
                                                <td><?= $requestPrice1['subdistrict_to'] . ', ' .  $requestPrice1['city_to'] . ', ' . $requestPrice1['province_to']  ?></td>
                                                <td><?= ($requestPrice1['moda'] != NULL) ? $requestPrice1['moda'] : '-' ?></td>
                                                <td><?= ($requestPrice1['berat'] != NULL) ? $requestPrice1['berat'] : '-' ?></td>
                                                <td><?= ($requestPrice1['koli'] != NULL) ? $requestPrice1['koli'] : '-' ?></td>
                                                <td><?= ($requestPrice1['komoditi'] != NULL) ? $requestPrice1['komoditi'] : '-' ?></td>
                                                <td><?= $requestPrice1['panjang'] . ' x ' . $requestPrice1['lebar'] . ' x ' . $requestPrice1['tinggi'] ?></td>
                                                <td><?=  ($requestPrice1['notes_sales'] != NULL) ? $requestPrice1['notes_sales'] : '-'  ?></td>

                                                <td>
                                                <button class="btn font-weight-bolder text-light modalEditRequest" data-toggle="modal" data-id_request="<?= $requestPrice1['id_request_price'] ?>" data-target="#modal-edit-request" style="background-color: #9c223b;">
                                                            Edit</button>

                                                </td>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            
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


<!-- modal Tambah Request  -->
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
                            <span style="color: red;">* </span>: Wajib Diisi
                        </div>
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
                            <input required type="text" class="form-control" name="jenis" id="jenis"></input>
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
                <form action="<?= base_url('sales/RequestPrice/editRequestBulk') ?>" method="POST">
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
                    '<input type="text" class="form-control" value="'+id_request+'" hidden name="id_request">' +
                    '<input type="text" class="form-control" value="'+response.code_request_price+'" hidden name="code">' +
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
                    '<textarea class="form-control" name="notes"  id="notes">'+response.notes_sales+'</textarea>' +
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