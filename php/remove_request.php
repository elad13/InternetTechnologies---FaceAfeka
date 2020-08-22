<?php
    require_once "functions.php";
    db_connect();
    $sql = "DELETE FROM friend_requests WHERE user_id = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param('i', $_GET['id']);
    if ($statement->execute()) {
        redirect_to('/dashboard.php');
    } else {
        echo "Error: " . $conn->error;
    }