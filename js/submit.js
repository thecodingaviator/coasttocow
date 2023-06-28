// js/submit.js
function handleFileUpload() {
    var form = document.getElementById('upload_form');
    var formData = new FormData(form);
    
    fetch('upload.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(result => {
      console.log('Success:', result);
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }