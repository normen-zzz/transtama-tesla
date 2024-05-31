<style>
    .select2-selection__rendered {
        font-size: 12px;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12">
                <div class="card card-custom card-stretch">
                    <div class="card-header py-3">
                        <div class="card-title align-items-start flex-column">
                            <h3 class="card-label font-weight-bolder text-dark">Add Request Pickup</h3>
                        </div>
                        <div class="card-toolbar">
                            <a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder') ?>" class="btn mr-2 text-light" style="background-color: #9c223b;">
                                <i class="fas fa-chevron-circle-left text-light"> </i>
                                Cancel
                            </a>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="overflow: auto;">
                        <div class="card-body p-0">
                            <!--begin: Wizard-->

                            <!--begin: Wizard Body-->
                            <div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
                                <div class="col col-sm-12">
                                    <!--begin: Wizard Form-->
                                    <form id="kt_form" novalidate="novalidate" action="<?= base_url('sales/requestPrice/processEditRequestPrice') ?>" method="POST" enctype="multipart/form-data">

                                        <div style="margin-top: -65px;">

                                            <div id="formRequest">
                                                <label for="exampleInputEmail1"><b>Customer</b><span style="color: red;">*</span></label>
                                                <select name="customer" class="form-control">
                                                    <?php foreach ($customer->result_array() as $customer1) {
                                                    ?>
                                                        <option value="<?= $customer1['id_customer'] ?>" <?php if ($customer1['id_customer'] == $detailRequestPrice['customer']) {
                                                                                                                echo 'selected';
                                                                                                            } ?>><?= $customer1['nama_pt'] ?></option>
                                                    <?php  } ?>
                                                </select>
                                                <h4 class="mb-10 font-weight-bold text-dark mt-4"><b>
                                                        <div id="nomorKolom">INFORMATION 1</div></b>
                                                   

                                                    <div class="row border mt-4">
                                                        <div class="col-md-12"> <label class="font-weight-bold mt-2" for="">FROM</label></div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">

                                                                <label for="exampleInputEmail1">Provinsi<span style="color: red;">*</span></label>
                                                                <select name="provinsi_from" class="form-control">
                                                                    <?php foreach ($provinsi->result_array() as $provinsi1) {
                                                                    ?>
                                                                        <option value="<?= $provinsi1['name'] ?>" <?php if ($provinsi1['name'] == $detailRequestPrice['provinsi_from']) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?= $provinsi1['name'] ?></option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Kabupaten/Kota<span style="color: red;">*</span></label>
                                                                <select name="kota_from" class="form-control">
                                                                    <?php foreach ($kota->result_array() as $kota1) {
                                                                    ?>
                                                                        <option value="<?= $kota1['city_name'] ?>" <?php if ($kota1['city_name'] == $detailRequestPrice['kota_from']) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?= $kota1['city_name'] ?></option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Kecamatan<span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="kecamatan_from" required name="kecamatan_from" value="<?= $detailRequestPrice['kecamatan_from'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Alamat<span style="color: red;">*</span></label>

                                                                <textarea class="form-control" name="alamat_from" id="alamat" cols="30" rows="2"><?= $detailRequestPrice['alamat_from'] ?></textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row border mt-4">
                                                        <div class="col-md-12"> <label class="font-weight-bold mt-2" for="">TO</label></div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Provinsi<span style="color: red;">*</span></label>
                                                                <select name="provinsi_to" class="form-control">
                                                                    <?php foreach ($provinsi->result_array() as $provinsi1) {
                                                                    ?>
                                                                        <option value="<?= $provinsi1['name'] ?>" <?php if ($provinsi1['name'] == $detailRequestPrice['provinsi_to']) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?= $provinsi1['name'] ?></option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Kabupaten/Kota<span style="color: red;">*</span></label>
                                                                <select name="kota_to" class="form-control">
                                                                    <?php foreach ($kota->result_array() as $kota1) {
                                                                    ?>
                                                                        <option value="<?= $kota1['city_name'] ?>" <?php if ($kota1['city_name'] == $detailRequestPrice['kota_to']) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?= $kota1['city_name'] ?></option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Kecamatan<span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="kecamatan_to" required name="kecamatan_to" value="<?= $detailRequestPrice['kecamatan_to'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Alamat<span style="color: red;">*</span></label>

                                                                <textarea class="form-control" name="alamat_to" id="alamat_to" cols="30" rows="2"><?= $detailRequestPrice['alamat_to'] ?></textarea>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Moda</label>
                                                                <select name="moda" class="form-control">
                                                                    <?php foreach ($moda->result_array() as $moda1) {
                                                                    ?>
                                                                        <option value="<?= $moda1['id_moda'] ?>" <?php if ($moda1['id_moda'] == $detailRequestPrice['moda']) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?= $moda1['nama_moda'] ?></option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Jenis Barang</label>
                                                                <input type="text" class="form-control" required name="jenis" value="<?= $detailRequestPrice['jenis'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Berat (KG)</label>
                                                                <input type="number" class="form-control" required name="berat" value="<?= $detailRequestPrice['berat'] ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Koli</label>
                                                                <input type="text" class="form-control" required name="koli" value="<?= $detailRequestPrice['koli'] ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Panjang (CM)</label>
                                                                <input type="text" class="form-control" required name="panjang" value="<?= $detailRequestPrice['panjang'] ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Lebar (CM)</label>
                                                                <input type="text" class="form-control" required name="lebar" value="<?= $detailRequestPrice['lebar'] ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Tinggi (CM)</label>
                                                                <input type="text" class="form-control" required name="tinggi" value="<?= $detailRequestPrice['tinggi'] ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Notes</label>
                                                                <textarea class="form-control" name="notes" id="notes" cols="30" rows="2"><?= $detailRequestPrice['notes_sales'] ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                            </div>
                                           

                                        </div>

                                        <div class="d-flex justify-content-between border-top mt-5 pt-10">

                                            <div>
                                                <button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn font-weight-bolder text-uppercase px-9 py-4 text-light" data-wizard-type="action-submit" style="background-color: #9c223b;">Submit</button>
                                            </div>
                                        </div>
                                        <!--end: Wizard Actions-->
                                    </form>
                                    <!--end: Wizard Form-->
                                </div>
                            </div>
                            <!--end: Wizard Body-->

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

