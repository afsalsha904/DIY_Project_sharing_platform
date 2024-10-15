<?php
$host = "localhost";
$port = "5432";
$dbname = "DIY_project_sharing_platform";
$user = "postgres";
$password = "1978";

$conn=pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if ($conn)
{
echo "Connected to the database successfully!";
} else 
{
echo "Failed to connect to the database."; 
}

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    //RETRIEVE VALUES

    $category_Type=$_POST["category_Type"];
    
    
}
$sql="INSERT INTO category_table(category_type)
values('$category_Type')";


$result = pg_query($conn, $sql); 
if ($result) 
{
echo "    Data inserted successfully!"; 
} 
else
{
echo "Error: " . pg_last_error($conn);
}

pg_close($conn);

?>

