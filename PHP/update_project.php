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
    
    $id = $_POST["proj_id"];
    
    if (empty($id)) {
        echo "Error: proj_id is empty";
        exit();
    }
    
    $project_title = $_POST["project_Title"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $video_url = $_POST["video_url"];
    $upload_date = $_POST["upload_Date"];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']); // Read the image file as binary
        $escaped_image = pg_escape_bytea($image); // Escape the binary data
    } else {
        $escaped_image = null;
    }
    
    if (isset($_FILES['pdf_File']) && $_FILES['pdf_File']['error'] == 0) {
        $pdf = file_get_contents($_FILES['pdf_File']['tmp_name']); // Read the PDF file as binary
        $escaped_pdf = pg_escape_bytea($pdf); // Escape the binary data
    } else {
        $escaped_pdf = null;
    }
    
    // Update user information in the registration table
    $query = "UPDATE project_table
                SET project_title = '$project_title',
                    category = '$category',
                    description = '$description',
                    upload_pdf = '$escaped_pdf',
                    video_url = '$video_url',
                    upload_date = '$upload_date',
                    image1 ='$escaped_image'
                WHERE proj_id = $id ";

    $result = pg_query($conn, $query);
    $dashboardPage = "http://localhost/DIY_Project_sharing_platform/php/All_projects.php";

    if ($result) {
        echo "Project updated successfully.";
        header("Location: $dashboardPage");
        exit();
    } else {
        echo "Error updating project: " . pg_last_error($conn);
    }
}


pg_close($conn);
?>