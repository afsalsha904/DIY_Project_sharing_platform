<?php
session_start();

$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";

$conn=pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
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
    
    $pdf = file_get_contents($_FILES['pdf_File']['tmp_name']); // Read the PDF file as binary
    $escaped_pdf = pg_escape_bytea($pdf); // Escape the binary data
    $Video_URL=$_POST["video_Url"];
    $image = file_get_contents($_FILES['image']['tmp_name']); // Read the image file as binary
    $escaped_image = pg_escape_bytea($image); // Escape the binary data
    $Upload_Date=$_POST["upload_Date"];
    $username = $_SESSION["username"];
    
}
$sql=" UPDATE project_table 
        SET upload_pdf = '$escaped_pdf',
            video_url = '$Video_URL',
            upload_date = '$Upload_Date',
            image1 = '$escaped_image'
        WHERE username = '$username'";

$result = pg_query($conn, $sql); 
if ($result) 
{
echo "Data inserted successfully!"; 
} 
else
{
echo "Error: " . pg_last_error($conn);
}

pg_close($conn);

?>
