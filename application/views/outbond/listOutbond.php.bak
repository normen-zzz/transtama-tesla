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
                                    <table id="tableOutbond" class="table table-bordered tableOutbond">
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

        $('#tableOutbond').DataTable({


            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],

            "processing": true,
            // "responsive": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                "<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
            "order": [
                [1, 'desc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?= base_url('shipper/Outbond/listDataOutbond'); ?>", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [
                [100, 200],
                [100, 200]
            ], // Combobox Limit
            "columns": [{
                    "data": "shipment_id",
                    "render": function(data, type, row, meta) {
                        if (row.bagging == 0) {
                            if (row.is_jabodetabek == 2) {
                                return '<input type="checkbox" name="shipment_id[]" class="form-control" value="' + data + '">';
                            }
                        }
                    }
                },
                {
                    "data": "shipment_id",
                },
                {
                    "data": "shipper",
                },
                {
                    "data": "consigne",
                },
                {
                    "data": "service_name",
                },
                {
                    "data": "shipment_id",
                    "render": function(data, type, row, meta) {


                        if (row.bagging == 0) {
                            return 'Paket telah tiba di Hub Jakarta Pusat';
                        } else {
                            return 'Paket telah tiba di Hub Jakarta Pusat On Bagging (' + row.bagging + ')';
                        }
                    }
                },
                {
                    "data": "shipment_id",
                    "render": function(data, type, row, meta) {
                        if (row.is_jabodetabek == 1) {
                            if (row.delivery_status == 0) {
                                $('.modalDelivery').click(function() {
                                    var shipment_id = $(this).data('shipment_id'); // Mendapatkan ID dari atribut data-id tombol yang diklik

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
                                return '<a href="<?= base_url("shipper/salesOrder/weight/") ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Weight</a>' +
                                    '<button type="button" class="btn btn-primary modalDelivery" data-toggle="modal" data-shipment_id="' + data + '" data-target="#modal-lg-dl"> Assign Delivery</button>';
                            } else if (row.delivery_status == 1) {
                                return '<a href="<?= base_url("shipper/salesOrder/weight/") ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Weight</a>' +
                                    '<div class="d-flex flex-column flex-grow-1 font-weight-bold">' +
                                    '<span class="text-muted">Delivery By</span>' +
                                    '<p class="text-dark text-hover-primary mb-1 font-size-lg">' + row.nama_user + '</p>' +
                                    '</div>';
                            }
                        } else {
                            return '<a href="<?= base_url("shipper/salesOrder/weight/") ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Weight</a>'
                        }
                    }
                },
            ],
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