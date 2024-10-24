<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<?php date_default_timezone_set('Asia/Jakarta');
	setlocale(LC_TIME, "id_ID.UTF8"); ?>
	<meta name="google-site-verification" content="n65eZx_Lmo6Qx0NYgwvqO_n21_VmI4GWGnl6CIWAAH8" />
	<meta charset="utf-8" />
	<title>Tesla Smartwork</title>
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
	<link href="<?= base_url('assets/back/') ?>plugins/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />
	<!-- <link href="<?= base_url('assets/back/') ?>plugins/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" /> -->
	<link href="<?= base_url('assets/back/metronic/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/back/metronic/') ?>css/pages/wizard/wizard-3.css" rel="stylesheet" type="text/css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>


	<!-- scan -->
	<!-- 
	<link rel="stylesheet" href="<?= base_url('assets/scan/') ?>style.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
	<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script> -->
	<!-- <link rel="stylesheet" href="https://twitter.github.io/typeahead.js/css/examples.css" /> -->


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

		.id_category {
			opacity: 0;
			height: 0px;
			display: block
				/* Reposition so the validation message shows over the label */
		}
	</style>


</head>
<!--end::Head-->

<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled page-loading" style="background-color: #eee;">


	<?php $this->load->view('templates/back/navbar'); ?>
		
	
	<?= $_content; ?>
	<?php $this->load->view('templates/back/footer'); ?>

	<!-- Modal -->
	<div class="modal fade" id="modalLoading" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="mx-auto spinner-border text-danger" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</div>



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

	<script src="<?php echo base_url() ?>assets/scans/js/qrcodelib.js"></script>
	<!-- <script src="<?php echo base_url() ?>assets/scans/js/webcodecamjquery.js"></script> -->
	<script src="<?php echo base_url() ?>assets/scans/app/core/scan.js"></script>

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
	<script src="<?= base_url('assets/back/') ?>plugins/dropify/js/dropify.min.js"></script>

	<!-- just include the file in a script tag untuk convert heic ke jpg -->
	<script src="<?= base_url('assets/heic2any/') ?>dist/heic2any.js"></script>
	<script script script src="<?= base_url('assets/back/metronic/') ?>js/pages/crud/forms/widgets/typeahead.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script> -->

	<!-- compress -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.0/dist/browser-image-compression.js"></script>
	<script src="<?= base_url('assets/compress/index.js') ?>"></script>
	<script src="<?= base_url('assets/compress/tracker.js') ?>"></script>
	<script src="<?= base_url('assets/compress/edit.js') ?>"></script>

	<!-- rupiah -->
	<script src="https://raw.githubusercontent.com/plentz/jquery-maskmoney/master/dist/jquery.maskMoney.min.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script> -->

	<!-- datepicker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js" integrity="sha512-zHDWtKP91CHnvBDpPpfLo9UsuMa02/WgXDYcnFp5DFs8lQvhCe2tx56h2l7SqKs/+yQCx4W++hZ/ABg8t3KH/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


	<!-- jquery knob -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js" integrity="sha512-NhRZzPdzMOMf005Xmd4JonwPftz4Pe99mRVcFeRDcdCtfjv46zPIi/7ZKScbpHD/V0HB1Eb+ZWigMqw94VUVaw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js" integrity="sha512-tBzZQxySO5q5lqwLWfu8Q+o4VkTcRGOeQGVQ0ueJga4A1RKuzmAu5HXDOXLEjpbKyV7ow9ympVoa6wZLEzRzDg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


	<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

	<script>
		// $('#submitMerge').css('visibility', 'hidden');
		function checkTotalCheckedBoxes() {
			var atLeastOneIsChecked = $('input[name="check[]"]:checked').length;

			if (atLeastOneIsChecked > 1) {
				$('#submitMerge').css('visibility', 'visible');
			} else {
				$('#submitMerge').css('visibility', 'hidden');
			}
		}
	</script>

	<script>
		$(document).ready(function() {

			$(document).ready(function() {
				$('.do').select();
			});

			$('.check').change(function() {
				if ($('.check:checked').length == 0) {
					$('.hide').hide(); //Show all,when nothing is checked
				} else {
					$('.hide').show();

				}

			});
		});
	</script>

	<script>
		$(function() {
			$(".dial").knob({
				'readOnly': true,
			});
		});
	</script>

	<script>
		$('#Submit').click(function() {
			$(this).html('<img src="<?= base_url('assets/loading/loading-red.gif') ?>" />'); // A GIF Image of Your choice
			return false
		});
	</script>

	<script type="text/javascript">
		if (<?= $date ?> == <?= date('d-m-y') ?>) {
			$('#datepickid div').datepicker({
				// minDate: '0',
				// startDate: "+1d",
				// dayNamesShort: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
				// language: "id",
				// dayNamesMin: ['Sunday', 'Monday', ],
				todayHighlight: true

			}).on('changeDate', function(e) {
				// $('#datepickid div').datepicker('setDate', selected.date);
				$('#dt_due').val(e.format('dd/mm/yy'));
				var value = $('#dt_due').val();
				// console.log(e);
				window.location.replace("<?= base_url('sales/SalesTracker/index/') ?>" + value);

			});
		} else {
			var realDate = new Date('<?= $date ?>');
			console.log(realDate);
			$('#datepickid div').datepicker('setDate', realDate).on('changeDate', function(e) {
				// $('#datepickid div').datepicker('setDate', selected.date);
				$('#dt_due').val(e.format('dd/mm/yy'));
				var value = $('#dt_due').val();
				// console.log(e);
				window.location.replace("<?= base_url('sales/SalesTracker/index/') ?>" + value);

			});

		}
	</script>

	<script type="text/javascript">
		if (<?= $date ?> == <?= date('d-m-y') ?>) {
			$('#datepickidcs div').datepicker({
				// minDate: '0',
				// startDate: "+1d",
				// dayNamesShort: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
				// language: "id",
				// dayNamesMin: ['Sunday', 'Monday', ],
				todayHighlight: true

			}).on('changeDate', function(e) {
				// $('#datepickid div').datepicker('setDate', selected.date);
				$('#dt_due').val(e.format('dd/mm/yy'));
				var value = $('#dt_due').val();
				// console.log(e);
				window.location.replace("<?= base_url('cs/MeetingTracker/index/') ?>" + value);

			});
		} else {
			var realDate = new Date('<?= $date ?>');
			console.log(realDate);
			$('#datepickidcs div').datepicker('setDate', realDate).on('changeDate', function(e) {
				// $('#datepickid div').datepicker('setDate', selected.date);
				$('#dt_due').val(e.format('dd/mm/yy'));
				var value = $('#dt_due').val();
				// console.log(e);
				window.location.replace("<?= base_url('cs/MeetingTracker/index/') ?>" + value);

			});

		}
	</script>




	<!-- Script -->
	<!-- untuk edit ap -->
	<script type="text/javascript">
		$(document).ready(function() {


			// On text click
			$('.edit').click(function() {
				// Hide input element
				$('.txtedit').hide();

				// Show next input element
				$(this).next('.txtedit').show().focus();

				// Hide clicked element
				$(this).hide();
			});


			// Focus out from a textbox
			$('.txtedit').focusout(function() {
				// Get edit id, field name and value
				var edit_id = $(this).data('id');
				var fieldname = $(this).data('field');
				var url = $(this).data('url');
				var value = $(this).val();

				// assign instance to element variable
				var element = this;

				// Send AJAX request
				$.ajax({
					url: url,
					type: 'post',
					data: {
						field: fieldname,
						value: value,
						id: edit_id
					},
					success: function(response) {
						// console.log(response);

						// Hide Input element
						$(element).hide();

						// Update viewing value and display it
						$(element).prev('.edit').show();
						if (fieldname == 'amount_proposed') {
							$(element).prev('.edit').text('Rp. ' + value);
						} else {
							$(element).prev('.edit').text(value);
						}

					}
				});
			});
		});
	</script>



	<script type="text/javascript">
		//$(document).ready(function() {
		// 	$('#consigne').on('input', function() {
		// 		var kode = $(this).val();
		// 		console.log(kode);

		// 		$.ajax({
		// 			type: "POST",
		// 			url: "<?php echo base_url('shipper/order/get_consigne') ?>",
		// 			dataType: "JSON",
		// 			data: {
		// 				kode: kode
		// 			},
		// 			cache: false,
		// 			success: function(data) {
		// 				$.each(data, function(consigne, destination) {
		// 					$('[name="consigne"]').val(data.consigne);
		// 					$('[name="destination"]').val(data.destination);
		// 				});
		// 			}

		// 		});
		// 		return false;

		// 	});

		// });
	</script>


	<script>
		$(document).ready(function() {

			$('.dropify').dropify();
			$('#shipper_id').change(function() {
				var id = $(this).val();
				// console.log(id);

				$.ajax({
					url: "<?php echo site_url('shipper/customer/getCustomerById'); ?>",
					method: "POST",
					data: {
						id: id
					},
					async: true,
					dataType: 'json',
					success: function(data) {
						$('#origin_destination').val(data.alamat);
						// $('#sender').val(data.pic);
						// $('#id_customer').val(data.id_customer);
						$('#state_shipper').val(data.provinsi);
						$('#city_shipper').val(data.kota);
						$('#shipper').val(data.nama_pt);
						// $('#nama1').html(html);

					}
				});
				return false;
				// alert('not found');
			});
		});
	</script>
	<script>
		$(document).ready(function() {

			// Initialize jSignature
			var $sigdiv = $("#signature").jSignature({
				'UndoButton': true,
				'height': 200,
				'width': 250

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


	<script>
		$(document).ready(function() {

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else {
				alert("Geolocation is not supported by this browser.");
			}

			function showPosition(position) {
				var latitude = position.coords.latitude;
				var longitude = position.coords.longitude;
				$('#koordinat').val(position.coords.latitude + ',' + position.coords.longitude);
			}


		});
	</script>



	<script type="text/javascript">
		$('select').select2({
			allowClear: true,
		});
	</script>

	<script type="text/javascript">
		function confirm_delete() {
			return confirm('are you sure?');
		}
	</script>

	<script>
		function collapse(cell) {
			var row = cell.parentElement;
			var target_row = row.parentElement.children[row.rowIndex + 1];
			if (target_row.style.display == 'table-row') {
				cell.innerHTML = '+';
				cell.style.display = 'none';
			} else {
				cell.innerHTML = '-';
				target_row.style.display = 'table-row';
			}
		}
	</script>



	<script>
		$(document).ready(function() {
			$('#myTable').DataTable({
				// fixedHeader: true,
				"ordering": false,
				// "dom": '<"top"f>rt<"bottom"ilp><"clear">',
				"dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
					"<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
				"bStateSave": true,
				"fnStateSave": function(oSettings, oData) {
					localStorage.setItem('offersDataTables', JSON.stringify(oData));
				},
				"fnStateLoad": function(oSettings) {
					return JSON.parse(localStorage.getItem('offersDataTables'));
				}
			});
		});
		$(document).ready(function() {
			var myTable = $('#myTable2').DataTable({
				"ordering": false,
				"dom": '<"top"f>rt<"bottom"ilp><"clear">'
			});
		});

		$(document).ready(function() {
			var myTable = $('.datatable').DataTable({
				responsive: true,
				"ordering": false,
				"dom": '<"top"f>rt<"bottom"ilp><"clear">'
			});

		});

		$(document).ready(function() {
			$('#myTableSalesTracker').DataTable({

				dom: 'Bfrtip',

				buttons: [{
					extend: 'pdf',
					title: 'Sales Tracker',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
					}
				}, {
					extend: 'excel',
					title: 'Sales Tracker',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
					}
				}, {
					extend: 'print',
					title: 'Sales Tracker',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
					},
					footer: true
				}],
				ordering: false,
				responsive: true,
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
			tabel = $('#mytablereport').DataTable({
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
					"url": "<?= base_url('cs/order/view_data_query'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": 'tgl_pickup',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": 'shipper',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": 'consigne',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": 'nama_user',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": "shipment_id",
						"render": function(data, type, row, meta) {
							return '<a target="blank" href="<?= base_url('cs/order/print') ?>/' + data + '">' + data + '</a>';
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
							return '<a href="<?= base_url('cs/order/edit/') ?>' + data + '/' + row.id_so + '" class="btn btn-sm text-light" style="background-color: #9c223b;">Edit</a>';
						}
					},
				],
			});
		});
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
					},
					{
						"data": 'shipper',
					},
					{
						"data": 'consigne',
					},
					{
						"data": "shipment_id",
						"render": function(data, type, row, meta) {
							return '<a href="<?= base_url('superadmin/order/print') ?>/' + data + '">' + data + '</a>';
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
							// return '<a href="<?= base_url('sales/salesOrder/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a><a href="<?= base_url('sales/salesOrder/edit/') ?>' + data + '" class="btn btn-sm text-light ml-2" style="background-color: #9c223b;">Edit</a>';

							return '<a href="<?= base_url('superadmin/Order/edit/') ?>' + data + '" class="btn btn-sm text-light ml-2" style="background-color: #9c223b;">Edit</a>';

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
							return '<a href="<?= base_url('shipper/order/print') ?>/' + data + '">' + data + '</a>';
						}
						// "render": function(data, type, row, meta) {
						// 	return '<a href="<?= base_url('uploads/barcode') ?>/' + data + '.pdf">' + data + '</a>';
						// }
					}, // Tampilkan kategori
					{
						"data": "shipper",
					},
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
							return '<a href="<?= base_url('shipper/order/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a><a href="<?= base_url('shipper/order/edit/') ?>' + data + '" class="btn btn-sm text-light ml-2" style="background-color: #9c223b;">Edit</a>';
						}
					},
				],
			});
		});
	</script>


	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytablecs').DataTable({
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
					"url": "<?= base_url('cs/order/view_data_query'); ?>", // URL file untuk proses select datanya
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
							return '<a href="<?= base_url('cs/order/print') ?>/' + data + '">' + data + '</a>';
						}
						// "render": function(data, type, row, meta) {
						// 	return '<a href="<?= base_url('uploads/barcode') ?>/' + data + '.pdf">' + data + '</a>';
						// }
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
							return '<a href="<?= base_url('cs/order/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a><a href="<?= base_url('cs/order/edit/') ?>' + data + '" class="btn btn-sm text-light ml-2" style="background-color: #9c223b;">Edit</a>';
						}
					},
				],
			});
		});
	</script>

	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytablesomgr').DataTable({
				"processing": true,
				// "responsive": true,
				"serverSide": true,
				"ordering": true, // Set true agar bisa di sorting
				"dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
					"<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
				"order": [
					[0, 'DESC']
				], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
				"ajax": {
					"url": "<?= base_url('sales/salesOrder/view_data_query'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return row.nama_user
						}
					}, {
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return row.tgl_pickup
						}
					},
					{
						"data": "time",
					},
					{
						"data": "shipper",
					},
					{
						"data": "destination",
					},
					{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							// return '<a href="<?= base_url('sales/salesOrder/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a><a href="<?= base_url('sales/salesOrder/edit/') ?>' + data + '" class="btn btn-sm text-light ml-2" style="background-color: #9c223b;">Edit</a>';
							if (row.status == 0) {
								return '<a href="<?= base_url('sales/salesOrder/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a><a href="<?= base_url('sales/salesOrder/edit/') ?>' + data + '" class="btn btn-sm text-light ml-2" style="background-color: #9c223b;">Edit</a>';
							} else {
								return '<a href="<?= base_url('sales/salesOrder/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>';

							}
						}
					},
				],
			});
		});
	</script>

	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytableso').DataTable({
				"processing": true,
				// "responsive": true,
				"serverSide": true,
				"ordering": true, // Set true agar bisa di sorting
				"dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
					"<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
				"order": [
					[0, 'DESC']
				], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
				"ajax": {
					"url": "<?= base_url('sales/salesOrder/view_data_query'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return row.tgl_pickup
						}
					},
					{
						"data": "time",
					},
					{
						"data": "shipper",
					},
					{
						"data": "destination",
					},
					{
						"data": "status",
						"render": function(data, type, row, meta) {
							if (data == 0) {
								return '<span class="label label-danger label-inline font-weight-lighter" style="width: 100px;">Request Pickup</span>';
							} else if (data == 5) {
								return '<span class="label label-secondary label-inline font-weight-lighter" style="width: 100px;">Cancel</span>';

							} else {
								return '<span class="label label-success label-inline font-weight-lighter" style="width: 100px;">Pickuped</span>';

							}
						}
					}, {
						"data": "status_approve",
						"render": function(data, type, row, meta) {
							if (data == 0) {
								if (row.lock == 0) {
									return '<small>Wait Until You Lock SO</small>';
								} else {
									return '<small>Wait Approve Manager</small>';
								}
							} else if (data == 1) {
								return '<span class="label label-primary label-inline font-weight-lighter" style="width: 120px;">Approve Manager</span>';
							} else if (data == 2) {
								return '<span class="label label-purple label-inline font-weight-lighter" style="width: 120px;">Approve CS</span>';
							} else {
								return '<span class="label label-success label-inline font-weight-lighter" style="width: 120px;">Approve Finance</span>';
							}

						}
					},
					{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							if (row.status == 0 || row.status == 1) {
								return `<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/detail/') ?>` + data + `" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/edit/') ?>` + data + `" class="btn btn-sm text-light ml-2" style="background-color: #9c223b;">Edit</a>
								<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/cancel/') ?>` + data + `" class="btn btn-sm text-light" style="background-color: #9c223b;">Cancel</a>`;
							} else {
								return `<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('sales/salesOrder/detail/') ?>` + data + `" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>`;

							}
						}
					},
				],
			});
		});
	</script>

	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytablesoin').DataTable({
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
					"url": "<?= base_url('shipper/salesOrder/view_data_query'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return row.sales
						}
					}, {
						"data": "tgl_pickup",
					},
					{
						"data": "time",
					},
					{
						"data": "shipper",
					},
					{
						"data": "destination",
					},
					{
						"data": "pu_poin",
					},
					{
						"data": "status",
						"render": function(data, type, row, meta) {
							if (data == 0) {
								return '<span class="label label-danger label-inline font-weight-lighter" style="width: 100px;">Request Pickup</span>';
							} else if (data == 5) {
								return '<span class="label label-secondary label-inline font-weight-lighter" style="width: 100px;">Cancel</span>';

							} else {
								return '<span class="label label-success label-inline font-weight-lighter" style="width: 100px;">Pickuped</span>';

							}
						}
					},
					{
						"data": "is_incoming",
						"render": function(data, type, row, meta) {
							if (data == 0) {
								return 'Outgoing';
							} else {
								return 'Incoming';
							}
						}
					},
					// {
					// 	"data": "status",
					// 	"render": function(data, type, row, meta) {
					// 		if (data == 0) {
					// 			return '<a href="#" class="btn btn-danger font-weight-bold btn-pill">Order In</a>';
					// 		} else if (data == 1) {
					// 			return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Order PU</a>';
					// 		} else if (data == 2) {
					// 			return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Order Pickuped</a>';
					// 		} else {
					// 			return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Order Finished</a>';
					// 		}
					// 	}
					// },
					{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return `<a onclick='$("#modalLoading").modal("show");' href="<?= base_url('shipper/salesOrder/detail/') ?>` + data + `" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>`;

						}
					},
				],
			});
		});
	</script>

	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytablesocs').DataTable({
				"processing": true,
				// "responsive": true,
				"serverSide": true,
				"ordering": true, // Set true agar bisa di sorting
				"dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
					"<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
				"order": [
					[0, 'DESC']
				], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
				"ajax": {
					"url": "<?= base_url('cs/salesOrder/view_data_query'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return row.sales
						}
					}, {
						"data": "tgl_pickup",
					},
					{
						"data": "time",
					},
					{
						"data": "shipper",
					},
					{
						"data": "pu_poin",
					},
					{
						"data": "destination",
					},
					{
						"data": "is_incoming",
						"render": function(data, type, row, meta) {
							if (data == 0) {
								return '<a href="#" class="btn btn-danger font-weight-bold btn-pill">No</a>';
							} else {
								return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Yes</a>';
							}
						}
					},
					// {
					// 	"data": "status",
					// 	"render": function(data, type, row, meta) {
					// 		if (data == 0) {
					// 			return '<a href="#" class="btn btn-danger font-weight-bold btn-pill">Order In</a>';
					// 		} else if (data == 1) {
					// 			return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Order PU</a>';
					// 		} else if (data == 2) {
					// 			return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Order Pickuped</a>';
					// 		} else {
					// 			return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Order Finished</a>';
					// 		}
					// 	}
					// },
					{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return '<a href="<?= base_url('cs/salesOrder/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>';

						}
					},
				],
			});
		});
	</script>

	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytabledriver').DataTable({
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
					"url": "<?= base_url('shipper/salesOrder/view_data_query'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": "shipper",
					}, {
						"data": "pu_poin",
					}, {
						"data": "tgl_pickup",
					},
					{
						"data": "time",
					},
					{
						"data": "status",
						"render": function(data, type, row, meta) {
							if (data == 0) {
								return '<a href="#" class="btn btn-danger font-weight-bold btn-pill">Process</a>';
							} else {
								return '<a href="#" class="btn btn-success font-weight-bold btn-pill">Success</a>';
							}
						}
					},
					{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return '<a href="<?= base_url('shipper/salesOrder/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>';

						}
					},
				],
			});
		});
	</script>

	<script>
		$(".radioBtnClass").change(function() {
			// bind a function to the change event
			if ($(this).is(":checked")) { // check if the radio is checked
				var selected = $(this).val(); // retrieve the value
				if (selected == 'ops') {
					$("#driver2").show();
				} else {
					$("#driver2").hide();
				}

			}
		});
	</script>

	<script>
		$(document).ready(function() {

			// // get Edit Product
			// $('.btn-edit').on('click', function() {
			// 	// get data from button edit
			// 	const id = $(this).data('id');
			// 	const name = $(this).data('name');
			// 	const price = $(this).data('price');
			// 	const category = $(this).data('category_id');
			// 	// Set data to Form Edit
			// 	$('.product_id').val(id);
			// 	$('.product_name').val(name);
			// 	$('.product_price').val(price);
			// 	$('.product_category').val(category).trigger('change');
			// 	// Call Modal Edit
			// 	$('#editModal').modal('show');
			// });
			// get Delete Product
			$('.btn-edit').on('click', function() {
				// get data from button edit
				const id = $(this).data('id');
				// Set data to Form Edit
				// $('#id2').innerHTML = id;
				document.getElementById("id2").innerHTML = id;
				$('.shipment_id').val(id);
				// Call Modal Edit
				$('#deleteModal').modal('show');
			});

		});
	</script>

	<script>
		$(document).ready(function() {
			$('#tableSalesTracker').DataTable();
		});
	</script>


	



	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytablesoinsuperadmin').DataTable({
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
					"url": "<?= base_url('superadmin/salesOrder/view_data_query'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return row.sales
						}
					}, {
						"data": "tgl_pickup",
					},
					{
						"data": "time",
					},
					{
						"data": "shipper",
					},
					{
						"data": "destination",
					},
					{
						"data": "pu_poin",
					},
					{
						"data": "status",
						"render": function(data, type, row, meta) {
							if (data == 0) {
								return '<span class="label label-danger label-inline font-weight-lighter" style="width: 100px;">Request Pickup</span>';
							} else if (data == 5) {
								return '<span class="label label-secondary label-inline font-weight-lighter" style="width: 100px;">Cancel</span>';

							} else {
								return '<span class="label label-success label-inline font-weight-lighter" style="width: 100px;">Pickuped</span>';

							}
						}
					},
					{
						"data": "is_incoming",
						"render": function(data, type, row, meta) {
							if (data == 0) {
								return 'Outgoing';
							} else {
								return 'Incoming';
							}
						}
					},

					{
						"data": "id_so",
						"render": function(data, type, row, meta) {
							return '<a href="<?= base_url('superadmin/salesOrder/detail/') ?>' + data + '" class="btn btn-sm mb-1 text-light" style="background-color: #9c223b;">Detail</a>';

						}
					},
				],
			});
		});
	</script>
	<script>
		const el = document.getElementById("foo");
		const inputEl = document.getElementById("nameFoo");
		el.addEventListener("change", function() {
			if (this.value === "1") {
				inputEl.style.display = "none";
			} else {
				inputEl.style.display = "block";
			}
		});

		function preview_image() {
			var total_file = document.getElementById("upload_file").files.length;
			for (var i = 0; i < total_file; i++) {
				$('#image_preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "' widht='900' height='300'><br>");
			}
		}
	</script>



	<script>
		$(document).ready(function() {
			var i = 2;
			$(".tambah-form-essay").on('click', function() {
				row = '<div class="rec-element2">' +
					'<div class="form-group">' +
					'<label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name">No. DO/DN ' + i + ' <span class="required"></span>' +
					'</label>' +
					'<div class="col-md-12 col-sm-12 col-xs-12"> ' +
					'<div class="input-group">' +
					'<input type="text" name="note_cs[]" id="note_cs' + i + '" alt="' + i + '" class="form-control">' +
					'<span class="input-group-btn">' +
					'<button type="button" class="btn btn-warning del-element2"><i class="fa fa-minus-square"></i> Hapus</button>' +
					'</span>' +
					'</div>' +
					'</div>' +
					'</div>' +
					'<div class="ln_solid"></div>' +

					'</div>';
				$(row).insertBefore("#nextkolom2");
				$('#jumlahkolom2').val(i + 1);
				i++;
			});
			$(document).on('click', '.del-element2', function(e) {
				e.preventDefault()
				i--;
				//$(this).parents('.rec-element').fadeOut(400);
				$(this).parents('.rec-element2').remove();
				$('#jumlahkolom2').val(i - 1);
			});
		});
	</script>



	<script>
		$(document).ready(function() {
			var i = 2;
			$(".tambah-so").on('click', function() {
				row = '<div class="rec-element">' +
					'<div class="form-group">' +
					'<label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name">No. SO/PO ' + i + ' <span class="required"></span>' +
					'</label>' +
					'<div class="col-md-12 col-sm-12 col-xs-12"> ' +
					'<div class="input-group">' +
					'<input type="text" name="no_so[]" id="no_so' + i + '" alt="' + i + '" class="form-control">' +
					'<span class="input-group-btn">' +
					'<button type="button" class="btn btn-warning del-element"><i class="fa fa-minus-square"></i> Hapus</button>' +
					'</span>' +
					'</div>' +
					'</div>' +
					'</div>' +
					'<div class="ln_solid2"></div>' +

					'</div>';
				$(row).insertBefore("#nextkolom");
				$('#jumlahkolom').val(i + 1);
				i++;
			});
			$(document).on('click', '.del-element', function(e) {
				e.preventDefault()
				i--;
				//$(this).parents('.rec-element').fadeOut(400);
				$(this).parents('.rec-element').remove();
				$('#jumlahkolom').val(i - 1);
			});
		});
	</script>

	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytablereportsales').DataTable({
				"processing": true,

				"serverSide": true,
				"ordering": true, // Set true agar bisa di sorting
				"dom": "<'row'<'col-lg-10 col-md-10 col-xs-12'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
					"<'row'<'col-lg-10 col-md-10 col-xs-12'l>>",
				"order": [
					[4, 'desc']
				], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
				"ajax": {
					"url": "<?= base_url('sales/salesOrder/report_order'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[5, 10, 50],
					[5, 10, 50]
				], // Combobox Limit
				"columns": [{
						"data": 'tgl_pickup',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": 'shipper',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": 'consigne',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": 'nama_user',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": "shipment_id",
						"render": function(data, type, row, meta) {
							return '<a target="blank" href="<?= base_url('sales/salesOrder/print') ?>/' + data + '">' + data + '</a>';
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
							return '<a href="<?= base_url('sales/salesOrder/trackingReport/') ?>' + data + '/' + row.id_so + '" class="btn btn-sm text-light" style="background-color: #9c223b;">Detail</a>';
						}
					},
				],
			});
		});
	</script>

	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#mytablereportsuperadmin').DataTable({
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
						"data": 'tgl_pickup',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": 'shipper',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": 'consigne',
						// "sortable": false,
						// render: function(data, type, row, meta) {
						// 	return meta.row + meta.settings._iDisplayStart + 1;
						// }
					},
					{
						"data": "shipment_id",
						"render": function(data, type, row, meta) {
							return '<a target="blank" href="<?= base_url('superadmin/order/print2') ?>/' + data + '">' + data + '</a>';
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
							return '<a href="<?= base_url('superadmin/order/edit/') ?>' + data + '/' + row.id_so + '" class="btn btn-sm text-light" style="background-color: #9c223b;">Edit</a>';
						}
					},

				],
			});
		});
	</script>

	<script>
		$(document).ready(function() {
			var i = 2;
			$(".tambah-ap").on('click', function() {
				row = '<div class="rec-element-ap" style="margin-left:20px">' +
					'<div class="row">' +
					'<div class="col-md-2">' +
					'<label for="note_cs">Choose Category ' + i + '</label>' +
					'<div class="form-group rec-element-ap">' +
					'<input type="text" class="browse-category form-control id_category" required id="id_category' + i + '"  name="id_category[]">' +
					'<input type="text" readonly class="browse-category required form-control" id="nama_kategori' + i + '" data-index="' + i + '" name="nama_kategori_pengeluaran[]">' +
					'</div>' +
					'</div>' +
					'<div class="col-md-4" style="margin-left:5px">' +
					'<label for="note_cs">Description ' + i + '</label>' +
					'<div class="form-group rec-element-ap">' +
					'<textarea class="form-control" id="descriptions' + i + '" name="descriptions[]" required></textarea>' +
					'</div>' +
					'</div>' +
					'<div class="col-md-2">' +
					'<label for="note_cs">Amount Proposed ' + i + '</label>' +
					'<div class="form-group rec-element-ap">' +
					'<input type="text" class="amount_proposed required form-control" id="rupiah1' + i + '" name="amount_proposed[]">' +
					'</div>' +
					'</div>' +
					'<div class="col-md-2">' +
					'<label for="note_cs">Attachment ' + i + '</label>' +
					'<div class="form-group rec-element-ap">' +
					'<input type="file" class="form-control" required  onchange="handleImageUploadTracker(this.id);" id="attachment' + i + '" name="attachment[]" accept="image/*" capture required>' +
					'<input type="file" class="form-control" required  id="upload_file-attachment' + i + '" name="attachment2[]" accept="image/*" hidden>' +

					'</div>' +
					'</div>' +
					'<div class="col-md-1">' +
					'<span class="input-group-btn">' +
					'<button type="button" class="btn btn-warning del-element_ap mt-4"><i class="fa fa-minus-square"></i></button>' +
					'</span>' +
					'</div>' +
					'<div class="ln_solid_ap"></div>' +
					'</div>';
				'</div>';

				$(row).insertBefore("#nextkolom_ap");
				const collection = document.getElementsByClassName("amount_proposed");
				for (let i = 0; i < collection.length; i++) {
					collection[i].addEventListener('keyup', function(e) {
						collection[i].value = formatRupiah(this.value, 'Rp. ');
					});
				}
				$('#jumlahkolom_ap').val(i + 1);
				i++;
			});
			$(document).on('click', '.del-element_ap', function(e) {
				e.preventDefault()
				i--;
				//$(this).parents('.rec-element').fadeOut(400);
				$(this).parents('.rec-element-ap').remove();
				$('#jumlahkolom_ap').val(i - 1);
			});
		});
	</script>


	<script>
		$('body').on("click", ".browse-category", function() {
			var index = $(this).attr('data-index');


			jQuery("#selectCategory").attr("data-index", index);
			jQuery("#selectCategory").modal("toggle");
		});



		$('body').on("click", '.btn-choose', function(e) {
			id_category = $(this).attr("data-id");

			indek = $("#selectCategory").attr("data-index");


			document.getElementById("id_category" + indek + "").value = $(this).attr('data-id');


			document.getElementById("nama_kategori" + indek + "").value = $(this).attr('data-nama');
			$("#selectCategory").modal('hide');
		});
	</script>


	<script type="text/javascript">
		$(document).ready(function() {
			const inputEl = document.getElementById("mode");
			const car = document.getElementById("car");
			const car2 = document.getElementById("car2");
			const car3 = document.getElementById("car3");
			const car4 = document.getElementById("car4");
			document.getElementById("car3").style.display = "block";
			$('#kat').change(function() {

				var id = $(this).val();
				if (id == 1) {
					document.getElementById("mode").style.display = "block";
					car.style.display = "none";
					car2.style.display = "none";
					car3.style.display = "block";
					car4.style.display = "none";
				} else if (id == 3) {
					document.getElementById("car").style.display = "block";
					document.getElementById("car2").style.display = "block";
					document.getElementById("car3").style.display = "block";
					document.getElementById("car4").style.display = "block";
				} else {
					inputEl.style.display = "none";
					car.style.display = "none";
					car2.style.display = "none";
					car3.style.display = "block";
					car4.style.display = "none";
				}

				$('#no_ca').change(function() {

					var nomor_ca = $(this).val();
					console.log(nomor_ca);
					$.ajax({
						url: "<?php echo site_url('Ap/getDataCa'); ?>",
						method: "POST",
						data: {
							nomor_ca: nomor_ca,
						},
						success: function(data) {
							// console.log('Berhasil');
							$('#ca_approved').val(data)

						},
						error: function(error) {
							// alert(error);
							console.log(JSON.stringify(error));
						}


					});

				});

			});

		});

		$(document).ready(function() {
			$('#modee').change(function() {

				var id = $(this).val();
				console.log(id);

				if (id == 1) {
					document.getElementById("via").style.display = "block";
				} else {
					inputEl.style.display = "none";
				}

			});


		});
	</script>

	<script>
		function Cash() {
			if (document.getElementById('tf').checked) {
				document.getElementById('via').style.display = "block";
			} else {
				document.getElementById('via').style.display = "none";
			}
		}
	</script>


	<script>
		$(document).on("click", ".open-Arrive", function() {
			var myBookId = $(this).data('id');
			var name = $(this).data('name');
			var code = $(this).data('code');
			$(".modal-body #id").val(myBookId);
			$(".modal-body #city_name").val(name);
			$(".modal-body #tree_code").val(code);

		});
	</script>

	<!-- ========= FORMAT RUPIAH ============ -->
	<script type="text/javascript">
		const collection = document.getElementsByClassName("amount_proposed");
		for (let i = 0; i < collection.length; i++) {
			collection[i].addEventListener('keyup', function(e) {
				collection[i].value = formatRupiah(this.value, 'Rp. ');
			});
		}

		/* Tanpa Rupiah */
		var tanpa_rupiah = document.getElementById('tanpa-rupiah');
		tanpa_rupiah.addEventListener('keyup', function(e) {
			tanpa_rupiah.value = formatRupiah(this.value);
		});

		/* Dengan Rupiah */
		var dengan_rupiah = document.getElementById('dengan-rupiah');
		dengan_rupiah.addEventListener('keyup', function(e) {
			dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
		});

		/* Fungsi */
		function formatRupiah(angka, prefix) {
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
				split = number_string.split(','),
				sisa = split[0].length % 3,
				rupiah = split[0].substr(0, sisa),
				ribuan = split[0].substr(sisa).match(/\d{3}/gi);

			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}



		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix) {
			// console.log(typeof(angka))
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
				split = number_string.split(','),
				sisa = split[0].length % 3,
				rupiah = split[0].substr(0, sisa),
				ribuan = split[0].substr(sisa).match(/\d{3}/gi);
			// tambahkan titik jika yang di input sudah menjadi angka ribuan

			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
	</script>

	<script>
		$(document).ready(function() {
			
			var approved = 0;

			// $('#no_ca').change(function() {
			// 	var id = $(this).val();
			// 	// console.log(id);
			// 	$.ajax({
			// 		url: "<?php echo site_url('shipper/ap/getAp'); ?>",
			// 		method: "POST",
			// 		data: {
			// 			no_ap: id
			// 		},
			// 		async: true,
			// 		dataType: 'json',
			// 		success: function(data) {
			// 			approved = data.amount_approved;
			// 			$('#ca_approved').val(formatRupiah(approved, 'Rp. '));

			// 		}
			// 	});
			// 	return false;
			// 	// alert('not found');
			// });

			$(document).on("keyup", ".amount_proposed", function() {
				var sum = 0;
				var sisa = 0;
				var proposed = 0;
				approved = $('#ca_approved').val()
				$(".amount_proposed").each(function() {
					proposed = $(this).val();
					proposed = proposed.replace(/[^,\d]/g, '').toString();
					console.log(proposed);
					sum += +proposed;
				});
				sum = sum.toString();
				sum = formatRupiah(sum, 'Rp. ');
				// console.log(sum);
				$(".total_expanses").val(sum);
				// console.log(sum);
				sum = sum.replace(/[^,\d]/g, '').toString();
				sum = parseInt(sum, 10);
				approved = approved.replace(/[^,\d]/g, '').toString();
				approved = parseInt(approved, 10);
				console.log('ini aproved');
				console.log(approved);
				sisa = approved - sum;
				sisa = sisa.toString();
				console.log(sisa)
				sisaFormat = formatRupiah(sisa, 'Rp. ')
				if (parseInt(sisa) < 0) {
					$("#overless").text('Less');
				} else {
					$("#overless").text('Over');
				}
				$("#sisa").val(sisaFormat);
			});

		});
	</script>

	<script>
		$(document).on("click", ".open-Customer", function() {
			var id = $(this).data('id');
			var nama = $(this).data('nama');
			var email = $(this).data('email');
			var pic = $(this).data('pic');
			var no_telp = $(this).data('no_telp');
			var provinsi = $(this).data('provinsi');
			var kota = $(this).data('kota');
			var alamat = $(this).data('alamat');

			$(".modal-body #id_customer").val(id);
			$(".modal-body #nama_pt").val(nama);
			$(".modal-body #email").val(email);
			$(".modal-body #pic").val(pic);
			$(".modal-body #no_telp").val(no_telp);
			$(".modal-body #provinsi").val(provinsi);
			$(".modal-body #kota").val(kota);
			$(".modal-body #alamat").val(alamat);

		});
	</script>
	
	<script>
		$('button[type="submit"]').on('click', function() {
			var button = $(this);
			setTimeout(function() {
				button.prop('disabled', true);
				setTimeout(function() {
					button.prop('disabled', false);
				}, 3000); // Jeda 2 detik untuk mengaktifkan kembali tombol
			}, 200); // Jeda 1 detik untuk menonaktifkan tombol
		});
	</script>





</body>
<!--end::Body-->

</html>