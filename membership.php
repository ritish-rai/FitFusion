<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Packages | Your Gym Name</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="membership.css">
</head>
<body>

    <!-- Navbar Section -->
    <?php include('navbar.php'); ?>

    <!-- Membership Page Content -->
    <section class="membership-section">
        <div class="membership-header">
            <h2>Our Membership Packages</h2>
            <p>Choose the best plan that fits your goals, whether you're looking to join group classes, get personal training, or build strength.</p>
        </div>

        <div class="membership-cards-container">
            <?php
            // Database connection
            $conn = new mysqli("localhost", "root", "", "fitness");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch packages from the database
            $sql = "SELECT * FROM packages";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Display each package dynamically
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='membership-card'>";
                    echo "<img src='images/" . htmlspecialchars($row['img']) . "' alt='" . htmlspecialchars($row['heading']) . "' class='card-image'>";
                    echo "<div class='card-header'>";
                    echo "<h3>" . htmlspecialchars($row['heading']) . "</h3>";
                    echo "<p class='price'>$" . htmlspecialchars($row['price']) . "/month</p>";
                    echo "</div>";
                    echo "<ul class='card-details'>";

                    // Add tick marks for each feature
                    $features = explode(',', $row['discription']); // Split features by commas
                    foreach ($features as $feature) {
                        echo "<li>✔ " . htmlspecialchars(trim($feature)) . "</li>";
                    }

                    echo "</ul>";

                    // Determine button text based on session
                    $buttonText = isset($_SESSION['auth_user']) ? "Join Now" : "Sign Up";

                    // Add the Join Now/Sign Up button with a link to join.php
                    echo "<a href='join.php?package_id=" . urlencode($row['id']) . "' class='card-button'>$buttonText</a>";
                    
                    echo "</div>";
                }
            } else {
                echo "<p>No packages available at the moment.</p>";
            }

            $conn->close();
            ?>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include('footer.php'); ?>

<script src="script.js"></script>
</body>
</html>
