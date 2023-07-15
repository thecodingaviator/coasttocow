function handleFileUpload() {
  var form = document.getElementById('upload_form');
  var formData = new FormData(form);

  //get form data submitted and give it to upload.php
  fetch('/upload.php', {
  method: 'POST',
  body: formData,
  })
  .then(response => response.text())
  //if it gets to upload, success will be printed
  .then(result => {
    console.log('Success:', result);
  })
  .catch(error => {
    console.error('Error:', error);
  });
}
