<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// Retrieve the logged-in user details
$user_id = $_SESSION['auth_user']['user_id'];
$username = $_SESSION['auth_user']['name'];

// Retrieve package ID from the query string
if (isset($_GET['package_id']) && !empty($_GET['package_id'])) {
    $package_id = intval($_GET['package_id']);

    // Fetch package details from the database
    $sql = "SELECT * FROM packages WHERE id = $package_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $package = $result->fetch_assoc();
    } else {
        die("Invalid package selected.");
    }
} else {
    die("No package selected.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Package | Your Gym Name</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
        }
        .join-section {
    background-color: #000; /* Black background */
    padding: 60px 20px;
    color: #fff;
}
        header {
            background-color: #333;
            color: white;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
            color: black;
        }

        table th {
            background-color: #333;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #218838;
        }

        .text-center {
            text-align: center;
        }

        footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>
    <!-- Navbar Section -->
    <?php include('navbar.php'); ?>

    <!-- User and Package Details -->
    <section class="join-section">
    <div class="container">
        <h2>Package Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>User ID</td>
                    <td><?php echo htmlspecialchars($user_id); ?></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><?php echo htmlspecialchars($username); ?></td>
                </tr>
                <tr>
                    <td>Package ID</td>
                    <td><?php echo htmlspecialchars($package['id']); ?></td>
                </tr>
                <tr>
                    <td>Package Heading</td>
                    <td><?php echo htmlspecialchars($package['heading']); ?></td>
                </tr>
                <tr>
                    <td>Package Description</td>
                    <td><?php echo htmlspecialchars($package['discription']); ?></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>$<?php echo htmlspecialchars($package['price']); ?></td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <a href="confirm_package.php?package_id=<?php echo urlencode($package['id']); ?>" class="btn">Confirm Package</a>
        </div>
    </div>
</section>
    <!-- Footer Section -->
    <?php include('footer.php'); ?>
</body>

</html>
