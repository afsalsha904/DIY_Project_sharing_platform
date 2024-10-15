<?php
// Start a session (if not already started)
session_start();
// Check if the user is logged in
if (isset($_SESSION["username"])) {
$username = $_SESSION["username"];
echo "";
} else {
// User is not logged in, handle as needed (e.g., redirect to the login page)
header("Location: http://localhost/DIY_Project_sharing_platform/HTML/Login_page.html");
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
$query1 = "SELECT COUNT(*) AS project_count FROM project_table WHERE username = '$username'";
$result1 = pg_query($conn, $query1);

if ($result1) {
    $row1 = pg_fetch_assoc($result1);
    $project_count = $row1['project_count'];
} else {
    $project_count = 0; // Default to 0 if query fails
}

// // Query to get the category of the projects uploaded by the logged-in user
// $query2 = "SELECT category FROM project_table WHERE username = '$username'";
// $result2 = pg_query($conn, $query2);

// if ($result2) {
//     // Assuming you want to fetch the first category
//     $row2 = pg_fetch_assoc($result2);
//     $category = $row2['category'];
// } else {
//     $category = null; // Default to null if query fails
// }


pg_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard for User</title>
    
    <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/user_dashboard_css.CSS">
    </head>
<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Left-side Menu -->
        <div class= "left-menu">
            <!-- Subtitle -->
            <img src="http://localhost/DIY_Project_sharing_platform/IMAGES/diy3.png" width="100px" height="100px" ><br><br>
            <div class="subtitle">Hy, <?php echo htmlspecialchars( $username);?>!</div><br><br>
            
            <div class="menu-item" onclick="toggleDropdown1()">
                <span class="menu-icon">👤</span> User Profile
            </div>
            <ul type="none" id="g" style="display: none;">

                <li><a href="http://localhost/DIY_Project_sharing_platform/PHP/view_profile.php">View Profile</a></li><br/>
                
                <li><a href="http://localhost/DIY_Project_sharing_platform/PHP/edit_profile.php" onclick="loadContent('edit_profile.php')" >Edit Profile</a></li>
                
            </ul><script>
                function toggleDropdown1() {
                    var dropdown = document.getElementById("g");
                    if (dropdown.style.display === "none") {
                        dropdown.style.display = "block";
                    } else {
                        dropdown.style.display = "none";
                    }
                }
                function loadContent(url) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "http://localhost/DIY_Project_sharing_platform/PHP/" + url, true);
            xhttp.send();
            }
                </script><br>

            <div class="menu-item" onclick="toggleDropdown2()">
            <span class="menu-icon">📂</span> Projects
            </div>
            <ul type="none" id="f" style="display: none;">

                <li><a href="http://localhost/DIY_Project_sharing_platform/PHP/project.php">Create Projects</a></li><br/>
                                
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
                <a href="http://localhost/DIY_Project_sharing_platform/PHP/All_projects.php" class="menu-icon">👁 All Projects</a> 
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
            <?php echo htmlspecialchars($username);?> Projects
            </div>

            <!-- Content Area (Initially empty, will be populated based on menu selection) -->
            <div class="content" id="content">
                Welcome to the User Dashboard. Select a menu item to view content.
            </div><br><br><br><br><br>
            <div class="card">
                
                <div class="content">
                  <h2>No of Projects:</h2>
                  <p><?php echo htmlspecialchars($project_count); ?></p>
                </div>
              </div><br><br>
              
           <!-- <div class="progress-container">
           <h3>Your Progression:</h3>
           <div class="progress-bar">
           <div class="progress" style="width: 20%;"></div>
           </div>
           </div> -->




</div>
</div>
</body>
</html>