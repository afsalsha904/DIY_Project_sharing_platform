<?php
// Start a session (if not already started)
session_start();
// Check if the user is logged in
if (isset($_SESSION["username"])) {
$username = $_SESSION["username"];
echo "";
} else {
// User is not logged in, handle as needed (e.g., redirect to the login page)
header("Location: http://localhost/DIY_Project_sharing_platform/HTML/admin_login.html");
exit();
}

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

// Query to count the number of projects uploaded by the logged-in user
$query1 = "SELECT COUNT(*) AS project_count FROM project_table ";
$result1 = pg_query($conn, $query1);

if ($result1) {
    $row1 = pg_fetch_assoc($result1);
    $project_count = $row1['project_count'];
} else {
    $project_count = 0; // Default to 0 if query fails
}

pg_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard for Admin</title>
    <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/admin_dashboard_css.CSS">
</head>
<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Left-side Menu -->
        <div class="left-menu">
            <!-- Subtitle -->
            <img src="http://localhost/DIY_Project_sharing_platform/IMAGES/diy2.png" width="100px" height="100px" ><br><br>
            <div class="subtitle">Admin</div><br/><br/>
            
            <div class="menu-item" onclick="toggleDropdown1()">
                <span class="menu-icon">👤</span> Users
            </div>
            <ul type="none" id="g" style="display: none;">

                <li><a href="http://localhost/DIY_Project_sharing_platform/PHP/view_user.php">View User</a></li><br/>
                
                <li><a href="http://localhost/DIY_Project_sharing_platform/PHP/edit_user.php" >Edit user</a></li>
                
            </ul><script>
                function toggleDropdown1()
                {
                    var dropdown = document.getElementById("g");
                    if (dropdown.style.display === "none") {
                        dropdown.style.display = "block";
                    } else {
                        dropdown.style.display = "none";
                    }
                }
                </script><br>

            <div class="menu-item" onclick="toggleDropdown2()">
            <span class="menu-icon">📂</span> Projects
            </div>
            <ul type="none" id="f" style="display: none;">

                <li><a href="http://localhost/DIY_Project_sharing_platform/PHP/admin_view_project.php">View Projects</a></li><br/>
                
                <li><a href="http://localhost/DIY_Project_sharing_platform/PHP/admin_edit_project.php">Edit Projects</a></li><br/>

                <li><a href="http://localhost/DIY_Project_sharing_platform/PHP/admin_delete_project.php">Delete Projects</a></li>
                
            </ul><script>
                function toggleDropdown2() {
                    var dropdown = document.getElementById("f");
                    if (dropdown.style.display === "none") {
                        dropdown.style.display = "block";
                    } else {
                        dropdown.style.display = "none";
                    }
                }
                </script><br>
            
            <div class="menu-item" >
                <a href="http://localhost/DIY_Project_sharing_platform/HTML/category.html" class="menu-icon">➕ Add Category</a> 
            </div><br>
            
            <div class="menu-item" >
                <a href="http://localhost/DIY_Project_sharing_platform/PHP/logout.php" class="menu-icon">🚪Logout</a>
            </div>
            <!-- Add more menu items with icons as needed -->
        </div>
        <!-- Right Content Block -->
        <div class="right-content">
            <!-- Heading Bar -->
            <div class="heading-bar">
                Admin dashboard
            </div>

            <!-- Content Area (Initially empty, will be populated based on menu selection) -->
            <div class="content" id="content">
                Welcome to the Admin Dashboard. Select a menu item to view content.
            </div><br/><br/>
            <div class="card">
            <div class="content">
                  <h2>All Projects:</h2>
                  <p><?php echo htmlspecialchars($project_count); ?></p>
                </div>
              </div><br><br>
            </div>
        </div>
    </div>

    

</body>
</html>