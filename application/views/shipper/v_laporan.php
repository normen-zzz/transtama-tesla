<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="col-md-12">
            <form action="<?= base_url('dekan/pengajuan/laporan') ?>" method="POST">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Filter By Prodi</label>
                            <select class="form-control" name="id_prodi">
                                <option value="0">Semua Data</option>
                                <?php foreach ($jurusan as $j) {
                                ?>
                                    <option value="<?= $j['id_prodi'] ?>"><?= $j['nama_prodi'] ?></option>

                                <?php } ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="0">Pengajuan Masuk</option>
                                <option value="1">Pengajuan Validasi Baak</option>
                                <option value="2">Pengajuan Terverifikasi</option>
                                <option value="3">Pengajuan Dicetak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-8">
                        <button class="btn btn-success" type="submit">Cek</button>
                        <a href="<?= base_url('dekan/pengajuan/laporan') ?>" class="btn btn-primary">Reset Filter</a>
                    </div>
                </div>

            </form>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Laporan Pengajuan Ijazah</h2>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="overflow: auto;">
                        <table id="myTable" class="table table-bordered">
                            <!-- <a href="<?= base_url('baak/pengajuan/add') ?>" class="btn btn-success mr-2 mb-4">
                                <i class="fas fa-plus-circle"> </i>Tambah
                            </a> -->

                            <?php if (isset($id_prodi) && isset($status)) { ?>
                                <a href="<?= base_url('dekan/pengajuan/cetakLaporan/' . encrypt_url($id_prodi) . '/' . encrypt_url($status)) ?>" class="btn btn-danger mr-2 mb-4">
                                    <i class="fas fa-print"> </i>Cetak
                                </a>
                            <?php } else { ?>
                                <a href="<?= base_url('dekan/pengajuan/cetakLaporan/') ?>" class="btn btn-danger mr-2 mb-4">
                                    <i class="fas fa-print"> </i>Cetak
                                </a>
                            <?php } ?>



                            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Fakultas</th>
                                    <th>Prodi</th>
                                    <th>Tanggal Lulus</th>
                                    <th>IPK</th>
                                    <th>Status</th>
                                    <!-- <th>Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pengajuan as $p) { ?>
                                    <tr>
                                        <td><?= $p['nama_mhs'] ?></td>
                                        <td><?= $p['nim'] ?></td>
                                        <td><?= $p['fakultas'] ?></td>
                                        <td><?= $p['prodi'] ?></td>
                                        <td><?= bulan_indo($p['tgl_lulus']) ?></td>
                                        <td><?= $p['ipk'] ?></td>
                                        <td><a class="badge badge-light-danger font-weight-bold"><?= status($p['status']) ?> </a></td>


                                    </tr>
                                <?php } ?>

                            </tbody>

                        </table>
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