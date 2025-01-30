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
                <th>Tanggal Pickup</th>
				<th>Driver</th>
                <th>Shipper</th>
                <th>Consigne</th>
                <th>Shipment ID</th>
                <th>Order ID</th>
				<th>Freigh/Kg</th>
				<th>Special Freigh</th>
				<th>Komisi</th>
               
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order as $p) {

            ?>
                <tr>
					<td><?= bulan_indo($p['tgl_pickup']) ?></td>
                    <td><?= $p['nama_user'] ?></td>
					
                    <td><b><?= $p['shipper'] ?></b> <br><?= $p['city_shipper'] ?>, <?= $p['state_shipper'] ?> </td>
                    <td><b><?= $p['consigne'] ?></b> <br><?= $p['city_consigne'] ?>, <?= $p['state_consigne'] ?> </td>
                    <td> <?= $p['shipment_id'] ?> </td>
                    <td><?= $p['order_id'] ?></td>
					 <td><?= $p['freight_kg'] ?></td>
					 <td><?= $p['special_freight'] ?></td>
					 <td><?= $p['cn'] ?></td>
                   
                    
                </tr>
            <?php } ?>

        </tbody>

    </table>

</body>