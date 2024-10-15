<?php
// Database connection parameters
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";
// Connect to PostgreSQL database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $username = pg_escape_string($conn, $_POST['username']);
    $query = "DELETE FROM registration_table WHERE username = '$username'";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "User removed successfully.";
    } else {
        echo "Error removing user: " . pg_last_error($conn);
    }

    pg_close($conn);
    header("Location: edit_user.php"); // Redirect back to the users list
    exit();
}
?>
