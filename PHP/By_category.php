<?php
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";

// Establishing connection to the database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    echo "Failed to connect to database.";
    exit();
}

// Query to get all unique categories from the project_table
$query = "SELECT DISTINCT category FROM project_table";
$result = pg_query($conn, $query);

if (!$result) {
    echo "Error in query execution.";
    exit();
}

// Fetch all categories
$categories = pg_fetch_all($result);

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/By_category.css">
</head>
<body>
    <div class="container">
        <h1>Categories</h1>
        <div class="category-grid">
            <?php if ($categories): ?>
                <?php foreach ($categories as $category): ?>
                    <div class="category-block">
                        <a href="projects_by_category.php?category=<?php echo urlencode($category['category']); ?>">
                            <?php echo htmlspecialchars($category['category']); ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No categories found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
