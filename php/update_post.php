<?php
require_once "functions.php";
db_connect();

$sql = "UPDATE posts SET isPrivate = ? WHERE id = ?";
$statement = $conn->prepare($sql);
$statement->bind_param('si', $_GET['status'], $_GET['id']);

if ($statement->execute()) {
    redirect_to('/dashboard.php');
} else {
    echo "Error!!! " . $conn->error;
}
$conn->close();
