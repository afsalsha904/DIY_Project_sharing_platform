// LOGOUT 
<?php
session_start(); // Start the session

// Destroy the session to log the user out
session_destroy();

// Redirect to the login page
header("Location:http://localhost/DIY_Project_sharing_platform/HTML/Login_page.html"); // Change "login.php" to your actual login page URL
exit(); // Make sure to exit to prevent further code execution
?>