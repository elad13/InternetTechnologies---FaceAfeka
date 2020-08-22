<?php include "templates/header.php" ?>
<?php require_once "php/functions.php" ?>
<?php
check_auth();
db_connect();
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<style type="text/css">
    input[type=file] {
        display: inline;
    }

    #image_preview {
        padding: 10px;
    }

    #post_image_preview img {
        width: 100px;
        padding: 5px;
    }

    #image_preview img {
        width: 100px;
        padding: 5px;
    }
</style>

<!-- main -->
<main class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- profile brief -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>Hello,</p>
                    <h4><?php echo $_SESSION['user_username'] ?></h4>
                </div>
            </div>
            <!-- ./profile brief -->

            <!-- friend requests -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Friend Requests</h4>
                    <?php
                    $sql = "SELECT * FROM friend_requests WHERE friend_id = {$_SESSION['user_id']}";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                    ?><ul><?php

                            while ($f_request = $result->fetch_assoc()) {
                            ?><li><?php

                                    $u_sql = "SELECT * FROM users WHERE id = {$f_request['user_id']} LIMIT 1";
                                    $u_result = $conn->query($u_sql);
                                    $fr_user = $u_result->fetch_assoc();

                                    ?><a href="profile.php?username=<?php echo $fr_user['username']; ?>">
                                        <?php echo $fr_user['username']; ?>
                                    </a>

                                    <a class="text-success" href="php/accept_request.php?uid=<?php echo $fr_user['id']; ?>">
                                        [Accept]
                                    </a>

                                    <a class="text-danger" href="php/remove_request.php?uid=<?php echo $fr_user['id']; ?>">
                                        [Decline]
                                    </a>

                                </li><?php
                                    }

                                        ?></ul><?php
                                            } else {
                                                ?><p class="text-center">No Friend Requests!</p><?php
                                                                                            }
                                                                                                ?>
                </div>
            </div>
            <!-- ./friend requests -->

        </div>
        <div class="col-md-6">
            <!-- post form -->

            <form method="post" action="php/create_post.php" id="add_post" enctype="multipart/form-data">
                <div>
                    <input class="form-control" type="text" name="content" placeholder="Make A Post…">
                </div>
                <div>
                    <input type="file" id="uploadFile" name="uploadFile[]" multiple />

                    <div id="image_preview"></div>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="privateChec" name="privatePost" value="true">
                    <label class="form-check-label" for="privateChec">Private Post</label>
                </div>
                <div>
                    <button class="btn btn-success" type="submit" name="post">Post</button>
                </div>
            </form>
            <hr>

            <script type="text/javascript">
                $("#uploadFile").change(function() {
                    $('#image_preview').html("");
                    var total_file = document.getElementById("uploadFile").files.length;
                    for (var i = 0; i < total_file; i++) {
                        $('#image_preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "'>");
                    }
                });
                $('add_post').ajaxForm(function() {});
            </script>
            <!-- ./post form -->
            <!-- feed -->
            <div>
                <!-- post -->
                <?php
                //$sql = "SELECT * FROM posts ORDER BY date DESC";
                $sql = "SELECT posts.id as post_id, posts.user_id as user_id, posts.isPrivate as post_private, posts.*, users.* FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.user_id = {$_SESSION['user_id']} OR (posts.user_id != {$_SESSION['user_id']} AND posts.isPrivate = 0) ORDER BY date DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($post = $result->fetch_assoc()) {
                        $private_string = $post['isPrivate'] ? "private" : "public";
                        $private_value = $post['isPrivate'] ? 0 : 1;
                ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p><?php echo $post['text']; ?></p>
                            </div>
                            <?php
                            $query = $conn->query("SELECT * FROM images WHERE post_id={$post['post_id']}");
                            if ($query->num_rows > 0) {
                            ?>
                                <div id="post_image_preview">
                                    <?php
                                    while ($row = $query->fetch_assoc()) {
                                        $imageURL = 'uploads/' . $row["file_name"];
                                    ?>
                                        <a href="<?php echo $imageURL; ?>">
                                            <img src="<?php echo $imageURL; ?>" alt="" />
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="panel-footer">
                                <span>Posted <?php echo $post['date']; ?> By <?php echo $post['username']; ?></span>
                                <span class="text-muted">
                                    <?php
                                    if ($post['isPrivate'] == 1)
                                        echo '(Private)';
                                    else
                                        echo '(Public)';
                                    ?>
                                </span>
                                <?php if ($post['user_id'] == $_SESSION['user_id']) { ?>
                                    <span class="pull-right"><a class="text-danger" href="php/delete_post.php?id=<?php echo $post['post_id']; ?>">[delete] </a></span>
                                    <span class="pull-right"><a class="text-danger" href="php/update_post.php?id=<?php echo $post['post_id']; ?>&status=<?php echo $private_value; ?>">[Update Permission]</a></span>
                                <?php } ?>
                            </div>
                            <!-- post comments -->
                            <div class="panel-body">
                                <?php
                                $commentSql = "SELECT post_comments.id as comment_id, post_comments.user_id as user_id, post_comments.*, users.* FROM post_comments LEFT JOIN users ON post_comments.user_id = users.id WHERE post_comments.post_id = {$post['post_id']} ORDER BY post_comments.id ASC";
                                $commentsResult = $conn->query($commentSql);
                                if ($commentsResult->num_rows > 0) {
                                    while ($comment = $commentsResult->fetch_assoc()) {
                                ?>
                                        <li>
                                            <span><?php echo $comment['comment']; ?> (Commented By <?php echo $comment['username']; ?>)</span>
                                            <?php if ($comment['user_id'] == $_SESSION['user_id']) { ?>
                                                <span class="pull-rght"> <a class="text-danger" href="php/delete_comment.php?id=<?php echo $comment['comment_id']; ?>">[delete]</a></span>
                                            <?php } ?>
                                        </li>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <p class="text-center">No Comments Yet!</p>
                                <?php

                                }
                                ?>
                            </div>
                            <div class="pannel-footer">
                                <form method="post" action="php/create_comment.php">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="comment" placeholder="Add A Comment..." required>
                                        <input class="sr-only" type="text" name="post_id" value="<?php echo $post['post_id'] ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit" name="post">Add</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <p class="text-center">No posts yet!</p>
                <?php
                }
                ?>
                <!-- ./post -->
            </div>
            <!-- ./feed -->
        </div>
        <div class="col-md-3">
            <!-- add friend -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Add Friend</h4>
                    <?php
                    $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend = 0";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    ?><ul><?php

                            while ($fc_user = $result->fetch_assoc()) {
                            ?><li>
                                    <?php echo $fc_user['username']; ?>
                                    <a href="php/add_friend.php?uid=<?php echo $fc_user['id']; ?>">[add]</a>
                                </li><?php
                                    }

                                        ?></ul><?php
                                            } else {
                                                ?><p class="text-center">No Users To Add!</p><?php
                                                                                            }
                                                                                                ?>

                    <script type="text/javascript">
                        var xmlHttp;

                        function showHint(str) {
                            if (str.length == 0) {
                                document.getElementById("txtHint").innerHTML = "";
                                return;
                            }
                            xmlHttp = GetXmlHttpObject();
                            if (xmlHttp == null) {
                                alert("Your browser does not support AJAX!");
                                return;
                            }
                            var url = "php/get_hint.php";
                            url = url + "?q=" + str;
                            url = url + "&sid=" + Math.random();
                            xmlHttp.onreadystatechange = stateChanged;
                            xmlHttp.open("GET", url, true);
                            xmlHttp.send(null);
                        }

                        function stateChanged() {
                            if (xmlHttp.readyState == 4) {
                                document.getElementById("txtHint").innerHTML = xmlHttp.responseText;
                            }
                        }

                        function GetXmlHttpObject() {
                            var xmlHttp = null;
                            try {
                                /* firefox, Opera 8.0+, Safari*/
                                xmlHttp = new XMLHttpRequest();
                            } catch (e) {
                                /Iexplorer/
                                try {
                                    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                                } catch (e) {
                                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                                }
                            }
                            return xmlHttp;
                        }
                    </script>
                    <form>
                        Search:
                        <input type="text" id="txt1" onkeyup="showHint(this.value)">
                    </form>
                    <p>Results: <span id="txtHint"></span></p>
                </div>
            </div>
            <!-- ./add friend -->

            <!-- friends -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Friends</h4>
                    <?php
                    $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend > 0 ";

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    ?><ul><?php
                            while ($fc_user = $result->fetch_assoc()) {
                            ?><li>
                                    <?php echo $fc_user['username']; ?>
                                    <a href="php/unfriend.php?uid=<?php echo $fc_user['id']; ?>">[unfriend]</a>
                                </li><?php
                                    }

                                        ?></ul><?php
                                            } else {
                                                ?><p class="text-center">No Friends yet!</p><?php
                                                                                        }
                                                                                            ?>
                </div>
            </div>
            <!-- ./friends -->
            <!-- Game -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Memory Card Game</h4>
                    <button onclick="MemoryGame()">Memory Card Game</button>
                    <h5>Play With:</h5>

                    <script>
                        function MemoryGame() {
                            window.open('/game.php');
                        }
                    </script>
                    <?php
                    $sql = "SELECT game_requests.id as request_id, users.username as from_user, game_requests.url as url FROM game_requests LEFT JOIN users ON game_requests.from_user = users.id WHERE game_requests.to_user = {$_SESSION['user_id']}";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    ?><ul><?php

                            while ($game_req = $result->fetch_assoc()) {
                            ?><li>

                                    Game with: <?php echo $game_req['from_user']; ?>
                                    <a onclick="open_in_new_tab_and_reload('<?php echo $game_req['url']; ?>',<?php echo $game_req['request_id']; ?>)"> Accept</a>
                                    
                                    <a onclick="ignore_and_reload(<?php echo $game_req['request_id']; ?>)"> Ignore</a>

                                </li>

                            <?php
                            }

                            ?></ul><?php
                                } else {
                                    ?><p class="text-center">No Game Requests!</p><?php
                                                                                }
                                                                                    ?>
                    <script type="text/javascript">
                        function open_in_new_tab_and_reload(url, req_id) {
                            alert(url);
                            //Open in new tab
                            window.open(url, '_blank');
                            //reload current page
                            window.location.href = "php/start_game.php?request_id=" + req_id;
                        }

                        function ignore_and_reload(req_id) {
                            //reload current page
                            window.location.href = "php/start_game.php?request_id=" + req_id;
                        }
                    </script>


                    <!--  ./Game -->
                </div>
            </div>
</main>
<!-- ./main -->

<?php include "templates/footer.php" ?>