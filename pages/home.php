<?php
// print_r($_SESSION);
// die();
$user = $obj->Select("user", "*", "uid", array($_SESSION['uid']));
$friends = $obj->Select("friend_list JOIN user ON user.uid=friend_list.fid", "*", "friend_list.uid", array($_SESSION['uid']));

?>
<div class="head-section container-fluid">
    <div class="row mt-3">
        <div class="col-sm-4 new-user">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-outline-warning">Add new user</button>
                </div>
            </div>

        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <img class="card-img-top user-image" src="./files/backgroung.jpg" alt="Card image cap">
                        </div>
                        <div class="col-sm-6">
                            <h5 class="card-title"><?= $user[0]['username'] ?></h5>
                            <p class="card-text">Online</p>
                        </div>
                        <div class="col-sm-3">
                            <a href="logout.php" class="btn btn-primary">Log out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <h5 class="card-header">FriendList</h5>
                <div class="friend-list">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($friends as $friend) : ?>
                            <li class="list-group-item card friendSelect" data-friend="<?= $friend['fid'] ?>">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img class="card-img-top user-image" src="./files/backgroung.jpg" alt="Card image cap">
                                    </div>
                                    <div class="col-sm-6">
                                        <h5 class="card-title"><?= $friend['username'] ?></h5>
                                        <p class="card-text"><?= $friend['log_in'] == 0 ? "Offline" : "Online"; ?></p>
                                    </div>

                                </div>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>

        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-12 message-show hideAtFirst">

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<form action="" method="post" id="message-form">
    <div class="card  message-input hideAtFirst">
        <div class="row card-body">

            <div class="col-sm-10">
                <input type="text" class="form-control" name="message" id="message-input" data-user="<?= $_SESSION['users_data']['email'] ?>">
            </div>
            <div class="col-sm-2">
                <button class="btn btn-danger" class="submit" id="send-btn" name="submit">Send</button>
            </div>

        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        let st = {
            message: "",
            receiver_id: null
        };
        //hide at first
        $('.hideAtFirst').css("display", "none");
        //message in state variable
        $('#message-input').keyup(function(e) {
            // console.log(e.target.value);
            st.message = e.target.value;
            // console.log(st);
        });
        $.each($('.friendSelect'), function(index, value) {
            // console.log($(value).attr("data-friend"));
            $(value).click(function(e) {
                $('.hideAtFirst').css("display", "block");
                st.receiver_id = $(value).attr("data-friend");
                loadMessage();
                loadInterval();

            });
        });
        //message submit
        $('#message-form').submit(function(e) {
            e.preventDefault();
            if (st.message == "") {
                return false;
            } else {
                $.ajax({
                    url: `${js_urls}pages/ajax.php?key=messageApp&todo=insertMessage`,
                    type: 'POST',
                    data: {
                        sender_email: `${$('#message-input').attr("data-user")}`,
                        msg_content: st.message,
                        receiver_id: st.receiver_id
                    },
                    success: function(s) {
                        console.log(s);
                        st.message = "";
                        $('#message-input').val("");
                        loadMessage();
                    }

                });
            }
            // console.log(js_urls);

        });

        //message check and load
        function loadMessage() {
            $.ajax({
                url: `${js_urls}pages/ajax.php?key=messageApp&todo=loadMessage`,
                type: 'POST',
                data: {
                    sender_email: `${$('#message-input').attr("data-user")}`,
                    receiver_id: st.receiver_id
                },
                success: function(s) {
                    console.log("ok");
                    console.log(s);
                    $.each(s, function(index, value) {
                        if (value.sender_email == `${$('#message-input').attr("data-user")}`) {
                            // const showMessage = $('.message-show');
                            // messageDiv = document.createElement("div");
                            // messageDiv
                            const messageDiv = document.createElement('div');
                            messageDiv.classList.add("alert", "alert-danger", "sentMessage");
                            messageDiv.innerText = value.msg_content;
                            document.querySelector('.message-show').appendChild(messageDiv);
                            // $(document.createElement('div'), {
                            //     text: value.msg_content,
                            //     'class': 'alert alert-danger'
                            // }).appendTo('.message-show');
                        } else {
                            // $(document.createElement('div'), {
                            //     text: value.msg_content,
                            //     'class': 'alert alert-primary'
                            // }).appendTo('.message-show');
                            const messageDiv = document.createElement('div');
                            messageDiv.classList.add("alert", "alert-primary", "gotMessage");
                            messageDiv.innerText = value.msg_content;
                            document.querySelector('.message-show').appendChild(messageDiv);
                        }
                        document.querySelector('.message-show').scrollTop = document.querySelector('.message-show').scrollHeight;

                    });
                }
            });
        }
        //load messages every 2 seconds
        function loadInterval() {
            setInterval(loadMessage, 2000);
        }
        // if (st.receiver_id != null) {
        // setInterval(loadMessage, 2000);
        // }


    });
</script>