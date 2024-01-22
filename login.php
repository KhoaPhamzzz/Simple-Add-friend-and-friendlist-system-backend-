<?php
// Start the session
session_start();

include("functions/db.php");

if (isset($_SESSION['loggedIn']) == true) {
    // Redirect to login.php if not logged in
    header("Location:  friendlist.php");
    exit();
}

// Define variables and set to empty values
$email = $password = "";
$emailErr = $passwordErr = "";

// Function to sanitize input data
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to check if email exists in the friends table
function isEmailExists($conn, $email)
{
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM friends WHERE friend_email = '$email'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// Server-side form validation
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = sanitizeInput($_POST["email"]);
        if (!isEmailExists($conn, $email)) {
            $emailErr = "Email does not exist";
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = sanitizeInput($_POST["password"]);
    }

    // If input is valid, set session variables and redirect to friendlist.php (Task 4)
    if (empty($emailErr) && empty($passwordErr)) {
        $email = mysqli_real_escape_string($conn, $email);
        $query = "SELECT * FROM friends WHERE friend_email = '$email'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        if ($password === $storedPassword) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['friend_id'] = $row['friend_id'];
            $_SESSION['profile_name'] = $row['profile_name'];
            // Redirect to friendlist.php (Task 4)
            header("Location: friendlist.php");
            exit();
        } else {
            $passwordErr = "Invalid password";
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
    <h1>Login</h1>

    <!-- Login form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span class="error"><?php echo $emailErr; ?></span>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password">
            <span class="error"><?php echo $passwordErr; ?></span>
        </div>
        <input type="submit" name="submit" value="Login">
    </form>