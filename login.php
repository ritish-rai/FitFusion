<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Your Gym Name</title>
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

    <!-- Login Page Content -->
    <section class="signup-section">
        <div class="signup-container">
            <div class="signup-header">
                <h2>Login to Your Account</h2>
                <p>Welcome back! Please log in with your username and password to access your account.</p>
            </div>

            <!-- Login Form -->
            <form class="signup-form" method="POST">
                <!-- General login error message -->
                <?php if (!empty($login_error)) { ?>
                    <div class="error" style="text-align:center;"><?= $login_error; ?></div>
                <?php } ?>

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

                <button type="submit" class="signup-button" name="b1">Login</button>
            </form>

            <div class="signin-link">
                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include('footer.php'); ?>

</body>

</html>

<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['auth'])) {
    header('Location: index.php');
    exit();
}

// Initialize error variables
$username_error = '';
$password_error = '';
$login_error = '';

if (isset($_POST['b1'])) {
    $errors = false;

    // Validate username
    if (empty($_POST['username'])) {
        $username_error = "Username is required.";
        $errors = true;
    } else {
        $a = $_POST['username'];
    }

    // Validate password
    if (empty($_POST['password'])) {
        $password_error = "Password is required.";
        $errors = true;
    } else {
        $b = $_POST['password'];
    }

    // Proceed only if there are no validation errors
    if (!$errors) {
        $con = new mysqli("localhost", "root", "", "fitness");

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $a = $con->real_escape_string($a);
        $b = $con->real_escape_string($b);

        $q = "SELECT * FROM login WHERE username='$a' AND password='$b'";
        $query_run = $con->query($q);

        if ($query_run && $query_run->num_rows > 0) {
            $_SESSION['auth'] = true;
            $userdata = $query_run->fetch_assoc();
            $user_id = $userdata['id'];
            $uname = $userdata['firstname'];
            $role = $userdata['flag'];
            

            $_SESSION['auth_user'] = [
                'user_id' => $user_id,
                'name' => $uname,
            ];
            $_SESSION['role'] = $role;

            if ($role == 1) {
                header('Location: admin/index.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            $login_error = "Invalid Username or Password";
        }

        $con->close();
    }
}
?>
