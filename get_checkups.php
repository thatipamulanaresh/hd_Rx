<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');


$select_sql = "SELECT DISTINCT * FROM checkup_master ";

$result = $con->query($select_sql);

if (!$result) {
    echo json_encode(array("status" => "False", "message" => "Query error: " . $con->error));
} else {
    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode(array("status" => "True", "message" => "Data Found", "data" => $rows));
    } else {
        echo json_encode(array("status" => "False", "message" => "No Data Found"));
    }

    $result->free_result(); 
    $con->close();
}
?>