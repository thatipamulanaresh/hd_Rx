<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');

$pres_id = $_POST['pres_id'];


$select_sql = "SELECT * FROM medicine_table";

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