<?php

include 'connection.php';

$mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
$password = mysqli_real_escape_string($con, $_POST['password']);

$select_sql = "SELECT * FROM rx_partners WHERE mobile_number = '$mobile_number' AND password = '$password'";

$result = $con->query($select_sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Generate a longer token
        $token = substr(bin2hex(random_bytes(16)), 0, 32); // Generates a 32-character (128-bit) hexadecimal string        
        $last_login = date('Y-m-d H:i:s');
        $update_sql = "UPDATE rx_partners SET token = '$token', last_login = '$last_login' WHERE mobile_number = '$mobile_number'";
        $con->query($update_sql);
        
        $row['token'] = $token;
        $row['last_login'] = $last_login;
        
        $questions[] = $row;
    }

    echo json_encode(array("status" => "True", "message" => "Login Successful", "data" => $questions));
} else {
    echo json_encode(array("status" => "True", "message" => "No Data Found"));
}

$con->close();

?>
