<?php
//include config to connect to the sqlite server
require_once('db/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){
    header('Location: login.php');
    exit;
}

//define page title
$title = 'bunq chat';
require('layout/header.php');
?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <?php
                        $SQLres=$db->fetch_user_list();
                        if(!empty($SQLres)) {
                            while ($row = $SQLres->fetchArray(SQLITE3_ASSOC)){
                                extract($row);
                                if($id != $_SESSION['id']) {
                                    echo "<button class='list-group-item clickable' value='{$id}'>{$name}</button>";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-9 current-chat">
                <div class="row current-chat-area">
                    <ul class="message_list">
                    </ul>
                </div>
                <div class="row">
                    <form id="message_sending" method="post" data-toggle="validator">
                        <div class="input-group">
                            <input type="text" class="form-control" name="message" id="message" placeholder="Type you message here..." required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="js/messages_flow.js"></script>
<?php
//include simple html header
require('layout/footer.php');
?>

