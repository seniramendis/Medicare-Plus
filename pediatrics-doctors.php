<?php
// --- LINE 1: START SESSION SAFELY ---
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// ------------------------------------

$pageTitle = 'Pediatrics Specialists';
$pageKey = 'services'; // Keeps "Services" nav item active
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
        /* --- GLOBAL RESET --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
        }

        /* --- PAGE-SPECIFIC STYLES --- */
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

        /* Responsive */
        @media screen and (max-width: 600px) {
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
    // Include Header Safely
    if (file_exists('header.php')) {
        include 'header.php';
    }
    ?>

    <main class="page-container">
        <div class="service-detail">
            <h2>Pediatrics Department</h2>

            <h3>Compassionate, Comprehensive Care for Every Stage of Childhood</h3>
            <p>Our Pediatrics department provides a warm, child-friendly environment dedicated to the unique health needs of your family, from infancy through adolescence.</p>


            <h3>Services Include:</h3>
            <ul>
                <li>Newborn & Infant Care</li>
                <li>Well-Child Visits & Annual Check-ups</li>
                <li>Childhood Vaccinations</li>
                <li>Developmental Screening</li>
                <li>Adolescent Medicine</li>
                <li>Specialist Consultations</li>
            </ul>
            <h3>Our Specialists</h3>
        </div>

        <div class="doctor-list">
            <div class="doctor-card">
                <img src="images/dr-shaman.png" alt="Prof. Shaman Rajindrajith" onerror="this.src='images/placeholder_doctor.png'">
                <div class="doctor-info">
                    <h4>Prof. Shaman Rajindrajith</h4>
                    <p class="doctor-title">Consultant Pediatrician</p>
                    <p>Prof. Shaman Rajindrajith is a trusted expert in general pediatrics and child development.</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card">
                <img src="images/Prof-Pujitha-Wickramasinghe.jpg" alt="Prof. Pujitha Wickramasinghe" onerror="this.src='images/placeholder_doctor.png'">
                <div class="doctor-info">
                    <h4>Prof. Pujitha Wickramasinghe</h4>
                    <p class="doctor-title">Pediatric Neurologist</p>
                    <p>Prof. Pujitha specializes in neurological disorders in children.</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card">
                <img src="images/Dr. Duminda Samarasinghe.jpeg" alt="Dr. Duminda Samarasinghe" onerror="this.src='images/placeholder_doctor.png'">
                <div class="doctor-info">
                    <h4>Dr. Duminda Samarasinghe</h4>
                    <p class="doctor-title">Head of Neonatology</p>
                    <p>Dr. Duminda leads our Neonatal Intensive Care Unit (NICU) with expertise in newborn care.</p>
                    <a href="#" class="button">Book Appointment</a>
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