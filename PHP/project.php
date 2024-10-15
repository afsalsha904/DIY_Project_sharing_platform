<?php

$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";

// Establish connection to the database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    echo "Failed to connect to the database.";
    exit;
}

$sql1 = "SELECT category_type FROM category_table";
$result1 = pg_query($conn, $sql1);

if (!$result1) {
    die("Error in SQL query: " . pg_last_error());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Upload Form</title>
    <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/project_table_css.CSS">
</head>
<body>
    <div class="container">
        <h2>Project Upload</h2>
        <br/><br/>

        <form action="http://localhost/DIY_Project_sharing_platform/PHP/project_create.php" method="POST" enctype="multipart/form-data">
            <!-- Project Title -->
            <div class="form-group">
                <label for="project_Title">Project Title:</label>
                <input type="text" id="project_Title" name="project_Title" required>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <?php
                    while ($row = pg_fetch_assoc($result1)) {
                        echo "<option value='" . htmlspecialchars($row['category_type']) . "'>" . htmlspecialchars($row['category_type']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <!-- Upload PDF -->
            <div class="form-group">
                <label for="pdfFile">Upload PDF</label>
                <input type="file" id="pdfFile" name="pdf_File" accept=".pdf" required>
            </div>

            <!-- Video URL -->
            <div class="form-group">
                <label for="videoUrl">Video URL</label>
                <input type="text" id="videoUrl" name="video_Url">
            </div>

            <!-- Upload Image -->
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <!-- Submit Button -->
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

<?php
// Free result set and close connection
pg_free_result($result1);
pg_close($conn);
?>
