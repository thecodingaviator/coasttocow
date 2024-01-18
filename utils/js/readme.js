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
 *WILL EVENTUALLY NEED TO BE UPDATED TO INCLUDE ALL DATA SECTS OR SEPARATED TO MULTIPLE FUNCTIONS!
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

/**
 * Fetches question sets from a JSON file and returns the set corresponding to the current data section.
 * 
 * The current data section is determined by the value of the 'data_sect' element in the DOM.
 * 
 * @returns {Promise} A promise that resolves to the question set for the current data section.
 * If the data section is 'animalTrials', the promise resolves to data.animalTrials.
 * If the data section is 'socialScience', the promise resolves to data.socialScience.
 * If the data section is 'other', the promise resolves to data.other.
 * If the data section does not match any of these options, the promise rejects with an error.
 */
function questionSets(){
  //get the current data sect 
  var data_sect = document.getElementById('data_sect').value;
  
  return fetch('utils/js/questionSets.json')
  .then(response => response.json())
  .then(data => {
    console.log(data);
    var questionSet = null;
    if (data_sect == "animalTrials"){
      questionSet = data.animalTrials;
    }
    else if (data_sect == "socialScience"){
      questionSet = data.socialScience;
    }
    else if (data_sect == "other"){
      questionSet = data.other;
    }
    if (!questionSet) {
      throw new Error('No question set found for data_sect: ' + data_sect);
    }
    return questionSet;
  });
}

/**
 * Updates the questions displayed in a specified HTML element based on a provided question set.
 * 
 * This function first clears any existing content in the specified HTML element. It then iterates over the provided question set,
 * creating and appending new HTML elements for each question. The type of HTML element created for each question depends on the question's type.
 * 
 * @param {string} questionsDivId - The ID of the HTML element where the questions should be displayed.
 * @param {Array} questionSet - An array of question objects. Each object should have a 'type', 'id', and 'label' property, and may optionally have an 'options' property if the type is 'checkbox', 'radio', or 'select'.
 */
function updateQuestionsBasedOnInput(questionsDivId, questionSet) {
  var questionsDiv = document.getElementById(questionsDivId);

  // Clear current questions
  while (questionsDiv.firstChild) {
    questionsDiv.removeChild(questionsDiv.firstChild);
  }
  //Loop through new question set
  questionSet.forEach(function(question) {
    //All questions get a label regardless of type
    var label = document.createElement('label');
    label.setAttribute('for', question.id);
    label.textContent = question.label;
    questionsDiv.appendChild(label);

    //now we need to create the input element based on the type
    //for multiple choice questions, we need to create an input for each option
    if (question.type === "checkbox" || question.type === "radio") {
      question.options.forEach(function(option, index) {
        var input = document.createElement('input');
        input.type = question.type;
        input.id = question.id + index;
        input.name = question.id;
        questionsDiv.appendChild(input);
      });
    } 
    //for text area we need to account for rows
    else if (question.type === "textarea") {
      var textarea = document.createElement('textarea');
      textarea.id = question.id;
      textarea.name = question.id;
      textarea.rows = question.rows;
      questionsDiv.appendChild(textarea);
    }
    //for select we need to create an option for each selection
    else if (question.type === "select") {
      var select = document.createElement('select');
      select.id = question.id;
      select.name = question.id;

      question.options.forEach(function(option) {
        var optionElement = document.createElement('option');
        optionElement.value = option;
        optionElement.textContent = option;
        select.appendChild(optionElement);
      });
      questionsDiv.appendChild(select);
    }
    //general case for all other types, text and date mostly
    else {
      var input = document.createElement('input');
      input.type = question.type;
      input.id = question.id;
      input.name = question.id;
      questionsDiv.appendChild(input);
    }
  });
  wrapAsterisks(document.body);
}


// Initial call to attach the event to existing buttons
attachFillFormEvent();
wrapAsterisks(document.body);

