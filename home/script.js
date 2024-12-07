document.getElementById('extract-button').addEventListener('click', function() {
  const input = document.getElementById('image-input');
  const output = document.getElementById('output');
  const loading = document.getElementById('loading');

  if (input.files.length === 0) {
      output.value = "Please upload an image.";
      return;
  }

  const file = input.files[0];
  const reader = new FileReader();

  reader.onload = function(event) {
      const img = new Image();
      img.src = event.target.result;

      img.onload = function() {

        loading.classList.remove('hidden');
        Tesseract.recognize(
            img,
            'eng',
            {
                logger: info => console.log(info) // Optional: Log progress
            }
        ).then(({ data: { text } }) => {
            output.value = text;
            loading.classList.add('hidden');
        }).catch(err => {
            output.value = "Error: " + err;
            loading.classList.add('hidden'); 
        });
      };
  };

  reader.readAsDataURL(file);
});