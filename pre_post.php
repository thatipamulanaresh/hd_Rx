<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');

// Check if all necessary fields are present
if(empty($_POST["pres_id"]) || empty($_POST["med_id"]) || empty($_POST["dosage"]) || empty($_POST["duration"]) || empty($_POST["quantity"]) || empty($_POST["timing"])) {
    echo json_encode(array("status" => "False", "message" => "All fields are required"));
    exit; // Stop script execution
}

$insert_sql = "INSERT INTO med_prescription
    (med_id, dosage, duration, quantity, timing, notes,date,status)
    VALUES
    ('" . $_POST["med_id"] . "','" . $_POST["dosage"] . "','" . $_POST["duration"] . "'
    ,'" . $_POST["quantity"] . "','" . $_POST["timing"] . "','" . $_POST["notes"] . "','$date','" . $_POST["status"] . "')";

if ($con->query($insert_sql) === TRUE) {
    echo json_encode(array("status" => "True", "message" => "Record added successfully"));
} else {
    echo json_encode(array("status" => "False", "message" => "Error: " . $con->error));
}

$con->close();
?>
