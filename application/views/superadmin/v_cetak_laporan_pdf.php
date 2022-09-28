<style>
    table {
        width: 100%;
        font-size: 12pt;

    }

    table,
    th,
    td {
        border-collapse: collapse;
        text-align: left;
        table-layout: fixed;
        font-size: 13px;

    }

    td {
        color: black;
        word-wrap: break-word;

    }

    h1 {
        font-size: 40px;
        margin-top: 1px;
    }

    .garis {
        border-top: 1px solid black;
        margin-left: 30px;
        margin-right: 40px;
    }

    #nilai {
        text-align: right;
        float: right;
    }

    .footer {
        margin-left: 30px;
        /* margin-top: 230px; */
        position: fixed;
        top: 520px;
    }

    p {
        font-size: 16px;
    }
</style>

<body>
    <center>
        <table border="1">
            <tr>
                <td style="width: 20%;">
                    <img src="<?= base_url('uploads/tlx2.jpg') ?>" width="150" height="70">
                </td>
                <td><b>
                        <h2>
                            <center><?= $title; ?></center>
                        </h2> <br>
            </tr>

        </table>

    </center>
    <table class="table table-bordered" border="1">
        <thead>
            <tr>
                <th style="width: 15%;">Driver</th>
                <th style="width: 20%;">Shipper</th>
                <th style="width: 20%;">Consigne</th>
                <th style="width: 10%;">Shipment ID</th>
                <th style="width: 10%;">Order ID</th>
                <th style="width: 20%;">Image</th>
                <th>Signature</th>
                <th>Created At</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order as $p) {

            ?>
                <tr>
                    <td><?= $p['nama_user'] ?></td>
                    <td><b><?= $p['shipper'] ?></b> <br><?= $p['city_shipper'] ?>, <?= $p['state_shipper'] ?> </td>
                    <td><b><?= $p['consigne'] ?></b> <br><?= $p['city_consigne'] ?>, <?= $p['state_consigne'] ?> </td>
                    <td> <?= $p['shipment_id'] ?> </td>
                    <td><?= $p['order_id'] ?></td>
                    <td> <img src="<?= base_url('uploads/berkas/') . $p['image'] ?>" width="100" height="100"> </td>
                    <td> <img src="data:<?= $p['signature']; ?>" height="80" width="200" alt=""></td>
                    <td><?= bulan_indo($p['created_at']) ?></td>
                </tr>
            <?php } ?>

        </tbody>

    </table>

</body>