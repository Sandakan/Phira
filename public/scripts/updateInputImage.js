function updateImage(input_id, image_id) {
	const input = document.getElementById(input_id);
	const image = document.getElementById(image_id);

	// Check if a file is selected
	if (input.files && input.files[0]) {
		const reader = new FileReader();

		// When the file is read successfully, update the image source
		reader.onload = function (e) {
			image.src = e.target.result; // Set the image source to the uploaded file
		};

		reader.readAsDataURL(input.files[0]); // Read the file as a data URL
	}
}
