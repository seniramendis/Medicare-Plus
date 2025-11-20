<?php
// --- CRITICAL FIX: ADD THIS AT THE VERY TOP ---
ob_start();      // 1. Buffers output so headers don't send too early
session_start(); // 2. Starts the session so we know who is logged in
// ----------------------------------------------

$pageTitle = 'Our Services';
$pageKey = 'services'; // This makes the Services tab green in the header
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'Services - Medicare Plus'; ?></title>
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

        /* --- 2. PAGE-SPECIFIC STYLES (Services) --- */
        .page-container {
            width: 85%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(12, 12, 12, 0.08);
        }

        .service-listing h2 {
            font-size: 2.2em;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #57c95a;
        }

        .service-listing>p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 30px;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .service-card {
            background-color: #fdfdfd;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9e9e9;
            text-align: center;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(30, 58, 138, 0.1);
        }

        .service-icon-container {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .service-icon-container i {
            font-size: 30px;
            color: #ffffff;
        }

        /* Icon Background Colors */
        .icon-cardiology .service-icon-container {
            background-color: #d9534f;
        }

        .icon-pediatrics .service-icon-container {
            background-color: #5bc0de;
        }

        .icon-orthopedics .service-icon-container {
            background-color: #f0ad4e;
        }

        .icon-dermatology .service-icon-container {
            background-color: #5cb85c;
        }

        .icon-general .service-icon-container {
            background-color: #4267B2;
        }

        .icon-diagnostic .service-icon-container {
            background-color: #7E57C2;
        }

        .icon-emergency .service-icon-container {
            background-color: #E63946;
        }

        .service-card h4 {
            font-size: 1.4em;
            color: #1e3a8a;
            margin: 0 0 10px 0;
        }

        .service-card p {
            font-size: 0.95em;
            color: #666;
            line-height: 1.5;
            flex-grow: 1;
        }

        .service-card .card-link {
            display: inline-block;
            margin-top: auto;
            padding-top: 15px;
            text-decoration: none;
            color: #2563eb;
            font-weight: bold;
        }

        .service-card .card-link:hover {
            color: #1e3a8a;
        }

        /* --- 3. PAGE-SPECIFIC RESPONSIVE STYLES --- */
        @media screen and (max-width: 600px) {
            .page-container {
                width: 95%;
                padding: 20px 15px;
            }

            .service-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php
    // Include header
    // Because we started the session at the very top (Line 4), the header will work perfectly!
    if (file_exists('header.php')) {
        include 'header.php';
    }
    ?>

    <main class="page-container">
        <div class="service-listing">
            <h2>Our Services</h2>
            <p>We provide world-class specialty care across a wide range of medical fields. Our expert teams use the latest technology to ensure the best possible outcomes for our patients.</p>

            <div class="service-grid">

                <div class="service-card icon-cardiology">
                    <div class="service-icon-container">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <h4>Cardiology</h4>
                    <p>Expert care for your heart, including disease management and post-heart attack care.</p>
                    <a href="Cardiology Specialists.php" class="card-link">Learn More →</a>
                </div>

                <div class="service-card icon-pediatrics">
                    <div class="service-icon-container">
                        <i class="fa-solid fa-child"></i>
                    </div>
                    <h4>Pediatrics</h4>
                    <p>Comprehensive health services for infants, children, and adolescents.</p>
                    <a href="pediatrics-doctors.php" class="card-link">Learn More →</a>
                </div>

                <div class="service-card icon-orthopedics">
                    <div class="service-icon-container">
                        <i class="fa-solid fa-bone"></i>
                    </div>
                    <h4>Orthopedics</h4>
                    <p>Treatment for bone, joint, and sports-related injuries.</p>
                    <a href="orthopedics-doctors.php" class="card-link">Learn More →</a>
                </div>

                <div class="service-card icon-dermatology">
                    <div class="service-icon-container">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h4>Dermatology</h4>
                    <p>Advanced care for all conditions of the skin, hair, and nails.</p>
                    <a href="dermatology-doctors.php" class="card-link">Learn More →</a>
                </div>

                <div class="service-card icon-general">
                    <div class="service-icon-container">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                    <h4>General Consultations</h4>
                    <p>Primary care for routine check-ups, preventative care, and managing common illnesses.</p>
                    <a href="general-consultations.php" class="card-link">Learn More →</a>
                </div>

                <div class="service-card icon-diagnostic">
                    <div class="service-icon-container">
                        <i class="fa-solid fa-microscope"></i>
                    </div>
                    <h4>Advanced Diagnostics</h4>
                    <p>State-of-the-art imaging (MRI, CT) and comprehensive lab services for accurate diagnosis.</p>
                    <a href="diagnostics.php" class="card-link">Learn More →</a>
                </div>

                <div class="service-card icon-emergency">
                    <div class="service-icon-container">
                        <i class="fa-solid fa-truck-medical"></i>
                    </div>
                    <h4>Emergency Care</h4>
                    <p>Our 24/7 Emergency Room is equipped to handle all medical emergencies, from minor to critical.</p>
                    <a href="Emergency Care.php" class="card-link">Learn More →</a>
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