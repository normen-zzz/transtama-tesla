<!--begin::Content-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/scans/css/style.css">
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Dashboard-->
			<div class="row">
				<div id="qr-reader" style="width: 600px"></div>
			</div>
			<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
			<script>
				function onScanSuccess(decodedText, decodedResult) {
					console.log(`Code scanned = ${decodedText}`, decodedResult);
				}
				var html5QrcodeScanner = new Html5QrcodeScanner(
					"qr-reader", {
						fps: 10,
						qrbox: 250
					});
				html5QrcodeScanner.render(onScanSuccess);
			</script>

		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->