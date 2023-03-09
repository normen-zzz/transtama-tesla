//Untuk CS

if ($("#cobascanCS").length) {
	var sendToCs = {
		resultFunction: function (result) {
			// $('.hasilscan').append($('<input name="id_karyawan" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
			// $.post("../cek.php", { noijazah: result.code} );
			var redirect = "tracking";

			$.redirectPost(redirect, { shipment_id: result.code, modal: 1 });
		},
	};
	var scanCs = $("#cobascanCS")
		.WebCodeCamJQuery(sendToCs)
		.data().plugin_WebCodeCamJQuery;

	scanCs.buildSelectMenu("#selectCamCs");
	scanCs.play();
	$("#selectCamCs").on("change", function () {
		scanCs.stop().play();
	});
}

/*  Without visible select menu
    decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
*/

// end for CS

//Untuk dispatcher dan ops

if ($("#cobascanOPS").length) {
	var sendToOps = {
		resultFunction: function (result) {
			// $('.hasilscan').append($('<input name="id_karyawan" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
			// $.post("../cek.php", { noijazah: result.code} );
			var redirect = "scan/cek_id";

			$.redirectPost(redirect, { id_karyawan: result.code });
		},
	};
	var scanOps = $("#cobascanOPS")
		.WebCodeCamJQuery(sendToOps)
		.data().plugin_WebCodeCamJQuery;

	scanOps.buildSelectMenu("select");
	scanOps.play();
	$("select").on("change", function () {
		scanOps.stop().play();
	});
}

if ($("#scanOutbond").length) {
	var sendToOutbond = {
		resultFunction: function (result) {
			// scanOutbond.stop();
			// $('.hasilscan').append($('<input name="id_karyawan" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
			// $.post("../cek.php", { noijazah: result.code} );
			var redirect = "scan/outbond";

			$.redirectPost(redirect, { id_karyawan: result.code });
		},
	};
	var scanOutbond = $("#scanOutbond")
		.WebCodeCamJQuery(sendToOutbond)
		.data().plugin_WebCodeCamJQuery;

	scanOutbond.buildSelectMenu("select");
	scanOutbond.play();
	$("select").on("change", function () {
		scanOutbond.stop().play();
	});
}

/*  Without visible select menu
    decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
*/

// end for ops

// jquery extend function
$.extend({
	redirectPost: function (location, args) {
		var form = "";
		$.each(args, function (key, value) {
			form += '<input type="hidden" name="' + key + '" value="' + value + '">';
		});
		$('<form action="' + location + '" method="POST">' + form + "</form>")
			.appendTo("body")
			.submit();
	},
});
