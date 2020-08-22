<?php require_once "functions.php" ?>

<?php

db_connect();

// Fill up array with names
$sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend = 0";
$result = $conn->query($sql);

$a = [];
while ($row = $result->fetch_assoc()) {

    $a[] = $row;
}

$q = $_GET["q"]; //get the q parameter from URL
//lookup all hints from array if length of q>0
if (strlen($q) > 0) {
    $hint = "";
    for ($i = 0; $i < count($a); $i++) {
        if (strtolower($q) == strtolower(substr($a[$i]['username'], 0, strlen($q)))) {
            $hint = $a[$i];
        }
    }
}
// Set output to "no suggestion" if no hint were found
// or to the correct values
if ($hint == "") {
    $response = "No Results";
    echo $response;
} else {
    $response = $hint['username'];
    echo $response;
    echo "<a href=php/add_friend.php?uid=".$hint['id']."> Send Request</a>";
}

?>