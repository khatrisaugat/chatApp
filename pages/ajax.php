<?php
require_once("../config/config.php");
require_once("../config/db.php");
if (isset($_GET['key']) || $_GET['key'] == "messageApp") {
    //todo something is set
    if (isset($_GET['todo'])) {
        //insert a message in db
        if ($_GET['todo'] == "insertMessage") {
            $Data['sender_email'] = $_POST['sender_email'];
            $Data['msg_content'] = $_POST['msg_content'];
            $receiver = $obj->Select("user", "*", "uid", array($_POST['receiver_id']));
            $Data['receiver_email'] = $receiver[0]['email'];
            $msg_id = $obj->Insert("users_chat", $Data);
            header("Content-type: application/json");
            echo json_encode($Data, true);
        }
        //load Messages
        if ($_GET['todo'] == "loadMessage") {
            $receiver = $obj->Select("user", "*", "uid", array($_POST['receiver_id']));
            // $myMessages = $obj->Select("users_chat", "*", "sender_email", array($_POST['sender_email'], " AND receiver_email='" . $receiver[0]['email'] . "' OR sender_email='" . $receiver[0]['email'] . "' AND receiver_email='" . $_POST['sender_email'] . "' ORDER BY msg_id ASC"));
            $myMessages = $obj->Query("SELECT * FROM `users_chat` WHERE sender_email='" . $_POST['sender_email'] . "' AND receiver_email='" . $receiver[0]['email'] . "' OR sender_email='" . $receiver[0]['email'] . "' AND receiver_email='" . $_POST['sender_email'] . "' ORDER BY msg_id ASC");
            header("Content-type: application/json");
            echo json_encode($myMessages, true);
        }
    }
}
