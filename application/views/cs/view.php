<table border="1" class="table table-bordered" cellpadding="8" class="p-2" id="myTable">
    <thead>
        <tr>
            <th scope="col" style="text-align: center;">No</th>
            <th scope="col" style="text-align: center;">Nama Kategori</th>

            <th style="width:20%">Opsi</th>
        </tr>
    </thead>
    <?php
    if (!empty($siswa)) { // Jika data pada database tidak sama dengan empty (alias ada datanya)
        $no = 1;
        $index = 0;
        foreach ($siswa as $data) {
            // Lakukan looping pada variabel siswa dari controller
    ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $data['nama_kategori_pengeluaran'] ?></td>

                <td><button type="button" class="btn btn-warning btn-sm btn-choose" data-id="<?= $data['id_kategori'] ?>" data-nama="<?= $data['nama_kategori_pengeluaran'] ?>"><i class="fa fa-check"></i></button></td>
            <tr>
        <?php $no++;
            $index++;
        }
    } else { // Jika data tidak ada
        echo "<tr><td colspan='4'>Data tidak ada</td></tr>";
    }
        ?>
</table>