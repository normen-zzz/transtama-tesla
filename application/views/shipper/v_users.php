<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <!-- <h5 class="text-dark font-weight-bold my-1 mr-5">Tugas <?= $class['nama_kelas']; ?></h5> -->
                    <!--end::Page Title-->

                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message') ?>"></div>

                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->

            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Education-->
            <div class="d-flex flex-row">
                <!--begin::Aside-->
                <div class="flex-row-auto offcanvas-mobile w-300px w-xl-325px" id="kt_profile_aside">
                    <!--begin::Nav Panel Widget 4-->
                    <div class="card card-custom gutter-b">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Wrapper-->
                            <div class="d-flex justify-content-between flex-column h-100">
                                <!--begin::Container-->
                                <div class="h-100">
                                    <!--begin::Header-->
                                    <div class="d-flex flex-column flex-center">
                                        <!--begin::Image-->
                                        <!-- <div class="bgi-no-repeat bgi-size-cover rounded min-h-180px w-100" style="background-image: url(<?= base_url('assets/back/metronic/') ?>media/stock-600x400/img-72.jpg)"></div> -->
                                        <!--end::Image-->
                                        <!--begin::Title-->
                                        <a href="#" class="card-title font-weight-bolder text-dark-75 text-hover-primary font-size-h4 m-0 pt-7 pb-1">Mahasiswa </a>
                                        <a href="#" class="card-title font-weight-bolder text-dark-75 text-hover-primary font-size-h4 m-0 pt-7 pb-1"><?= $kelas['nama_kelas']; ?></a>
                                        <!--end::Title-->
                                        <!--begin::Text-->
                                        <div class="font-weight-bold text-dark-50 font-size-sm pb-7"><?= $kelas['hari']; ?>, <?= $kelas['jam_mulai']; ?> - <?= $kelas['jam_selesai']; ?></div>
                                        <!--end::Text-->
                                        <a href="<?= base_url('dosen/classes/detail/' . $kelas['kode_kelas']) ?>" class="card-title text-hover-primary font-size-h4 m-0 pt-7 pb-1">Kembali Ke Kelas</a>
                                    </div>
                                    <!--end::Header-->

                                </div>
                                <!--eng::Container-->

                            </div>

                            <!--end::Wrapper-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Nav Panel Widget 4-->

                </div>
                <!--end::Aside-->
                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-8">
                    <div class="row">
                        <div class="col-xxl-6">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <h4>List Mahasiswa</h4>
                                        <a href="#" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus"></i></a>

                                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                                        <thead>
                                            <tr>
                                                <th>Nama Mahasiswa</th>
                                                <th>Tanggal Bergabung Kelas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $t) { ?>
                                                <tr>
                                                    <td><?= $t['nama_user'] ?></td>
                                                    <td><?= $t['join_at'] ?></td>
                                                    <td>
                                                        <a onclick="return confirm('Apakah anda yakin ?')" href="<?= base_url('dosen/classes/deleteUser/' . encrypt_url($t['id_join_kelas']) . '/' . encrypt_url($t['id_kelas'])) ?>" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>

                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Nama Mahasiswa</th>
                                                <th>Tanggal Bergabung Kelas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!--begin::Forms Widget 8-->

                        </div>

                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Education-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->
</div>


<!-- add Materi -->
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Mahasiswa Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card card-custom">
                <!--begin::Form-->
                <form action="<?= base_url('dosen/classes/joinClass') ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" hidden name="id_kelas" value="<?= $kelas['id_kelas']; ?>">
                            <input type="text" class="form-control" hidden name="kode_kelas" value="<?= $kelas['kode_kelas']; ?>">
                        </div>

                        <table id="myTable2" class="table table-bordered no-footer">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>Pilih Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allUsers as $all) { ?>
                                    <tr>
                                        <td><?= $all['nama_user'] ?></td>
                                        <td>
                                            <label class="checkbox checkbox-single">
                                                <input type="checkbox" class="group-checkable" name="id_user[]" value="<?= $all['id_user']; ?>">
                                                <span></span>
                                            </label>

                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>Pilih Mahasiswa</th>
                                </tr>
                            </tfoot>
                        </table>


                    </div>
                    <div class=" card-footer">

                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>

                    </div>
                </form>
            </div>
            <!--end::Form-->
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- /.modal -->