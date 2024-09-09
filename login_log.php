<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');

// Check if the required POST data is set
if (isset($_POST["user_id"], $_POST["mobile_number"], $_POST["IMEI_no"], $_POST["androidV"], $_POST["manu"], $_POST["model"])) {
    // Escape user inputs to prevent SQL injection
    $user_id = mysqli_real_escape_string($con, $_POST["user_id"]);
    $mobile_number = mysqli_real_escape_string($con, $_POST["mobile_number"]);
    $IMEI_no = mysqli_real_escape_string($con, $_POST["IMEI_no"]);
    $androidV = mysqli_real_escape_string($con, $_POST["androidV"]);
    $manu = mysqli_real_escape_string($con, $_POST["manu"]);
    $model = mysqli_real_escape_string($con, $_POST["model"]);

    // Insert data into login_log table
    $insert_sql = "INSERT INTO login_log (user_id, mobile_number, IMEI_no, androidV, manu, model, login_time, status) 
                   VALUES ('$user_id', '$mobile_number', '$IMEI_no', '$androidV', '$manu', '$model', '$date', 'active')";
    
    if ($con->query($insert_sql) === TRUE) {
        echo json_encode(array("status" => "True", "message" => "Data inserted successfully."));
    } else {
        echo json_encode(array("status" => "False", "message" => "Failed to insert: " . $con->error));
    }
    
    // Retrieve data from login_log table
    $select_sql = "SELECT * FROM login_log";
    $result = $con->query($select_sql);

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // Optionally, you can return the data if needed
        // echo json_encode($data);
    } else {
        echo json_encode(array("status" => "False", "message" => "No records found"));
    }

} else {
    echo json_encode(array("status" => "False", "message" => "Required fields are missing"));
}

$con->close();
?>
