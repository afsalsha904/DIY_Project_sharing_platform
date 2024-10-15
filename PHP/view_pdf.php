<?php
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres"; 
$password = "1978";
// Connect to PostgreSQL database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if ($conn) {
echo "";
} else {
echo "Failed."; 
}

session_start();

if (isset($_GET['id'])) 
{
    $id = intval($_GET['id']);

    $query = "SELECT upload_pdf FROM project_table WHERE proj_id = $id";
    $result = pg_query($conn, $query);

    if ($row = pg_fetch_assoc($result)) 
    {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . htmlspecialchars($row['upload_pdf']) . '"');
        echo pg_unescape_bytea($row['upload_pdf']);
    } else 
    {
        echo "File not found.";
    }
}
else 
{
    echo "Invalid request.";
}

pg_close($conn);
?>