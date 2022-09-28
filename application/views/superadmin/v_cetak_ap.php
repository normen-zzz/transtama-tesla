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
        font-size: 12px;
        font-family: 'Times New Roman', Times, serif;
    }

    .page_break {
        page-break-before: always;
    }
</style>

<body style="font-family:'Open Sans',sans-serif; margin:-15px; margin-top:-50px;" onload="window.print()">

    <div class="inv" style="margin-left: -10px; margin-top:-20px;">
        <table border="0">
            <tr>
                <td style="width: 30%; margin-bottom: 10px;">
                    <img src="<?= base_url('uploads/LogoRaw.png') ?>" width="100" height="60" style="margin-bottom:5px;">
                </td>
                <td style="font-size: 16px; padding-top:25px; font-weight:bold;width: 35%;">
                    <b style="margin-left: 0px; text-align:center"> <?= strtoupper($info['keterangan']) ?> </b>
                </td>
                <td>
                    <p><b>PT. Transtama Logistics Express</b> </p>
                    <p>Jl. Penjernihan II No. 3A</p>
                    <p>Jakarta 10210, Indonesia</p>
                    <p>Phone &nbsp;&nbsp;&nbsp;: +62 21 57852609</p>
                    <p>Fax &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: +62 21 57852608</p>
                    <p>No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $info['no_pengeluaran'] ?></p>
                    <p>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= bulan_indo($info['date']) ?></p>
                </td>
            </tr>
        </table>

    </div>
    <div class="purpose" style="width: 102%; height:10px; border: 1px solid black; margin-bottom: 10px;margin-left: -15px; margin-right:5px">
        <h4>Purpose : <?= $info['purpose'] ?></h4>
    </div>

    <div class="content" style="margin-left: -15px; margin-right:0px">

        <table style="width:100%; border-left:none;border-right:none;text-align:center" border="1">
            <tr>
                <td style=" font-size: 12px; width:5%;text-align:center"><b>No.</b>
                </td>
                <td style=" font-size: 12px; width:40%;text-align:center"><b>Description</b>
                </td>
                <td style=" font-size: 12px; width:20%;text-align:center"><b>Amount Proposed</b>
                </td>
                <td style=" font-size: 12px; width:20%;text-align:center"><b>Amount Approved</b>
                </td>

            </tr>
            <?php $no = 1;
            $total = 0;
            foreach ($ap as $a) {
            ?>
                <tr>
                    <td style=" font-size: 12px;"><?= $no; ?>
                    </td>
                    <td style=" font-size: 12px;"><?= $a['nama_kategori_pengeluaran'] ?> - <?= $a['description'] ?>
                    </td>
                    <td style=" font-size: 12px;"><?= rupiah($a['amount_proposed']) ?>
                    </td>
                    <td style=" font-size: 12px;"><?= rupiah($a['amount_approved']) ?>
                    </td>
                </tr>

            <?php $no++;
                $total = $total + $a['amount_proposed'];
            } ?>

            <?php if ($info['keterangan'] == 'CASH ADVANCE REPORT') {
                $get_ca = $this->db->get_where('tbl_pengeluaran', ['no_pengeluaran' => $a['no_ca']])->row_array();
                $amount_ca_approved = $get_ca['amount_approved'];

                $sisa = $amount_ca_approved - $total;
            ?>
                <tr>
                    <td colspan="2" style=" font-size: 12px; width:25%; font-weight:bold; height:20px;text-align:left">Total Cash Advance Approved</td>
                    <td><?= rupiah($amount_ca_approved); ?> </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style=" font-size: 12px; width:25%; font-weight:bold; height:20px;text-align:left">Total Expenses</td>
                    <td><?= rupiah($total); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style=" font-size: 12px; width:25%; font-weight:bold; height:20px;text-align:left">
                        <?= ($sisa < 0) ? 'Less' : 'Over' ?>
                    </td>
                    <td><?= rupiah($sisa); ?></td>
                    <td></td>
                </tr>

            <?php  } elseif ($info['keterangan'] == 'PAYMENT ORDER') {
            ?>
                <tr>
                    <td></td>
                    <td style=" font-size: 12px; width:25%; font-weight:bold; height:20px;text-align:center">TOTAL</td>
                    <td><?= rupiah($total); ?></td>
                    <td></td>
                </tr>

            <?php  } else {
            ?>
                <tr>
                    <td></td>
                    <td style=" font-size: 12px; width:25%; font-weight:bold; height:20px;text-align:center">TOTAL</td>
                    <td><?= rupiah($total); ?></td>
                    <td><?= rupiah($info['total_approved']); ?></td>
                </tr>

            <?php  } ?>

        </table>

        <?php if ($info['keterangan'] == 'PAYMENT ORDER') {
        ?>
            <table border="0">
                <tr>
                    <td>Payment Mode :&nbsp;&nbsp;&nbsp; <input type="checkbox" <?php if ($info['payment_mode'] == 0) {
                                                                                    echo "checked='checked'";
                                                                                } ?>>Cash &nbsp;&nbsp;&nbsp;<input type="checkbox" <?php if ($info['payment_mode'] == 1) {
                                                                                                                                        echo "checked='checked'";
                                                                                                                                    } ?>>Bank Transfer &nbsp;&nbsp;&nbsp; Via <?php if ($info['payment_mode'] == 1) {
                                                                                                                                                                                    echo $info['via_transfer'];
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo '.................';
                                                                                                                                                                                } ?> </td>

                </tr>
            </table>


        <?php  } ?>
        <br>

        <?php
        $pemohon = $this->db->get_where('tb_user', ['id_user' => $info['id_user']])->row_array();
        $ttd_atasan = $this->db->get_where('tb_user', ['id_user' => $approval['approve_by_atasan']])->row_array();
        $ttd_sm = $this->db->get_where('tb_user', ['id_user' => $approval['approve_by_sm']])->row_array();
        $ttd_gm = $this->db->get_where('tb_user', ['id_user' => $approval['approve_by_gm']])->row_array();
        $ttd_finance = $this->db->get_where('tb_user', ['id_user' => $approval['received_by']])->row_array();
        $ttd_mgr_finance = $this->db->get_where('tb_user', ['id_user' => $approval['approve_mgr_finance']])->row_array();
        if ($ttd_sm == NULL) {
            $nama_sm = '-';
        } else {
            $nama_sm = $ttd_sm['nama_user'];
        }

        ?>

        <?php if ($info['is_approve_sm'] == 1) {
        ?>
            <table style="width:100%;" border="1">
                <tr>
                    <td style="font-size: 10px; width:10%;text-align:left"><b></b>
                    </td>
                    <td style=" font-size: 10px; width:15%; text-align:center"><b>Name</b>
                    </td>
                    <td style=" font-size: 10px; width:10%; text-align:center"><b>Date</b>
                    </td>
                    <td style=" font-size: 10px; width:10%; text-align:center"><b>Signature</b>
                    </td>

                </tr>
                <tr>
                    <td style="font-size: 10px; text-align:left"><b>Prepared By</b>
                    </td>
                    <td style="font-size: 12px; font-weight:bold; height:20px;">
                        <p><?= $pemohon['nama_user'] ?></p>
                        <p style="margin-left:150 px;"><?= $ttd_atasan['nama_user'] ?></p>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><?= date($info['created']) . '<br>' . $approval['created_atasan'] ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><img src="<?= base_url('uploads/ttd/' . $pemohon['ttd']) ?>" alt="ttd" width="40" height="40">
                        <img src="<?= base_url('uploads/ttd/' . $ttd_atasan['ttd']) ?>" alt="ttd" width="40" height="40" style="margin-left:100px ;">
                    </td>

                </tr>
                <tr>
                    <td style="font-size: 10px; text-align:left"><b>Acknowledge By</b>
                    </td>
                    <td style="font-size: 12px; font-weight:bold; height:20px;text-align:left"><?= $nama_sm ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><?= $approval['created_sm'] ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><img src="<?= base_url('uploads/ttd/' . $ttd_sm['ttd']) ?>" alt="ttd" width="40" height="40">
                    </td>

                </tr>
                <tr>
                    <td style="font-size: 10px; text-align:left"><b>Approved By</b>
                    </td>
                    <td style="font-size: 12px;  font-weight:bold; height:20px;text-align:left"><?= $ttd_gm['nama_user'] ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><?= $approval['created_gm'] ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><img src="<?= base_url('uploads/ttd/' . $ttd_gm['ttd']) ?>" alt="ttd" width="40" height="40">
                    </td>

                </tr>
                <tr>
                    <td style="font-size: 10px; text-align:left"><b>Received By</b>
                    </td>
                    <td style="font-size: 12px;  font-weight:bold; height:20px;text-align:left">
                        <p><?= $ttd_finance['nama_user'] ?></p>
                        <p style="margin-left:200px ;"><?= $ttd_mgr_finance['nama_user'] ?></p>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><?= $approval['created_received'] . '<br>' . $approval['created_mgr_finance']  ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left">
                        <img src="<?= base_url('uploads/ttd/' .  $ttd_finance['ttd']) ?>" alt="ttd" width="40" height="40">
                        <img src="<?= base_url('uploads/ttd/' . $ttd_mgr_finance['ttd']) ?>" alt="ttd" width="40" height="40" style="margin-left:100px ;">
                    </td>

                </tr>
            </table>

        <?php } else {
        ?>
            <table style="width:100%;" border="1">
                <tr>
                    <td style="font-size: 10px; width:10%;text-align:left"><b></b>
                    </td>
                    <td style=" font-size: 10px; width:15%; text-align:center"><b>Name</b>
                    </td>
                    <td style=" font-size: 10px; width:10%; text-align:center"><b>Date</b>
                    </td>
                    <td style=" font-size: 10px; width:10%; text-align:center"><b>Signature</b>
                    </td>

                </tr>
                <tr>
                    <td style="font-size: 10px; text-align:left"><b>Prepared By</b>
                    </td>
                    <td style="font-size: 12px; font-weight:bold; height:20px;"><span><?= $pemohon['nama_user'] ?></span>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><?= $info['created'] ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><img src="<?= base_url('uploads/ttd/' . $pemohon['ttd']) ?>" alt="ttd" width="40" height="40">

                    </td>

                </tr>
                <tr>
                    <td style="font-size: 10px; text-align:left"><b>Acknowledge By</b>
                    </td>
                    <td style="font-size: 12px; font-weight:bold; height:20px;text-align:left"><?= $ttd_atasan['nama_user'] ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><?= $approval['created_atasan'] ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"> <img src="<?= base_url('uploads/ttd/' . $ttd_atasan['ttd']) ?>" alt="ttd" width="40" height="40">
                    </td>

                </tr>
                <tr>
                    <td style="font-size: 10px; text-align:left"><b>Approved By</b>
                    </td>
                    <td style="font-size: 12px;  font-weight:bold; height:20px;text-align:left"><?= $ttd_gm['nama_user'] ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><?= $approval['created_gm'] ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><img src="<?= base_url('uploads/ttd/' . $ttd_gm['ttd']) ?>" alt="ttd" width="40" height="40">
                    </td>

                </tr>
                <tr>
                    <td style="font-size: 10px; text-align:left"><b>Received By</b>
                    </td>
                    <td style="font-size: 12px;  font-weight:bold; height:20px;text-align:left">
                        <p><?= $ttd_finance['nama_user'] ?></p>
                        <p style="margin-left:200px ;"><?= $ttd_mgr_finance['nama_user'] ?></p>
                    </td>
                    <td style=" font-size: 12px; text-align:left"><?= $approval['created_received'] . '<br>' . $approval['created_mgr_finance']  ?>
                    </td>
                    <td style=" font-size: 12px; text-align:left">
                        <img src="<?= base_url('uploads/ttd/' .  $ttd_finance['ttd']) ?>" alt="ttd" width="40" height="40">
                        <img src="<?= base_url('uploads/ttd/' . $ttd_mgr_finance['ttd']) ?>" alt="ttd" width="40" height="40" style="margin-left:100px ;">
                    </td>

                </tr>
            </table>

        <?php } ?>





    </div>

    <?php


    if (empty($a['attachment'])) {
        echo '';
    } else {
    ?>
        <div class="page_break"></div>
        <div class="content" style="margin-left: -15px; margin-right:0px">
            <center>
                <p style="text-align: center; font-size:20px; font-style:bold"> ATTACHMENT</p>
            </center>
            <?php $no = 1;

            foreach ($ap as $a) {
                if (empty($a['attachment'])) {
                    echo '';
                } else {
            ?>
                    <span style="font-size:20px; font-style:bold"><?= $no . '. ' . $a['description'] ?> </span>
                    <p><img src="<?= base_url('uploads/ap/' . $a['attachment']) ?>" width="auto"> </p>
            <?php }
                $no++;
            } ?>

        </div>
    <?php
    } ?>



</body>