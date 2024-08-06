<style>
    #scanner-container {
        width: 300px;
        height: 300px;
        border: 1px solid #ccc;
        padding: 10px;
    }

    #scanner-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<!--begin::Content-->

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <div class="row">
                <div class="col-12">
                    <div class="card card-custom card-stretch">

                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <div class="row">
                            <div class="col-sm-5">
                                <h1>Scan QR Codes</h1>
                                <div class="section">
                                    <div id="my-qr-reader">
                                    </div>
                                </div>
                            </div>
                            <script src="https://unpkg.com/html5-qrcode"> </script>




                        </div>
                        <form action="<?= base_url('shipper/Outbond/scanBarcodeOutbond') ?>" id="scanOutbond" method="POST">
                            <input type="text" name="hasilscan" id="hasilScan" hidden>
                        </form>

                        <!-- /.box-body -->
                        <div class="row m-4" style="overflow: auto;">
                            <div class="col-md-12">
                                <form action="<?= base_url('shipper/Outbond/doBagging') ?>" method="POST">
                                    <button type="submit" style="float: right;" class="btn btn-primary">Bagging</button>
                                    <table id="myTable" class="table table-bordered">
                                        <h3 class="title font-weight-bold">List Scan In/Out</h3>
                                        <!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
                                        <p><?= $this->session->flashdata('message'); ?></p>
                                        <thead>
                                            <tr>
                                                <th style="width: 1%;">#</th>
                                                <th style="width: 10%">Shipment ID</th>
                                                <th style="width: 15%;">Shipper</th>
                                                <th style="width: 15%;">Consignee</th>
                                                <th style="width: 15%;">Service</th>
                                                <th style="width: 15%;">Last Status</th>
                                                <th style="width: 5%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($outbond->result_array() as $outbond1) { ?>

                                                <tr>
                                                    <td>
                                                        <?php if ($outbond1['bagging'] == NULL) { ?>
                                                            <?php if ($outbond1['is_jabodetabek'] == 2) { ?>
                                                                <input type="checkbox" name="shipment_id[]" class="form-control" value="<?= $outbond1['shipment_id'] ?>">
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $outbond1['shipment_id'] ?></td>
                                                    <td><?= $outbond1['shipper'] ?></td>
                                                    <td><?= $outbond1['consigne'] ?></td>
                                                    <td><?= getServiceName($outbond1['service_type']) ?></td>
                                                    <td>Paket telah tiba di hub Jakarta Pusat<?= getStatusBagging($outbond1['shipment_id']) ?></td>
                                                    <td>
                                                        <a href="<?= base_url('shipper/salesOrder/weight/' . $outbond1['shipment_id']) ?>" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Weight</a>
                                                        <?php if ($outbond1['is_jabodetabek'] == 1) { ?>
                                                            <?php if ($outbond1['delivery_status'] == NULL) { ?>
                                                                <button type="button" class="btn btn-primary modalDelivery" data-toggle="modal" data-shipment_id="<?= $outbond1['shipment_id'] ?>" data-target="#modal-lg-dl">
                                                                Assign Delivery
                                                            </button>
                                                            <?php } elseif ($outbond1['delivery_status'] ==1) { ?>
                                                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                                                <span class="text-muted">Delivery By</span>
																	<p  class="text-dark text-hover-primary mb-1 font-size-lg"><?= getNamaUser($outbond1['delivery_by'])  ?></p>
																	
																</div>
                                                                <?php } ?>
                                                            
                                                        <?php } ?>
                                                    </td>

                                                </tr>

                                            <?php } ?>

                                        </tbody>


                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->







<div class="modal fade" id="modal-lg-dl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign Driver DL</b> </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('shipper/Outbond/assignDriverDelivery') ?>" method="POST">
                    <div id="modal-content">

                    </div>

                    <!-- /.card-body -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button onclick='$("#modalLoading").modal("show");' type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<script>
    $(document).ready(function() {
        $('.modalDelivery').click(function() {
            var shipment_id = $(this).data('shipment_id'); // Mendapatkan ID dari atribut data-id tombol yang diklik
            var id_so = $(this).data('id_so');
            $('#modal-content').html('<p>Please Wait </p>');
            // Memuat data menggunakan AJAX dengan mengirimkan ID sebagai parameter

            // Menampilkan data ke dalam modal
            var content = '<div class="card-body"><div class="row">' +
                'Asign Delivery ' + shipment_id +
                '<input type="text" name="shipment_id" class="form-control" hidden value="' + shipment_id + '">' +
                '<div class="col-md-12">' +
                '<label for="id_driver">Choose Driver : </label>' +
                '<select name="id_driver" class="form-select" id="selectField" style="width: 200px;">' +
                <?php foreach ($users as $u) {
                ?> '<option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>' +
                <?php    } ?> '</select>' +

                '</div>' +

                '</div>' +
                '</div>';
            $('#modal-content').html(content);
            $('#selectField').select2();


        });
    });
</script>


<script>
    const scannerVideo = document.getElementById('scanner-video');
    const scanResultInput = document.getElementById('scan-result');
    const scanButton = document.getElementById('scan-button');

    let scanner;

    scanButton.addEventListener('click', () => {
        scanner = new Instascan.Scanner({
            video: scannerVideo,
            scanPeriod: 5,
            mirror: false,
        });

        scanner.addListener('scan', (content) => {
            scanResultInput.value = content;
        });

        Instascan.Camera.getCameras().then((cameras) => {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('Tidak ada kamera yang tersedia');
            }
        }).catch((err) => {
            console.error(err);
        });
    });
</script>

<script>
    // script.js file

    function domReady(fn) {
        if (
            document.readyState === "complete" ||
            document.readyState === "interactive"
        ) {
            setTimeout(fn, 1000);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    domReady(function() {

        // If found you qr code
        function onScanSuccess(decodeText, decodeResult) {
            var hasilScan = document.getElementById("hasilScan");
            hasilScan.value = decodeText;
            var formScan = document.getElementById('scanOutbond')
            formScan.submit()
            htmlscanner.clear();
        }

        let htmlscanner = new Html5QrcodeScanner(
            "my-qr-reader", {
                fps: 10,
                qrbos: 250
            }
        );
        htmlscanner.render(onScanSuccess);

    });
</script>