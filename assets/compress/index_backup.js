function getImageDimensions(image) {
	return new Promise((resolve, reject) => {
		image.onload = function (e) {
			const width = this.width;
			const height = this.height;
			resolve({ height, width });
		};
	});
}

function compressImage(image, scale, initalWidth, initalHeight) {
	return new Promise((resolve, reject) => {
		const canvas = document.createElement("canvas");

		canvas.width = scale * initalWidth;
		canvas.height = scale * initalHeight;

		const ctx = canvas.getContext("2d");
		ctx.drawImage(image, 0, 0, canvas.width, canvas.height);

		ctx.canvas.toBlob((blob) => {
			resolve(blob);
		}, "image/png");
	});
}

const imageInput = document.getElementById("upload_file");

// $("#upload_file").on("change", async (e) => {
// 	const reader = new FileReader();
// 	reader.addEventListener("load", async (event) => {
// 		const image = event.target.result;

// 	});
// });
let container = new DataTransfer();
var foto;
document
	.getElementById("upload_file")
	.addEventListener("change", async (event) => {
		console.log("ini image input");
		console.log(imageInput.files);
		const file = event.target.files[0];
		const image = event.target.files;
		// console.log("ini target files");
		// console.log(image);

		for (let k = 0; k < image.length; k++) {
			// console.log(image[k].name);
			const uploadedImage = image[k];
			if (!uploadedImage) {
				// if no file is uploaded, no need to do anything
				return;
			}
			//preview the inputted image
			const inputPreview = document.getElementById("input-preview");
			inputPreview.src = URL.createObjectURL(uploadedImage);
			//get the dimensions of the input image
			const { height, width } = await getImageDimensions(inputPreview);
			const MAX_WIDTH = 200; //if we resize by width, this is the max width of compressed image
			const MAX_HEIGHT = 200; //if we resize by height, this is the max height of the compressed image
			const widthRatioBlob = await compressImage(
				inputPreview,
				MAX_WIDTH / width,
				width,
				height
			);
			const heightRatioBlob = await compressImage(
				inputPreview,
				MAX_HEIGHT / height,
				width,
				height
			);
			//pick the smaller blob between both
			const compressedBlob =
				widthRatioBlob.size > heightRatioBlob.size
					? heightRatioBlob
					: widthRatioBlob;
			// preview the compressed blob
			const outputPreview = document.getElementById("output-preview");
			outputPreview.src = URL.createObjectURL(compressedBlob);
			/*in some cases, the initial uploaded image maybe smaller than our compressed result.
		      if that is the case, reuse the uploaded image. */
			const optimalBlob =
				compressedBlob.size < uploadedImage.size
					? compressedBlob
					: uploadedImage;
			console.log(
				`Inital Size: ${uploadedImage.size}. Compressed Size: ${optimalBlob.size}`
			);
			getImgURL(URL.createObjectURL(compressedBlob), async (imgBlob) => {
				// Load img blob to input
				// WIP: UTF8 character error

				let fileName = image[k].name;
				let file = new File(
					[imgBlob],
					fileName,
					{ type: image[k].type, lastModified: new Date().getTime() },
					"utf-8"
				);
				// $("input[name='ktp2[]']").val(file);
				container.items.add(file);

				console.log("data Ke" + [k]);
			});

			// $("input[name='ktp2[]']").val(URL.createObjectURL(compressedBlob));
			// $("#upload_file2").val(compressedBlob);
			// console.log(compressedBlob);
			URL.revokeObjectURL(inputPreview);
			URL.revokeObjectURL(outputPreview);
			// console.log(URL.createObjectURL(compressedBlob));
			// console.log("ini foto");
		}
		console.log("ini Container");
		console.log(container.files);
		document.querySelector("#upload_file2").files = container.files;
		// $('input:file[name="ktp2[]"]').val(foto);
		// console.log("Ini isi dari input file ktp");
		// console.log($("input[name='ktp[]']").val());
		// document.querySelector("#upload_file2").files = foto;

		// $("input[name='ktp2[]']").val(foto);
	});

function getImgURL(url, callback) {
	var xhr = new XMLHttpRequest();
	xhr.onload = function () {
		callback(xhr.response);
	};
	xhr.open("GET", url);
	xhr.responseType = "blob";
	xhr.send();
}
