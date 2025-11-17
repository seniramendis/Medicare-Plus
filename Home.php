<?php
$pageTitle = 'Home';
$pageKey = 'home'; // This is the key! It tells header.php and footer.php to load the external files.
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'Medicare Plus - Your Lifetime Partner in Health'; ?></title>
    <link rel="icon" href="images/Favicon.png" type="image/png">

    <!-- Link to your new home page specific styles -->
    <link rel="stylesheet" href="HomeStyles.css?v=1.1">

    <script src="https://kit.fontawesome.com/9e166a3863.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php
    include 'header.php';
    ?>

    <!-- ================== -->
    <!-- MAIN SLIDESHOW     -->
    <!-- ================== -->
    <div class="slideshow-container">

        <div class="mySlides fade">
            <div class="numbertext">1 / 4</div>
            <img src="images/Slideshow1.png" alt="Your partner for a lifetime of health">
            <div class="text">YOUR PARTNER FOR A LIFETIME OF HEALTH</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">2 / 4</div>
            <img src="images/Slideshow2.png" alt="Visit us on our website">
            <div class="text">VISIT US ON WWW.MEDICAREPLUS.LK</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">3 / 4</div>
            <img src="images/Slideshow3.png" alt="Follow us on social media">
            <div class="text">FOLLOW US ON SOCIAL MEDIA</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">4 / 4</div>
            <img src="images/Slideshow4.png" alt="Medicare Plus, your partner for health">
            <div class="text">YOUR PARTNER FOR A LIFETIME OF HEALTH</div>
        </div>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
    </div>
    <br><br>

    <!-- ================== -->
    <!-- QUOTE SECTION      -->
    <!-- ================== -->
    <div class="quote">
        <h1>"The good physician treats the disease;
            the great physician treats the patient who has the disease." </h1>
        <p>- William Osler</p>
    </div><br>

    <!-- ================== -->
    <!-- SERVICES SECTION   -->
    <!-- ================== -->
    <main class="page-container-home" id="Services">
        <h1>OUR SERVICES</h1>
        <p>We provide world-class specialty care across a wide range of medical fields. Our expert teams use the
            latest technology to ensure the best possible outcomes for our patients.</p><br>

        <div class="service-carousel-container">

            <!-- Slide 1 -->
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

            <!-- Slide 2 -->
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

            <!-- Slide 3 -->
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

            <a class="service-prev" onclick="plusServiceSlides(-1)">&#10094;</a>
            <a class="service-next" onclick="plusServiceSlides(1)">&#10095;</a>
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

    <!-- ================== -->
    <!-- ABOUT US SECTION   -->
    <!-- ================== -->
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
                `, 'specialist-treatments.php')">
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

    <!-- ====================================================== -->
    <!-- === ENHANCED & DECORATED MODAL === -->
    <!-- ====================================================== -->
    <div id="infoModal" class="modal">
        <div class="modal-content">

            <div class="modal-header">
                <h2 id="modalTitle">Modal Title</h2>
                <!-- 
                  NEW: Replaced the 'x' span with a styled button.
                  The ID is used by the new JS to add a click listener.
                -->
                <button type="button" class="modal-close-btn" id="modalCloseBtn" onclick="closeModal()">
                    <i class="fa-solid fa-times"></i> Close
                </button>
            </div>

            <div class="modal-body">
                <div id="modalContent">
                    <!-- Content is injected here by JavaScript -->
                </div>
            </div>

            <div class="modal-footer">
                <!-- 
                  NEW: Added an <a> tag as a wrapper for the button 
                  and included a Font Awesome icon.
                -->
                <a id="modalLearnMoreLink" href="#">
                    Learn More
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <button type="button" class="cancelbtn" onclick="closeModal()">Close</button>
            </div>

        </div>
    </div>


    <?php
    include 'footer.php';
    ?>

    <!-- Link to your new home page specific script -->
    <script src="home-script.js"></script>

</body>

</html>