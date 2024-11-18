<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Your Gym Name</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="contact.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .form-field {
            margin-bottom: 20px;
        }

        .form-field input,
        .form-field textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-field input.error,
        .form-field textarea.error {
            border-color: red;
        }
    </style>
</head>

<body>

    <!-- Navbar Section -->
    <?php include('navbar.php'); ?>

    <!-- Contact Us Section -->
    <section class="contact-section">
        <div class="contact-container">
            <!-- Contact Info Section -->
            <div class="contact-content">
                <div class="contact-text">
                    <h2>Contact Us</h2>
                    <p>We'd love to hear from you! Whether you have a question about our services, want to book a class, or just want to say hello, feel free to reach out to us using the form below.</p>
                    <ul>
                        <li><strong>Phone:</strong> (123) 456-7890</li>
                        <li><strong>Email:</strong> contact@yourgym.com</li>
                        <li><strong>Address:</strong> 123 Fitness St, Fit City, USA</li>
                    </ul>
                </div>
                <div class="contact-image">
                    <img src="images/conctact.jpg" alt="Contact Us">
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="contact-form">
                <h3>Send Us a Message</h3>
                <form action="" method="POST" id="contactForm">
                    <div class="form-field">
                        <label for="name">First Name</label>
                        <input type="text" id="name" name="name">
                        <div class="error-message" id="nameError"></div>
                    </div>
                    <div class="form-field">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname">
                        <div class="error-message" id="lastnameError"></div>
                    </div>
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                        <div class="error-message" id="emailError"></div>
                    </div>
                    <div class="form-field">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" id="mobile" name="mobile">
                        <div class="error-message" id="mobileError"></div>
                    </div>
                    <div class="form-field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="4"></textarea>
                        <div class="error-message" id="messageError"></div>
                    </div>
                    <button type="submit" name="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include('footer.php'); ?>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function (e) {
            let hasError = false;

            // Clear previous error messages
            document.querySelectorAll('.error-message').forEach(msg => msg.textContent = '');
            document.querySelectorAll('.form-field input, .form-field textarea').forEach(field => field.classList.remove('error'));

            // Validate fields
            const name = document.getElementById('name');
            const lastname = document.getElementById('lastname');
            const email = document.getElementById('email');
            const mobile = document.getElementById('mobile');
            const message = document.getElementById('message');

            if (name.value.trim() === '') {
                document.getElementById('nameError').textContent = "First Name cannot be empty.";
                name.classList.add('error');
                hasError = true;
            }
            if (lastname.value.trim() === '') {
                document.getElementById('lastnameError').textContent = "Last Name cannot be empty.";
                lastname.classList.add('error');
                hasError = true;
            }
            if (email.value.trim() === '') {
                document.getElementById('emailError').textContent = "Email cannot be empty.";
                email.classList.add('error');
                hasError = true;
            } else if (!/^\S+@\S+\.\S+$/.test(email.value)) {
                document.getElementById('emailError').textContent = "Invalid email format.";
                email.classList.add('error');
                hasError = true;
            }
            if (mobile.value.trim() === '') {
                document.getElementById('mobileError').textContent = "Mobile Number cannot be empty.";
                mobile.classList.add('error');
                hasError = true;
            }
            if (message.value.trim() === '') {
                document.getElementById('messageError').textContent = "Message cannot be empty.";
                message.classList.add('error');
                hasError = true;
            }

            // Prevent form submission if there are errors
            if (hasError) {
                e.preventDefault();
            }
        });
    </script>

    <?php
    if (isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile']);
        $message = trim($_POST['message']);

        $con = new mysqli("localhost", "root", "", "fitness");
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $stmt = $con->prepare("INSERT INTO contact (fname, lname, email, phone, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $lastname, $email, $mobile, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Thank you for your feedback!');</script>";
        } else {
            echo "<script>alert('Error: Unable to submit your message. Please try again later.');</script>";
        }

        $stmt->close();
        $con->close();
    }
    ?>
</body>

</html>
