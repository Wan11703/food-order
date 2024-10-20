<?php
include("config/constants.php");

$response = array();

if (isset($_POST['email']) && isset($_POST['username'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];

    $sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['status'] = 'error';
        $response['message'] = 'Record with this email or username already exists.';
    } else {
        $response['status'] = 'success';
    }

    $stmt->close();
}

echo json_encode($response);
?>
