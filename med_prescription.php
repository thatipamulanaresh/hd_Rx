<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');

// Check if pres_id is set in the POST request
if (!isset($_POST['pres_id'])) {
    echo json_encode(array("status" => "False", "message" => "pres_id is not set"));
    exit();
}

$pres_id = $_POST['pres_id'];

// Validate pres_id to be a number
if (!is_numeric($pres_id)) {
    echo json_encode(array("status" => "False", "message" => "Invalid pres_id"));
    exit();
}

// Sanitize the pres_id to prevent SQL injection
$pres_id = $con->real_escape_string($pres_id);

// Prepare the SQL query
$select_sql = "SELECT med_prescription.id, medicine_master.medicine_name,pres_id,
 med_id, dosage, duration, quantity, timing, notes
               FROM med_prescription 
               INNER JOIN medicine_master 
               ON med_prescription.med_id = medicine_master.id 
               WHERE med_prescription.id = '$pres_id'";

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
