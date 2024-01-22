<?php
// Start the session
session_start();

include("functions/db.php");



// Define variables and set to empty values
$email = $profileName = $password = $confirmPassword = "";
$emailErr = $profileNameErr = $passwordErr = $confirmPasswordErr = "";

// Function to sanitize input data
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate email format
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
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
        if (!validateEmail($email)) {
            $emailErr = "Invalid email format";
        } elseif (isEmailExists($conn, $email)) {
            $emailErr = "Email already exists";
        }
    }

    // Validate profile name
    if (empty($_POST["profile_name"])) {
        $profileNameErr = "Profile name is required";
    } else {
        $profileName = sanitizeInput($_POST["profile_name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $profileName)) {
            $profileNameErr = "Only letters and spaces are allowed";
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = sanitizeInput($_POST["password"]);
        // You can add additional password validation if needed
    }

    // Validate confirm password
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Please confirm password";
    } else {
        $confirmPassword = sanitizeInput($_POST["confirm_password"]);
        if ($confirmPassword !== $password) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    // If input is valid, add data to the friends table and set session variables
    if (empty($emailErr) && empty($profileNameErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        $dateStarted = date("Y-m-d");
        $numOfFriends = 0;

        $insertQuery = "INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friends)
        VALUES ('$email', '$password', '$profileName', '$dateStarted', '$numOfFriends')";

        if (mysqli_query($conn, $insertQuery)) {
            // Set session variables
            $_SESSION['loggedIn'] = true;
            $_SESSION['email'] = $email;

            // Redirect to friendadd.php (Task 5)
            header("Location: friendadd.php");
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
    <h1>Sign Up</h1>

    <!-- Sign up form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span class="error"><?php echo $emailErr; ?></span>
        </div>
        <div class="form-group">
            <label>Profile Name:</label>
            <input type="text" name="profile_name" value="<?php echo $profileName; ?>">
            <span class="error"><?php echo $profileNameErr; ?></span>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password">
            <span class="error"><?php echo $passwordErr; ?></span>
        </div>
        <div class="form-group">
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password">
            <span class="error"><?php echo $confirmPasswordErr; ?></span>
        </div>
        <input type="submit" name="submit" value="Register">
        <input type="reset" value="Clear">
    </form>

    <!-- Link to return to the Home page -->
    <p><a href="index.php">Back to Home</a></p>

</body>

</html>