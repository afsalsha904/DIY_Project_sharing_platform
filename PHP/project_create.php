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

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/DIY_Project_sharing_platform/PHP/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form values
    $project_Title = $_POST["project_Title"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $username = $_SESSION["username"];

    // Handle file uploads
    $pdf = file_get_contents($_FILES['pdf_File']['tmp_name']); // Read the PDF file as binary
    $escaped_pdf = pg_escape_bytea($pdf); // Escape the binary data
    $video_URL = $_POST["video_Url"];
    $image = file_get_contents($_FILES['image']['tmp_name']); // Read the image file as binary
    $escaped_image = pg_escape_bytea($image); // Escape the binary data
    $upload_Date = date('d-m-y');
    // Insert the project details along with the uploaded files into the database
    $sql = "INSERT INTO project_table (project_title, category, description, upload_pdf, video_url, image1, upload_date, username)
            VALUES ('$project_Title', '$category', '$description', '$escaped_pdf', '$video_URL', '$escaped_image', '$upload_Date', '$username')";

    // Execute the SQL query
    $result = pg_query($conn, $sql);

    // Redirect to the user dashboard upon successful insert
    $dashboardPage = "http://localhost/DIY_Project_sharing_platform/php/user_dashboard.php";

    if ($result) {
        echo "Project created successfully!";
        header("Location: $dashboardPage");
        exit();
    } else {
        echo "Error inserting data: " . pg_last_error($conn);
    }
}

pg_close($conn);
?>
