<?php
// Initialize error variables
$firstname_error = $lastname_error = $username_error = $password_error = '';

if (isset($_POST['signup'])) {
    $errors = false;

    // Validate fields
    if (empty($_POST['firstname']) || !preg_match('/^[A-Za-z]+$/', $_POST['firstname'])) {
        $firstname_error = "First name should contain only letters.";
        $errors = true;
    } else {
        $firstName = $_POST['firstname'];
    }

    if (empty($_POST['lastname']) || !preg_match('/^[A-Za-z]+$/', $_POST['lastname'])) {
        $lastname_error = "Last name should contain only letters.";
        $errors = true;
    } else {
        $lastName = $_POST['lastname'];
    }

    if (empty($_POST['username']) || strlen($_POST['username']) < 4) {
        $username_error = "Username should be at least 4 characters.";
        $errors = true;
    } else {
        $username = $_POST['username'];
    }

    if (empty($_POST['password']) || strlen($_POST['password']) < 6) {
        $password_error = "Password should be at least 6 characters.";
        $errors = true;
    } else {
        $password = $_POST['password'];
    }

    // Proceed if no errors
    if (!$errors) {
        $flag = ($username === 'admin' && $password === 'admin') ? 1 : 0;

        // Database connection
        $con = new mysqli("localhost", "root", "", "fitness");

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        // Check if username already exists
        $checkQuery = "SELECT * FROM login WHERE username='$username'";
        $checkResult = $con->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            $username_error = "Username already exists. Please choose a different username.";
        } else {
            // Insert user into the database
            $insertQuery = "INSERT INTO login (firstname, lastname, username, password, flag) VALUES ('$firstName', '$lastName', '$username', '$password', '$flag')";
            if ($con->query($insertQuery) === TRUE) {
                echo "<script>alert('Registration successful! Redirecting to login page...');</script>";
                echo "<script>window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Error: " . $con->error . "');</script>";
            }
        }

        $con->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Your Gym Name</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="signup.css">
    <style>
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <!-- Navbar Section -->
    <?php include('navbar.php'); ?>

    <!-- Signup Page Content -->
    <section class="signup-section">
        <div class="signup-container">
            <div class="signup-header">
                <h2>Sign Up for Your Gym Membership</h2>
                <p>Join us today and start your fitness journey! Fill out the form below to create your account and choose the best membership plan for you.</p>
            </div>

            <!-- Signup Form -->
            <form class="signup-form" action="" method="POST">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" 
                           value="<?= isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '' ?>">
                    <?php if (!empty($firstname_error)) { ?>
                        <div class="error"><?= $firstname_error; ?></div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" 
                           value="<?= isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '' ?>">
                    <?php if (!empty($lastname_error)) { ?>
                        <div class="error"><?= $lastname_error; ?></div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" 
                           value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                    <?php if (!empty($username_error)) { ?>
                        <div class="error"><?= $username_error; ?></div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                    <?php if (!empty($password_error)) { ?>
                        <div class="error"><?= $password_error; ?></div>
                    <?php } ?>
                </div>

                <button type="submit" class="signup-button" name="signup">Sign Up</button>
            </form>

            <div class="signin-link">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include('footer.php'); ?>
</body>

</html>
