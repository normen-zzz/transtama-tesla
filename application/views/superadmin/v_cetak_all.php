<?php 
$is_generate = $this->db->query("SELECT type FROM tbl_so WHERE id_so = ".$orders[0]['id_so']." ")->row_array();
?>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet" type="text/css">
<style>
    @page {
        margin-top: 15px;
        margin-left: 5px;
        margin-right: 10px;
        <?php if ($is_generate['type'] == 1) { ?>margin-bottom: 50px;
        <?php } else { ?>margin-bottom: 5px;
        <?php } ?>
    }

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

    .smallCell
{
    height: 50px;
}

    p {
        font-size: 16px;
    }
</style>

<body style="font-family:'Open Sans',sans-serif; margin:-5px; margin-top:20px;" onload="window.print()">
    <?php foreach ($orders as $order) { ?>

        <div class="inv" style="margin-left: 10px; margin-top:20px;">
            <table border="0">
                <tr>
                    <td style="width: 70%; margin-bottom: 10px;">
                        <img src="<?= base_url('uploads/logo.png') ?>" width="120" height="45" style="margin-bottom:5px;">
                        <!-- <img src="<?= base_url('uploads/tlx2.jpg') ?>" width="120" height="45" style="margin-bottom:5px;"> -->
                    </td>
                    <td style="font-size: 20px; padding-top:25px; font-weight:bold;">
                        <b style="margin-left:20px"><?= $order['prefix'] ?></b>
                    </td>
                </tr>
            </table>

        </div>
        <div class="content" style="border: 1px solid black;margin-left: 10px; margin-right:5px">
            <center>
                <table border="0" style="margin:2px;">
                    <tr>
                        <td style="width: 65%;">
                            <img src="<?= base_url('uploads/barcode/') . $order['shipment_id'] ?>.jpg" width="150" height="53" style="margin-top: 2px; margin-left:2px;">
                            <!-- <img src="<?= base_url('uploads/barcode/') . $order['shipment_id'] ?>-<?= $koli_ke ?>-<?= $koli ?>.jpg" width="100%" height="50"> -->
                            <i><b> <?= $order['shipment_id'] ?></b> </i>
                        </td>
                        <td>
                            <img src="<?= base_url('uploads/qrcode/') . $order['shipment_id'] ?>.png" width="73" height="60" style="margin-top: -13px; margin-left:8px;">
                        </td>

                    </tr>
                </table>

            </center>

            <!-- <hr> -->
            <table style="width:100%;  margin-top:2px; border-top:1px solid black">
                <tr>
                    <td style=" font-size: 10px; width:72%"><b>Shipper :</b> <?= ucwords(strtolower($order['shipper']))?> <?= ($order['mark_shipper'] != NULL) ? ' (' . $order['mark_shipper'] . ') ' : "" ?> <?='<br>' . '<b>' . ucwords(strtolower($order['city_shipper'])) . ', ' . ucwords(strtolower($order['state_shipper'])) . '</b>' ?>
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
				
                    <td class="smallCell" style="font-size: 8px; text-align:left">
					
					
     <b>Consignee : <?php if ($order['consigne'] != NULL) {
                                                                                    ?></b> <?= ucwords(strtolower($order['consigne'])) . '<br>' . ucwords($order['destination']) . '. ' . '<br>'  . '<b>' . ucwords(strtolower($order['city_consigne'])) . '</b>' . ', ' . '<b>' . ucwords(strtolower($order['state_consigne'])) . '</b>'  ?>
                        <b>Indonesia</b> <?php } ?>
						
					
					
                    </td>
                </tr>


            </table>
            <table>
                <tr>
                    <td style="border-bottom: 1px solid black;border-top: 1px solid black;font-size: 10px;">
                        DO Number :
                        <?php
                        $get_do = $this->db->select('no_do')->get_where('tbl_no_do', ['shipment_id' => $order['shipment_id']]);
                        $jumlah = $get_do->num_rows();
                        if ($get_do) {
                            $i = 1;
                            foreach ($get_do->result_array() as $d) {
                        ?>
                                <?= ($i == $jumlah) ? $d['no_do'] : $d['no_do'] . '/'  ?>
                            <?php $i++;
                            }
                        } else {
                            ?>
                            <?= $order['note_cs'] ?>
                        <?php   }

                        ?>
                    </td>
                </tr>
            </table>

            <table style="width:100%; border-left:none;border-right:none" border="0">
                <tr>
                    <td style="border-top: 1px ; font-size: 10px;">
                        <b>Pieces :</b> <?= $order['koli'] ?>
                    </td>
                    <td style="border-top: 1px ; border-left: 1px ;font-size: 10px;">
                        <b>Weight :</b> <?= ($order['is_weight_print'] == 1) ?  $order['weight'] : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td style=" font-size: 8px; width:50%;border-top: 1px solid black;">
                        <?php if ($order['signature']) {
                        ?>
                            <center><img src="data:<?= $order['signature']; ?>" height="60" width="60" alt=""></center> <br>

                        <?php  } else {
                        ?>
                            <br><br><br><br><br><br>

                        <?php } ?>


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

                    </td>
                    <td style=" font-size: 8px; width:50%;border-top: 1px solid black;border-left: 1px solid black;"><br><br><br>
                    </td>
                </tr>

                <tr>
                    <td style=" font-size: 7.5px; width:50%;border-bottom: 1px solid black;"><b>Sender : <?= $order['sender'] ?><br>
                            <!-- <b>Date &nbsp;&nbsp;&nbsp;&nbsp;: <?= $tahun . '-' . $bulan . '-' . $tanggal . '&nbsp;' . $jam . ':' . $menit . ':' . $detik ?></b></td> -->
                            <b>Date &nbsp;&nbsp;&nbsp;&nbsp;: <?= date('Y-m-d', strtotime($order['tgl_pickup'])) ?></b></td>
                    <td style=" font-size: 7.5px; width:50%;border-left: 1px solid black;border-bottom: 1px solid black;"><b>Receiver : <br>
                            <b>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="border-bottom: 1px;font-size: 8px;">
                        Phone :
                    </td>
                </tr>
            </table>


        </div>

    <?php } ?>


</body>