<?php

//Define back slash so that you can use it anywhere later
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
// Define your website siteroot
defined("SITE_ROOT") ? null : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once "functions.php";
db_connect();
$sql = "INSERT INTO posts (text, user_id, isPrivate) VALUES (?, ?, ?)";
$isPrivate = 0;
if (isset($_POST['privatePost']))
    $isPrivate = 1;
$statement = $conn->prepare($sql);
$insertValuesSQL = '';
$statement->bind_param('sii', $_POST['content'], $_SESSION['user_id'], $isPrivate);
if ($statement->execute()) {
    $post_id = $lastid = mysqli_insert_id($conn);
    if (count($_FILES["uploadFile"]["name"]) > 0) {
        $folder = SITE_ROOT . DS . "uploads";
        for ($i = 0; $i < count($_FILES["uploadFile"]["name"]); $i++) {
            $filename = $_FILES["uploadFile"]["tmp_name"][$i];
            $path = $_FILES["uploadFile"]["name"][$i];
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $destination = 'IMG_' . date("Ymd_His_") . rand(100, 1000) . '.' . $extension;
            if (move_uploaded_file($filename, $folder . DS . $destination)) {
                $insertValuesSQL .= "('" . $destination . "'," . $post_id . " ),";
            }
        }
        if (!empty($insertValuesSQL)) {
            $insertValuesSQL = trim($insertValuesSQL, ',');
            // Insert image file name into database
            $insert = $conn->query("INSERT INTO images (file_name, post_id) VALUES {$insertValuesSQL}");
            if (!$insert) {
                echo "Error!!! " . $conn->error;
            }
        }
    }
    redirect_to("/dashboard.php");
} else {
    echo "Error!!! " . $conn->error;
}
$conn->close();
