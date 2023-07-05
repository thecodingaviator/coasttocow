# CoastCowConsumer Data Repository

This repository contains the source code for the **CoastCowConsumer Data Repository**.

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

### `explore.php`

The `explore.php` file represents the explore page of the Coast to Cow Consumer Data Repository website. It allows users to search and explore data from the MySQL database.

The file structure follows the standard PHP file format, starting with the `<?php` opening tag. It includes a combination of PHP statements and HTML markup, with PHP code enclosed within `<?php` and `?>` tags.

The main functionalities of the `explore.php` file include:

- Database interaction: The file retrieves data from the MySQL database based on the user's search criteria. It prepares a query using the search table and value provided by the user and executes it using a prepared statement. The resulting data is stored in the `$result` variable.
- HTML rendering: The file defines the structure and presentation of the explore page using HTML markup. It includes a navigation bar (`navbar.php`), a search form with options to select the search table and field, and an input for the search value. The search results are displayed in a table format.
- Table generation: The file generates an HTML table dynamically based on the search results. It iterates over the result data and generates table headers and rows dynamically. The table headers exclude the 'file_id' column, and the rows exclude the 'file_id' column and generate a link to download the file if the 'free_download' column is set to 1.

Important considerations for future developers working on the explore page:

- Security: Ensure that the overall website implements strong security measures, including user authentication and authorization checks for accessing sensitive data or performing specific actions.
- Configuration: The file includes `utils/config.php` at the beginning, indicating the presence of a configuration file. Review the configuration file to ensure sensitive information like database connection details is properly protected.
- Styling: The file references CSS files (`dashboard-common.css`, `explore.css`) for styling. Modify these files to customize the appearance of the explore page if needed.
- Navigation: The file includes a navigation bar (`navbar.php`) that may contain links to other pages or functionality. Review and modify the navigation bar as necessary to reflect the structure of the website.
- Search functionality: Customize the search form options, fields, and search criteria based on the specific requirements of the Coast to Cow Consumer Data Repository website.
- Data retrieval: Modify the query and data retrieval logic to fetch the desired data from the MySQL database. Adjust the table headers and row generation code based on the structure of the retrieved data.

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
- Configuration: The file includes the Google service account credentials file (`utils/c3-testing-389115-f39fd8b05d5d.json`) using `putenv()`. Ensure that the path to the credentials file is correct and matches the actual location of the file.
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

- Google Drive setup: It sets up the Google Drive client using the service account credentials defined in `c3-testing-389115-f39fd8b05d5d.json`.
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
- Database: The application likely requires a database for storing and retrieving data. Ensure that the database is properly set up and configured.
- CSS: Cascading Style Sheets (CSS) are used for styling the application's user interface.
- Other dependencies: The application may require additional libraries, frameworks, or APIs depending on its specific functionality. Please refer to the individual files and their associated documentation for any additional dependencies.

## Installation

To install and set up the **CoastCowConsumer Data Repository**:

1. Clone this repository to your local machine.
2. Configure the necessary dependencies such as the PHP environment and database connection details.
3. Ensure that the file permissions are correctly set to allow the application to run.
4. Set up the database and import any required schema or sample data if provided.
5. Once the environment is properly set up, access the application by running a local server and navigating to the appropriate URL.

## License

The **CoastCowConsumer Data Repository** is released under the MIT License. See the [LICENSE](LICENSE) file for more details.
