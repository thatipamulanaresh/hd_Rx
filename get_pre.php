<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');

// Retrieve and validate the pres_id from POST request
if (isset($_POST["pres_id"])) {
    $pres_id = intval($_POST["pres_id"]);
    if ($pres_id <= 0) {
        echo json_encode(array("status" => "False", "message" => "Invalid prescription ID"));
        exit();
    }
} else {
    echo json_encode(array("status" => "False", "message" => "Prescription ID not provided"));
    exit();
}

// Construct the SQL query
$select_sql = "
    SELECT 
        mp.id,
        mm.medicine_name,
        mp.dosage,
        mp.duration,
        mp.quantity,
        mp.timing,
        mp.notes,
        mp.date,
        mp.status
    FROM 
        med_prescription mp
    INNER JOIN 
        medicine_master mm 
    ON 
        mp.med_id = mm.id
    WHERE 
        mp.pres_id = $pres_id
";

$result = $con->query($select_sql);

if ($result) {
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode(array("status" => "True", "data" => $data));
    } else {
        echo json_encode(array("status" => "False", "message" => "No records found"));
    }
} else {
    echo json_encode(array("status" => "False", "message" => "Query failed: " . $con->error));
}

$con->close();
?>
