<?php
// Database connection parameters
	$host = "localhost";
    $username_db = "postgres";
    $password_db = "1978";
    $database = "DIY_project_sharing_platform";
    $port = "5432";

    // Connect to the database
    $conn =pg_connect("host=$host dbname=$database user=$username_db password=$password_db port=$port");

    // Check connection
    if (!$conn) {
        die("Connection failed: ". pg_last_error());
    }

// SESSION START

session_start();

if (!isset($_SESSION['username'])) {

  header("Location:http://localhost/DIY_Project_sharing_platform/PHP/login.php");
   exit;
}

$username = $_SESSION['username'];

$query = "SELECT * FROM registration_table WHERE username = '$username'";
$result = pg_query($conn, $query);

if ($result && pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    $username=$row['username'];
    $first_name = $row['first_name'];
    $last_name=$row['last_name'];
    $email=$row['email'];
    $phone_number = $row['phone'];
    $DOB = $row['date_of_birth'];
    
} else {
    echo "User not found.";
    exit;
}
// Close the connection
pg_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/view_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
    <div class="profile-container">
        <h1>Profile</h1>
        <div class="profile-details">
            <label for="first_name">First Name</label>
            <span><h4><?php echo htmlspecialchars($first_name); ?></h4></span><br>

            <label for="last_name">Last Name</label>
            <span><?php echo htmlspecialchars($last_name); ?></span><br><br>

            <label for="mail">Email</label>
            <span><?php echo htmlspecialchars($email); ?></span><br><br>

            <label for="phone_no">Phone No</label>
            <span><?php echo htmlspecialchars($phone_number); ?></span><br><br>

            <label for="dob">Date Of Birth</label>
            <span><?php echo htmlspecialchars($DOB); ?></span><br><br>
        </div>
    </div>
</body>
</html>
