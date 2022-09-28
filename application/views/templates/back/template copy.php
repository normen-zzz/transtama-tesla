<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<meta charset="utf-8" />
	<title>Shipper-Apps</title>
	<meta name="description" content="Updates and statistics" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Vendors Styles(used by this page)-->
	<link href="<?= base_url('assets/back/metronic/') ?>plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/back/metronic/') ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="<?= base_url('assets/back/metronic/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/back/metronic/') ?>plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/back/') ?>plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/back/') ?>plugins/jquery-ui-1.13.1/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/back/metronic/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/back/metronic/') ?>css/pages/wizard/wizard-3.css" rel="stylesheet" type="text/css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?= base_url('assets/back/metronic/') ?>plugins/custom/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

	<link type="text/css" href="<?= base_url('assets/back/metronic/') ?>css/jquery.signature.css" rel="stylesheet">

	<link rel="shortcut icon" href="<?= base_url('uploads/') ?>icon512.png" />
	<style>
		.dataTables_wrapper .dataTables_filter {
			float: left;
		}

		.dataTables_wrapper .dataTables_length {
			float: right;
		}
	</style>
	<style type="text/css">
		body {
			font-family: Helvetica, sans-serif;
		}

		h2,
		h3 {
			margin-top: 0;
		}

		form {
			margin-top: 15px;
		}

		form>input {
			margin-right: 15px;
		}

		#results {
			float: right;
			margin: 20px;
			padding: 20px;
			border: 1px solid;
			background: #ccc;
		}
	</style>


</head>
<!--end::Head-->

<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled page-loading" style="background-color: #eee;">


	<?php $this->load->view('templates/back/navbar'); ?>
	<?= $_content; ?>
	<?php $this->load->view('templates/back/footer'); ?>

	<!-- REQUIRED SCRIPTS -->
	<script>
		var HOST_URL = "#";
	</script>
	<!--begin::Global Config(global config for global JS scripts)-->
	<script>
		var KTAppSettings = {
			"breakpoints": {
				"sm": 576,
				"md": 768,
				"lg": 992,
				"xl": 1200,
				"xxl": 1200
			},
			"colors": {
				"theme": {
					"base": {
						"white": "#ffffff",
						"primary": "#6993FF",
						"secondary": "#E5EAEE",
						"success": "#1BC5BD",
						"info": "#8950FC",
						"warning": "#FFA800",
						"danger": "#F64E60",
						"light": "#F3F6F9",
						"dark": "#212121"
					},
					"light": {
						"white": "#ffffff",
						"primary": "#E1E9FF",
						"secondary": "#ECF0F3",
						"success": "#C9F7F5",
						"info": "#EEE5FF",
						"warning": "#FFF4DE",
						"danger": "#FFE2E5",
						"light": "#F3F6F9",
						"dark": "#D6D6E0"
					},
					"inverse": {
						"white": "#ffffff",
						"primary": "#ffffff",
						"secondary": "#212121",
						"success": "#ffffff",
						"info": "#ffffff",
						"warning": "#ffffff",
						"danger": "#ffffff",
						"light": "#464E5F",
						"dark": "#ffffff"
					}
				},
				"gray": {
					"gray-100": "#F3F6F9",
					"gray-200": "#ECF0F3",
					"gray-300": "#E5EAEE",
					"gray-400": "#D6D6E0",
					"gray-500": "#B5B5C3",
					"gray-600": "#80808F",
					"gray-700": "#464E5F",
					"gray-800": "#1B283F",
					"gray-900": "#212121"
				}
			},
			"font-family": "Poppins"
		};
	</script>
	<!--end::Global Config-->
	<!--begin::Global Theme Bundle(used by all pages)-->
	<script src="<?= base_url('assets/back/metronic/') ?>plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/prismjs/prismjs.bundle.js"></script>
	<script src="<?= base_url('assets/back/metronic/') ?>js/scripts.bundle.js"></script>
	<!--end::Global Theme Bundle-->
	<script src="<?= base_url('assets/back/metronic/') ?>js/pages/crud/forms/editors/summernote.js"></script>
	<!--begin::Page Vendors(used by this page)-->
	<script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/datatables/datatables.bundle.js"></script>
	<!--end::Page Vendors-->
	<!--begin::Page Vendors(used by this page)-->
	<script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
	<!--end::Page Vendors-->
	<!--begin::Page Scripts(used by this page)-->
	<script src="<?= base_url('assets/back/metronic/') ?>js/pages/widgets.js"></script>
	<!--end::Page Scripts-->
	<!--begin::Page Scripts(used by this page)-->
	<script src="<?= base_url('assets/back/metronic/') ?>js/pages/crud/datatables/basic/scrollable.js"></script>
	<!--end::Page Scripts-->
	<script src="<?= base_url('assets/back/metronic/') ?>js/pages/crud/file-upload/dropzonejs.js"></script>
	<script src="<?= base_url('assets/back/metronic/') ?>js/pages/crud/forms/widgets/bootstrap-datetimepicker.js">
	</script>
	<script src="<?= base_url('assets/back/metronic/') ?>js/pages/custom/wizard/wizard-3.js"></script>
	<!-- SweetAlert2 -->
	<script src="<?= base_url('assets/back/metronic/') ?>plugins/custom/sweetalert2/sweetalert2.min.js"></script>
	<!-- Select2 -->
	<script src="<?= base_url('assets/back/') ?>plugins/select2/js/select2.min.js"></script>
	<!-- Toastr -->
	<script src=" <?= base_url('assets/back/metronic/') ?>js/myscript.js"></script>
	<!-- jSignature -->
	<script src="<?= base_url('assets/back/metronic/') ?>js/jquery.signature.js"></script>
	<script src="<?= base_url('assets/back/metronic/') ?>js/jSignature.min.js"></script>

	<!-- <script src="YourJquery source path"></script> -->
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#shipper").autocomplete({
				source: "<?php echo base_url('shipper/order/get_autocomplete'); ?>",
				select: function(event, ui) {
					$('[name="shipper"]').val(ui.item.nama_pt);
					$('[name="sender"]').val(ui.item.pic);
				}

			});
		});
	</script>

	<script>
		$(document).ready(function() {

			// Initialize jSignature
			var $sigdiv = $("#signature").jSignature({
				'UndoButton': true,
				'height': 150,
				'width': 100

			});

			$('#click').click(function() {
				// Get response of type image
				var data = $sigdiv.jSignature('getData', 'image');
				// Storing in textarea
				$('#output').val(data);
				console.log(data);

				// Alter image source 
				$('#sign_prev').attr('src', "data:" + data);
				$('#sign_prev').show();


			});
		});
	</script>
	<script type="text/javascript">
		$('select').select2({
			allowClear: true,
		});
	</script>


	<script>
		$(document).ready(function() {
			$('#myTable').DataTable({
				"ordering": false,
				// "dom": '<"top"f>rt<"bottom"ilp><"clear">',
				"dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
					"<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
			});
		});
		$(document).ready(function() {
			var myTable = $('#myTable2').DataTable({
				"ordering": false,
				"dom": '<"top"f>rt<"bottom"ilp><"clear">'
			});
		});

		// Class definition

		var KTSummernoteDemo = function() {
			// Private functions
			var demos = function() {
				$('.summernote').summernote({
					height: 150,
					width: 720
				});
			}

			return {
				// public functions
				init: function() {
					demos();
				}
			};
		}();

		// Initialization
		jQuery(document).ready(function() {
			KTSummernoteDemo.init();
		});
	</script>

	<script type="text/javascript">
		function showSoal(select) {
			if (select.value == 'Pg') {
				document.getElementById('demo').style.display = "block";
				document.getElementById('essay').style.display = "none";
			} else if (select.value == 'essay') {
				document.getElementById('demo').style.display = "none";
				document.getElementById('essay').style.display = "block";
			} else {
				document.getElementById('demo').style.display = "none";
				document.getElementById('essay').style.display = "none";

			}
		}
	</script>

	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytable').DataTable({
				"processing": true,

				"serverSide": true,
				"ordering": true, // Set true agar bisa di sorting
				"dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
					"<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
				"order": [
					[0, 'desc']
				], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
				"ajax": {
					"url": "<?= base_url('superadmin/order/view_data_query'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": 'nama_user',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": "shipment_id",
						"render": function(data, type, row, meta) {
							return '<a href="<?= base_url('uploads/barcode') ?>/' + data + '.pdf">' + data + '</a>';
						}
					}, // Tampilkan kategori
					{
						"data": "created_at",
						"render": function(data, type, row, meta) {
							var options = {
								weekday: 'long',
								year: 'numeric',
								month: 'long',
								day: 'numeric'
							};
							var today = new Date(data);
							return today.toLocaleDateString("en-US", options);
						}

					}, // Tampilkan nama sub kategori
					{
						"data": "id",
						"render": function(data, type, row, meta) {
							return '<a href="<?= base_url('superadmin/order/detail/') ?>' + data + '" class="btn btn-sm text-light" style="background-color: #9c223b;">Detail</a>';
						}
					},
				],
			});
		});
	</script>
	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytableshipper').DataTable({
				"processing": true,
				// "responsive": true,
				"serverSide": true,
				"ordering": true, // Set true agar bisa di sorting
				"dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
					"<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
				"order": [
					[0, 'desc']
				], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
				"ajax": {
					"url": "<?= base_url('shipper/order/view_data_query'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": "shipment_id",
						"render": function(data, type, row, meta) {
							return '<a href="<?= base_url('uploads/barcode') ?>/' + data + '.pdf">' + data + '</a>';
						}
					}, // Tampilkan kategori
					// {
					// 	"data": "nama_user",
					// },
					{
						"data": "created_at",
						"render": function(data, type, row, meta) {
							var options = {
								weekday: 'long',
								year: 'numeric',
								month: 'long',
								day: 'numeric'
							};
							var today = new Date(data);
							return today.toLocaleDateString("en-US", options);
						}

					}, // Tampilkan nama sub kategori
					{
						"data": "id",
						"render": function(data, type, row, meta) {
							return '<a href="<?= base_url('shipper/order/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a><a href="<?= base_url('shipper/order/edit/') ?>' + data + '" class="btn btn-sm btn-success text-light ml-2">Edit</a>';
						}
					},
				],
			});
		});
	</script>


</body>
<!--end::Body-->

</html>