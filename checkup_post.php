<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d H:i:s');

try {
    if (
        isset($_POST['pres_id'], $_POST['checkup_id'], $_POST['user_id'], $_POST['user_mob_no'], 
              $_POST['checkup_date'], $_POST['checkup_details'], $_POST['checkup_status'], 
              $_POST['rx_partner_id'])
    ) {
        // Sanitize input
        $pres_id = $con->real_escape_string($_POST['pres_id']);
        $checkup_id = $con->real_escape_string($_POST['checkup_id']);
        $user_id = $con->real_escape_string($_POST['user_id']);
        $user_mob_no = $con->real_escape_string($_POST['user_mob_no']);
        $checkup_date = $con->real_escape_string($_POST['checkup_date']);
        $checkup_details = $con->real_escape_string($_POST['checkup_details']);
        $checkup_status = $con->real_escape_string($_POST['checkup_status']);
        $remarks = $con->real_escape_string($_POST['remarks'] ?? '');
        $rx_partner_id = $con->real_escape_string($_POST['rx_partner_id']);
        $status = $con->real_escape_string($_POST['status'] ?? 'active'); // Default value 'active'

        // Set empty fields to NULL
        $remarks = empty($remarks) ? 'NULL' : "'$remarks'";

        // Validate date format and convert if necessary
        $date_format = 'Y-m-d H:i:s';
        $checkup_date_obj = DateTime::createFromFormat($date_format, $checkup_date);
        if (!$checkup_date_obj || $checkup_date_obj->format($date_format) !== $checkup_date) {
            // Attempt to parse date in a different format if necessary
            $alt_date_format = 'Y-m-d';
            $checkup_date_obj = DateTime::createFromFormat($alt_date_format, $checkup_date);
            if (!$checkup_date_obj || $checkup_date_obj->format($alt_date_format) !== $checkup_date) {
                throw new Exception("Invalid date format for checkup_date. Expected format: $date_format or $alt_date_format");
            }
            // Convert to expected format
            $checkup_date = $checkup_date_obj->format($date_format);
        }

        // Insert data into checkup table
        $insert_sql = "INSERT INTO checkup 
            (pres_id, checkup_id, user_id, user_mob_no, checkup_date, checkup_details, checkup_status, remarks, rx_partner_id, status) 
            VALUES ('$pres_id', '$checkup_id', '$user_id', '$user_mob_no', '$checkup_date', '$checkup_details', '$checkup_status', $remarks, '$rx_partner_id', '$status')";

        if ($con->query($insert_sql) === TRUE) {
            // Retrieve data from checkup table
            $select_sql = "SELECT * FROM checkup WHERE checkup_id = '$checkup_id'";
            $result = $con->query($select_sql);

            if ($result->num_rows > 0) {
                $data_list = array();
                while ($row = $result->fetch_assoc()) {
                    $data_list[] = array(
                        "id" => $row["id"],
                        "pres_id" => $row["pres_id"],
                        "checkup_id" => $row["checkup_id"],
                        "user_id" => $row["user_id"],
                        "user_mob_no" => $row["user_mob_no"],
                        "checkup_date" => $row["checkup_date"],
                        "checkup_details" => $row["checkup_details"],
                        "checkup_status" => $row["checkup_status"],
                        "remarks" => $row["remarks"],
                        "rx_partner_id" => $row["rx_partner_id"],
                        "status" => $row["status"]
                    );
                }
                $response = array(
                    "success" => true,
                    "message" => "Checkup data stored and fetched successfully",
                    "data" => $data_list
                );
            } else {
                throw new Exception("No data found for the provided checkup_id");
            }
        } else {
            throw new Exception("Failed to insert: " . $con->error);
        }
    } else {
        throw new Exception("All fields are required");
    }
} catch (Exception $e) {
    $response = array(
        "success" => false,
        "message" => $e->getMessage()
    );
}

echo json_encode($response);
$con->close();
?>
