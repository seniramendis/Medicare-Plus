<?php
session_start(); // CRITICAL: Must be the very first line
$pageTitle = 'Home';
$pageKey = 'home';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'Medicare Plus - Your Lifetime Partner in Health'; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">

    <link rel="stylesheet" href="HomeStyles.css?v=1.1">

    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>

    <style>
        /* =========================================
           1. TOP SLIDESHOW ARROWS (Main Banner)
           ========================================= */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 24px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            background-color: rgba(0, 0, 0, 0.3);
            /* Dark see-through background */
            text-decoration: none;
            z-index: 10;
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* =========================================
           2. SERVICES & DOCTORS CAROUSEL ARROWS
           (Circular buttons with shadows)
           ========================================= */

        /* Ensure the container acts as a reference point for the buttons */
        .service-carousel-container {
            position: relative;
        }

        .service-prev,
        .service-next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            /* Centers perfectly vertically */
            width: 45px;
            height: 45px;
            color: #333;
            /* Dark arrow color */
            background-color: white;
            /* White Circle */
            font-weight: bold;
            font-size: 20px;
            border-radius: 50%;
            /* Makes it a circle */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            /* Adds a nice shadow */
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            text-decoration: none;
            z-index: 100;
            transition: all 0.3s ease;
        }

        /* Position Left Button */
        .service-prev {
            left: -20px;
            /* Sits slightly outside the content to the left */
        }

        /* Position Right Button */
        .service-next {
            right: -20px;
            /* Sits slightly outside the content to the right */
        }

        /* Hover effect for Services/Doctors buttons */
        .service-prev:hover,
        .service-next:hover {
            background-color: #57c95a;
            /* Green on hover */
            color: white;
        }

        /* Mobile adjustment: Bring arrows inside if screen is small */
        @media only screen and (max-width: 768px) {
            .service-prev {
                left: 0;
            }

            .service-next {
                right: 0;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="slideshow-container">

        <div class="mySlides fade">
            <img src="images/Slideshow1.png" alt="Your partner for a lifetime of health" style="width:100%">
            <div class="text">YOUR PARTNER FOR A LIFETIME OF HEALTH</div>
        </div>

        <div class="mySlides fade">
            <img src="images/Slideshow2.png" alt="Visit us on our website" style="width:100%">
            <div class="text">VISIT US ON WWW.MEDICAREPLUS.LK</div>
        </div>

        <div class="mySlides fade">
            <img src="images/Slideshow3.png" alt="Follow us on social media" style="width:100%">
            <div class="text">FOLLOW US ON SOCIAL MEDIA</div>
        </div>

        <div class="mySlides fade">
            <img src="images/Slideshow4.png" alt="Medicare Plus, your partner for health" style="width:100%">
            <div class="text">YOUR PARTNER FOR A LIFETIME OF HEALTH</div>
        </div>

        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
    </div>

    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
    </div>
    <br><br>

    <div class="quote">
        <h1>"The good physician treats the disease;
            the great physician treats the patient who has the disease." </h1>
        <p>- William Osler</p>
    </div><br>

    <main class="page-container-home" id="Services">
        <h1>OUR SERVICES</h1>
        <p>We provide world-class specialty care across a wide range of medical fields. Our expert teams use the
            latest technology to ensure the best possible outcomes for our patients.</p><br>

        <div class="service-carousel-container">

            <div class="service-slide">
                <div class="service-grid-home">
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
                </div>
            </div>

            <div class="service-slide">
                <div class="service-grid-home">
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
                </div>
            </div>

            <div class="service-slide">
                <div class="service-grid-home service-grid-single">
                    <div class="service-card icon-emergency">
                        <div class="service-icon-container">
                            <i class="fa-solid fa-truck-medical"></i>
                        </div>
                        <h4>Emergency Care</h4>
                        <p>Our 24/7 Emergency Room is equipped to handle all medical emergencies, from minor to
                            critical.</p>
                        <a href="Emergency Care.php" class="card-link">Learn More →</a>
                    </div>
                </div>
            </div>

            <a class="service-prev" onclick="plusServiceSlides(-1)">❮</a>
            <a class="service-next" onclick="plusServiceSlides(1)">❯</a>
        </div>

        <div class="service-dots-container">
            <span class="service-dot" onclick="currentServiceSlide(1)"></span>
            <span class="service-dot" onclick="currentServiceSlide(2)"></span>
            <span class="service-dot" onclick="currentServiceSlide(3)"></span>
        </div>

        <div class="view-all-services-container">
            <a href="services.php" class="button">View All Services</a>
        </div>
    </main>

    <section class="page-container-home doctor-preview-section">
        <h1><i class="fa-solid fa-user-doctor"></i> Featured Specialists</h1>
        <p>We make it easy to find the right expert. Swipe through our featured specialists below or use our full directory to search all doctors by name and specialty.</p>

        <div class="service-carousel-container doctor-carousel-container">

            <div class="service-slide doctor-slide" data-slide-index="1">
                <div class="doctor-slide-inner-grid">
                    <div class="doctor-card" data-name="Dr. Gotabhaya Ranasinghe" data-specialty="Cardiology">
                        <img src="images/Dr. Gotabhaya Ranasinghe.webp" alt="Dr. Gotabhaya Ranasinghe">
                        <div class="doctor-info">
                            <h4>Dr. Gotabhaya Ranasinghe</h4>
                            <p class="doctor-title">Senior Consultant Cardiologist</p>
                            <p class="doctor-specialty">Cardiology</p>
                            <a href="find_a_doctor.php#Dr. Gotabhaya Ranasinghe" class="button button-small">View Profile</a>
                        </div>
                    </div>

                    <div class="doctor-card" data-name="Prof. Shaman Rajindrajith" data-specialty="Pediatrics">
                        <img src="images/dr-shaman.png" alt="Prof. Shaman Rajindrajith">
                        <div class="doctor-info">
                            <h4>Prof. Shaman Rajindrajith</h4>
                            <p class="doctor-title">Consultant Pediatrician</p>
                            <p class="doctor-specialty">Pediatrics</p>
                            <a href="find_a_doctor.php#Prof. Shaman Rajindrajith" class="button button-small">View Profile</a>
                        </div>
                    </div>

                    <div class="doctor-card" data-name="Dr. Nayana Perera" data-specialty="Dermatology">
                        <img src="images/Nayana Perera.jpeg" alt="Dr. Nayana Perera">
                        <div class="doctor-info">
                            <h4>Dr. Nayana Perera</h4>
                            <p class="doctor-title">Head of Cosmetic Dermatology</p>
                            <p class="doctor-specialty">Dermatology</p>
                            <a href="find_a_doctor.php#Dr. Nayana Perera" class="button button-small">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="service-slide doctor-slide" data-slide-index="2">
                <div class="doctor-slide-inner-grid">
                    <div class="doctor-card" data-name="Dr. Ashan Abeyewardene" data-specialty="Orthopedics">
                        <img src="images/Ashan Abeyewardene.jpeg" alt="Dr. Ashan Abeyewardene">
                        <div class="doctor-info">
                            <h4>Dr. Ashan Abeyewardene</h4>
                            <p class="doctor-title">Head of Joint Replacement</p>
                            <p class="doctor-specialty">Orthopedics</p>
                            <a href="find_a_doctor.php#Dr. Ashan Abeyewardene" class="button button-small">View Profile</a>
                        </div>
                    </div>

                    <div class="doctor-card" data-name="Dr. Elena Fernando" data-specialty="General Practitioner">
                        <img src="images/Elena Fernando.jpeg" alt="Dr. Elena Fernando">
                        <div class="doctor-info">
                            <h4>Dr. Elena Fernando</h4>
                            <p class="doctor-title">Senior General Practitioner</p>
                            <p class="doctor-specialty">General Practitioner</p>
                            <a href="find_a_doctor.php#Dr. Elena Fernando" class="button button-small">View Profile</a>
                        </div>
                    </div>

                    <div class="doctor-card" data-name="Dr. Chandra Silva" data-specialty="Cardiology">
                        <img src="images/placeholder_doctor.png" alt="Dr. Chandra Silva">
                        <div class="doctor-info">
                            <h4>Dr. Chandra Silva</h4>
                            <p class="doctor-title">Consultant Cardiologist</p>
                            <p class="doctor-specialty">Cardiology</p>
                            <a href="find_a_doctor.php#Dr. Chandra Silva" class="button button-small">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>

            <a class="service-prev" onclick="plusDoctorSlides(-1)">❮</a>
            <a class="service-next" onclick="plusDoctorSlides(1)">❯</a>
        </div>

        <div class="service-dots-container doctor-dots-container">
            <span class="service-dot doctor-dot" onclick="currentDoctorSlide(1)"></span>
            <span class="service-dot doctor-dot" onclick="currentDoctorSlide(2)"></span>
        </div>


        <div class="view-all-services-container">
            <a href="find_a_doctor.php" class="button button-large">Search All Specialists →</a>
        </div>

    </section>

    <section class="page-container-home location-section">
        <h1><i class="fa-solid fa-location-dot"></i> Our Location & Contact Info</h1>
        <p>We are conveniently located with ample parking and accessibility. Visit us or get in touch below.</p>

        <div class="location-content-grid">
            <div class="location-details">
                <h3>Medicare Plus Hospital</h3>
                <ul class="footer-contact">
                    <li><i class="fa-solid fa-map-marker-alt"></i>No. 84 St.Rita's Road, Mount Lavinia,
                        Sri Lanka</li>
                    <li><i class="fa-solid fa-phone"></i><a href="tel:+94112499590">+94 11 2 499 590</a></li>
                    <li><i class="fa-solid fa-envelope"></i><a href="mailto:info@medicareplus.lk"> info@medicareplus.lk</a></li>
                    <li><i class="fa-solid fa-clock"></i> Open 24/7 for Emergency Services</li>
                </ul>

                <a href="https://www.google.com/maps/dir/?api=1&destination=Medicare+Plus,+No.+84+St.Rita's+Road,+Mount+Lavinia"
                    target="_blank"
                    class="button button-large location-button">
                    <i class="fa-solid fa-route"></i> Get Directions
                </a>
            </div>

            <div class="map-placeholder">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.4283597441464!2d79.8789504!3d6.828623599999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2458e0a75df89%3A0x67a3f87b328a6f67!2sSt%20Rita's%20Rd%2C%20Mount%20Lavinia!5e0!3m2!1sen!2slk!4v1700200000000!5m2!1sen!2slk"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <div class="About" id="AboutUs">
        <h1>ABOUT US</h1>
        <section class="AboutText">
            <p>Welcome to MediCare Plus, a leading private healthcare provider dedicated to delivering a comprehensive
                range of medical services. Our mission is to ensure the well-being of our community by offering
                accessible,
                efficient, and high-quality care.</p>
            <p>We provide a wide array of services to meet your needs, including:</p>

            <a class="service-link" onclick="openModal('General Medical Consultations', `
                <p><strong>Comprehensive care for your everyday health needs.</strong></p>
                <p>This is your primary care service for non-emergency health concerns. Visit our general doctors for routine check-ups, preventative care, vaccinations, and treatment for common illnesses like colds, flu, and infections.</p>
                <p>They also help manage chronic conditions like diabetes or asthma and can provide referrals to specialists when needed.</p>
                `, 'general-consultations.php')">
                <li>General Medical Consultations</li>
            </a>

            <a class="service-link" onclick="openModal('Specialist Treatments', `
                <h3><i class='fa-solid fa-stethoscope'></i> Expert Care by Leading Specialists</h3>
                <p>MediCare Plus offers access to a network of highly qualified specialists across various fields including <strong>Cardiology, Neurology, Orthopedics,</strong> and more.</p>
                <p>We facilitate timely appointments and ensure integrated care, using the latest techniques to provide effective treatment plans tailored to your needs.</p>
                `, 'Specialist Treatments.php')">
                <li>Specialist Treatments</li>
            </a>

            <a class="service-link" onclick="openModal('Advanced Diagnostic Services', `
                <h3><i class='fa-solid fa-microscope'></i> Accurate Diagnosis, Faster Treatment</h3>
                <p>Our state-of-the-art diagnostic wing includes:</p>
                <ul>
                    <li>Advanced MRI and CT Scanners</li>
                    <li>Digital X-Ray and Ultrasound</li>
                    <li>Comprehensive Laboratory Services</li>
                    <li>ECG and Stress Testing</li>
                </ul>
                <p>We believe precise diagnostics are the cornerstone of effective healthcare.</p>
                `, 'diagnostics.php')">
                <li>Advanced Diagnostic Services</li>
            </a>

            <a class="service-link" onclick="openModal('Emergency Care', `
                <h3><i class='fa-solid fa-truck-medical'></i> 24/7 Emergency & Trauma Care</h3>
                <p><strong>Our Emergency Room is open 24 hours a day, 7 days a week.</strong></p>
                <p>Staffed by highly trained emergency physicians and nurses, we are equipped to handle all medical emergencies, from minor injuries to critical, life-threatening conditions. Your health and safety are our first priority.</p>
                `, 'Emergency Care.php')">
                <li>Emergency Care</li>
            </a>

            <p>In response to rising patient expectations and the need for improved service delivery,
                we are proud to introduce our new interactive web platform. This site is a cornerstone
                of our commitment to digital transformation in healthcare.</p>
        </section>
        <section class="AboutImage">
            <img src="images/Logo4.png" alt="Medicare Plus Logo">
        </section>
    </div>

    <div id="infoModal" class="modal">
        <div class="modal-content">

            <div class="modal-header">
                <h2 id="modalTitle">Modal Title</h2>
                <button type="button" class="modal-close-btn" id="modalCloseBtn" onclick="closeModal()">
                    <i class="fa-solid fa-times"></i> Close
                </button>
            </div>

            <div class="modal-body">
                <div id="modalContent">
                </div>
            </div>

            <div class="modal-footer">
                <a id="modalLearnMoreLink" href="#">
                    Learn More
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <button type="button" class="cancelbtn" onclick="closeModal()">Close</button>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="first.js"></script>

</body>

</html>