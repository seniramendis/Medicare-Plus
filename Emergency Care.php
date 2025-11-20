<?php
// --- LINE 1: START SESSION SAFELY (THE BOSS) ---
ob_start();      // Buffer output to prevent header errors
session_start(); // Start the session immediately
// ---------------------------------------------

$pageTitle = 'Emergency Care';
$pageKey = 'services'; // FIX: Renamed to '$pageKey' so the Services tab turns GREEN
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
        /* --- 1. GLOBAL BODY STYLES --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        /* --- 2. PAGE-SPECIFIC STYLES (Emergency) --- */
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

        .service-detail h3 {
            font-size: 1.6em;
            color: #333;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .service-detail ul {
            list-style-type: none;
            padding-left: 0;
        }

        .service-detail li {
            font-size: 1.1em;
            color: #444;
            margin-bottom: 12px;
            position: relative;
            padding-left: 30px;
        }

        .service-detail li::before {
            content: '✔';
            position: absolute;
            left: 0;
            top: 0;
            color: #57c95a;
            font-weight: bold;
            font-size: 1.2em;
        }

        /* Emergency Specific Styles */
        .emergency-alert {
            background-color: #E63946;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .emergency-alert a {
            color: white;
            text-decoration: underline;
            font-weight: bold;
        }

        /* Button Groups */
        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .button {
            display: inline-block;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            padding: 8px 20px;
            border-radius: 30px;
            margin-top: 20px;
            border: none;
            transition: all 0.3s ease;
        }

        .direction-button {
            background: linear-gradient(45deg, #1e3a8a, #2563eb) !important;
            color: white !important;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }

        .direction-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 18px rgba(30, 58, 138, 0.4);
            background: linear-gradient(45deg, #2563eb, #3b82f6) !important;
        }

        .call-button {
            background: #E63946 !important;
            color: white !important;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(230, 57, 70, 0.3);
        }

        .call-button:hover {
            transform: translateY(-3px);
            background: #d62828 !important;
            box-shadow: 0 7px 18px rgba(230, 57, 70, 0.4);
        }

        .button i {
            margin-right: 8px;
        }

        a.emergency_no {
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s ease;
            display: inline-block;
        }

        a.emergency_no:hover {
            transform: scale(1.1);
        }

        /* Responsive */
        @media screen and (max-width: 600px) {
            .page-container {
                width: 95%;
                padding: 20px 15px;
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
        <section class="service-detail">

            <div class="emergency-alert">
                <strong>In case of a life-threatening emergency, call <a href="tel:71999" class="emergency_no">71999</a> immediately.</strong>
            </div>

            <h2>24/7 Emergency Care</h2>

            <p><strong>24/7 Expert Medical Care When You Need It Most</strong></p>
            <p>Our Emergency Treatment Unit (ETU) is fully staffed and equipped 24 hours a day, 365 days a year, to provide immediate, expert care for all medical and surgical emergencies.</p>



            [Image of emergency room triage process]


            <h3>Services Include:</h3>
            <ul>
                <li>24/7/365 Emergency Physician Coverage</li>
                <li>On-call Specialists for all major fields</li>
                <li>Rapid Response for Heart Attacks & Strokes</li>
                <li>Advanced Trauma & Cardiac Life Support</li>
                <li>Dedicated 24/7 Emergency Pharmacy</li>
                <li>Immediate access to Diagnostic Imaging and Laboratory</li>
            </ul>
            <p><strong>Location:</strong> No. 84 St.Rita's Road, Mount Lavinia, Sri Lanka</p>

            <div class="button-group">
                <a href="https://www.google.com/maps?q=Mount+Lavinia,+Sri+Lanka" target="_blank" class="button direction-button">
                    <i class="fa-solid fa-diamond-turn-right"></i> Get Directions
                </a>

                <a href="tel:+94112499590" class="button call-button">
                    <i class="fa-solid fa-phone"></i> Call Hospital
                </a>
            </div>
        </section>
    </main>

    <?php
    if (file_exists('footer.php')) {
        include 'footer.php';
    }
    ?>
</body>

</html>