<?php
session_start();
$user_id = $_SESSION['friend_id'];
include("db.php");
$friend_id = $_GET['user'];

$sql = "DELETE FROM `myfriends` WHERE  `friend_id1`='$user_id' AND `friend_id2`='$friend_id'";
$sql_run = mysqli_query($conn, $sql);

$friendq = " SELECT `friend_id1` FROM `myfriends`  WHERE `friend_id1` = '$user_id'";
$friendq_run = mysqli_query($conn, $friendq);
$friendcount = mysqli_num_rows($friendq_run);
// if ($sql_run) {
$updatefriends = "UPDATE `friends` SET  `num_of_friends`='$friendcount' WHERE `friend_id`='$user_id' ";
$updatefriends_run = mysqli_query($conn, $updatefriends);
if ($updatefriends_run) {
    header('location: ../friendlist.php');
} else {
    echo "Something went wrong";
}
// }