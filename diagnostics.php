<?php
$pageTitle = 'Advanced Diagnostics';
$parentPageKey = 'services'; // Keeps "Services" nav item active
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
        /* --- 1. GLOBAL BODY STYLES (Keep this here) --- */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
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

        /* Doctor List (used for equipment list) */
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
            width: 100%;
            height: 180px;
            /* Adjusted height for equipment */
            border-radius: 8px;
            /* Less rounded for equipment */
            object-fit: cover;
            border: 1px solid #eee;
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

        /* --- 3. PAGE-SPECIFIC RESPONSIVE STYLES --- */
        @media screen and (max-width: 600px) {

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
    // HEADER GOES HERE, INSIDE THE BODY
    include 'header.php';
    ?>

    <main class="page-container">
        <section class="service-detail">
            <h2>Advanced Diagnostic Services</h2>

            <p><strong>Precision and Technology in Medical Testing</strong></p>
            <p>The accuracy of your diagnosis is the foundation of effective treatment. Our Advanced Diagnostics Center uses state-of-the-art technology to provide precise and timely results for your healthcare team.</p>

            <h3>Services Include:</h3>
            <ul>
                <li>Imaging: MRI, CT Scans, Digital X-Ray, 4D Ultrasound, Doppler Scans, Mammography</li>
                <li>Laboratory: Clinical Pathology (Blood, Urine, Stool), Histopathology, Microbiology</li>
                <li>Cardiac Diagnostics: ECG, Echocardiogram, Stress Tests</li>
            </ul>
            <h3>Our Diagnostic Capabilities</h3>
        </section>

        <div class="doctor-list">
            <div class="doctor-card">
                <img src="images/MRI Scanner.webp" alt="MRI Scanner">
                <div class="doctor-info">
                    <h4>MRI (Magnetic Resonance Imaging)</h4>

                    <p class="doctor-title">High-Field 1.5T MRI</p>
                    <p>Our MRI provides highly detailed images of soft tissues, joints, and the nervous system.</p>
                    <a href="#" class="button">Schedule Scan</a>
                </div>
            </div>

            <div class="doctor-card">
                <img src="images/CT Scanner.jpeg" alt="CT Scanner">
                <div class="doctor-info">
                    <h4>CT (Computed Tomography)</h4>

                    <p class="doctor-title">128-Slice CT Scanner</p>
                    <p>Delivers fast, high-resolution cross-sectional images, crucial for emergency and complex cases.</p>
                    <a href="#" class="button">Schedule Scan</a>
                </div>
            </div>

            <div class="doctor-card">
                <img src="images/LabService.jpg" alt="Ultrasound Machine">
                <div class="doctor-info">
                    <h4>Ultrasound Imaging</h4>

                    <p class="doctor-title">4D & Doppler Ultrasound</p>
                    <p>Safe, real-time imaging for obstetrics, vascular studies (Doppler), and abdominal diagnostics.</p>
                    <a href="#" class="button">Schedule Scan</a>
                </div>
            </div>
        </div>
    </main>



    <?php
    include 'footer.php';
    ?>
</body>

</html>