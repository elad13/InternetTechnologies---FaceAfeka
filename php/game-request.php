<?php
    require_once "/functions.php";
    db_connect();
    $sql = "INSERT INTO game_requests (player1_username, player2_username) VALUES (?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param('ss', $_SESSION['user_username'], $_GET['username']);
    if ($statement->execute()) {
        redirect_to("/dashboard.php?game_request_sent=true");
    } else {
        echo "Error: " . $conn->error;
    }
