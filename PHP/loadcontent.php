<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: http://localhost/DIY_Project_sharing_platform/HTML/Login_page.html");
    exit();
}
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard for User</title>
    <link rel="stylesheet" href="http://localhost/DIY_Project_sharing_platform/CSS/user_dashboard_css.CSS">
    <style>
        .menu-item {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="left-menu">
            <img src="http://localhost/DIY_Project_sharing_platform/IMAGES/diy3.png" width="100px" height="100px"><br><br>
            <div class="subtitle">Hy, <?php echo htmlspecialchars($username); ?>!</div><br><br>

            <div class="menu-item" onclick="loadContent('view_profile.php')">
                <span class="menu-icon">👤</span> User Profile
            </div>
            <ul id="g" style="display: none;">
                <li><a href="#">View Profile</a></li>
                <li><a href="#" onclick="loadContent('edit_profile.php')">Edit Profile</a></li>
            </ul>
            <br>

            <div class="menu-item" onclick="toggleDropdown2()">
                <span class="menu-icon">📂</span> Projects
            </div>
            <ul id="f" style="display: none;">
                <li><a href="#">📄Create Projects</a></li>
                <li><a href="#">➕Add Media</a></li>
            </ul>
            <br>

            <div class="menu-item">
                <span class="menu-icon">👁️</span> All Projects
            </div>
            <br>

            <div class="menu-item">
                <span class="menu-icon">❌</span> Delete Project
            </div>
            <br>

            <div class="menu-item">
                <a href="http://localhost/DIY_Project_sharing_platform/PHP/logout.php" class="menu-icon">🚪Logout</a>
            </div>
        </div>

        <div class="right-content">
            <div class="heading-bar">
                <?php echo htmlspecialchars($username); ?> Projects
            </div>

            <div class="content" id="content">
                Welcome to the User Dashboard. Select a menu item to view content.
            </div>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>
