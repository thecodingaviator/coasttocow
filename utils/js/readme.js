document.getElementById('add-author-btn').addEventListener('click', function () {
  var container = document.getElementById('primary_contact_container');
  var authors = container.querySelectorAll('.author-input').length;
  var newAuthor = authors + 1;

  var inputHTML = '<div class="author-input" id="author-input-' + newAuthor + '">' +
    '<label for="primary_contact' + newAuthor + '">Author ' + newAuthor + ':</label>' +
    '<input type="text" id="primary_contact' + newAuthor + '" class="primary_contact" name="authors[]">' +
    '<button type="button" class="remove-author-btn">Remove</button>' +
    '</div>';

  container.insertAdjacentHTML('beforeend', inputHTML);
  attachRemoveAuthorEvent();
});

function attachRemoveAuthorEvent() {
  var removeButtons = document.querySelectorAll('.remove-author-btn');
  removeButtons.forEach(function (button) {
    button.removeEventListener('click', removeAuthor);
    button.addEventListener('click', removeAuthor);
  });
}

function removeAuthor(event) {
  var authorDiv = event.target.parentNode;
  authorDiv.parentNode.removeChild(authorDiv);
}

// Initial call to attach the event to existing buttons
attachRemoveAuthorEvent();
