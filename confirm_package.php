<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "fitness");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user details from the session
$user_id = $_SESSION['auth_user']['user_id'];
$username = $conn->real_escape_string($_SESSION['auth_user']['name']);

// Check if package_id is passed in the query string
if (isset($_GET['package_id']) && !empty($_GET['package_id'])) {
    $package_id = intval($_GET['package_id']);

    // Fetch package details from the database
    $sql = "SELECT * FROM packages WHERE id = $package_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $package = $result->fetch_assoc();
        $package_heading = urlencode($package['heading']);
        $package_description = urlencode($package['discription']);
        $package_price = $package['price'];

        // Redirect to checkout.php with package details
        header("Location: checkout.php?package_id=$package_id&package_heading=$package_heading&package_description=$package_description&package_price=$package_price");
        exit();
    } else {
        die("Invalid package selected.");
    }
} else {
    die("No package selected.");
}

// Close the connection
// $conn->close();
?>
