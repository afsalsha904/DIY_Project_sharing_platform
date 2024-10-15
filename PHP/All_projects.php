<?php
session_start();

$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$pwd = "1978";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pwd");
if (!$conn) {
    die("Failed to connect to the database: " . pg_last_error());
}

if (isset($_POST['delete'])) {
    $id_to_delete = $_POST['proj_id'];
    $delete_query = "DELETE FROM project_table WHERE proj_id = $1";
    $delete_result = pg_query_params($conn, $delete_query, array($id_to_delete));

    if ($delete_result) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . pg_last_error();
    }
}

$username = $_SESSION["username"];
$query = "SELECT * FROM project_table WHERE username = $1";
$result = pg_query_params($conn, $query, array($username));

if (!$result) {
    die("Error in query: " . pg_last_error());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>VIEW PROJECTS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f1f1; }
        .VIEW-BUTTON { background-color: blue; color: white; border: none; padding: 8px 16px; cursor: pointer; border-radius: 1cm; }
        .VIEW-BUTTON:hover { background-color: lightblue; }
        .EDIT-BUTTON { background-color: green; color: white; border: none; padding: 8px 16px; cursor: pointer; border-radius: 1cm; }
        .EDIT-BUTTON:hover { background-color: lightgreen; }
        .DELETE-BUTTON { background-color: #FF0000; color: white; border: none; padding: 8px 16px; cursor: pointer; border-radius: 1cm; }
        .DELETE-BUTTON:hover { background-color: #FFA27F; }
    </style>
</head>
<body>
    <h2>PROJECTS</h2>
    <table>
        <tr>
            <th>PROJECT NAME</th>
            <th>CATEGORY</th>
            <th>DESCRIPTION</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php
        while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['project_title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
            echo "<td>
                    <form method='post' action='http://localhost/DIY_Project_sharing_platform/PHP/view_project.php'>
                        <input type='hidden' name='proj_id' value='" . htmlspecialchars($row['proj_id']) . "' />
                        <input type='submit' name='view' value='VIEW' class='VIEW-BUTTON' />
                    </form>
                  </td>";
            echo "<td>
                    <form method='post' action='http://localhost/DIY_Project_sharing_platform/PHP/edit_project.php'>
                        <input type='hidden' name='proj_id' value='" . htmlspecialchars($row['proj_id']) . "' />
                        <input type='submit' name='edit' value='EDIT' class='EDIT-BUTTON' />
                    </form>
                  </td>";
            echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='proj_id' value='" . htmlspecialchars($row['proj_id']) . "' />
                        <input type='submit' name='delete' value='DELETE' class='DELETE-BUTTON' />
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    // Free resultset
    pg_free_result($result);

    // Close the connection
    pg_close($conn);
    ?>
</body>
</html>