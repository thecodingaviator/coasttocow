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

function fillForm() {
  var selectedTitle = document.getElementById('entryTitles').value;

  // Use AJAX to fetch data from the server and populate the form fields
  // Example using Fetch API:
  fetch('getData.php?title=' + selectedTitle)
      .then(response => response.json())
      .then(data => {
          document.getElementById('creation_date').value = data.creation_date;
          document.getElementById('subcommittee').value = data.subcommittee;
          document.getElementById('primary_contact').value = data.primary_contact;
          document.getElementById('title').value = data.title;

          // Checkboxes for creators
          var creators = document.getElementsByName('creators');
          creators.forEach(creator => {
              creator.checked = data.creators.includes(creator.value);
          });

          // Acknowledgements textarea
          document.getElementById('acknowledgements').value = data.acknowledgements;

          // Data Usage Agreement textarea
          document.getElementById('data_usage_agreement').value = data.data_usage_agreement;

          // Keywords input
          document.getElementById('keywords').value = data.keywords;

          // Licensed Data select
          document.getElementById('licensed_data').value = data.licensed_data;

          // Data and File(s) Overview textarea
          document.getElementById('data_overview').value = data.data_overview;

          // Sharing and Access Information textarea
          document.getElementById('sharing_access_info').value = data.sharing_access_info;

          // Links to Publications input
          document.getElementById('publications_links').value = data.publications_links;

          // IRB Compliance select
          document.getElementById('irb_compliance').value = data.irb_compliance;

          //Public links to data
          document.getElementById('data_links').value = data.data_links;

          //Ancillary Relationships
          document.getElementById('ancillary_relationships').value = data.ancillary_relationships;

          //Github_link
          document.getElementById('github_link').value = data.github_link;

          //number of files num_files
          document.getElementById('num_files').value = data.num_files;

          // Dataset Change Log textarea
          document.getElementById('change_log').value = data.change_log;

          // Methodological Information textarea
          document.getElementById('methodological_info').value = data.methodological_info;

          // Tech for Creation textarea
          document.getElementById('tech_for_creation').value = data.tech_for_creation;

          // Sample Collection Procedure textarea
          document.getElementById('sample_collection_procedure').value = data.sample_collection_procedure;

          // Collection Conditions input
          document.getElementById('collection_conditions').value = data.collection_conditions;

          // Other Collection input
          document.getElementById('other_collection').value = data.other_collection;

          // Cleaned Data select
          document.getElementById('cleaned_data').value = data.cleaned_data;

          // Cleaning Methods input
          document.getElementById('cleaning_methods').value = data.cleaning_methods;

          // QA Procedures input
          document.getElementById('qa_procedures').value = data.qa_procedures;

          // Key Analytic Methods input
          document.getElementById('key_analytic_methods').value = data.key_analytic_methods;

          // Key Softwares input
          document.getElementById('key_softwares').value = data.key_softwares;

          // Key Software Address input
          document.getElementById('key_software_address').value = data.key_software_address;

          // Other Software Info input
          document.getElementById('other_software_info').value = data.other_software_info;

          // Naming Conventions input
          document.getElementById('naming_conventions').value = data.naming_conventions;

          // Abbreviations Used input
          document.getElementById('abbreviations_used').value = data.abbreviations_used;

          // Variables Used input
          document.getElementById('variables_used').value = data.variables_used;

          // Dependencies input
          document.getElementById('dependencies').value = data.dependencies;

          // Additional Information textarea
          document.getElementById('additional_info').value = data.additional_info;
      })
      .catch(error => console.error('Error:', error));
}

// Initial call to attach the event to existing buttons
attachRemoveAuthorEvent();
