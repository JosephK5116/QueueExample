Explanation of this code, 

For this solution I have stored the information saved by a user in a SQL database. The information is then retrieved and displayed in the table 
I have chosen to use Bootstrap as a front-end web framework for this test. The reason I have chosen to use bootstrap is that it easily provides stylish CSS as well as responsive design for a website.
The buttons which select different customer options (Citizen, Organisation, and Anonymous) utilise JavaScript to load different form content into the form depending on which customer type the user is inputting. I have decided to use this feature because it prevents the page from reloading and resetting the user selected service requirement
JavaScript is also used to hide the submit button unless some data has been inputted into input textboxes. This has been utilised to prevent accidental submission of blank input. 
User input is sanitised through the use of mysqli_real_escape_string and htmlentities to protect the database and website from threats such as SQL injection and Cross-Site Scripting
The information from the database is selected and sorted by the time which the customer was placed into the queue in descending order to ensure that the customer who has been waiting the longest appears at the top of the queue list. 
