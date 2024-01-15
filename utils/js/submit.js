/**
 * Filename: submit.js
 * Author: Gordon Doore, Parth Parth
 * Date: 01/09/2023
 * Code for submission of uploaded file
 *
 * 
 * 
 * @function handleFileUpload
 * @description
 *   Fetches form data from the specified HTML form, sends it to the server-side
 *   script (upload.php) using AJAX, and displays a loader during the upload process.
 *   Upon successful upload, it logs the success message and redirects to a confirmation page.
 *   In case of an error, it logs the error message.
 */
function handleFileUpload() {
  var form = document.getElementById('upload_form');
  console.log(form == null)
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