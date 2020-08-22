
<?php
    require_once "functions.php";
    db_connect();
    $userSql = "SELECT username FROM users WHERE users.id = {$_POST['to_user']}";
    $result = $conn->query($userSql);
    if ($result->num_rows > 0)
    {
        if ($user = $result->fetch_assoc()){
            $sql = "INSERT INTO game_requests (from_user, to_user, url) VALUES (?, ?, ?)";
            $statement = $conn->prepare ($sql);
            $url = "http://localHost:8000/?player1=".$_SESSION['user_username']."&player2=".$user['username'];
            $statement->bind_param('iis', $_SESSION['user_id'], $_POST['to_user'], $url);
            if (!$statement->execute()){
                echo "Error!!! ".$conn->error;
            }
        }
    }
    redirect_to('/dashboard.php');
    $conn->close();
