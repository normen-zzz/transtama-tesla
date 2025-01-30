<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet" type="text/css">
<style>
    @page {
        margin-top: 15px;
        margin-left: 5px;
        margin-right: 10px;
        margin-bottom: 25px;
        
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

    p {
        font-size: 16px;
    }
</style>

<body style="font-family:'Open Sans',sans-serif" onload="window.print()">


    <div class="inv" style="margin-left: 10px;">
        <table >
            <tr>
                <td style="width: 70%; margin-bottom: 10px;">
                    <img src="<?= base_url('uploads/logo.png') ?>" width="120" height="45" style="margin-bottom:5px;">
                    <!-- <img src="<?= base_url('uploads/tlx2.jpg') ?>" width="120" height="45" style="margin-bottom:5px;"> -->
                </td>
                <td><h4>BAGGING-<?= $bagging['id_bagging'] ?></h4></td>

            </tr>
        </table>

    </div>
    <div class="content" style="border: 1px solid black;margin-left: 10px; margin-right:5px">

        <table border="0" style="margin:2px;">
            <tr>
                <td style="text-align: center;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= $bagging['id_bagging'] ?>" width="73" height="60">
                </td>

            </tr>
        </table>

        <table style="border: 1px solid black;">
            <tr>
                <td>Smu : <?= substr($bagging['smu'],0,3).'-'.substr($bagging['smu'],3)  ?></td>
            </tr>
        </table>







        <table style="width:100%;border-left:none;border-right:none" border="1">
            <tr>
                <td style="border-top: 1px solid black; font-size: 10px; vertical-align: top;text-align: left; height:fit-content">
                    <b>Total Resi :</b><?= $resi->num_rows() ?>
                </td>

            </tr>
            <tr>
                <td style="height: 130px; vertical-align: top;text-align: left;">
                    <?php foreach ($resi->result_array() as $resi1) {
                        echo $resi1['shipment_id'] . ', ';
                    } ?> 
                  
                </td>
                    

            </tr>
            <tr>
                <td style=" font-size: 7.5px; width:50%;border-bottom: 1px solid black;">
                    <b>Date &nbsp;&nbsp;&nbsp;&nbsp;: <?= date('Y-m-d', strtotime($bagging['created_at'])) ?></b>
                </td>


            </tr>

        </table>



    </div>


</body>