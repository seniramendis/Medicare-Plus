<?php
ob_start(); // Buffering to prevent "headers already sent" errors
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Only start session if one isn't active
}

$pageTitle = 'Advanced Diagnostic Services';
$parentPageKey = 'services';
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
        /* GLOBAL BODY STYLES */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        /* PAGE-SPECIFIC STYLES */
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

        .button:hover {
            background-color: #45a049;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

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
    // Ensure header.php exists in the same folder, or the script will warn you.
    if (file_exists('header.php')) {
        include 'header.php';
    } else {
        echo "<p style='color:red; text-align:center;'>Error: header.php not found.</p>";
    }
    ?>

    <main class="page-container">
        <section class="service-detail">
            <h2>Advanced Diagnostic Services</h2>
            <p>Our facility is equipped with state-of-the-art diagnostic technology to provide accurate and timely results, helping your doctor create the best treatment plan for you.</p>

            <h3>Radiology & Imaging:</h3>
            <ul>
                <li>X-Ray</li>
                <li>CT Scans</li>
                <li>MRI Scans</li>
                <li>Ultrasound</li>
            </ul>

            <h3>Laboratory Services:</h3>
            <ul>
                <li>Comprehensive Blood Tests</li>
                <li>Urine Analysis</li>
                <li>Biopsies and Pathology</li>
            </ul>

            <p>Registered patients can securely access their lab results and reports through the patient portal.</p>
            <a href="login.php" class="button">Access Patient Portal</a>
        </section>
    </main>

    <?php

    include 'footer.php';

    ?>
</body>

</html>