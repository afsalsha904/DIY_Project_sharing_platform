<?php
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";

// Get the category from the URL parameter
$category = $_GET['category'] ?? '';

if (empty($category)) {
    echo "No category specified.";
    exit();
}

// Establishing connection to the database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    echo "Failed to connect to the database.";
    exit();
}

// Query to get projects by category
$query = "SELECT proj_id, project_title FROM project_table WHERE category = $1";
$result = pg_query_params($conn, $query, array($category));

if (!$result) {
    echo "Error in query execution.";
    exit();
}

$projects = pg_fetch_all($result);

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects in <?php echo htmlspecialchars($category); ?></title>
    <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/projects_by_category.css">
</head>
<body>
    <div class="container">
        <h1>Projects in <?php echo htmlspecialchars($category); ?></h1>
        <ul class="project-list">
            <?php if ($projects): ?>
                <?php foreach ($projects as $project): ?>
                    <li>
                        <a href="category_view_project.php?proj_id=<?php echo htmlspecialchars($project['proj_id']); ?>">
                            <?php echo htmlspecialchars($project['project_title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No projects found in this category.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
