<?php
$pageTitle = 'Orthopedics Specialists';
$parentPageKey = 'services'; // Keeps "Services" nav item active
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
        /* --- 1. GLOBAL STYLES (Header, Nav, Footer, Responsive) --- */
        /* RECOMMENDATION: This global CSS is likely in your 'styles.css'.
           You should remove Section 1 and Section 3 from this file
           and keep only Section 2 (Page-Specific Styles). */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        header {
            background: linear-gradient(90deg, #1e3a8a, #2563eb, #1e3a8a);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            color: white;
        }

        .logo {
            width: 120px;
            height: 95px;
            margin-left: 290px;
            margin-top: 14px;
        }

        .brand-container {
            text-align: center;
        }

        .brandName {
            margin: 0;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            margin-left: -150px;
        }

        header p {
            margin: 0;
            font-size: 16px;
            text-align: center;
            opacity: 0.9;
            margin-left: -150px;
        }

        .search-bar-box {
            display: inline-flex;
            align-items: center;
            position: relative;
            margin-right: 2rem;
        }

        .search-bar-box i {
            position: absolute;
            left: 12px;
            color: #555;
        }

        .search-control {
            height: 38px;
            width: 250px;
            padding: 3px 15px 3px 40px;
            border-radius: 1.9rem;
            border: none;
            margin-left: 0;
        }

        .pagination {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            background-color: #f8f9fa;
            padding: 10px 40px;
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .pagination-center {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .pagination a {
            color: #333;
            padding: 8px 14px;
            text-decoration: none;
            font-size: 15px;
            border-radius: 20px;
            transition: all 0.3s ease;
            font-weight: 500;
            margin: 0 4px;
        }

        .pagination a.active {
            background-color: #57c95a;
            color: white;
            font-weight: bold;
        }

        .pagination a:hover:not(.active):not(.login-button) {
            background-color: #e9e9e9;
        }

        .pagination a.login-button {
            margin-left: auto;
            background-color: #1e3a8a;
            color: white;
            font-weight: bold;
        }

        .pagination a.login-button:hover {
            background-color: #2563eb;
        }

        .site-footer {
            background-color: #181818;
            color: #ccc;
            padding: 60px 40px 20px 40px;
            line-height: 1.7;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-column {
            flex: 1;
            min-width: 230px;
        }

        .footer-logo {
            width: 130px;
            height: auto;
            margin-bottom: 15px;
            filter: brightness(0) invert(1) contrast(0.8);
        }

        .footer-column h3 {
            color: #ffffff;
            font-size: 16px;
            text-transform: uppercase;
            margin-bottom: 25px;
        }

        .site-footer p {
            color: #ccc;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #57c95a;
        }

        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
            color: #ccc;
        }

        .footer-contact li {
            margin-bottom: 12px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .footer-contact i {
            color: #57c95a;
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .footer-contact a {
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .footer-contact a:hover {
            color: #57c95a;
        }

        .footer-bottom {
            border-top: 1px solid #444;
            padding-top: 25px;
            text-align: center;
        }

        .footer-socials {
            margin-bottom: 15px;
        }

        .footer-socials a {
            color: #ccc;
            margin: 0 12px;
            font-size: 16px;
            text-decoration: none;
        }

        .footer-socials a:hover {
            color: #57c95a;
        }

        /* --- 2. PAGE-SPECIFIC STYLES (Service Detail + Doctor List) --- */
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

        /* Doctor List */
        .doctor-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .doctor-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            padding: 25px;
            background-color: #fdfdfd;
            border: 1px solid #e9e9e9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(30, 58, 138, 0.1);
        }

        .doctor-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #1e3a8a;
        }

        .doctor-info {
            text-align: center;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            width: 100%;
        }

        .doctor-card h4 {
            font-size: 1.6em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .doctor-title {
            font-size: 1.1em;
            font-weight: bold;
            color: #555;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .doctor-info p {
            font-size: 0.95em;
            color: #666;
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 15px;
            margin-top: 0;
        }

        .doctor-info a.button {
            margin-top: auto;
        }

        /* --- 3. RESPONSIVE STYLES --- */
        @media screen and (max-width: 600px) {
            header {
                flex-direction: column;
                padding: 10px;
            }

            .brand-container {
                order: -1;
            }

            .logo {
                margin-left: 0;
            }

            .brandName,
            header p {
                margin-left: 0;
            }

            .pagination {
                flex-direction: column;
                padding: 5px;
            }

            .pagination-center {
                flex-direction: column;
                width: 100%;
            }

            .pagination a {
                margin: 5px 0;
                text-align: center;
            }

            .pagination a.login-button {
                margin-left: 0;
                width: 100%;
            }

            .footer-container {
                flex-direction: column;
                align-items: center;
            }

            .footer-column {
                width: 90%;
                max-width: 350px;
                text-align: center;
            }

            .site-footer p,
            .footer-links li {
                text-align: center;
            }

            .footer-contact li,
            .footer-contact a {
                justify-content: center;
            }

            .footer-logo {
                margin-left: auto;
                margin-right: auto;
            }

            /* Page Specific Responsive */
            .page-container {
                width: 95%;
                padding: 20px 15px;
            }

            .doctor-list {
                grid-template-columns: 1fr;
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
            <h2>Orthopedics Department</h2>

            <h3>Restoring Your Mobility, Reclaiming Your Life</h3>

            <p>Our Orthopedics department is committed to helping you move freely and live without pain. We treat all conditions of the musculoskeletal system, from bones and joints to ligaments and tendons, using both surgical and non-surgical methods.</p>

            <h3>Services Include:</h3>
            <ul>
                <li>Total Joint Replacement (Hip, Knee, Shoulder)</li>
                <li>Sports Medicine & Arthroscopic Surgery</li>
                <li>Spine Surgery & Care</li>
                <li>Pediatric Orthopedics</li>
                <li>Trauma & Fracture Care</li>
            </ul>
            <h3>Our Specialists</h3>
        </div>

        <div class="doctor-list">
            <div class="doctor-card">
                <img src="images/Ashan Abeyewardene.jpeg" alt="Dr. Ashan Abeyewardene">
                <div class="doctor-info">
                    <h4>Dr. Ashan Abeyewardene</h4>
                    <p class="doctor-title">Head of Joint Replacement</p>
                    <p>Dr. Ashan is a leading surgeon in minimally invasive hip and knee replacement surgery...</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card">
                <img src="images/Narendra Pinto.jpg" alt="Dr. Narendra Pinto">
                <div class="doctor-info">
                    <h4>Dr. Narendra Pinto</h4>
                    <p class="doctor-title">Sports Medicine Specialist</p>
                    <p>Dr. Narendra Pinto focuses on sports-related injuries, specializing in arthroscopic repair...</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card">
                <img src="images/Velayutham Swarnakumaar.jpeg" alt="Dr. V. Swarnakumaar">
                <div class="doctor-info">
                    <h4>Dr. V. Swarnakumaar</h4>
                    <p class="doctor-title">Pediatric Orthopedic Surgeon</p>
                    <p>Dr. V. Swarnakumaar is dedicated to treating musculoskeletal problems in children...</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>
        </div>
    </main>

    <script>
        // This page does not require page-specific JavaScript.
    </script>

    <?php
    include 'footer.php';
    ?>
</body>

</html>