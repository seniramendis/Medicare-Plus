<?php
// --- LINE 1: START SESSION HERE (THE BOSS) ---
ob_start();      // Buffer output to prevent header errors
session_start(); // Start the session immediately
// ---------------------------------------------

$pageTitle = 'General Consultations';
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

        /* Doctor Card Styles */
        .doctor-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .doctor-card {
            flex: 1;
            min-width: 240px;
            background-color: #fdfdfd;
            border: 1px solid #eef;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            text-align: center;
            padding: 25px 20px 20px 20px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .doctor-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            margin-left: auto;
            margin-right: auto;
        }

        .doctor-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .doctor-info h4 {
            font-size: 1.3em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .doctor-info .doctor-title {
            font-size: 0.9em;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .doctor-info p {
            font-size: 0.95em;
            color: #555;
            line-height: 1.5;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .doctor-info .button {
            margin-top: auto;
        }

        .FindDoctorbutton {
            display: inline-block;
            background-color: #1e3a8a;
            color: #fff;
            padding: 10px 25px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            border-radius: 30px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .FindDoctorbutton:hover {
            background-color: #16306b;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media screen and (max-width: 600px) {
            .page-container {
                width: 95%;
                padding: 20px 15px;
            }

            .doctor-list {
                flex-direction: column;
            }

            .doctor-card {
                min-width: 100%;
            }

            .doctor-info p {
                min-height: auto;
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
            <h2>General Medical Consultations</h2>

            <p><strong>Your First Step to Better Health and Wellness</strong></p>
            <p>Our General Consultations service (Outpatient Department, or OPD) is your central point of access to our hospital's trusted medical care. This is the ideal starting point for any non-emergency health concern, from common colds and fevers to managing long-term health. Our experienced General Practitioners (GPs) and Family Medicine specialists are dedicated to providing holistic, patient-centered care.</p>



            <p>We focus on preventive health, including routine check-ups, immunizations, and lifestyle counseling. Our team is also skilled in managing chronic conditions such as diabetes, hypertension, and asthma, coordinating your care to ensure the best possible outcomes. If specialized treatment is needed, your GP will seamlessly connect you with the right specialist within our network, acting as your dedicated health advocate every step of the way.</p>

            <h3>Services Include:</h3>
            <ul>
                <li>General Practitioner (GP) Consultations</li>
                <li>Treatment for Acute Illnesses (Flu, Infections, etc.)</li>
                <li>Chronic Disease Management (Diabetes, Hypertension)</li>
                <li>Annual Health Check-ups & Preventive Screenings</li>
                <li>Vaccinations and Immunizations</li>
                <li>Referrals to Specialist Consultants</li>
                <li>Medical Certificates and Health Reports</li>
            </ul>

            <h3>Our Specialists</h3>

            <div class="doctor-list">

                <div class="doctor-card">
                    <img src="images/Elena Fernando.jpeg" alt="Dr. Elena Fernando" onerror="this.src='images/placeholder_doctor.png'">
                    <div class="doctor-info">
                        <h4>Dr. Elena Fernando</h4>
                        <p class="doctor-title">Senior General Practitioner</p>
                        <p>With over 25 years in family medicine, Dr. Fernando has a special interest in managing chronic conditions like diabetes and hypertension. She is known for her thorough and caring approach.</p>
                        <a href="#" class="button">Book Appointment</a>
                    </div>
                </div>

                <div class="doctor-card">
                    <img src="images/Kevin Perera.jpg" alt="Dr. Kevin Perera" onerror="this.src='images/placeholder_doctor.png'">
                    <div class="doctor-info">
                        <h4>Dr. Kevin Perera</h4>
                        <p class="doctor-title">General Practitioner</p>
                        <p>Dr. Perera focuses on preventative health and wellness. He is passionate about helping patients achieve their health goals through lifestyle modifications and routine check-ups.</p>
                        <a href="#" class="button">Book Appointment</a>
                    </div>
                </div>

                <div class="doctor-card">
                    <img src="images/Maria Silva.jpeg" alt="Dr. Maria Silva" onerror="this.src='images/placeholder_doctor.png'">
                    <div class="doctor-info">
                        <h4>Dr. Maria Silva</h4>
                        <p class="doctor-title">General Practitioner & Family Medicine</p>
                        <p>Dr. Silva provides care for the entire family, from infants to seniors. She has a special focus on pediatric primary care and women's health.</p>
                        <a href="#" class="button">Book Appointment</a>
                    </div>
                </div>

            </div>

            <a href="find_a_doctor.php" class="FindDoctorbutton"><i class="fa-solid fa-user-doctor"></i> Find Doctors</a>
        </section>
    </main>

    <?php
    if (file_exists('footer.php')) {
        include 'footer.php';
    }
    ?>
</body>

</html>