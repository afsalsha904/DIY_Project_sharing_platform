<?php
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    echo "Failed to connect to database.";
    exit();
}

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/DIY_Project_sharing_platform/PHP/login.php");
    exit();
}

$base64_image = '';
$project_name = '';
$category = '';
$description = '';
$date = '';

//if (isset($_GET['proj_id'])) {
   // $id_to_view = $_GET['proj_id'];
    $id_to_view = $_POST['proj_id'];

    $query = "SELECT * FROM project_table WHERE proj_id = $1";
    $result = pg_query_params($conn, $query, array($id_to_view));

    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);

        $image_data = pg_unescape_bytea($row['image1']); 
        $base64_image = base64_encode($image_data); 

        $project_name = htmlspecialchars($row["project_title"]);
        $category = htmlspecialchars($row["category"]);
        $description = htmlspecialchars($row["description"]);
        $pdf = htmlspecialchars($row["upload_pdf"]);
        $video = htmlspecialchars($row["video_url"]);
        $date = htmlspecialchars($row["upload_date"]);
    } else {
        echo "Project not found.";
        exit();
    }
// } else {
//     echo "No project ID provided.";
//     exit();
// }

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/view_project.css">
</head>
<body>
    <div class="container">
        <div class="image-container">
            <?php
            if ($base64_image) {
                echo "<img src='data:image/jpeg;base64," . $base64_image . "' alt='Project Image' class='enlarged-image'>";
            }
            ?>
        </div>
        
        <h1 class="project-title"><?php echo $project_name; ?></h1>
        
        <div class="project-details">
            <p><strong>Category:</strong> <?php echo $category; ?></p>
            <p><strong>Description:</strong> <?php echo $description; ?></p>
            <p><strong>Video Url:</strong> <?php echo '<a href="' . $video . '">' . $video . '</a>'; ?></p>
            
            <div class="pdf-container">
                <?php if ($pdf) { ?>
                    <a href="http://localhost/DIY_Project_sharing_platform/PHP/view_pdf.php?id=<?php echo urlencode($id_to_view); ?>" class="pdf-view-button">View Procedure</a>
                <?php } ?>
            </div>
            
            <p><strong>Uploaded Date:</strong> <?php echo $date; ?></p>
        </div>
    </div>
</body>
</html>