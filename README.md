# CoastCowConsumer Data Repository

This repository contains the source code for the **CoastCowConsumer Data Repository**. Created by [@thecodingaviator](https://github.com/thecodingaviator) and [@gordoncd](https://github.com/gordoncd).

[![deploy](https://github.com/thecodingaviator/coasttocow/actions/workflows/deploy.yml/badge.svg)](https://github.com/thecodingaviator/coasttocow/actions/workflows/deploy.yml)

## Table of Contents

- [Acknowledgements](#acknowledgements)
- [Description](#description)
- [File List](#file-list)
- [Usage](#usage)
- [Dependencies](#dependencies)
- [Installation](#installation)
- [Contributing](#contributing)
- [License](#license)

## Acknowledgements

We use state-of-the-art equipment and high-throughput protocols in our research. In the Bigelow Laboratory Analytical Facilities, we’ve developed in vitro batch assays that mimic a rumen for rapid comparisons of algal candidates and use mass spectrometry to look for promising compounds. Members of our team at the University of Vermont conduct further testing in continuous fermenters to understand how algae-based additives impact the dynamic rumen microbiome, which is responsible for the methane production. The best algal candidates, some of which come from Bigelow Laboratory’s National Center for Marine Microbiota and Algae collection, are being developed as additives to be used in holistic animal feeding trials with dairy cows at partnering research farms at University of New Hampshire, Wolfe’s Neck Center for Agriculture and the Environment, and William H. Miner Agricultural Research Institute. These studies explore the supplements’ nutritional value and subsequent effects on methane burps, milk quality, and milk yields of individual cows, as well as the implications to manure and soil health for grazing and conventional herds.

We are also conducting economic analyses with partners at Colby College, Syracuse University, and University of Vermont to explore pragmatic entry points into the supply chain and cost-benefits of using seaweed feed supplements for organic and conventional dairy in New England. In parallel, Clarkson University is using life cycle assessments to evaluate the cradle-to-grave impact on greenhouse gas emissions of the most promising seaweed additive candidates, including impacts to manure quality and utility in anaerobic digestion or as fertilizer – to ensure the final products represent a net greenhouse gas reduction and true seafood-based solution.

The Coast to Cow to Consumer Project is Funded By:

- Shelby Cullom Davis Charitable Fund
- USDA AFRI Sustainable Agriculture Systems Program
- USDA AFRI Organic Research and Extension Initiative

## Description

The **CoastCowConsumer Data Repository** is a web application designed to provide users with various features and functionality. It allows users to perform tasks such as data exploration, dataset submission, account registration, password reset, and more.

## File List

### `confirmation.php`

The `confirmation.php` file is responsible for displaying a confirmation page on the Coast to Cow Consumer Data Repository website. It provides feedback to the user based on certain conditions and includes HTML rendering and PHP logic.

The main features of the `confirmation.php` file are as follows:

- Email Notification: It checks if an email was sent by verifying the `$_SESSION['email_sent']` variable. If the variable is set to `true`, a notification is displayed on the confirmation page. The `$_SESSION['email_sent']` variable is then unset to prevent multiple notifications.
- Content Display: Within the content section, the file retrieves and displays any debugging messages stored in the `$_SESSION['update']` variable. If debugging messages are present, they are shown with a heading. If no debugging messages are found, a message indicating their absence is displayed.

Developers working on the `confirmation.php` file should consider the following:

- Content: Consider adding relevant content to the confirmation page, such as project statistics, additional instructions, or any other pertinent information.

---

### `dashboard.php`

The `dashboard.php` file represents the dashboard page of the Coast to Cow Consumer Data Repository website. It provides an interface for logged-in users to access various features and functionalities.

The file structure follows the standard PHP file format, starting with the `<?php` opening tag. It includes a combination of PHP statements and HTML markup, with PHP code enclosed within `<?php` and `?>` tags.

The main functionalities of the `dashboard.php` file include:

- Session management: The file checks whether a session is already active using `session_status()`. If not, it starts a new session using `session_start()`.
- User authentication: The file checks whether the user is logged in by verifying the `$_SESSION['logged_in']` variable. If not, the user is redirected to the login page using the `header()` function.
- Email notification: If an email was sent and the `$_SESSION['email_sent']` variable is set to `true`, a notification is displayed on the dashboard indicating that an email containing the user's UserID has been sent. The session variable is then unset to avoid displaying the notification multiple times.
- HTML rendering: The file defines the structure and presentation of the dashboard page using HTML markup. It includes a navigation bar (`navbar.php`) and a content area with various buttons for different functionalities.

Important considerations for future developers working on the dashboard page:

- Security: Ensure that the overall website implements strong security measures, including user authentication and authorization checks for accessing sensitive data or performing specific actions.
- Configuration: The file includes `utils/config.php` at the beginning, indicating the presence of a configuration file. Review the configuration file to ensure sensitive information like database connection details is properly protected.
- Styling: The file references CSS files (`dashboard-common.css`, `dashboard.css`) for styling. Modify these files to customize the appearance of the dashboard page if needed.
- Navigation: The file includes a navigation bar (`navbar.php`) that may contain links to other pages or functionality. Review and modify the navigation bar as necessary to reflect the structure of the website.
- Content: In progress and undecided contents likely will pertain to project statistics or relevent information.

---
### `download.php`

The `download.php` file is responsible for downloading files from Google Drive using a service account defined in the `credentials.php` file. This file should not be modified unless you understand its intricacies.

Here's an overview of the `download.php` file:

- Google Drive API Setup: The file sets up the Google Drive API by configuring the service account credentials from the relevent json file and defining the required scopes for accessing and interacting with Google Drive files.
- Handling File Download Requests: If the server receives a `GET` request and the `name` parameter is set, the file ID is extracted from the request. The file metadata, including the name and MIME type, is fetched using the Google Drive API.
- Setting Download Headers: The appropriate headers for file download are set to instruct the browser on how to handle the file. This includes the content type, disposition, transfer encoding, and other relevant headers.
- Downloading the File: The file content is fetched using the Google Drive API, and the content is outputted to the browser, triggering the file download.

Important notes:

- Do not modify the file unless you understand its purpose and implications.
- Ensure that the `utils/c3-testing-389115-f39fd8b05d5d.json` file exists and contains the correct credentials for the Google Drive service account.
- Verify the `vendor/autoload.php` path to include the required libraries properly.


---


### `explore_dash.php`

The `explore_dash.php` file represents the explore page of the Coast to Cow Consumer Data Repository website. It allows users to explore and visualize data from the MySQL database.

The file structure follows the standard PHP file format, starting with the `<?php` opening tag. It includes a combination of PHP statements and HTML markup, with PHP code enclosed within `<?php` and `?>` tags.

The main functionalities of the `explore_dash.php` file include:

- Database interaction: The file retrieves data from the MySQL database using a prepared statement. The query selects components, calculates the average AsFed and DM values from the `C3AnalysisTMR` table, and groups the data by components.
- HTML rendering: The file defines the structure and presentation of the explore page using HTML markup. It includes a navigation bar (`navbar.php`) and a content area with buttons for exploring different datasets and a chart to display the average AsFed and DM values by component type.
- Chart.js integration: The file uses the Chart.js library to create a bar chart. It retrieves the data from the PHP code and populates the chart using JavaScript. The chart displays the average AsFed and DM values for each component type.

Important considerations for future developers working on the explore page:

- Security: Ensure that the overall website implements strong security measures, including user authentication and authorization checks for accessing sensitive data or performing specific actions.
- Configuration: The file includes `utils/config.php` at the beginning, indicating the presence of a configuration file. Review the configuration file to ensure sensitive information like database connection details is properly protected.
- Styling: The file references CSS files (`dashboard-common.css`, `explore_dash.css`) for styling. Modify these files to customize the appearance of the explore page if needed.
- Navigation: The file includes a navigation bar (`navbar.php`) that may contain links to other pages or functionality. Review and modify the navigation bar as necessary to reflect the structure of the website.
- Data visualization: Customize the chart options and data retrieval based on the specific requirements of the Coast to Cow Consumer Data Repository website. Modify the chart's appearance, labels, and dataset configurations as needed.

---

### `explore.js`

The `explore.js` file provides JavaScript functionality for the explore page (`explore_DO.php`) of the Coast to Cow Consumer Data Repository website. It handles data retrieval, display, and downloading using the ag-Grid library.

Here's an overview of the `explore.js` file:

- Error Handling: The file defines variables to display error messages in the `errorDiv` and `errorMessage` elements.

- Search Form Submission: The file adds an event listener to the search form (`#searchForm`) to handle form submissions. It retrieves the selected search table value and sends a GET request to the `/utils/getTableData.php` endpoint with the search table as a parameter.

- Handling Server Response: The file processes the server response in the `xhr.onload` callback function. It checks the response status, parses the JSON data, and displays the number of results found in the `resultsContainer` element.

- Modifying Data for Display: The file modifies the retrieved data if it contains specific properties (`free_download` and `file_id`). It converts the `unique_name` property into a link if `free_download` is set to 1 and removes the `free_download` and `file_id` properties from each row.

- Generating Column Names and Configuring ag-Grid: The file generates column names for the ag-Grid based on the retrieved data. It checks the column's data type and enables numeric column filtering if applicable. If the column name is `unique_name`, a custom cell renderer is assigned to render the link for downloadable files.

- Creating and Updating ag-Grid: The file creates and updates the ag-Grid using the generated column names and data. It sets pagination, auto-sizing columns, and defines default column settings.

- Handling Error Conditions: The file handles error conditions in the `xhr.onerror` callback function and displays the appropriate error message.

- Downloading Data as CSV: The file adds an event listener to the download button (`#download-csv`) to trigger the download of the ag-Grid data as a CSV file. It checks if data is populated, creates a download link, and triggers the download.

- Modal Handling: The file adds event listeners to the confirm and cancel buttons of the download modal (`downloadModal`). It confirms the download by converting the ag-Grid data to CSV and triggers the download. It also cancels the download by hiding the modal.

Important considerations for future developers working on the `explore.js` file:

- Customize error handling to suit your requirements and provide meaningful error messages to users.

- Modify the form submission handler to handle additional search parameters or modify the search functionality.

- Customize the data modification and column generation logic based on the structure and requirements of your data.

- Customize ag-Grid configuration and functionality to match the desired display and interaction requirements.

- Modify the download functionality to handle different file formats or additional data processing requirements.

---

### `explore_DO.php`

The `explore_DO.php` file is used for exploring data related to the Dairy One trials on the Coast to Cow Consumer Data Repository website. It provides a user interface to search and view data stored in the database.

Here's an overview of the `explore_DO.php` file:

- PHP Inclusion: The file includes the `utils/config.php` file to access any necessary configurations or dependencies.

- HTML Structure: The file defines the structure of the explore page using HTML markup. It includes a title, CSS stylesheets, and JavaScript libraries.

- Modal Dialog: The file includes a modal dialog element (`downloadModal`) that displays a data disclaimer message. Users are required to confirm their agreement before downloading data.

- Navigation Bar: The file includes the `navbar.php` file, which typically contains a navigation bar with links to different sections of the website.

- Content Display: The main content section includes a search form and a results container. Users can select a search table, submit the form, and view the results in an ag-Grid-based table (`my-grid`). The table is initially hidden (`style="display: none;"`) and will be populated dynamically.

- JavaScript: The file includes the `utils/js/explore.js` JavaScript file, which likely contains functionality for handling search submissions, displaying search results, and handling interactions with the ag-Grid table.

Important considerations for future developers working on the `explore_DO.php` file:

- Ensure that the `utils/config.php` file is properly configured and contains necessary database connection details.

- Review and modify the search form (`searchForm`) as needed to match the desired search functionality and available search tables.

- Customize the `downloadModal` content and functionality to reflect the specific data usage policies and requirements of the Dairy One trials.

- Modify the `explore.js` file (`utils/js/explore.js`) to enhance or modify the functionality of the explore page, such as handling search requests and interacting with the ag-Grid table.

---

### `explore_RD.php`

The `explore_RD.php` file serves the same function as `explore_DO.php` but is designed for exploring all other submitted data, not just Dairy One trials, on the Coast to Cow Consumer Data Repository website.

Here's an overview of the `explore_RD.php` file:

- PHP Inclusion: The file includes the `utils/config.php` file to access any necessary configurations or dependencies.

- HTML Structure: The file defines the structure of the explore page using HTML markup. It includes a title, CSS stylesheets, and JavaScript libraries.

- Modal Dialog: The file includes a modal dialog element (`downloadModal`) that displays a data disclaimer message. Users are required to confirm their agreement before downloading data.

- Navigation Bar: The file includes the `navbar.php` file, which typically contains a navigation bar with links to different sections of the website.

- Content Display: The main content section includes a search form and a results container. Users can select a search table, submit the form, and view the results in an ag-Grid-based table (`my-grid`). The table is initially hidden (`style="display: none;"`) and will be populated dynamically.

- JavaScript: The file includes the `utils/js/explore.js` JavaScript file, which likely contains functionality for handling search submissions, displaying search results, and handling interactions with the ag-Grid table.

Important considerations for future developers working on the `explore_RD.php` file:

- Ensure that the `utils/config.php` file is properly configured and contains necessary database connection details.

- Review and modify the search form (`searchForm`) as needed to match the desired search functionality and available search tables. In this case, the options include "DataMasterTest" and "AnalysisGrain".

- Customize the `downloadModal` content and functionality to reflect the specific data usage policies and requirements for exploring other submitted data.

- Modify the `explore.js` file (`utils/js/explore.js`) to enhance or modify the functionality of the explore page, such as handling search requests and interacting with the ag-Grid table.

---

### `download.php`

The `download.php` file handles the download of files from Google Drive using a service account defined in `credentials.php`. It is responsible for retrieving file metadata, setting appropriate headers for the file download, and downloading the file content.

The file structure follows the standard PHP file format, starting with the `<?php` opening tag. It includes the necessary dependencies, such as the Google API client library, and includes the `utils/config.php` file.

The main functionalities of the `download.php` file include:

- Google Drive integration: The file uses the Google API client library to interact with Google Drive. It sets up the client and service objects, defines the required scopes, and authenticates using the service account credentials defined in `credentials.php`.
- File download: When the file is requested through a GET request and the `name` parameter is provided, the file is fetched from Google Drive using the specified file ID. The file metadata is retrieved, appropriate headers are set for the file download, and the file content is downloaded and outputted to the browser.

Important considerations for future developers working on the download functionality:

- Security: Ensure that the file download functionality is secured and access is restricted to authorized users as per the website's authentication and authorization system.
- File ID: The `download.php` file expects the file ID to be provided through the `name` parameter in the GET request. Modify the code as necessary to match the file ID parameter name used in the website's URL structure.
- Configuration: The file includes the Google service account credentials file (`utils/c3-upload.json`) using `putenv()`. Ensure that the path to the credentials file is correct and matches the actual location of the file.
- Google Drive API: Review and modify the required scopes based on the specific actions and access needed for file downloading from Google Drive.
- Error handling: Consider adding appropriate error handling mechanisms to handle cases where the file is not found or the request is invalid.

---

### `index.php`

The `index.php` file serves as the homepage for the Coast to Cow Consumer Data Repository website. It handles user authentication and login functionality, allowing users to sign in to access their data.

The file structure follows the standard PHP file format, starting with the `<?php` opening tag. It includes a combination of PHP statements and HTML markup, with PHP code enclosed within `<?php` and `?>` tags.

The main functionalities of the `index.php` file include:

- Session management: The file starts a session using `session_start()` and checks if the user is already logged in. If so, they are redirected to the dashboard page using the `header()` function.
- User authentication: Upon form submission, the file retrieves the user ID and password from the `$_POST` superglobal. The password is hashed using SHA-256 for secure storage and comparison. The file then performs a database query to validate the credentials against the stored password in the `C3UserNameAndPassword` table. If the credentials match, the user is authenticated, and their user ID is stored in the session. They are then redirected to the dashboard page using the `header()` function. If the credentials do not match, an error message is assigned to the `$error` variable, which is displayed on the login page.
- HTML rendering: The file defines the structure and presentation of the login page using HTML markup. It includes a form with inputs for the user ID and password, a submit button, and links for signing up and resetting the password.

Important considerations for future developers working on the login page:

- Security: While the file hashes passwords using SHA-256, ensure that the overall website implements strong security measures, such as input validation, output sanitization, and protection against common vulnerabilities like SQL injection and cross-site scripting (XSS) attacks.
- Configuration: The file includes `utils/config.php` at the beginning, indicating the presence of a configuration file. Review the configuration file to ensure sensitive information like database connection details is properly protected.
- Styling and scripts: The file references CSS files (`normalize.css`, `universal.css`, `index.css`) for styling and includes a JavaScript function (`submitForm()`) for form submission. Inspect and modify these files if necessary.
- User experience: Pay attention to the provided error message, form validation, and overall usability and accessibility of the login form.
- Database interaction: The file interacts with the `C3UserNameAndPassword` table in the database to validate user credentials. Verify the database connection configuration and the table structure.
- Error handling: Customize the error message or error handling behavior if needed. Review where the error message is assigned and how it is displayed in the HTML code.

---

### `modify.php`

The `modify.php` file is responsible for handling the editing of user profiles. It allows users to update their profile information, including email, phone number, job title, institution, and password. The file also handles the verification of the current password before allowing changes to be made.

The file structure follows the standard PHP file format, starting with the `<?php` opening tag. It includes the necessary dependencies, such as the `utils/config.php` file, and starts the session.

The main functionalities of the `modify.php` file include:

- Form submission: When the form is submitted (identified by the `submit` button), the user input values are retrieved from the `$_POST` superglobal and assigned to respective variables.
- Password hashing: The current and new passwords are hashed using the SHA-256 algorithm before being compared or stored in the database.
- Database interaction: The file interacts with the database to fetch the user's current profile information and perform necessary updates. SQL statements are prepared and executed using the PDO library.
- Profile update: If the current password matches the password stored in the database, the profile information is updated in the `C3SignUp` table. If a new password is provided, it is also updated in the `C3UserNameAndPassword` table.
- Error handling: Appropriate error messages are displayed if there are any issues during the database operations or if the current password is incorrect.

Important considerations for future developers working on the profile editing functionality:

- Security: Ensure that the password hashing and storage mechanisms comply with recommended security practices.
- Input validation: Implement proper input validation and sanitization to prevent SQL injection and other security vulnerabilities.
- Database structure: Review and modify the SQL statements and table/column names to match the actual database structure and naming conventions.
- Error handling: Enhance error handling by providing detailed error messages and considering different failure scenarios.
- Password strength requirements: Implement password strength validation to ensure that new passwords meet the desired security criteria.
- User experience: Consider enhancing the user interface and providing visual feedback for successful profile updates.

---

### `navbar.php`

The `navbar.php` file is responsible for rendering the navigation bar at the top of the web application. It includes links to different pages and provides user-related options, such as accessing the user's profile and logging out.

The file starts with the `<?php` opening tag and includes the necessary dependencies, such as the `utils/config.php` file. It also starts the session.

The main functionalities of the `navbar.php` file include:

- Session check: It verifies whether the user is logged in by checking the session variable `logged_in`. If the user is not logged in, they are redirected to the login page (`index.php`).
- Logout functionality: When the user clicks the "Logout" button, the session is cleared and destroyed. The user is then redirected to the login page.
- User information: The file retrieves the user's first name and last name from the `C3SignUp` table based on the user's ID stored in the session variable `user_id`. The retrieved information is used to display the user's name in the navigation bar.
- Profile dropdown: The user's name is displayed in a dropdown menu. When the dropdown is hovered over, an arrow animation is triggered to indicate the open/close state. The dropdown menu provides options to edit the user's profile and logout.

Important considerations for future developers working on the navigation bar:

- Navigation links: Modify the navigation links to match the specific pages and URLs of the web application.
- Styling: Customize the CSS styles in the `navbar.css` file to match the desired appearance of the navigation bar.
- User information retrieval: Review and modify the SQL statements and table/column names to match the actual database structure and naming conventions.
- Session management: Ensure that session variables are properly initialized and destroyed to maintain secure and consistent user sessions.

---

### `resetpassword.php`

The `resetpassword.php` file handles the logic for resetting a user's password. It provides a form where users can enter their user ID and email to initiate the password reset process.

The file starts with the `<?php` opening tag and includes the necessary dependencies, such as the `utils/config.php` file. It also starts the session.

The main functionalities of the `resetpassword.php` file include:

- Session check: If the user is already logged in, they are redirected to the dashboard (`dashboard.php`).
- Password reset process: When the user submits the form, the file verifies the user's provided user ID and email. If the information is valid, a temporary password is generated and stored in the database. An email is then sent to the user's email address with the temporary password. The user is notified of the password reset process status through error messages displayed on the page.
- Temporary password generation: The `generateTemporaryPassword` function generates a random temporary password consisting of alphanumeric characters. The length of the temporary password is set to 8 characters but can be modified as needed.
- Email sending: The `mail` function is used to send an email with the temporary password to the user's email address. The email includes a subject, message body, and headers.
- Error handling: If there are any errors during the password reset process, an error message is displayed on the page to notify the user.

Important considerations for future developers working on the password reset functionality:

- Form validation: Add appropriate validation and sanitization to the form inputs to ensure data integrity and security.
- Email configuration: Update the `From` address in the email headers to match the desired sender email address.
- Styling: Customize the CSS styles in the `resetpassword.css` file to match the desired appearance of the password reset form.
- Database structure: Review and modify the SQL statements and table/column names to match the actual database structure and naming conventions.
- Email template: Customize the email subject and message to match the desired content and formatting for the password reset email.

---
###  `seaweed.php`

Under construction, will incorporate a new seaweed id so a user can track the flow of a seaweed sample within the C3 project.

---

### `signup.php`

The `signup.php` file handles the logic for user registration. It provides a form where users can enter their information to create a new account.

The file starts with the `<?php` opening tag and includes the necessary dependencies, such as the `utils/config.php` file. It also starts the session.

The main functionalities of the `signup.php` file include:

- Session check: If the user is already logged in, they are redirected to the dashboard (`dashboard.php`).
- User registration process: When the user submits the registration form, the file retrieves the form inputs (first name, last name, email, password, phone number, job title, and institution). The password is hashed using SHA-256 for security.
- Database operations: The user's information is inserted into the `C3SignUp` table, and the user ID, password, and email are inserted into the `C3UserNameAndPassword` table. The user ID is generated based on the user's last name and email.
- Email confirmation: If the database operations are successful, an email is sent to the user's email address with their user ID. The email includes a subject, message body, and headers. The `mail` function is used to send the email. The success or failure of sending the email is stored in a session variable.
- Error handling: If there are any errors during the registration process, an error message is displayed on the page to notify the user.

Important considerations for future developers working on the registration functionality:

- Form validation: Add appropriate validation and sanitization to the form inputs to ensure data integrity and security.
- Email configuration: Update the `From` address in the email headers to match the desired sender email address.
- Styling: Customize the CSS styles in the `signup.css` file to match the desired appearance of the registration form.
- Database structure: Review and modify the SQL statements and table/column names to match the actual database structure and naming conventions.
- Email template: Customize the email subject and message to match the desired content and formatting for the registration confirmation email.

---

### `submit.php`

The `submit.php` file handles the submission of a dataset by the user. It provides a form where users can enter metadata related to the dataset they want to submit.

The file starts with the `<?php` opening tag and includes the necessary dependencies, such as the `utils/config.php` file. It also starts the session.

The main functionalities of the `submit.php` file include:

- Session check: If the user is not logged in, they are redirected to the login page (`index.php`).
- Dataset submission process: When the user submits the dataset metadata form, the file retrieves the form inputs (email, primary contact last name, primary contact first name, institution, dataset name, dataset description, data classification, and various checkboxes and links).
- Database operations: The form inputs are stored as session variables and then validated. If the dataset name is unique, all form inputs are saved as session variables.
- Error handling: If there are any errors during the dataset submission process (e.g., dataset name already exists), an error message is displayed on the page to notify the user.
- Metadata form: The form allows users to enter metadata information about the dataset, including email, primary contact details, dataset name, dataset description, data classification, and various checkboxes and links.

Important considerations for future developers working on the dataset submission functionality:

- Form validation: Add appropriate validation and sanitization to the form inputs to ensure data integrity and security.
- Database structure: Review and modify the SQL statements and table/column names to match the actual database structure and naming conventions.
- Session variables: Review the use of session variables to store and retrieve form inputs. Ensure that session variables are cleared or updated appropriately.
- Error handling: Implement additional error handling and validation checks to cover various scenarios and improve the user experience.
- File upload: If the form includes file uploads, consider adding the necessary logic to handle file uploads securely and store file references in the database.
- Styling: Customize the CSS styles in the `submit.css` file to match the desired appearance of the submission form.
- Email template: If email notifications or confirmations are required, design and implement appropriate email templates and functionality.

---

### `templates.php`

The `templates.php` file displays a list of templates available for download. It includes HTML markup to create a page layout with a header, content section, and a card container to display the templates.

The file starts with the `<?php` opening tag and includes the necessary dependencies, such as the `utils/config.php` file.

The main functionalities of the `templates.php` file include:

- Template display: The file displays a list of templates as cards, where each card includes an image of a PDF icon, the template name, and a download link.
- File download: When a user clicks on the download link, the corresponding template PDF file is downloaded.

Important considerations for future developers working on the templates functionality:

- File management: Ensure that the PDF files referenced in the `href` attribute of the download links exist in the specified locations (`pdfs/sample1.pdf`, `pdfs/sample2.pdf`, etc.). THESE DO NOT EXIST AS OF 07/05/2023
- Card design: Customize the CSS styles in the `templates.css` file to match the desired appearance of the template cards. NEEDS TO BE UPDATED
- Template files: Replace the sample template PDF files (`sample1.pdf`, `sample2.pdf`, etc.) with the actual template files to be provided to users.
- Template variety: Add more cards and download links to display additional templates as needed.
- Accessibility: Consider adding appropriate accessibility attributes to the HTML elements to improve the accessibility of the template page.
- Error handling: Implement error handling and validation checks as necessary to handle any potential issues related to template file availability or download.

---
### `upload.php`

The `upload.php` file handles the file upload functionality to Google Drive using a service account defined in the `credentials.php` file.

The file starts with the `<?php` opening tag and includes the necessary dependencies, such as the Google Drive client library (`autoload.php`) and the `utils/config.php` file.

The main functionalities of the `upload.php` file include:

- Google Drive setup: It sets up the Google Drive client using the service account credentials defined in `c3-upload.json`.
- File upload: When the file upload form is submitted via POST request, the file is processed. The file details, such as the file name, folder selection, and file content, are obtained from the `$_FILES` and `$_POST` superglobal variables.
- Google Drive API integration: The file is uploaded to Google Drive using the Google Drive API. The file is created with a unique name based on the session variable `unique_name` and is moved to the specified folder ID obtained from the `folder_ids` array.
- Database insertion: After the file is successfully uploaded, the relevant metadata, along with the file ID, are stored in the database table `C3DataMasterTest`.
- Session management: Session variables are used to store and retrieve information throughout the file upload process. Once the file is uploaded and the metadata is stored, session variables related to the file upload are unset.

Important considerations for future developers working on the file upload functionality:

- File validation: Implement proper validation checks on the uploaded file, such as file size, file type, and any additional requirements specific to your application.
- Folder selection validation: Validate and sanitize the selected folder before using it to avoid security risks or unexpected behavior.
- Error handling: Implement robust error handling and logging mechanisms to handle any potential errors that may occur during file upload or database insertion.
- Database structure: Ensure that the database table structure (`C3DataMasterTest`) matches the column names and data types used in the SQL query.
- Session management: Review and modify the session variables used based on your application's specific requirements and session management practices.

---

## Usage

To use the **CoastCowConsumer Data Repository**:

1. Ensure that the necessary dependencies are available and properly configured (see [Dependencies](#dependencies)).
2. Set up the application by following the installation instructions (see [Installation](#installation)).
3. Access the application by navigating to the appropriate URLs for each page, such as `dashboard.php` for the main dashboard page, `explore.php` for the explore page, and so on.
4. Follow the user interface and functionality provided by each page to interact with the application.

## Dependencies

The **CoastCowConsumer Data Repository** has the following dependencies:

- PHP: The server-side scripting language used for building the application.
- Database: The application likely requires a database for storing and retrieving data. If the user wishes to use the C3 database to work on their data, they must obtain credentials from an administrator.  This can be found at utils/credentials.php and includes API keys, folder ID's, server and database credentials.
- CSS: Cascading Style Sheets (CSS) are used for styling the application's user interface.
- Other dependencies: `"phpmailer/phpmailer": ^6.8 , "google/apiclient": ^2.0`

## Installation

To install and set up the **CoastCowConsumer Data Repository**:

1. Clone this repository to your local machine.
2. Configure the necessary dependencies such as the PHP environment and database connection details.
3. Ensure that the file permissions are correctly set to allow the application to run.
4. Set up the database and import any required schema or sample data if provided.
5. Once the environment is properly set up, access the application by running a local server and navigating to the appropriate URL.

    ### Configuring Composer

    If one plans to localhost the repository, the user is responsible for managing their own packages to confirm proper functionality

    We recommend the user uses composer for their file management. Composer is a dependency management tool for PHP programming. It is designed to simplify the process of managing dependencies, libraries, and packages in PHP projects. Composer allows developers to easily declare the libraries and dependencies their project requires and handles the installation and management of those dependencies.
    This way, we can confirm that libaries are all compatible and do not need to worry about managing this.
    Here's a quick tutorial on how and where to install [composer](https://getcomposer.org/doc/01-basic-usage.md)

    Once one has composer installed, they should create or update their composer.json file to include: `"phpmailer/phpmailer": ^6.8` and ` "google/apiclient": ^2.0` as well as any additional non-native installations (libraries, APIs, other software).
    Now, the user just needs to run php composer.phar update.  More about this is included in the composer tutorial.



## License

The **CoastCowConsumer Data Repository** is released under the MIT License. See the [LICENSE](LICENSE) file for more details.
