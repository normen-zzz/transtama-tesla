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
    <table class="table table-bordered" border="1">
        <center>
            <h1> <?= $title; ?></h1>
        </center>
        <thead>
            <tr>
                <th>No</th>
                <th>DATE</th>
                <th>SHPMENT ID</th>
                <th>NO DO/DN</th>
                <th>NO SO/PO</th>
                <th>STP</th>
                <th>CUSTOMER</th>
                <th>CONSIGNEE</th>
                <th>DEST</th>
                <th>SERVICE</th>
                <th>COMM</th>
                <th>COLLY</th>
                <th>WEIGHT</th>
                <th>SPECIAL WEIGHT</th>
                <th>PETUGAS PICKUP</th>
                <th>STATUS DELIVERY</th>

            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
			foreach ($order as $p) {
                $get_tracking = $this->db->order_by('id_tracking', 'DESC')->get_where('tbl_tracking_real', ['shipment_id' => $p['shipment_id']])->row_array();
                $get_do = $this->db->select('no_do,no_so, berat, koli')->get_where('tbl_no_do', ['shipment_id' => $p['shipment_id']])->result_array();
                $jumlah = $this->db->select('no_do')->get_where('tbl_no_do', ['shipment_id' => $p['shipment_id']])->num_rows();
                
            ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= bulan_indo($p['tgl_pickup']) ?></td>
                    <td> <?= $p['shipment_id'] ?> </td>
                    <td>
                        <?php
                        if ($get_do) {
                            $i = 1;
                            foreach ($get_do as $d) {
                        ?>
                                <?= ($i == $jumlah) ? $d['no_do'] : $d['no_do'] . '/'  ?>
                            <?php $i++;
                            }
                        } else {
                            ?>
                            <?= $p['note_cs'] ?>
                        <?php   }

                        ?>
                    </td>
                    <td> <?php
                            if ($get_do) {
                                $i = 1;
                                foreach ($get_do as $d) {
                            ?>
                                <?= ($i == $jumlah) ? $d['no_so'] : $d['no_so'] . '/'  ?>
                            <?php $i++;
                                }
                            } else {
                            ?>
                            <?= $p['no_so'] ?>
                        <?php   }

                        ?></td>
                    <td> <?= $p['no_stp'] ?> </td>
                    <td><b><?= $p['shipper'] ?></b> </td>
                    <td><b><?= $p['consigne'] ?></b></td>
                    <td><b><?= $p['tree_consignee'] ?></b></td>
                    <td><b><?= $p['service_name'] ?></b></td>
                    <td><b><?= $p['pu_commodity'] ?></b></td>
                    <td><b><?= $p['koli'] ?></b></td>
                    <td><b><?= $p['berat_js'] ?></b></td>
                    <td><b><?= $p['berat_msr'] ?></b></td>
                    <td><?= $p['nama_user'] ?></td>
                    <td><?= $get_tracking['status'] ?></td>
                </tr>
            <?php $no++;
            } ?>

        </tbody>

    </table>

</body>