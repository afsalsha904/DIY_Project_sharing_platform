<?php
$proj_id = $_GET['proj_id'] ?? '';

if (empty($proj_id)) {
    echo "No project ID provided.";
    exit();
}

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

$query = "SELECT * FROM project_table WHERE proj_id = $1";
$result = pg_query_params($conn, $query, array($proj_id));

if ($result && pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);

    $project_name = htmlspecialchars($row["project_title"]);
    $username = htmlspecialchars($row["username"]);
    $category = htmlspecialchars($row["category"]);
    $description = htmlspecialchars($row["description"]);
} else {
    echo "Project not found.";
    exit();
}

pg_close($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reporter_name = $_POST['name'];
    $reporter_email = $_POST['email'];
    $report_message = $_POST['message'];
    
    $to = 'afsalsha904@gmail.com';  // Admin email
    $subject = "Report for Project ID: $proj_id";
    $body = "Project Title: $project_name\n"
            . "Reported by: $reporter_name ($reporter_email)\n\n"
            . "Message: $report_message";
    
    if (mail($to, $subject, $body)) {
        echo "Report successfully sent!";
    } else {
        echo "Failed to send the report.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Project</title>
    <style>
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: "Helvetica Neue", Arial, sans-serif;
        }
        .form-group {
            margin-bottom: 15px;
            
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Report This Project</h2>
        <p><strong>Project Name:</strong> <?php echo $project_name; ?></p>
        <p><strong>Uploaded by:</strong> <?php echo $username; ?></p>
        <p><strong>Category:</strong> <?php echo $category; ?></p>
        <p><strong>Description:</strong> <?php echo $description; ?></p><br>
        
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Describe the Issue</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Submit Report</button>
        </form>
    </div>
</body>
</html>
