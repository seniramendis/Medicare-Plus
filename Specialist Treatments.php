<?php
// --- LINE 1: START SESSION SAFELY ---
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// ------------------------------------

$pageTitle = 'Specialist Treatments';
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

        /* --- RESPONSIVE STYLES --- */
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
    // Include Header Safely
    if (file_exists('header.php')) {
        include 'header.php';
    }
    ?>

    <main class="page-container">
        <section class="service-listing">
            <h2>Specialist Treatments</h2>
            <p>We offer a wide range of specialist services provided by board-certified experts in their fields. Explore our specialties below to find the care you need.</p>

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
                        <i class="fa-solid fa-child-reaching"></i>
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
                        <i class="fa-solid fa-spa"></i>
                    </div>
                    <h4>Dermatology</h4>
                    <p>Advanced care for all conditions of the skin, hair, and nails.</p>
                    <a href="dermatology-doctors.php" class="card-link">Learn More →</a>
                </div>

            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="find_a_doctor.php" class="button">Find a Specialist</a>
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