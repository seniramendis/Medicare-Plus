<?php
$pageTitle = 'Contact Us';
$pageKey = 'contact'; // Not 'home'
// The 'header.php' include is now called inside the <body>
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'Medicare Plus'; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">



    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        /* --- 2. PAGE-SPECIFIC STYLES (Contact) --- */
        /* All global styles (Section 1 & 3) have been moved to styles.css */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        .page-container {
            width: 85%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(12, 12, 12, 0.08);
        }

        .service-detail h2 {
            font-size: 2.2em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #57c95a;
        }

        .service-detail p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 25px;
        }

        .contact-layout {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
        }

        .contact-form-container {
            flex: 2;
            min-width: 300px;
        }

        .contact-details-container {
            flex: 1;
            min-width: 300px;
        }

        .contact-form-container h3,
        .contact-details-container h3 {
            font-size: 1.6em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        #contactForm label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
            margin-top: 15px;
        }

        #contactForm input[type="text"],
        #contactForm input[type="email"],
        #contactForm textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            font-family: Arial, Helvetica, sans-serif;
            transition: all 0.3s ease;
        }

        #contactForm input[type="text"]:focus,
        #contactForm input[type="email"]:focus,
        #contactForm textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
        }

        #contactForm textarea {
            resize: vertical;
        }

        .button {
            display: inline-block;
            background-color: #57c95a;
            color: #fff;
            padding: 8px 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            border-radius: 30px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        #contactForm .button {
            background-color: #1e3a8a;
            font-size: 1.1em;
            padding: 12px 30px;
            border: none;
            cursor: pointer;
            color: white;
            text-transform: uppercase;
        }

        #contactForm .button:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }

        .contact-details-list {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }

        .contact-details-list li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            font-size: 1.1em;
            color: #444;
        }

        .contact-details-list i {
            font-size: 1.6em;
            color: #57c95a;
            margin-right: 20px;
            width: 30px;
            text-align: center;
        }

        .contact-details-list a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: bold;
        }

        .contact-details-list a:hover {
            text-decoration: underline;
        }

        .map-wrapper {
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .map-wrapper iframe {
            width: 100%;
            height: 300px;
            display: block;
            border: none;
        }

        .custom-alert-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            padding-top: 60px;
        }

        .custom-alert-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 25px 30px;
            border: 1px solid #888;
            width: 80%;
            max-width: 450px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation-name: animatezoom;
            animation-duration: 0.6s;
        }

        .custom-alert-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            margin-top: -15px;
        }

        .custom-alert-close:hover,
        .custom-alert-close:focus {
            color: #f44336;
            text-decoration: none;
            cursor: pointer;
        }

        .custom-alert-content .fa-circle-check {
            font-size: 1.5em;
            /* Significantly reduced size */
            color: #57c95a;
            margin-bottom: 10px;
            line-height: 1;
        }

        .custom-alert-content h2 {
            margin-top: 0;
            color: #333;
        }

        @keyframes animatezoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }
    </style>
</head>

<body>

    <?php
    include 'header.php';
    ?>

    <main class="page-container">
        <div class="service-detail">
            <h2>Contact Us</h2>
            <p>We're here to help. Whether you have a question about our services, need to book an appointment, or
                require assistance, please don't hesitate to get in touch.</p>
        </div>

        <div class="contact-layout">

            <div class="contact-form-container">
                <h3>Send Us a Message</h3>
                <form id="contactForm">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>

                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" required></textarea>

                    <button type="submit" class="button">Send Message</button>
                </form>
            </div>

            <div class="contact-details-container">
                <h3>Our Location & Details</h3>

                <ul class="contact-details-list">
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <div>
                            <strong>Address:</strong><br>
                            No. 84 St.Rita's Road,<br>
                            Mount Lavinia, Sri Lanka
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <div>
                            <strong>Phone:</strong><br>
                            <a href="tel:+94112499590">+94 11 2 499 590</a>
                        </div>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <div>
                            <strong>Email:</strong><br>
                            <a href="mailto:support@medicareplus.com">support@medicareplus.com</a>
                        </div>
                    </li>
                </ul>

                <div class="map-wrapper">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.503460818231!2d79.86475731523474!3d6.830200921406517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25a66b7264429%3A0x6854b0c79f36f616!2sSt.Rita's%20Rd%2C%20Mount%20Lavinia!5e0!3m2!1sen!2slk!4v1678886521345!5m2!1sen!2slk"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>
        </div>
    </main>

    <div id="feedbackModal" class="custom-alert-modal">
        <div class="custom-alert-content">
            <span class="custom-alert-close">×</span>
            <h2><i class="fa-solid fa-circle-check"></i> Thank You!</h2>
            <p>Your message has been sent successfully. We'll get back to you soon.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var contactForm = document.getElementById("contactForm");
            var feedbackModal = document.getElementById("feedbackModal");
            var closeBtn = feedbackModal ? feedbackModal.querySelector(".custom-alert-close") : null;

            if (contactForm && feedbackModal) {
                contactForm.addEventListener("submit", function(event) {
                    event.preventDefault();
                    feedbackModal.style.display = "block";
                    contactForm.reset();
                });
            }

            if (closeBtn) {
                closeBtn.onclick = function() {
                    feedbackModal.style.display = "none";
                }
            }

            window.addEventListener("click", function(event) {
                if (event.target == feedbackModal) {
                    feedbackModal.style.display = "none";
                }
            });
        });
    </script>

    <?php
    include 'footer.php';
    ?>
</body>

</html>