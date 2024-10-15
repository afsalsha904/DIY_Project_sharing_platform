<?php
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    echo "Failed to connect to the database.";
    exit();
}


$proj_id = $_GET['proj_id'] ?? '';

if (empty($proj_id)) {
    echo "No project ID provided.";
    exit();
}

$query = "SELECT * FROM project_table WHERE proj_id = $1";
$result = pg_query_params($conn, $query, array($proj_id));

if ($result && pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);

    $image_data = pg_unescape_bytea($row['image1']); 
    $base64_image = base64_encode($image_data); 

    $project_name = htmlspecialchars($row["project_title"]);
    $username = htmlspecialchars($row["username"]);
    $category = htmlspecialchars($row["category"]);
    $description = htmlspecialchars($row["description"]);
    $pdf = htmlspecialchars($row["upload_pdf"]);
    $video = htmlspecialchars($row["video_url"]);
    $date = htmlspecialchars($row["upload_date"]);
} else {
    echo "Project not found.";
    exit();
}

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/view_project.css">
    <style>
        .btn-report {
            display: block;
            margin: 20px 850px ;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            width: fit-content;
        }
        .btn-report:hover {
            background-color: #c82333;
        }
    </style>
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
                    <a href="http://localhost/DIY_Project_sharing_platform/PHP/view_pdf.php?id=<?php echo urlencode($proj_id); ?>" class="pdf-view-button">View PDF</a>
                <?php } ?>
            </div>
            
            <p><strong>Uploaded Date:</strong> <?php echo $date; ?></p>
            <p><strong>Uploaded by:</strong> <?php echo $username; ?></p>

            <!-- Add the report button -->
            <a href="report_project.php?proj_id=<?php echo urlencode($proj_id); ?>" class="btn-report">Report</a>
        </div>
    </div>
</body>
</html>
