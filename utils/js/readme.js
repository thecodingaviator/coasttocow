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

function attachFillFormEvent() {
  var fillFormButton = document.getElementById('fill_from_title');
  fillFormButton.removeEventListener('click', fillForm);
  fillFormButton.addEventListener('click', fillForm);
}

function removeAuthor(event) {
  var authorDiv = event.target.parentNode;
  authorDiv.parentNode.removeChild(authorDiv);
}

function fillForm() {

  var selectedTitle = document.getElementById('selected_title').value;
  //check if this even exists and throw if not
  if (selectedTitle == "None") {
    alert("Please select a title from the dropdown menu.");
    return;
  }

  // Use AJAX to fetch data from the server and populate the form fields
  fetch('/utils/getReadMeData.php?title=' + selectedTitle)
    .then(response => response.text())
    .then(data => {
      data = JSON.parse(data);
      document.getElementById('subcommittee').value = data["subcommittee"];
      document.getElementById('primary_contact').value = data["primary_contact"];

      // Checkboxes for creators THIS LOOKS A BIT WRONG
      var creators = document.getElementsByName('institution');
      creators.forEach(creator => {
        creator.checked = data.creators.includes(creator.value);
      });

      // Acknowledgements textarea
      document.getElementById('acknowledgements').value = data.acknow;

      // Data Usage Agreement textarea
      document.getElementById('data_usage_agreement').value = data.data_usage_agreement;

      // Keywords input
      document.getElementById('keywords').value = data.keywords;

      // Licensed Data select
      document.getElementById('licensed_data').value = data.licensed_data;

      // Data and File(s) Overview textarea
      document.getElementById('data_overview').value = data.file_description;

      // Links to Publications input
      document.getElementById('publications_links').value = data.publication_link;

      // IRB Compliance select
      document.getElementById('iacuc_compliance').value = data.iacuc;

      //Public links to data
      document.getElementById('data_links').value = data.alternate_available_link;

      //Ancillary Relationships
      document.getElementById('ancillary_relationships').value = data.ancillary_link;

      //Github_link
      document.getElementById('github_link').value = data.github_link;

      //number of files num_files
      document.getElementById('num_files').value = data.num_files_readme;

      // Dataset Change Log textarea
      document.getElementById('change_log').value = data.dataset_change_log;

      // Tech for Creation textarea
      document.getElementById('tech_for_creation').value = data.technology_for_creation;

      // Sample Collection Procedure textarea
      document.getElementById('sample_collection_procedure').value = data.sample_collection_procedure;

      // Collection Conditions input
      document.getElementById('collection_conditions').value = data.conditions_collection;

      // Other Collection input
      document.getElementById('other_collection').value = data.data_collection_other;

      // Cleaned Data select
      document.getElementById('cleaned_data').value = data.cleaned;

      // Cleaning Methods input
      document.getElementById('cleaning_methods').value = data.cleaning_desc;

      // QA Procedures input
      document.getElementById('qa_procedures').value = data.qa_procedures;

      // Key Analytic Methods input
      document.getElementById('key_analytic_methods').value = data.key_analytical_methods;

      // Key Softwares input
      document.getElementById('key_softwares').value = data.key_softwares;

      // Key Software Address input
      document.getElementById('key_software_address').value = data.key_software_address;

      // Other Software Info input
      document.getElementById('other_software_info').value = data.other_software_information;

      // Naming Conventions input
      document.getElementById('naming_conventions').value = data.naming_conventions;

      // Abbreviations Used input
      document.getElementById('abbreviations_used').value = data.abbreviations_definition;

      // Variables Used input
      document.getElementById('variables_used').value = data.variables_description;

      // Dependencies input
      document.getElementById('dependencies').value = data.dependencies;

      // Additional Information textarea
      document.getElementById('additional_info').value = data.other_information;
    })
    .catch(error => console.error('Error:', error));
}

function wrapAsterisks(element) {
  if (element.hasChildNodes()) {
    element.childNodes.forEach(child => {
      wrapAsterisks(child);
    });
  } else if (element.nodeType === Text.TEXT_NODE) {
    if (element.textContent.includes('*')) {
      const newHTML = element.textContent.replace(/\*/g, '<span class="red-asterisk">*</span>');
      const newSpan = document.createElement('span');
      newSpan.innerHTML = newHTML;
      element.parentNode.replaceChild(newSpan, element);
    }
  }
}

// Initial call to attach the event to existing buttons
attachRemoveAuthorEvent();
attachFillFormEvent();
wrapAsterisks(document.body);