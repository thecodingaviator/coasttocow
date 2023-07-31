function handleFileUpload() {
  var form = document.getElementById('upload_form');
  var formData = new FormData(form);

  document.getElementsByClassName("loader")[0].style.display = "block";

  //get form data submitted and give it to upload.php
  fetch('/upload.php', {
  method: 'POST',
  body: formData,
  })
  .then(response => response.text())
  //if it gets to upload, success will be printed
  .then(result => {
    console.log('Success:', result);
    //redirect to confirm page only after upload.php has finished
  
    window.location.href = "confirmation.php"

    // remove loader
    document.getElementsByClassName("loader")[0].style.display = "none";
  })
  .catch(error => {
    console.error('Error:', error);
  });

}