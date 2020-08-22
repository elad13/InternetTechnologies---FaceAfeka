
<?php
    require_once "functions.php";
    db_connect();
    $sql = "INSERT INTO post_comments (comment, post_id, user_id) VALUES (?, ?, ?)";
    $statement = $conn->prepare ($sql);
    $statement->bind_param('sii', $_POST['comment'], $_POST['post_id'], $_SESSION['user_id']);
    if ($statement->execute()){
        redirect_to("/dashboard.php");
    }else {
        echo "Error!!! ".$conn->error;
    }
    $conn->close();
