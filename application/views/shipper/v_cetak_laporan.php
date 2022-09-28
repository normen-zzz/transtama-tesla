<center>
    <h4>LAPORAN PENDAFTARAN IJAZAH</h4>
</center>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
            <!-- <th>NIK</th> -->
            <!-- <th>No.HP</th> -->
            <th>Fakultas</th>
            <th>Prodi</th>
            <th>Tanggal Lulus</th>
            <th>No. Ijazah</th>
            <th>IPK</th>
            <th>Status</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($pengajuan as $p) { ?>
            <tr>
                <td><?= $p['nama_mhs'] ?></td>
                <td><?= $p['nim'] ?></td>
                <td><?= $p['email'] ?></td>
                <!-- <td><?= $p['nik'] ?></td> -->
                <!-- <td><?= $p['no_hp'] ?></td> -->
                <td><?= $p['fakultas'] ?></td>
                <td><?= $p['prodi'] ?></td>
                <td><?= bulan_indo($p['tgl_lulus']) ?></td>
                <td><?= $p['no_ijazah'] ?></td>
                <td><?= $p['ipk'] ?></td>
                <td><a class="badge badge-light-danger font-weight-bold"><?= status($p['status']) ?> </a></td>


                </td>
            </tr>
        <?php } ?>

    </tbody>

</table>