<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');

// Set a threshold for "most common" medicines
$popularity_threshold = 1; // Adjust based on your definition of common

try {
    // SQL query
    $select_sql = "SELECT medicine_name 
               FROM medicine_master 
               WHERE popularity_score > $popularity_threshold 
               GROUP BY medicine_name 
               ORDER BY MAX(popularity_score) DESC";
    // Execute the query
    $result = $con->query($select_sql);

    if (!$result) {
        throw new Exception("Query error: " . $con->error);
    }

    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode(array("status" => "True", "message" => "Data Found", "data" => $rows));
    } else {
        echo json_encode(array("status" => "False", "message" => "No Data Found"));
    }

    // Free the result set
    $result->free_result();

} catch (Exception $e) {
    // Catching and returning any exception that occurs
    echo json_encode(array("status" => "False", "message" => $e->getMessage()));
} finally {
    // Close the database connection in the "finally" block to ensure it's always closed
    if ($con) {
        $con->close();
    }
}
?>
