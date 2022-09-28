async function handleImageEditUpload(id, no) {
	var fileUpload = document.getElementById(id);
	//This is a hidden input in the html document. This is what will be sent to the server.
	var fileUploads = document.getElementById("upload_fileedit" + no);
	$("#upload_fileedit" + no).on("change", function () {
		fileUploads = document.getElementById("upload_fileedit");
	});
	var formData = new FormData();
	console.log(no);

	const options = {
		maxSizeMB: 0.2,
		maxWidthOrHeight: 1920,
		useWebWorker: true,
	};
	console.log(fileUpload);
	var file;
	const dataTransfer = new DataTransfer();
	const compressedImages = [];
	for (let i = 0; i < fileUpload.files.length; i++) {
		const imageFile = fileUpload.files[i];
		fileUploads = document.getElementById("upload_fileedit" + no);
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

	// console.log("Ini Isi items");
	// console.log(dataTransfer.items);
	// alert(fileUploads.files);
}
