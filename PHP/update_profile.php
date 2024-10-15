
<?php
// Database connection parameters
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";

// Connect to PostgreSQL database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) 
{
    die("Connection failed: ". pg_last_error());
}

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    
    $username = $_SESSION["username"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $dob = $_POST["DOB"];
    
    // Update user information in the registration table
    $query = "UPDATE registration_table
    SET first_name = '$first_name',last_name = '$last_name',phone = '$phone',email = '$email',date_of_birth = '$dob'
    WHERE username = '$username'";

    $result = pg_query($conn, $query);
    $dashboardPage = "http://localhost/DIY_Project_sharing_platform/php/user_dashboard.php";

    if ($result) {
        echo "Profile updated successfully.";
        header("Location: $dashboardPage");
        exit();
    } else {
        echo "Error updating profile: " . pg_last_error($conn);
    }
}


pg_close($conn);
?>