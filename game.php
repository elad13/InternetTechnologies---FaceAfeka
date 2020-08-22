<?php include "templates/header.php" ?>
<?php require_once "php/functions.php" ?>
<?php
check_auth();
db_connect();
?>

<div style="text-align: center;">
  <h1> Memory Card!</h1>


  <form method="post" action="php/create_game_request.php">

    <p>
      <span style="color: black"> Select a Player:</span>
      <select name="to_user">
        <?php
        $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend > 0 ";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($fc_user = $result->fetch_assoc()) {
        ?>
            <option value=<?php echo $fc_user['id']; ?>> <?php echo $fc_user['username']; ?> </option>
        <?php
          }
        }
        ?>
      </select>
    </p>
    <br><br>
    <input type="submit" value="Send Request" style="height:50px;width:150px;background:rgba(9, 203, 6, 0.918)">
  </form>
</div>
<?php include "templates/footer.php" ?>