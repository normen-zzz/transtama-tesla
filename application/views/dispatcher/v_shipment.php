<!--begin::Content-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
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

						<!-- /.box-body -->
						<div class="row">
                            <div class="col-sm-5" >
                                <h1>Scan QR Codes</h1>
                                <div class="section">
                                    <div id="my-qr-reader">
                                    </div>
                                </div>
                            </div>
                            <script src="https://unpkg.com/html5-qrcode"> </script>
                            


                           
                        </div>
						<form action="<?= base_url('dispatcher/Scan/scanInBagging') ?>" id="scanOutbond" method="POST">
                        <input type="text" name="hasilscan" id="hasilScan">
                        </form>
						<div class="row m-4" style="overflow: auto;">
							<div class="col-md-12">
								<table id="myTable" class="table table-bordered">
									<h3 class="title font-weight-bold">List Scan In</h3>
									<!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->
									<p><?= $this->session->flashdata('message'); ?></p>
									<thead>
										<tr>
											<th>No Bagging</th>
											<th>Created At</th>
											<th>Bagging By</th>
											<th>Status</th>
											<th>Action</th>
									</thead>
									<tbody>
										<?php foreach ($bagging->result_array() as $bagging1) { ?>

											<tr>
												<td><?= $bagging1['id_bagging'] ?></td>
												<td><?= date('d-m-Y H:i:s', strtotime($bagging1['created_at'])) ?></td>
												<td><?= getNamaUser($bagging1['created_by']) ?></td>
												<td><?= getStatusBaggingOutbond($bagging1['id_bagging']) ?></td>
												<td>
													<a class="btn btn-primary" href="<?= base_url('dispatcher/Scan/doScanOut/' . $bagging1['id_bagging']) ?>">SCAN OUT</a>
												</td>
											</tr>
										<?php } ?>
									</tbody>


								</table>
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
            formScan.submit();
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


