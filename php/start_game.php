<?php
    require_once "functions.php";
    db_connect();
    $sql = "select * FROM game_requests WHERE id = {$_GET['request_id']}";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        if ($game_req = $result->fetch_assoc())
        {
            $url = $game_req['url'];
            $del = "DELETE FROM game_requests WHERE id = ?";
            $statement = $conn->prepare($del);
            $statement->bind_param('i', $_GET['request_id']);
            if ($statement->execute()) {
                redirect_to('/dashboard.php');
            } else {   
                echo "Error: " . $conn->error;
            }
        }
    }
    
