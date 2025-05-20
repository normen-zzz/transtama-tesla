<!DOCTYPE html>
<html>
<head>
    <!-- Embed critical fonts instead of loading from Google -->
    <style>
        /* Embedded Open Sans font (subset) */
        @font-face {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Open Sans Regular'), local('OpenSans-Regular'), 
                 url(data:font/woff2;base64,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) format('woff2');
        }
        
        /* Page and document styles */
        @page {
            margin-top: 15px;
            margin-left: 5px;
            margin-right: 10px;
            margin-bottom: <?= $is_type_1 ? '50px' : '5px' ?>;
        }

        body {
            font-family:'Open Sans',sans-serif; 
            margin:-5px; 
            margin-top:20px;
        }

        table {
            width: 100%;
            font-size: 12pt;
            border-collapse: collapse;
            text-align: left;
            table-layout: fixed;
        }

        td {
            color: black;
            word-wrap: break-word;
            font-size: 13px;
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
            position: fixed;
            top: 520px;
        }
        
        .smallCell {
            height: 50px;
        }

        p {
            font-size: 16px;
        }
        
        /* Pre-define common styles to reduce duplication */
        .border-top { border-top: 1px solid black; }
        .border-left { border-left: 1px solid black; }
        .border-bottom { border-bottom: 1px solid black; }
        .font-small { font-size: 8px; }
        .font-medium { font-size: 10px; }
    </style>
</head>

<body onload="window.print()">
    <?php foreach ($orders as $order): ?>
        <div class="inv" style="margin-left: 10px; margin-top:20px;">
            <table border="0">
                <tr>
                    <td style="width: 70%; margin-bottom: 10px;">
                        <img src="<?= base_url('uploads/logo.png') ?>" width="120" height="45" style="margin-bottom:5px;">
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
                            <!-- Pre-load these images with proper dimensions -->
                            <img src="<?= base_url('uploads/barcode/') . $order['shipment_id'] ?>.jpg" width="150" height="53" style="margin-top: 2px; margin-left:2px;">
                            <i><b> <?= $order['shipment_id'] ?></b> </i>
                        </td>
                        <td>
                            <img src="<?= base_url('uploads/qrcode/') . $order['shipment_id'] ?>.png" width="73" height="60" style="margin-top: -13px; margin-left:8px;">
                        </td>
                    </tr>
                </table>
            </center>

            <table style="width:100%; margin-top:2px;" class="border-top">
                <tr>
                    <td style="font-size: 10px; width:72%"><b>Shipper :</b> 
                        <?= ucwords(strtolower($order['shipper'])) ?><br>
                        <b><?= ucwords(strtolower($order['city_shipper'])) ?>, <?= ucwords(strtolower($order['state_shipper'])) ?></b>
                        <b>Indonesia</b>
                    </td>
                    <td class="border-left"><b>
                        <h2 style="font-size: 12px;">
                            <center><span style="font-size: 12px; padding-top:-60px"><b><?= $order['tree_shipper'] ?>-<?= $order['tree_consignee'] ?></b></span></center>
                        </h2></b>
                    </td>
                </tr>
            </table>
            
            <table style="width:100%;" class="border-top">
                <tr>
                    <td class="smallCell font-small" style="text-align:left">
                        <b>Consignee : <?php if (!empty($order['consigne'])): ?></b> 
                            <?= ucwords(strtolower($order['consigne'])) ?><br>
                            <?= ucwords($order['destination']) ?>.<br>
                            <b><?= ucwords(strtolower($order['city_consigne'])) ?></b>, 
                            <b><?= ucwords(strtolower($order['state_consigne'])) ?></b>
                            <b>Indonesia</b> 
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            
            <table>
                <tr>
                    <td style="font-size: 10px;" class="border-bottom border-top">
                        DO Number : <?= $order['no_do'] ?>
                    </td>
                </tr>
            </table>

            <table style="width:100%; border-left:none;border-right:none" border="0">
                <tr>
                    <td style="font-size: 10px;" class="border-top">
                        <b>Pieces :</b> <?= $order['koli'] ?>
                    </td>
                    <td style="font-size: 10px;" class="border-top border-left">
                        <b>Weight :</b> <?= $order['berat_js'] ?>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 8px; width:50%;" class="border-top">
                        <?php if (!empty($order['signature'])): ?>
                            <center><img src="data:<?= $order['signature']; ?>" height="60" width="60" alt=""></center><br>
                        <?php else: ?>
                            <br><br><br><br><br><br>
                        <?php endif; ?>
                    </td>
                    <td style="font-size: 8px; width:50%;" class="border-top border-left"><br><br><br>
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 7.5px; width:50%;" class="border-bottom">
                        <b>Sender : <?= $order['sender'] ?><br>
                        <b>Date &nbsp;&nbsp;&nbsp;&nbsp;: <?= date('Y-m-d', strtotime($order['tgl_pickup'])) ?></b>
                    </td>
                    <td style="font-size: 7.5px; width:50%;" class="border-left border-bottom">
                        <b>Receiver : <br>
                        <b>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>
                    </td>
                </tr>
            </table>
            
            <table>
                <tr>
                    <td style="font-size: 8px;">
                        Phone :
                    </td>
                </tr>
            </table>
        </div>
    <?php endforeach; ?>
</body>
</html>