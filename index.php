<?php

include("functions/db.php");
// Create friends table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS friends (
            friend_id INT(11) NOT NULL AUTO_INCREMENT,
            friend_email VARCHAR(50) NOT NULL,
            password VARCHAR(20) NOT NULL,
            profile_name VARCHAR(30) NOT NULL,
            date_started DATE NOT NULL,
            num_of_friends INT(11) UNSIGNED,
            PRIMARY KEY (friend_id)
        )";

if (mysqli_query($conn, $sql)) {
    $tables_created = true;
} else {
    $tables_created = false;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Friends System</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
    <h1>My Friends System<br>Assignment Home Page</h1>
    <p>Name: Khoa Anh Pham</p>
    <p>Student ID: 102586997</p>
    <p>Email: <a href="mailto:102586997@student.swin.edu.au">102586997@student.swin.edu.au</a></p>
    <p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from
        any other student’s work or from any other source.</p>

    <br>
    <!-- Display message for table creation -->
    <?php
    if ($tables_created) {
        echo "<p>Tables successfully created and populated.</p>";
    } else {
        echo "<p>Error creating tables.</p>";
    }
    ?>

    <!-- Links container -->
    <div class="links-container">
        <!-- Link to sign up page -->
        <a href="signup.php">Sign Up</a>

        <!-- Link to log in page -->
        <a href="login.php">Log In</a>

        <!-- Link to about page -->
        <a href="about.php">About</a>
    </div>

</body>

</html>