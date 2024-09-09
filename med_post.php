<?php
include 'conection.php';
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d H:i:s');

if (
    isset($_POST['pres_id']) &&
    isset($_POST['med_id']) &&
    isset($_POST['user_id']) &&
    isset($_POST['user_mbl_no']) &&
    isset($_POST['assigned_day']) &&
    isset($_POST['time_of_day']) &&
    isset($_POST['days']) &&
    isset($_POST['category']) &&
    isset($_POST['doctor_tips']) &&
    isset($_POST['visit_notes']) &&
    isset($_POST['rx_partner_id']) &&
    isset($_POST['status'])
) {
    $pres_id = $con->real_escape_string($_POST['pres_id']);
    $med_id = $con->real_escape_string($_POST['med_id']);
    $user_id = $con->real_escape_string($_POST['user_id']);
    $user_mbl_no = $con->real_escape_string($_POST['user_mbl_no']);
    $assigned_day = $con->real_escape_string($_POST['assigned_day']);
    $time_of_day = $con->real_escape_string($_POST['time_of_day']);
    $days = $con->real_escape_string($_POST['days']);
    $category = $con->real_escape_string($_POST['category']);
    $doctor_tips = $con->real_escape_string($_POST['doctor_tips']);
    $visit_notes = $con->real_escape_string($_POST['visit_notes']);
    $rx_partner_id = $con->real_escape_string($_POST['rx_partner_id']);
    $status = $con->real_escape_string($_POST['status']);

    $insert_sql = "INSERT INTO medicine (pres_id, med_id, user_id, user_mbl_no, assigned_day, time_of_day, days, category, doctor_tips, visit_notes, rx_partner_id, status) 
                   VALUES ('$pres_id', '$med_id', '$user_id', '$user_mbl_no', '$assigned_day', '$time_of_day', '$days', '$category', '$doctor_tips', '$visit_notes', '$rx_partner_id', '$status')";

    if ($con->query($insert_sql) === TRUE) {
        $select_sql = "SELECT * FROM medicine WHERE med_id = '$med_id'";
        $result = $con->query($select_sql);

        if ($result->num_rows > 0) {
            $data_list = array();

            while ($row = $result->fetch_assoc()) {
                $data_list[] = array(
                    "id" => $row["id"],
                    "pres_id" => $row["pres_id"],
                    "med_id" => $row["med_id"],
                    "user_id" => $row["user_id"],
                    "user_mbl_no" => $row["user_mbl_no"],
                    "assigned_day" => $row["assigned_day"],
                    "time_of_day" => $row["time_of_day"],
                    "days" => $row["days"],
                    "category" => $row["category"],
                    "doctor_tips" => $row["doctor_tips"],
                    "visit_notes" => $row["visit_notes"],
                    "rx_partner_id" => $row["rx_partner_id"],
                    "status" => $row["status"]
                );
            }

            $response = array(
                "success" => true,
                "message" => "Medicine data stored and fetched successfully",
                "data" => $data_list
            );
        } else {
            $response = array(
                "success" => false,
                "message" => "No data found for the provided med_id"
            );
        }
    } else {
        $response = array(
            "success" => false,
            "message" => "Error: " . $con->error
        );
    }
} else {
    $response = array(
        "success" => false,
        "message" => "All fields are required"
    );
}

echo json_encode($response);
$con->close();
?>