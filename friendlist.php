<?php
// Start the session
session_start();
// Connect to the database
include("functions/db.php");
$sql2 = "CREATE TABLE IF NOT EXISTS myfriends ( 
             id INT(11) NOT NULL AUTO_INCREMENT,
            friend_id1 INT(11) NOT NULL ,
            friend_id2 INT(11) NOT NULL , 
            PRIMARY KEY (id)
        )";
if (mysqli_query($conn, $sql2)) {
    $tables_created = true;
} else {
    $tables_created = false;
}
// Check if user is logged in
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Redirect to login.php if not logged in
    header("Location: login.php");
    exit();
}




// Get the logged-in user's email from the session
$email = $_SESSION['email'];
$user_id = $_SESSION['friend_id'];

// Fetch the profile name of the logged-in user
$profileNameQuery = "SELECT profile_name FROM friends WHERE friend_email = '$email'";
$profileNameResult = mysqli_query($conn, $profileNameQuery);
$row = mysqli_fetch_assoc($profileNameResult);
$profileName = $row['profile_name'];

// // Fetch the friends of the logged-in user
$friendq = " SELECT * FROM `myfriends`  WHERE `friend_id1` = '$user_id'";
$friendq_run = mysqli_query($conn, $friendq);
$friendcount = mysqli_num_rows($friendq_run);
$RecordsPerPage = 5;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1; // Default to the first page
}
$offset = ceil($currentPage - 1) * $RecordsPerPage;


$friendprofileq = "SELECT f.friend_id2 as fid,f.friend_id1 as loggedinuserid, u.friend_id as userid, u.friend_email,u.profile_name,u.num_of_friends FROM friends u , myfriends f WHERE u.friend_id=f.friend_id2 AND f.friend_id1='$user_id' LIMIT $offset,$RecordsPerPage";

$friendprofleq_run = mysqli_query($conn, $friendprofileq);


$records = range(1, $friendcount);

?>



<!DOCTYPE html>
<html>

<head>
    <title>My Friend System</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <style>
    h1 {
        margin: 1px !important;
    }
    </style>
</head>

<body>
    <h1>My Friend List</h1>
    <h1> <?php echo $profileName . "'s"; ?> Friend List Page</h1>
    <h1>Total Friends: <?php echo $friendcount ?></h1>


    <?php
    if (mysqli_num_rows($friendprofleq_run) > 0) {
        foreach ($friendprofleq_run as $profile) {
    ?>
    <table class="table">

        <tbody>
            <tr>
                <td><?= $profile['profile_name'] ?></td>
                <td><?= $profile['num_of_friends'] . " mutual friends" ?></td>
                <td style="text-align: center;"><a class="add_friend_btn"
                        href="functions/removefriend.php?user=<?= $profile['fid'] ?>">Unfriend</a></td>
            </tr>

        </tbody>
        <?php
        }
        $totalPages = ceil($friendcount / $RecordsPerPage);
    } else {
        echo "<h1 style='padding: 10px;'>No friends Yet</h1>";
    }
        ?>
    </table>

    <div class="btnss">
        <?php
                if ($currentPage > 1) {
                ?>
        <a href="?page=<?= ($currentPage - 1) ?>">Previous</a>
        <?php
                } else {
                ?>
        <a>Previous</a>
        <?php
                }
                ?>
        <?php
                if ($currentPage < $totalPages) {
                ?>
        <a href="?page=<?= ($currentPage + 1) ?>">Next</a>
        <?php
                } else {
                ?>
        <a>Next</a>
        <?php
                }
                ?>


    </div>
    <!-- Links to Add Friends (Task 5) and Log out (Task 6) -->
    <div class="links-container">
        <a href="friendadd.php">Add Friends</a>
        <a href="logout.php">Log out</a>
    </div>

</body>

</html>