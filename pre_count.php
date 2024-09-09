<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');

// Initialize an array to store the response
$response = array();
$response['status'] = "true";
$response['message'] = 'Data fetched successfully';

try {
    // Query for total count this week
    $sql_week = "SELECT COUNT(*) AS total_count_this_week FROM med_prescription WHERE YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)";
    $result_week = $con->query($sql_week);
    if ($result_week) {
        $response['data']['total_count_this_week'] = $result_week->fetch_assoc()['total_count_this_week'];
    } else {
        throw new Exception("Error in query: " . $con->error);
    }

    // Query for today's count
    $sql_today = "SELECT COUNT(*) AS today_count FROM med_prescription WHERE DATE(date) = CURDATE()";
    $result_today = $con->query($sql_today);
    if ($result_today) {
        $response['data']['today_count'] = $result_today->fetch_assoc()['today_count'];
    } else {
        throw new Exception("Error in query: " . $con->error);
    }

    // Query for today's pending count
    $sql_pending_today = "SELECT COUNT(*) AS pending_count FROM med_prescription WHERE DATE(date) = CURDATE() AND status = 'pending'";
    $result_pending_today = $con->query($sql_pending_today);
    if ($result_pending_today) {
        $response['data']['pending_count'] = $result_pending_today->fetch_assoc()['pending_count'];
    } else {
        throw new Exception("Error in query: " . $con->error);
    }

} catch (Exception $e) {
    // In case of error, set status to false and add error message
    $response['status'] = "false";
    $response['message'] = $e->getMessage();
}

// Output the response in JSON format
header('Content-Type: application/json');
echo json_encode($response);

// Close connection
$con->close();
?>
