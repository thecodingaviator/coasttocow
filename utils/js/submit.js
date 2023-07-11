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

function changeTab(event, tabId) {
  // Hide all tab content
  var tabs = document.getElementsByClassName("tab");
  for (var i = 0; i < tabs.length; i++) {
    tabs[i].style.display = "none";
  }

  // Show the selected tab content
  document.getElementById(tabId).style.display = "block";

  // Prevent the default link behavior
  event.preventDefault();
}
