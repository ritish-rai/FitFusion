<?php
session_start();
require 'config/dbcon.php'; // Ensure this includes your database connection script

// Ensure the user is logged in
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user details from the session
$username = $_SESSION['auth_user']['name'];
$user_id = $_SESSION['auth_user']['user_id']; // Assuming you store the user ID in the session

// Retrieve package details from the query parameters
if (isset($_GET['package_id']) && isset($_GET['package_heading']) && isset($_GET['package_description']) && isset($_GET['package_price'])) {
    $package_id = intval($_GET['package_id']);
    $package_heading = urldecode($_GET['package_heading']);
    $package_description = urldecode($_GET['package_description']);
    $package_price = floatval($_GET['package_price']);
} else {
    die("No package details provided.");
}

// Handle COD Payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_payment'])) {
    $payment_mode = "Cash on Delivery";
    $created_at = date('Y-m-d H:i:s');

    $stmt = $con->prepare("INSERT INTO user_packages (user_id, username, package_id, package_heading, package_description, package_price, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("SQL Error: " . $con->error);
    }

    $stmt->bind_param("isissds", $user_id, $username, $package_id, $package_heading, $package_description, $package_price, $created_at);

    if ($stmt->execute()) {
        $stmt->close();
        $con->close();
        $_SESSION['success_message'] = "Payment successful. Your order has been placed.";
        header("Location: index.php");
        exit();
    } else {
        die("Error placing order: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Your Gym Name</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .btn:hover {
            background-color: #218838;
        }

        .btn.back {
            background-color: #007bff;
        }

        .btn.back:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Checkout</h1>
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <table>
            <tr>
                <th>Field</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>Package ID</td>
                <td><?php echo htmlspecialchars($package_id); ?></td>
            </tr>
            <tr>
                <td>Package Heading</td>
                <td><?php echo htmlspecialchars($package_heading); ?></td>
            </tr>
            <tr>
                <td>Package Description</td>
                <td><?php echo htmlspecialchars($package_description); ?></td>
            </tr>
            <tr>
                <td>Price</td>
                <td>$<?php echo htmlspecialchars(number_format($package_price, 2)); ?></td>
            </tr>
        </table>

        <!-- COD Payment Form -->
        <form method="POST">
            <button type="submit" name="cod_payment" class="btn">Cash on Delivery</button>
        </form>

        <!-- PayPal Button -->
        <div id="paypal-button-container" class="mt-3"></div>
        <a href="index.php" class="btn back">Back to Home</a>
    </div>

    <script
        src="https://www.paypal.com/sdk/js?client-id=AZ6uiBqDj6Co4GF5eM3VoPbLNzHr3hkEdS4oxDwpKpEiEBHaPfLBrwh6GX9zArOYmpqs4RijPuKUQnJB&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
        data-sdk-integration-source="developer-studio"></script>
    <script>
        window.paypal
            .Buttons({
                // Create order
                createOrder: async (data, actions) => {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                currency_code: 'USD',
                                value: <?= $package_price; ?>,
                            },
                        }],
                    });
                },

                // Capture order
                onApprove: async (data, actions) => {
                    return actions.order.capture().then(function(orderData) {
                        console.log('Capture result:', orderData, JSON.stringify(orderData, null, 2));
                        const transaction = orderData.purchase_units[0].payments.captures[0];

                        // Prepare data for Fetch request
                        const formData = new URLSearchParams({
                            user_id: <?= json_encode($user_id); ?>,
                            username: <?= json_encode($username); ?>,
                            package_id: <?= json_encode($package_id); ?>,
                            package_heading: <?= json_encode($package_heading); ?>,
                            package_description: <?= json_encode($package_description); ?>,
                            package_price: <?= json_encode($package_price); ?>,
                            payment_mode: "Paid by PayPal",
                            payment_id: transaction.id,
                        }).toString();

                        // Send data using Fetch API
                        fetch("functions/placeorder.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded",
                                },
                                body: formData,
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.status === 201) {
                                    alert("Order Placed Successfully");
                                    window.location.href = '/index.php';
                                } else {
                                    alert("Failed to place order. Please try again.");
                                }
                            })
                            .catch((error) => {
                                alert("An error occurred while placing the order.");
                            });
                    }).catch(function(error) {
                        alert('Something went wrong during the capture process.');
                    });
                },
            })
            .render("#paypal-button-container");
    </script>
</body>

</html>
