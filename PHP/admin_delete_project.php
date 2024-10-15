<?php
session_start();

$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$pwd = "1978";
// Connect to PostgreSQL database
$conn =pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pwd");
if ($conn)
	{
		echo "";
	}
else
	{
		echo "Failed to connect to the database.";
	}
// Handle delete request

if (isset($_POST['delete'])) {
    $id_to_delete = $_POST['proj_id'];
    $delete_query = "DELETE FROM project_table WHERE proj_id = $id_to_delete";
    $delete_result = pg_query($conn,$delete_query);

    if ($delete_result) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . pg_last_error();
    }
}




$query = "SELECT * FROM project_table "; 

$result = pg_query($conn, $query);

if (!$result) {
    die("Error in query: " . pg_last_error());
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>DELETE PROJECTS</title>
  <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #cbeff3;
            background-color: #00DBDE;
            background-image: linear-gradient(90deg, #00DBDE 0%, #FC00FF 100%);

        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:nth-child(odd) {
            background-color: #FAF9F6;
        }
        .DELETE-BUTTON{
            background-color: #FF0000;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 1cm;
        }
        .DELETE-BUTTON:hover {
            background-color: #FFA27F;
        }
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
        </tr>
        <?php
         while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['project_title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
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