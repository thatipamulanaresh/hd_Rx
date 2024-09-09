<?php
include 'connection.php';
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');

try {
    // Check if all required POST data is set
    if (
        isset($_POST["name"], $_POST["gender"], $_POST["dob"], $_POST["user_photo"], $_POST["food_preference"],
        $_POST["mobile_number"], $_POST["height"], $_POST["weight"], $_POST["smoking"], $_POST["diabetic"],
        $_POST["blood_pressure"], $_POST["pregnant"], $_POST["hb_value"], $_POST["aadhar_no"],
        $_POST["address"], $_POST["otp"])
    ) {
        // Escape user inputs to prevent SQL injection
        $name = mysqli_real_escape_string($con, $_POST["name"]);
        $gender = mysqli_real_escape_string($con, $_POST["gender"]);
        $dob = mysqli_real_escape_string($con, $_POST["dob"]);
        $user_photo = mysqli_real_escape_string($con, $_POST["user_photo"]);
        $food_preference = mysqli_real_escape_string($con, $_POST["food_preference"]);
        $mobile_number = mysqli_real_escape_string($con, $_POST["mobile_number"]);
        $height = mysqli_real_escape_string($con, $_POST["height"]);
        $weight = mysqli_real_escape_string($con, $_POST["weight"]);
        $smoking = mysqli_real_escape_string($con, $_POST["smoking"]);
        $diabetic = mysqli_real_escape_string($con, $_POST["diabetic"]);
        $blood_pressure = mysqli_real_escape_string($con, $_POST["blood_pressure"]);
        $pregnant = mysqli_real_escape_string($con, $_POST["pregnant"]);
        $hb_value = mysqli_real_escape_string($con, $_POST["hb_value"]);
        $aadhar_no = mysqli_real_escape_string($con, $_POST["aadhar_no"]);
        $address = mysqli_real_escape_string($con, $_POST["address"]);
        $otp = mysqli_real_escape_string($con, $_POST["otp"]);

        // Insert data into users table
        $insert_sql = "INSERT INTO users
            (name, gender, dob, user_photo, food_preference, mobile_number, height, weight, smoking, diabetic, blood_pressure,
            pregnant, hb_value, aadhar_no, address, otp, created_at)
            VALUES ('$name', '$gender', '$dob', '$user_photo', '$food_preference', '$mobile_number', '$height', '$weight',
            '$smoking', '$diabetic', '$blood_pressure', '$pregnant', '$hb_value', '$aadhar_no', '$address', '$otp', '$date')";

        if ($con->query($insert_sql) === TRUE) {
            echo json_encode(array("status" => "True", "message" => "Data inserted successfully."));
        } else {
            throw new Exception("Failed to insert: " . $con->error);
        }
    } else {
        throw new Exception("Required fields are missing");
    }
} catch (Exception $e) {
    echo json_encode(array("status" => "False", "message" => $e->getMessage()));
} finally {
    $con->close();
}
?>
