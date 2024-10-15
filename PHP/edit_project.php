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
    echo "Failed to connect to the database."; 
    exit();
}

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/DIY_Project_sharing_platform/PHP/login.php");
    exit();
}

if (isset($_POST['edit'])) {
    $id_to_edit = $_POST['proj_id'];
    $username = $_SESSION['username'];

    $query = "SELECT * FROM project_table WHERE proj_id = '$id_to_edit'";
    $result = pg_query($conn, $query);

    $sql1 = "SELECT category_type FROM category_table";
    $result1 = pg_query($conn, $sql1);

    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        $project_name = $row["project_title"];
        $category = $row["category"];
        $description = $row["description"];
        $pdf = $row["upload_pdf"];
        $image_data = pg_unescape_bytea($row['image1']); // Unescape the binary data
        $base64_image = base64_encode($image_data); // Encode the binary data as base64
        $video_url = $row["video_url"];
        $date = $row["upload_date"];
    } else {
        echo "Project not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Edit</title>
  <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/update_project.CSS">
</head>
<body>
  <div class="container">
    <h2><center>Edit project</center></h2>
    <form action="http://localhost/DIY_Project_sharing_platform/PHP/update_project.php" method="POST" enctype="multipart/form-data">
      
      <input type="hidden" name="proj_id" value="<?php echo htmlspecialchars($id_to_edit); ?>">

      <div class="form-group">
        <label for="project_Title">Project Title</label>
        <input type="text" id="project_Title" name="project_Title" required value="<?php echo htmlspecialchars($project_name); ?>"><br>
      </div>

      <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category" required>
          <?php
          if ($result1 && pg_num_rows($result1) > 0) {
              while ($row = pg_fetch_assoc($result1)) {
                  echo "<option value='" . htmlspecialchars($row['category_type']) . "'>" . htmlspecialchars($row['category_type']) . "</option>";
              }
          } else {
              echo "<option>No categories found.</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>
      </div>

      <div class="form-group">
        <label for="pdf_File">PDF</label>
        <?php if (isset($row['proj_id'])): ?>
          <a href="http://localhost/DIY_Project_sharing_platform/PHP/view_pdf.php?id=<?php echo htmlspecialchars($row['proj_id']); ?>" 
             style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; 
             text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold;">View</a>
        <?php endif; ?>
        <input type="file" id="pdf_File" name="pdf_File" accept=".pdf"><br>
      </div>

      <div class="form-group">
        <label for="video_url">Video URL</label>
        <input type="text" id="video_url" name="video_url" value="<?php echo htmlspecialchars($video_url); ?>"><br>
      </div>

      <div class="form-image">
        <label for="image">Image</label>&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if (isset($base64_image)): ?>
          <img src='data:image/jpeg;base64,<?php echo htmlspecialchars($base64_image); ?>' alt='Project Image' height='90' width='160'>
        <?php endif; ?>
        <input type="file" id="image" name="image" accept="image/*"><br>
      </div>

      <div class="form-group">
        <label for="Upload_Date">Date</label>
        <input type="date" id="upload_date" name="upload_Date" required value="<?php echo htmlspecialchars($date); ?>"><br>
      </div>

      <button type="submit">Update</button>
    </form>
  </div>
</body>
</html>
