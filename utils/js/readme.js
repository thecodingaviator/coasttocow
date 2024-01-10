/**
 * Filename: readme.js
 * Author: Gordon Doore, Parth Parth
 * Date: 01/09/2023
 * Description: This script provides functionality to fill readme submission form dynamically
 *              based on user-selected data fetched through AJAX in conenected database. It also
 *              includes event handling for button clicks and text node
 *              manipulation for asterisk wrapping allowing for formatting the selected data.
 */


/**
 * Fills a form with data fetched through AJAX based on the selected title.
 * If the selected title is "None," an alert is shown, and the function exits.
 * Uses the fetched data to populate various form fields.
 * Also includes event attachment for a button and a function to wrap asterisks in the document body.
 *
 * @function fillForm
 * @throws {Error} If there is an issue with the AJAX request.
 */
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
      console.log(data);
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

/**
 * Attaches the `fillForm` function to a button click event.
 * Removes any existing click event to prevent multiple event bindings.
 *
 * @function attachFillFormEvent
 */
function attachFillFormEvent() {
  var fillFormButton = document.getElementById('fill_from_title');
  fillFormButton.removeEventListener('click', fillForm);
  fillFormButton.addEventListener('click', fillForm);
}

/**
 * Recursively wraps asterisks within text nodes with a span element for styling.
 *
 * @function wrapAsterisks
 * @param {Node} element - The HTML element to traverse and wrap asterisks.
 */
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

function questionSets(){
  //use an event listener for the id: data_sect.  When it has been defined we remove 
  //the current question set and then the right one defined by data_sect

  //get the current data sect 
  var data_sect = document.getElementById('data_sect').value;
  //map this to a questionSet, throw error if can't find one
  
  fetch('questionSets.json')
  .then(response => response.json())
  .then(data => {
    uestionSets = data;
    updateQuestionsBasedOnInput('data_sect', 'questions', questionSets);
  });

  var questionSet = questionSets[data_sect];
  if (!questionSet) {
    throw new Error('No question set found for data_sect: ' + data_sect);
  }

  //remove current questionset if it exists and make the content questionSet
  removeCurrentQuestionSet();

  //wrap new question set in html
  var questionSetDiv = wrapQuestionSet(questionSet);

  //append new set to the form
  appendQuestionSet(questionSetDiv);
}

function updateQuestionsBasedOnInput(inputElementId, questionsDivId, questionSets) {
  document.getElementById(inputElementId).addEventListener('change', function(event) {
    var questionsDiv = document.getElementById(questionsDivId);
    questionsDiv.innerHTML = ''; // Clear current questions

    var selectedOption = event.target.value;
    var questions = questionSets[selectedOption] || []; // Default to empty array if no questions for this option

    questions.forEach(function(question) {
      questionsDiv.innerHTML += '<label for="' + question.id + '">' + question.label + '</label><br>';
      
      if (question.responseType === 'checkbox') {
        question.options.forEach(function(option, index) {
          questionsDiv.innerHTML += '<input type="' + question.responseType + '" id="' + question.id + index + '" name="' + question.id + '"><label for="' + question.id + index + '">' + option + '</label><br>';
        });
      } else {
        questionsDiv.innerHTML += '<input type="' + question.responseType + '" id="' + question.id + '" name="' + question.id + '"><br>';
      }
    });
  });
}


// Initial call to attach the event to existing buttons
attachFillFormEvent();
wrapAsterisks(document.body);

