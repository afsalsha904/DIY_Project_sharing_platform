<?php
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres"; $password = "1978";
// Connect to PostgreSQL database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if ($conn) {
echo "";
} else {
echo "Failed."; 
}

session_start();

if (!isset($_SESSION['username']))
{
  header("http://localhost/DIY_Project_sharing_platform/PHP/login.php");
  exit();
}

$username = $_SESSION['username'];

$query = "SELECT * FROM registration_table  WHERE username = '$username'";
$result = pg_query($conn, $query);

if ($result && pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    $first_name=$row["first_name"];
    $last_name=$row["last_name"];
    $email=$row["email"];
    $dob=$row["date_of_birth"];
    $phone=$row["phone"];

} else {
    echo "User not found.";
    exit();
}

// Close the connection
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>profile edit</title>
  <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/edit_profile.CSS">
</head>
  <body>
    <div class="container">
    <form name="edit_profile" action="http://localhost/DIY_Project_sharing_platform/PHP/update_profile.php" method="post" >
      <h2>Edit Profile</h2>

      <input type="hidden" id="username" name="username" required  value="<?php echo htmlspecialchars( $username);?>"><br>
      
      <label for="first_name">First Name</label>
      <input type="text" id="first_name" name="first_name" required  value="<?php echo htmlspecialchars($first_name);?>"> <br>
      <label for="last_name">Last Name</label>
      <input type="text" id="last_name" name="last_name" required  value="<?php echo htmlspecialchars($last_name);?>"><br>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required  value="<?php echo htmlspecialchars($email);?>"><br>
      <label for="DOB">Date of Birth</label>
      <input type="date" id="DOB" name="DOB" required value="<?php echo htmlspecialchars($dob);?>" ><br>
      <label for="phone">Phone Number</label>
      <input type="text" id="phone" name="phone" required  value="<?php echo htmlspecialchars($phone);?>"><br>
      <input type="submit" value="update">
    </form>
    </div>
  </body>
  </html>