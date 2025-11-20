<?php
// --- LINE 1: START SESSION SAFELY ---
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// ------------------------------------

$pageTitle = 'Our Locations';
$pageKey = 'location'; // This turns the "LOCATION" tab GREEN in the header
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'Our Locations - Medicare Plus'; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">

    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        /* --- 1. GLOBAL BODY STYLES --- */
        /* We keep these because your Header relies on them */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        /* --- 2. PAGE-SPECIFIC STYLES --- */
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

        .location-branch h3 {
            font-size: 1.6em;
            color: #1e3a8a;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .location-branch p {
            font-size: 1.1em;
            color: #555;
            margin-top: 0;
            margin-bottom: 25px;
        }

        .contact-layout {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
        }

        .contact-details-container {
            flex: 1;
            min-width: 300px;
        }

        .map-container {
            flex: 1;
            min-width: 300px;
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

        .contact-details-list span {
            display: block;
        }

        .contact-details-list small {
            font-size: 0.9em;
            color: #777;
        }

        .contact-details-list a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: bold;
        }

        .contact-details-list a:hover {
            text-decoration: underline;
        }

        .location-hours-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
            margin-top: 30px;
            margin-bottom: 15px;
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

        .button.direction-button {
            display: inline-block;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            padding: 8px 20px;
            border-radius: 30px;
            margin-top: 20px;
            background: linear-gradient(45deg, #1e3a8a, #2563eb) !important;
            color: white !important;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
            border: none;
            transition: all 0.3s ease;
        }

        .button.direction-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 18px rgba(30, 58, 138, 0.4);
            background: linear-gradient(45deg, #2563eb, #3b82f6) !important;
        }

        .button.direction-button i {
            margin-right: 8px;
        }

        /* Responsive */
        @media screen and (max-width: 600px) {
            .page-container {
                width: 95%;
                padding: 20px 15px;
            }

            .contact-layout {
                flex-direction: column;
            }
        }
    </style>

</head>

<body>

    <?php
    // Include Header Safely
    if (file_exists('header.php')) {
        include 'header.php';
    }
    ?>

    <main class="page-container">
        <div class="service-detail">
            <h2>Our Locations</h2>
            <p>Find our main hospital and clinics. We are conveniently located to serve you better. Below are our addresses, contact details, and operating hours.</p>


        </div>

        <div class="location-branch">
            <h3>Main Hospital: Mount Lavinia</h3>
            <p>Our primary, full-service hospital offering 24/7 emergency care, advanced diagnostics, and a comprehensive range of inpatient and outpatient services.</p>

            <div class="contact-layout">
                <div class="contact-details-container">
                    <ul class="contact-details-list">
                        <li>
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <span>
                                <strong>Address:</strong><br>
                                No. 84 St.Rita's Road,<br>
                                Mount Lavinia, Sri Lanka
                            </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <span>
                                <strong>Phone:</strong><br>
                                <a href="tel:+94112499590">+94 11 2 499 590</a>
                                <small>(24/7 General Line)</small>
                            </span>
                        </li>
                    </ul>

                    <h4 class="location-hours-title">Operating Hours</h4>
                    <ul class="contact-details-list">
                        <li>
                            <i class="fa-solid fa-clock"></i>
                            <span>
                                <strong>Hospital & Emergency:</strong><br>
                                Open 24 Hours, 7 Days a Week
                            </span>
                        </li>
                    </ul>

                    <a href="https://www.google.com/maps/search/?api=1&query=Mount+Lavinia" target="_blank" class="button direction-button">
                        <i class="fa-solid fa-directions"></i> Get Directions
                    </a>
                </div>

                <div class="map-container">
                    <div class="map-wrapper">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63381.92321947962!2d79.8211860263484!3d6.840353062361308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25a497f406159%3A0x10860b418c9c366f!2sMount%20Lavinia%2C%20Dehiwala-Mount%20Lavinia!5e0!3m2!1sen!2slk!4v1700000000000!5m2!1sen!2slk"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <hr style="margin-top: 40px; margin-bottom: 30px; border: 1px solid #f0f0f0;">

        <div class="location-branch">
            <h3>City Clinic: Colombo 07</h3>
            <p>Our outpatient clinic for specialist consultations and diagnostic services. Conveniently located in the heart of Colombo.</p>

            <div class="contact-layout">
                <div class="contact-details-container">
                    <ul class="contact-details-list">
                        <li>
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <span>
                                <strong> Address:</strong><br>
                                No. 123, Ward Place,<br>
                                Colombo 07, Sri Lanka
                            </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <span>
                                <strong>Phone:</strong><br>
                                <a href="tel:+94112555666">+94 11 2 555 666</a>
                                <small>(Appointments)</small>
                            </span>
                        </li>
                    </ul>

                    <h4 class="location-hours-title">Clinic Hours</h4>
                    <ul class="contact-details-list">
                        <li>
                            <i class="fa-solid fa-clock"></i>
                            <span>
                                <strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM
                            </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-clock"></i>
                            <span>
                                <strong>Saturday:</strong> 9:00 AM - 1:00 PM
                            </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-clock" style="color: #d9534f;"></i>
                            <span style="color: #d9534f;">
                                <strong>Sunday:</strong> Closed
                            </span>
                        </li>
                    </ul>

                    <a href="https://www.google.com/maps/search/?api=1&query=Colombo+07" target="_blank" class="button direction-button">
                        <i class="fa-solid fa-directions"></i> Get Directions
                    </a>
                </div>

                <div class="map-container">
                    <div class="map-wrapper">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.19351484781!2d79.862256!3d6.915576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25996564b8b8f%3A0x45972432222b4893!2sCinnamon%20Gardens%2C%20Colombo%2007!5e0!3m2!1sen!2slk!4v1700000000001!5m2!1sen!2slk"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    if (file_exists('footer.php')) {
        include 'footer.php';
    }
    ?>
</body>

</html>