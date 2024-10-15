<?php
// search.php

// Check if the 'query' parameter is set in the GET request
if (isset($_GET['query'])) {
    // Sanitize the search query to prevent XSS attacks
    $query = htmlspecialchars($_GET['query']);

    // Database connection settings
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

    // Sanitize the query to prevent SQL injection
    $searchTerm = '%' . pg_escape_string($query) . '%';

    // Prepare and execute the SQL query using ILIKE for case-insensitive search
    $result = pg_query_params($conn, "SELECT * FROM project_table WHERE category ILIKE $1 OR project_title ILIKE $1", array($searchTerm));

    // Output HTML with CSS
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Search Results</title>';
    echo '<style>';
    echo 'body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }';
    echo '.container { width: 80%; margin: 0 auto; padding: 20px; }';
    echo '.header { text-align: center; margin-bottom: 20px; }';
    echo '.header h1 { color: #333; }';
    echo '.results { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }';
    echo '.result-item { border-bottom: 1px solid #ddd; padding: 10px 0; }';
    echo '.result-item:last-child { border-bottom: none; }';
    echo '.result-item a { color: #007bff; text-decoration: none; }';
    echo '.result-item a:hover { text-decoration: underline; }';
    echo '.no-results { text-align: center; font-size: 1.2em; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="container">';
    echo '<div class="header">';
    echo '<h1>Search Results</h1>';
    echo '</div>';
    echo '<div class="results">';

    if ($result) {
        // Display results
        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $proj_id = htmlspecialchars($row['proj_id']);
                $project_title = htmlspecialchars($row['project_title']);
                echo '<div class="result-item">';
                echo '<a href="search_view.php?proj_id=' . urlencode($proj_id) . '">' . $project_title . '</a>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-results">No results found for "' . htmlspecialchars($query) . '".</p>';
        }
    } else {
        echo '<p class="no-results">Error executing query: ' . pg_last_error($conn) . '</p>';
    }

    echo '</div>';
    echo '</div>';
    echo '</body>';
    echo '</html>';

    // Close the connection
    pg_close($conn);
} else {
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Search</title>';
    echo '<style>';
    echo 'body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; text-align: center; }';
    echo '.container { width: 80%; margin: 0 auto; padding: 20px; }';
    echo '.message { font-size: 1.5em; color: #333; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="container">';
    echo '<p class="message">No search query provided.</p>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
}
?>
