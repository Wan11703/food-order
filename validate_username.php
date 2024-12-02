<?php
include("config/constants.php");
$username = json_decode(file_get_contents('php://input'))->username;
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
echo json_encode(['exists' => mysqli_num_rows($result) > 0]);
mysqli_close($conn);
?>