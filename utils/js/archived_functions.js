/**
 * Adds an event listener to the 'add_creator' button to create and append a new creator form to the 'creators_container' div.
 * 
 * The new creator form includes fields for the creator's name and ORCID, and a 'Remove Creator' button.
 * The 'Remove Creator' button removes the creator form when clicked and updates the 'add_creator' button text and color.
 * The 'add_creator' button text and color are also updated based on whether the limit of 6 creators has been reached.
 * 
 * @listens {click} - When the 'add_creator' button is clicked.
 * @fires {click} - When the 'Remove Creator' button is clicked.
 * @throws {Error} - If the 'creators_container' or 'add_creator' elements do not exist in the DOM.
 */
function addCreatorFields() {
    document.getElementById('add_creator').addEventListener('click', function(e) {
      e.preventDefault();
  
      var creatorsContainer = document.getElementById('creators_container');
      var addCreatorButton = document.getElementById('add_creator');
  
      // Only add a new creator if the limit hasn't been reached
      if (creatorsContainer.children.length < 6) {
        var newCreator = document.createElement('div');
        newCreator.className = 'creator';
  
        var creatorLabel = document.createElement('label');
        creatorLabel.textContent = 'Additional Creator/Author';
        creatorLabel.htmlFor = 'creators';
  
        var creatorInput = document.createElement('input');
        creatorInput.type = 'text';
        creatorInput.id = 'creators';
        creatorInput.name = 'creators';
        creatorInput.required = true;
  
        var orcidLabel = document.createElement('label');
        orcidLabel.textContent = 'Additional Creator/Author ORCID';
        orcidLabel.htmlFor = 'orcids';
  
        var orcidInput = document.createElement('input');
        orcidInput.type = 'text';
        orcidInput.id = 'orcids';
        orcidInput.name = 'orcids';
  
        var removeButton = document.createElement('button');
        removeButton.textContent = 'Remove Creator';
        removeButton.addEventListener('click', function(e) {
          e.preventDefault();
          creatorsContainer.removeChild(newCreator);
  
          // Update the button text and color when a creator is removed
          if (creatorsContainer.children.length < 6) {
            addCreatorButton.style.color = 'white';
            addCreatorButton.textContent = 'Add Another Creator/Author';
          }
        });
  
        // Append the new fields to the new creator div
        newCreator.appendChild(creatorLabel);
        newCreator.appendChild(creatorInput);
        newCreator.appendChild(orcidLabel);
        newCreator.appendChild(orcidInput);
        newCreator.appendChild(removeButton);
  
        creatorsContainer.appendChild(newCreator);
      }
  
      // Update the button text and color based on whether the limit has been reached
      if (creatorsContainer.children.length >= 6) {
        addCreatorButton.style.color = 'red';
        addCreatorButton.textContent = 'Creator limit reached';
      } else {
        addCreatorButton.style.color = 'white';
        addCreatorButton.textContent = 'Add Another Creator/Author';
      }
    });
  }