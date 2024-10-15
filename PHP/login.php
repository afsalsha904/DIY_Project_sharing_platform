<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['user_password'];
    

    // Database connection details
    $host = "localhost";
    $username_db = "postgres";
    $password_db = "1978";
    $database = "DIY_project_sharing_platform";
    $port = "5432";

    // Connect to the database
    $conn_string = "host=$host dbname=$database user=$username_db password=$password_db port=$port";
    $conn = pg_connect($conn_string);

    // Check connection
    if (!$conn) {
        die("Connection failed: ". pg_last_error());
    }

    // Define SQL queries based on the selected usertype

    
        $sql = "SELECT * FROM login_table WHERE username = '$username' AND user_password = '$password'";
        $dashboardPage = "http://localhost/DIY_Project_sharing_platform/php/user_dashboard.php";
    
    

    // Execute the SQL query
    $result = pg_query($conn, $sql);

    if (pg_num_rows($result) == 1) {
        $_SESSION["username"] = $username;
        // Correct username and password, redirect to the appropriate dashboard page
        header("Location: $dashboardPage");
        exit();
    } else {
        // Incorrect username or password
        echo "Invalid username or password.";
    }

    // Close the database connection
    pg_close($conn);
}
?>