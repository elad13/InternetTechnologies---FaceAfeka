<?php
    require_once "functions.php";
    db_connect();
    $sql = "DELETE FROM user_friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param('iiii', $_GET['uid'], $_SESSION['user_id'], $_SESSION['user_id'], $_GET['uid']);
    if ($statement->execute()) {
        redirect_to('/dashboard.php');
    } else {
        echo "Error: " . $conn->error;
    }