<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet" type="text/css">
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

<body style="font-family:'Open Sans',sans-serif; margin:-15px; margin-top:-50px;" onload="window.print()">

    <div class="inv" style="margin-left: -10px; margin-top:-20px;">
        <table border="0">
            <tr>
                <td style="width: 60%; margin-bottom: 10px;">
                    <img src="<?= base_url('uploads/tlx2.jpg') ?>" width="120" height="45" style="margin-bottom:5px;">
                </td>
                <td style="font-size: 20px; padding-top:25px; font-weight:bold;">
                    <b style="margin-left: 30px;"><?= $service['prefix'] ?></b>
                </td>
            </tr>
        </table>

    </div>
    <div class="content" style="border: 1px solid black;margin-left: -15px; margin-right:5px">
        <center>
            <table border="0" style="margin:2px;">
                <tr>
                    <td style="width: 60%; margin-bottom: 10px;">
                        <img src="<?= base_url('uploads/barcode/') . $order['shipment_id'] ?>.jpg" width="220" height="50">
                        <!-- <img src="<?= base_url('uploads/barcode/') . $order['shipment_id'] ?>-<?= $koli_ke ?>-<?= $koli ?>.jpg" width="100%" height="50"> -->
                        <i><b> <?= $order['shipment_id'] ?></b> </i>
                    </td>
                    <!-- <td><b>
                                <h2 style="font-size: 12px;">
                                    <center><u style="border-bottom: 2px solid black;"> <?= $service['prefix'] ?></u></center>
                                    <center> <span style="font-size: 12px; padding-top:-60px"><b><?= $order['tree_shipper'] ?>-<?= $order['tree_consignee'] ?></b> </span></center>
                                </h2>
                            </b>
                        </td> -->
                </tr>
            </table>

        </center>

        <!-- <hr> -->
        <table style="width:100%;  margin-top:2px; border-top:1px solid black">
            <tr>
                <td style=" font-size: 10px; width:72%"><b>Shipper :</b> <?= ucwords(strtolower($order['shipper'])) . '<br>' . '<b>' . ucwords(strtolower($order['city_shipper'])) . ', ' . ucwords(strtolower($order['state_shipper'])) . '</b>' ?>
                    <b>Indonesia</b>
                </td>
                <td style="border-left:1px solid black"><b>
                        <h2 style="font-size: 12px;">
                            <center> <span style="font-size: 12px; padding-top:-60px"><b><?= $order['tree_shipper'] ?>-<?= $order['tree_consignee'] ?></b> </span></center>
                        </h2>
                    </b>
                </td>

            </tr>


        </table>
        <table style="width:100%; border-top:1px solid black;">
            <tr>
                <td style=" font-size: 10px; text-align:left"><b>Consignee :</b> <?= ucwords(strtolower($order['consigne'])) . '<br>' . ucwords($order['destination']) . '. ' . '<br>'  . '<b>' . ucwords(strtolower($order['city_consigne'])) . '</b>' . ', ' . '<b>' . ucwords(strtolower($order['state_consigne'])) . '</b>'  ?>
                    <b>Indonesia</b>
                </td>
            </tr>


        </table>

        <table style="width:100%; border-left:none;border-right:none" border="0">
            <tr>
                <td style="border-top: 1px solid black; font-size: 10px;">
                    <b>Pieces :</b> <?= $order['koli'] ?>
                </td>
                <td style="border-top: 1px solid black; border-left: 1px solid black;font-size: 10px;">
                    <b>Weight :</b> <?= ($order['is_weight_print'] == 1) ?  $order['weight'] : ''; ?>
                </td>
            </tr>
            <tr>
                <td style=" font-size: 8px; width:50%;border-bottom: 1px solid black;border-top: 1px solid black;">
                    <center><img src="data:<?= $order['signature']; ?>" height="60" width="60" alt=""></center> <br>
                    <b>Sender :</b> <?= $order['sender'] ?> <br>

                    <?php
                    //pisahkan tanggal
                    $array1 = explode("-", $order['created_at']);

                    $tahun = $array1[0];
                    $bulan = $array1[1];
                    $sisa1 = $array1[2];
                    $array2 = explode(" ", $sisa1);
                    $tanggal = $array2[0];
                    $sisa2 = $array2[1];
                    $array3 = explode(":", $sisa2);
                    $jam = $array3[0];
                    $menit = $array3[1];
                    $detik = $array3[2];
                    ?>

                    <b>Date &nbsp;&nbsp;&nbsp;: </b><?= $tahun . '-' . $bulan . '-' . $tanggal . '&nbsp;&nbsp;' . $jam . ':' . $menit . ':' . $detik ?>
                </td>

                <td style=" font-size: 8px; width:50%;border-top: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;"><br><br><br><br><br><br> <b>Receiver : <br>
                        <b>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="border-bottom: 1px solid black;font-size: 8px;">
                    Phone :
                </td>
            </tr>
        </table>


    </div>


</body>