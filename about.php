<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Your Gym Name</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="about.css">
</head>
<body>

    <!-- Navbar Section -->
    <?php include('navbar.php'); ?>
    <!-- About Section -->
    <section class="about-section">
        <div class="about-container">
            <div class="about-content">
                <div class="about-text">
                    <h2>About Your Gym Name</h2>
                    <p>Welcome to <strong>Your Gym Name</strong>, where fitness meets fun and community! Our goal is to help you get fit, stay healthy, and achieve your fitness goals in a supportive and motivating environment.</p>
                </div>
                <div class="about-image">
                    <img src="images/about.jpg" alt="About Your Gym">
                </div>
            </div>

            <div class="about-content reverse">
                <div class="about-text">
                    <h3>Our Mission</h3>
                    <p>At Your Gym Name, we believe that fitness should be accessible, fun, and effective. Our mission is to provide world-class CrossFit classes, strength training, and personal coaching to help you become the best version of yourself. Whether you're a beginner or an experienced athlete, we have something for everyone!</p>
                </div>
                <div class="about-image">
                    <img src="images/mission.jpg" alt="Our Mission">
                </div>
            </div>

            <div class="about-content">
                <div class="about-text">
                    <h3>Our Values</h3>
                    <ul>
                        <li><strong>Community:</strong> We build strong relationships and create a welcoming environment for all fitness levels.</li>
                        <li><strong>Motivation:</strong> Our trainers push you to reach your goals, but we also celebrate every step you take towards progress.</li>
                        <li><strong>Accountability:</strong> We’re here to support you every day and keep you accountable on your fitness journey.</li>
                        <li><strong>Fun:</strong> We make sure you enjoy every workout session while getting fitter, stronger, and healthier.</li>
                    </ul>
                </div>
                <div class="about-image">
                    <img src="images/value.jpg" alt="Our Values">
                </div>
            </div>

            <h3>Meet Our Team</h3>
            <div class="team-container">
                <div class="team-member">
                    <img src="images/review.jpg" alt="Trainer 1">
                    <h4>John Doe</h4>
                    <p>Lead Trainer & CrossFit Coach</p>
                    <p>John has been in the fitness industry for over 10 years, helping athletes achieve their peak performance.</p>
                </div>
                <div class="team-member">
                    <img src="images/review.jpg" alt="Trainer 2">
                    <h4>Jane Smith</h4>
                    <p>Strength & Conditioning Coach</p>
                    <p>Jane specializes in strength training and injury prevention, ensuring that you become stronger and more resilient.</p>
                </div>
                <div class="team-member">
                    <img src="images/review.jpg" alt="Trainer 3">
                    <h4>Mike Johnson</h4>
                    <p>Personal Trainer</p>
                    <p>Mike helps clients achieve their personal fitness goals through customized training plans and nutrition coaching.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include('footer.php'); ?>
</body>
</html>
