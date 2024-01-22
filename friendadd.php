<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Redirect to login.php if not logged in
    header("Location: login.php");
    exit();
}
// Connect to the database
include("functions/db.php");

// Get the logged-in user's email from the session
$email = $_SESSION['email'];
$user_id = $_SESSION['friend_id'];


// Fetch the profile name of the logged-in user
$profileNameQuery = "SELECT profile_name FROM friends WHERE friend_email = '$email'";
$profileNameResult = mysqli_query($conn, $profileNameQuery);
$row = mysqli_fetch_assoc($profileNameResult);
$profileName = $row['profile_name'];
// Fetch all registered users except the friends of the logged-in user
$registeredUsersQuery = "SELECT * FROM friends  WHERE friend_email != '$email' ";
$registeredUsersResult = mysqli_query($conn, $registeredUsersQuery);

$friendq = " SELECT * FROM `myfriends`  WHERE `friend_id1` = '$user_id'";
$friendq_run = mysqli_query($conn, $friendq);
$friendcount = mysqli_num_rows($friendq_run);
$totaluser = "SELECT * FROM `friends` ";
$totaluser_q = mysqli_query($conn, $totaluser);
$totaluser_c = mysqli_num_rows($totaluser_q);
$products = array();
$RecordsPerPage = 5;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1; // Default to the first page
}
$offset = ceil($currentPage - 1) * $RecordsPerPage;
$total = "SELECT `friend_id` FROM `friends` LIMIT $offset ,$RecordsPerPage";
$total_q_r = mysqli_query($conn, $total);

while ($row = $total_q_r->fetch_assoc()) {
    $products[] = $row["friend_id"];
}
$totalPages = ceil($totaluser_c / $RecordsPerPage);

// print_r($products);
echo "<br/>";
$products2 = array();
$total_friends = "SELECT `friend_id2` FROM `myfriends` WHERE `friend_id1`='$user_id'";
$total_friends_q_r = mysqli_query($conn, $total_friends);

while ($row2 = $total_friends_q_r->fetch_assoc()) {
    $products2[] = $row2["friend_id2"];
}

?>



<!DOCTYPE html>
<html>

<head>
    <title>Add Friend List</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">

</head>

<body>
    <h1>Add Friend List</h1>
    <p>Logged in as: <?php echo $profileName; ?></p>
    <p>Total Friends: <?= $friendcount ?> </p>

    <!-- Display registered users to add as friends -->
    <h2>Registered Users : <?= $totaluser_c ?></h2>


    <?php
    $diff = array_diff($products, $products2);
    foreach ($diff as $item) {
        $unfriend_q = "SELECT * FROM `friends`   WHERE friend_id='$item' AND friend_id!='$user_id'";
        $unfriend_q_run = mysqli_query($conn, $unfriend_q);
        $total_unfriend_count = mysqli_num_rows($unfriend_q_run);


        $qu = "SELECT * FROM `friends` WHERE friend_id='$item' AND friend_id!='$user_id' ";
        $qu_r = mysqli_query($conn, $qu);
        $records = range(1, $total_unfriend_count);

        if (mysqli_num_rows($qu_r) > 0) {

            foreach ($qu_r as $userdata) {
    ?>
                <table class="table">


                    <tbody>
                        <tr>
                            <td class="nm">
                                <?= $userdata['profile_name'] ?>
                            </td>
                            <td class="nm"><?= $userdata['num_of_friends'] . " mutual friends" ?></td>
                            <td style="text-align: center;"><a class="add_friend_btn" href="functions/addfriend.php?user=<?= $userdata['friend_id'] ?>">Add as Friend</a></td>
                        </tr>
            <?php
            }
        }
    }
            ?>
                    </tbody>
                    <?php


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

                <!-- Links to Friend List (Task 5) and Log out (Task 6) -->
                <div class="links-container">
                    <a href="friendlist.php?page=1">Friend List</a>
                    <a href="logout.php">Log out</a>
                </div>

</body>

</html>