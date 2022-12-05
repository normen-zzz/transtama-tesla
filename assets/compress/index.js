async function handleImageUpload(id) {
	$("#modalLoading").modal("show");
	var fileUpload = document.getElementById(id);
	//This is a hidden input in the html document. This is what will be sent to the server.
	var fileUploads = document.getElementById("upload_file2");
	$("#upload_file2").on("change", function () {
		fileUploads = document.getElementById("upload_file2");
	});
	var formData = new FormData();

	const options = {
		maxSizeMB: 0.2,
		maxWidthOrHeight: 1920,
		useWebWorker: true,
	};
	console.log(fileUpload.files);
	var file;
	var imageFile = "";
	const dataTransfer = new DataTransfer();
	const compressedImages = [];
	for (let i = 0; i < fileUpload.files.length; i++) {
		var fileNameExt = fileUpload.files[i].name;
		var ext = fileNameExt.split(".");
		ext = ext[ext.length - 1];
		console.log(ext);

		if (ext == "heic" || ext == "heif") {
			var blob = new Blob([fileUpload.files[i]], { type: "image/" + ext });
			await heic2any({
				blob: blob,
				toType: "image/jpeg",
				quality: 0.5, // cuts the quality and size by half
			})
				.then(function (resultBlob) {
					console.log("hasil convert");
					console.log(resultBlob);
					let file = new File([resultBlob], fileUpload.files[i].name + ".jpg", {
						type: "image/jpeg",
					});
					imageFile = file;
					console.log("ini image file heif");
					console.log(imageFile);
				})
				.catch(function (x) {
					console.log(x.code);
					console.log(x.message);
				});
		} else {
			imageFile = fileUpload.files[i];
		}
		fileUploads = document.getElementById("upload_file2");
		try {
			console.log("Ini File Asli");
			console.log(imageFile);
			const compressedFile = await imageCompression(imageFile, options);
			compressedImages.push(compressedFile);
			// console.log(compressedImages[i]);
		} catch (error) {
			console.log(error);
		}
		console.log("masukin file ke" + [i + 1]);
		file = new File([compressedImages[i]], [compressedImages[i].name], {
			type: "image/jpeg",
		});
		if (fileUploads.files.length == 0) {
			dataTransfer.items.add(file);
		} else {
			console.log("Coba LIat Fileuploads di else");
			console.log(fileUploads.files[0]);
			console.log("Ini Yg File baru");
			console.log(file);

			for (let k = 0; k < fileUploads.files.length; k++) {
				if (dataTransfer.items.add(fileUploads.files[k])) {
					console.log("Tambah Di else Yg pertama berhasil");
				}
			}
			if (dataTransfer.items.add(file)) {
				console.log("Data Kedua berhasil");
			}
		}
	}

	if ((fileUploads.files = dataTransfer.files)) {
		dataTransfer.items.clear();
		var $el = $("#" + id);
		// $el.wrap("<form>").closest("form").get(0).reset();
		// $el.unwrap();
		$el.prop("disabled", true);
		console.log("success Clear");
	}

	console.log("Isi Input Kdua");
	console.log(fileUploads.files);
	setTimeout(function () {
		if ($("#modalLoading").modal("hide")) {
			console.log("Sembunyiin modal");
		}
	}, 2000);

	// console.log("Ini Isi items");
	// console.log(dataTransfer.items);
	// alert(fileUploads.files);
}
