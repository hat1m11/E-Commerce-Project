<?php
include "config.php";

// PAGE TITLE
$title = "Contact Us - 6ixe7ven";

// PAGE-SPECIFIC CSS  (fixed)
$extra_css = "<link rel='stylesheet' href='$BASE_URL/static/css/contact.css'>";

// Start capturing the content block
ob_start();
?>

<main class="contact-wrapper">

    <h2 class="contact-title">Contact Us</h2>
    <p class="contact-subtitle">We’d love to hear from you. Fill out the form below or reach us through our details.</p>

    <div class="contact-container">

        <!-- LEFT : Contact Information -->
        <div class="contact-info">
            <h3>Get in Touch</h3>
            <p>Email: <strong>support@6ixe7ven.com</strong></p>
            <p>Phone: <strong>+44 7123 456789</strong></p>
            <p>Address: <strong>Birmingham, United Kingdom</strong></p>

            <h3 style="margin-top: 25px;">Business Hours</h3>
            <p>Monday – Friday: 9:00 AM – 6:00 PM</p>
            <p>Saturday: 10:00 AM – 4:00 PM</p>
            <p>Sunday: Closed</p>
        </div>

        <!-- RIGHT : Contact Form -->
        <div class="contact-form">
            <h3>Send us a Message</h3>

            <form id="contactForm" action="https://formspree.io/f/xanvqbgp" method="POST">

                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="_replyto" placeholder="Enter your email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

                <button type="submit" class="contact-btn">Send Message</button>
            </form>
        </div>

    </div>

</main>

<?php
// END capturing
$content = ob_get_clean();

// LOAD base layout
include "base.php";
?>
