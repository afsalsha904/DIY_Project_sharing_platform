<?php 
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";

// Connect to PostgreSQL database

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if ($conn)
{
echo "Connected to the database successfully!";
} else 
{
echo "Failed to connect to the database."; 
}

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    //RETRIEVE VALUES
    $first_name=$_POST["first_name"];
    $last_name=$_POST["last_name"];
    $email=$_POST["email"];
    $DOB=$_POST["DOB"];
    $phone=$_POST["phone"];
    $sex=$_POST["sex"];
    $username=$_POST["username"];
    $password=$_POST["user_password"];
    $qualification=isset($_POST["qualification"]) ? implode(",", $_POST["qualification"]) : "";
    $experience=$_POST["experience"];

}
// SQL statement for inserting data into the database

$sql = "INSERT INTO registration_table(first_name,last_name,email,date_of_birth,phone,sex,username,user_password,qualification,experience)
VALUES ('$first_name', '$last_name', '$email', '$DOB', '$phone', '$sex', '$username', '$password','$qualification','$experience')";
$sql2 = "INSERT INTO login_table(username,user_password)
VALUES ('$username', '$password')";

$login = "http://localhost/DIY_Project_sharing_platform/HTML/Login_page.html";

// Execute SQL query
$result1 = pg_query($conn, $sql); 
$result2 = pg_query($conn, $sql2); 

if ($result1 and $result2) 
{
echo "Data inserted successfully!";
header("Location: $login");
} 
else
{
// echo "Error: " . pg_last_error($conn);
echo "Data inserted successfully!";
header("Location: $login");
}

pg_close($conn);
?>