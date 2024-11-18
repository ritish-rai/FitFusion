<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="navbar">
        <div class="logo"> <img src="images/finallogo.png" alt="logo" height="65px" width="65px"> </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="membership.php">Gym Membership</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>

            </ul>
        </nav>
        <div class="contact-info">
            <a href="tel:+1234567890">Join: (123) 456 7890</a>
        </div>
        <?php
        if (isset($_SESSION['auth_user'])) {
            echo "<div class='item' style= 'color:white;'>" . $_SESSION['auth_user']['name'] . "</div>";

            echo "<div class='cta-button'><a href='logout.php'>Logout</a></div>";
        } else {
            echo "<div class='cta-button'><a href='login.php'>Log-in</a></div>";
            // echo "<pre>";
            // print_r($_SESSION['auth_user']);
            // echo "</pre>";
        }
        ?>
    </div>
</header>