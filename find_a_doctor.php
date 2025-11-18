<?php
// find_doctor.php
$pageTitle = 'Find a Doctor';
$pageKey = 'find_doctor';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Medicare Plus' : 'Find a Doctor - Medicare Plus'; ?></title>
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

        /* --- 2. PAGE-SPECIFIC STYLES (Find a Doctor) --- */
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

        /* Filter Bar */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .filter-bar input[type="text"],
        .filter-bar select {
            flex: 1;
            min-width: 250px;
            height: 48px;
            padding: 0 20px;
            font-size: 16px;
            color: #333;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 24px;
            transition: all 0.3s ease;
        }

        .filter-bar select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding-right: 45px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%23555'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px 20px;
        }

        .filter-bar input[type="text"]:focus,
        .filter-bar select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
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

        .doctor-specialty {
            font-size: 1em;
            font-weight: 500;
            color: #555;
            margin-top: 0;
            margin-bottom: 12px;
        }

        .doctor-rating {
            margin-bottom: 15px;
            font-size: 0.9em;
        }

        .doctor-rating .fa-star,
        .doctor-rating .fa-star-half-stroke,
        .doctor-rating .fa-regular {
            color: #f0ad4e;
        }

        .doctor-rating span {
            color: #777;
            margin-left: 8px;
        }

        .doctor-description {
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

        #noResultsMessage {
            text-align: center;
            color: #777;
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
        <div class="service-detail">
            <h2>Find a Doctor</h2>
            <p>Search for our specialists by name or filter by department to find the right doctor for your needs. Our
                world-class team is here to provide you with expert care.</p>
        </div>

        <div class="filter-bar">
            <input type="text" id="doctorName" placeholder="Search by Doctor's Name...">
            <select id="doctorSpecialty">
                <option value="all">All Specialties</option>
                <option value="Cardiology">Cardiology</option>
                <option value="Dermatology">Dermatology</option>
                <option value="Endocrinology">Endocrinology</option>
                <option value="ENT">ENT</option>
                <option value="General Practitioner">General Practitioner</option>
                <option value="Gynaecology">Gynaecology</option>
                <option value="Neurology">Neurology</option>
                <option value="Orthopedics">Orthopedics</option>
                <option value="Pediatrics">Pediatrics</option>
            </select>
        </div>

        <div class="doctor-list" id="allDoctorsList">

            <div class="doctor-card" data-name="Dr. Gotabhaya Ranasinghe" data-specialty="Cardiology" data-slug="gotabhaya-ranasinghe">
                <img src="images/Dr. Gotabhaya Ranasinghe.webp" alt="Dr. Gotabhaya Ranasinghe">
                <div class="doctor-info">
                    <h4>Dr. Gotabhaya Ranasinghe</h4>
                    <p class="doctor-title">Senior Consultant Cardiologist</p>
                    <p class="doctor-specialty">Cardiology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.5 (120)</span>
                    </div>
                    <p class="doctor-description">Specializes in interventional cardiology and complex coronary procedures.</p>
                    <a href="doctor-profile.php?slug=gotabhaya-ranasinghe" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. S.A. Perera" data-specialty="Cardiology" data-slug="s-a-perera">
                <img src="https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. S.A. Perera">
                <div class="doctor-info">
                    <h4>Dr. S.A. Perera</h4>
                    <p class="doctor-title">Consultant Cardiologist</p>
                    <p class="doctor-specialty">Cardiology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <span>5.0 (98)</span>
                    </div>
                    <p class="doctor-description">Specializes in heart rhythm disorders and electrophysiology.</p>
                    <a href="doctor-profile.php?slug=s-a-perera" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Chandra Silva" data-specialty="Cardiology" data-slug="chandra-silva">
                <img src="images/placeholder_doctor.png" alt="Dr. Chandra Silva">
                <div class="doctor-info">
                    <h4>Dr. Chandra Silva</h4>
                    <p class="doctor-title">Consultant Cardiologist</p>
                    <p class="doctor-specialty">Cardiology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.7 (110)</span>
                    </div>
                    <p class="doctor-description">Expert in preventive cardiology and managing heart failure.</p>
                    <a href="doctor-profile.php?slug=chandra-silva" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Nayana Perera" data-specialty="Dermatology" data-slug="nayana-perera">
                <img src="images/Nayana Perera.jpeg" alt="Dr. Nayana Perera">
                <div class="doctor-info">
                    <h4>Dr. Nayana Perera</h4>
                    <p class="doctor-title">Head of Cosmetic Dermatology</p>
                    <p class="doctor-specialty">Dermatology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <span>5.0 (250)</span>
                    </div>
                    <p class="doctor-description">Specializes in advanced cosmetic procedures, including laser treatments and injectables.</p>
                    <a href="doctor-profile.php?slug=nayana-perera" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Saman Weerakoon" data-specialty="Dermatology" data-slug="saman-weerakoon">
                <img src="images/placeholder_doctor_male.png" alt="Dr. Saman Weerakoon">
                <div class="doctor-info">
                    <h4>Dr. Saman Weerakoon</h4>
                    <p class="doctor-title">Consultant Dermatologist</p>
                    <p class="doctor-specialty">Dermatology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.5 (95)</span>
                    </div>
                    <p class="doctor-description">Focuses on medical dermatology, including psoriasis, eczema, and skin cancer screenings.</p>
                    <a href="doctor-profile.php?slug=saman-weerakoon" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Priya Kumari" data-specialty="Dermatology" data-slug="priya-kumari">
                <img src="https://images.pexels.com/photos/5407054/pexels-photo-5407054.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. Priya Kumari">
                <div class="doctor-info">
                    <h4>Dr. Priya Kumari</h4>
                    <p class="doctor-title">Dermatologist</p>
                    <p class="doctor-specialty">Dermatology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.8 (188)</span>
                    </div>
                    <p class="doctor-description">Provides treatment for all skin, hair, and nail conditions.</p>
                    <a href="doctor-profile.php?slug=priya-kumari" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Ashan Abeyewardene" data-specialty="Orthopedics" data-slug="ashan-abeyewardene">
                <img src="images/Ashan Abeyewardene.jpeg" alt="Dr. Ashan Abeyewardene">
                <div class="doctor-info">
                    <h4>Dr. Ashan Abeyewardene</h4>
                    <p class="doctor-title">Head of Joint Replacement</p>
                    <p class="doctor-specialty">Orthopedics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.5 (105)</span>
                    </div>
                    <p class="doctor-description">A leading surgeon in minimally invasive hip and knee replacement surgery.</p>
                    <a href="doctor-profile.php?slug=ashan-abeyewardene" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Narendra Pinto" data-specialty="Orthopedics" data-slug="narendra-pinto">
                <img src="images/Narendra Pinto.jpg" alt="Dr. Narendra Pinto">
                <div class="doctor-info">
                    <h4>Dr. Narendra Pinto</h4>
                    <p class="doctor-title">Sports Medicine Specialist</p>
                    <p class="doctor-specialty">Orthopedics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <span>5.0 (150)</span>
                    </div>
                    <p class="doctor-description">Focuses on sports-related injuries, specializing in arthroscopic repair.</p>
                    <a href="doctor-profile.php?slug=narendra-pinto" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. V. Swarnakumaar" data-specialty="Orthopedics" data-slug="v-swarnakumaar">
                <img src="images/Velayutham Swarnakumaar.jpeg" alt="Dr. V. Swarnakumaar">
                <div class="doctor-info">
                    <h4>Dr. V. Swarnakumaar</h4>
                    <p class="doctor-title">Pediatric Orthopedic Surgeon</p>
                    <p class="doctor-specialty">Orthopedics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.7 (80)</span>
                    </div>
                    <p class="doctor-description">Dedicated to treating musculoskeletal problems in children.</p>
                    <a href="doctor-profile.php?slug=v-swarnakumaar" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Prof. Shaman Rajindrajith" data-specialty="Pediatrics" data-slug="shaman-rajindrajith">
                <img src="images/dr-shaman.png" alt="Prof. Shaman Rajindrajith">
                <div class="doctor-info">
                    <h4>Prof. Shaman Rajindrajith</h4>
                    <p class="doctor-title">Consultant Pediatrician</p>
                    <p class="doctor-specialty">Pediatrics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.5 (180)</span>
                    </div>
                    <p class="doctor-description">A trusted expert in general pediatrics and child development.</p>
                    <a href="doctor-profile.php?slug=shaman-rajindrajith" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Prof. Pujitha Wickramasinghe" data-specialty="Pediatrics" data-slug="pujitha-wickramasinghe">
                <img src="images/Prof-Pujitha-Wickramasinghe.jpg" alt="Prof. Pujitha Wickramasinghe">
                <div class="doctor-info">
                    <h4>Prof. Pujitha Wickramasinghe</h4>
                    <p class="doctor-title">Pediatric Neurologist</p>
                    <p class="doctor-specialty">Pediatrics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <span>4.9 (75)</span>
                    </div>
                    <p class="doctor-description">Specializes in neurological disorders in children.</p>
                    <a href="doctor-profile.php?slug=pujitha-wickramasinghe" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Duminda Samarasinghe" data-specialty="Pediatrics" data-slug="duminda-samarasinghe">
                <img src="images/Dr. Duminda Samarasinghe.jpeg" alt="Dr. Duminda Samarasinghe">
                <div class="doctor-info">
                    <h4>Dr. Duminda Samarasinghe</h4>
                    <p class="doctor-title">Head of Neonatology</p>
                    <p class="doctor-specialty">Pediatrics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.8 (115)</span>
                    </div>
                    <p class="doctor-description">Leads our Neonatal Intensive Care Unit (NICU) with expertise in newborn care.</p>
                    <a href="doctor-profile.php?slug=duminda-samarasinghe" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Elena Fernando" data-specialty="General Practitioner" data-slug="elena-fernando">
                <img src="images/Elena Fernando.jpeg" alt="Dr. Elena Fernando">
                <div class="doctor-info">
                    <h4>Dr. Elena Fernando</h4>
                    <p class="doctor-title">Senior General Practitioner</p>
                    <p class="doctor-specialty">General Practitioner</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.6 (220)</span>
                    </div>
                    <p class="doctor-description">Special interest in managing chronic conditions like diabetes and hypertension.</p>
                    <a href="doctor-profile.php?slug=elena-fernando" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Kevin Perera" data-specialty="General Practitioner" data-slug="kevin-perera">
                <img src="images/Kevin Perera.jpg" alt="Dr. Kevin Perera">
                <div class="doctor-info">
                    <h4>Dr. Kevin Perera</h4>
                    <p class="doctor-title">General Practitioner</p>
                    <p class="doctor-specialty">General Practitioner</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                        <span>4.4 (150)</span>
                    </div>
                    <p class="doctor-description">Focuses on preventative health and wellness, promoting healthy lifestyles.</p>
                    <a href="doctor-profile.php?slug=kevin-perera" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Maria Silva" data-specialty="General Practitioner" data-slug="maria-silva">
                <img src="images/Maria Silva.jpeg" alt="Dr. Maria Silva">
                <div class="doctor-info">
                    <h4>Dr. Maria Silva</h4>
                    <p class="doctor-title">General Practitioner & Family Medicine</p>
                    <p class="doctor-specialty">General Practitioner</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.7 (190)</span>
                    </div>
                    <p class="doctor-description">Provides care for the entire family, with a focus on pediatric and women's health.</p>
                    <a href="doctor-profile.php?slug=maria-silva" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Mohan Raj" data-specialty="Neurology" data-slug="mohan-raj">
                <img src="https://images.pexels.com/photos/5794038/pexels-photo-5794038.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. Mohan Raj">
                <div class="doctor-info">
                    <h4>Dr. Mohan Raj</h4>
                    <p class="doctor-title">Consultant Neurologist</p>
                    <p class="doctor-specialty">Neurology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.6 (112)</span>
                    </div>
                    <p class="doctor-description">Expert in treating stroke, epilepsy, and headache disorders.</p>
                    <a href="doctor-profile.php?slug=mohan-raj" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Fatima Hassan" data-specialty="Gynaecology" data-slug="fatima-hassan">
                <img src="https://images.pexels.com/photos/5327921/pexels-photo-5327921.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. Fatima Hassan">
                <div class="doctor-info">
                    <h4>Dr. Fatima Hassan</h4>
                    <p class="doctor-title">Consultant Gynaecologist</p>
                    <p class="doctor-specialty">Gynaecology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.8 (195)</span>
                    </div>
                    <p class="doctor-description">Compassionate care in women's health, from adolescence to menopause.</p>
                    <a href="doctor-profile.php?slug=fatima-hassan" class="button">View Profile</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Ajith Jayawardena" data-specialty="ENT" data-slug="ajith-jayawardena">
                <img src="https://images.pexels.com/photos/5407206/pexels-photo-5407206.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. Ajith Jayawardena">
                <div class="doctor-info">
                    <h4>Dr. Ajith Jayawardena</h4>
                    <p class="doctor-title">Consultant ENT Surgeon</p>
                    <p class="doctor-specialty">ENT</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                        <span>4.3 (64)</span>
                    </div>
                    <p class="doctor-description">Manages all types of ear, nose, and throat conditions in adults and children.</p>
                    <a href="doctor-profile.php?slug=ajith-jayawardena" class="button">View Profile</a>
                </div>
            </div>
        </div>

        <div id="noResultsMessage" style="display: none; text-align: center;">
            <h3>No doctors found matching your criteria.</h3>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('doctorName');
            const specialtySelect = document.getElementById('doctorSpecialty');
            const doctorList = document.getElementById('allDoctorsList');
            const allCards = doctorList ? doctorList.querySelectorAll('.doctor-card') : [];
            const noResultsMessage = document.getElementById('noResultsMessage');

            function filterDoctors() {
                if (!allCards.length) return;

                const nameQuery = nameInput.value.toLowerCase();
                const specialtyQuery = specialtySelect.value;
                let resultsFound = false;

                allCards.forEach(card => {
                    const name = (card.getAttribute('data-name') || '').toLowerCase();
                    const specialty = card.getAttribute('data-specialty');

                    const nameMatch = name.includes(nameQuery);
                    const specialtyMatch = (specialtyQuery === 'all' || specialty === specialtyQuery);

                    if (nameMatch && specialtyMatch) {
                        card.style.display = 'flex';
                        resultsFound = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (noResultsMessage) {
                    noResultsMessage.style.display = resultsFound ? 'none' : 'block';
                }
            }

            // Bind filterDoctors to both input and select changes
            if (nameInput) nameInput.addEventListener('keyup', filterDoctors);
            if (specialtySelect) specialtySelect.addEventListener('change', filterDoctors);

            // Run on load to ensure all doctors are visible initially
            filterDoctors();
        });
    </script>

    <?php
    include 'footer.php';
    ?>
</body>

</html>