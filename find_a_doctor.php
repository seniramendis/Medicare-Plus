<?php
$pageTitle = 'Find a Doctor';
$pageKey = 'find_doctor'; // Not 'home'
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

            <div class="doctor-card" data-name="Dr. Gotabhaya Ranasinghe" data-specialty="Cardiology">
                <img src="images/Dr. Gotabhaya Ranasinghe.webp" alt="Dr. Gotabhaya Ranasinghe">
                <div class="doctor-info">
                    <h4>Dr. Gotabhaya Ranasinghe</h4>
                    <p class="doctor-title">Senior Consultant Cardiologist</p>
                    <p class="doctor-specialty">Cardiology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.5 (120)</span>
                    </div>
                    <p class="doctor-description">With over 20 years of experience, Dr. Ranasinghe is a leading expert...</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. S.A. Perera" data-specialty="Cardiology">
                <img src="https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. S.A. Perera">
                <div class="doctor-info">
                    <h4>Dr. S.A. Perera</h4>
                    <p class="doctor-title">Consultant Cardiologist</p>
                    <p class="doctor-specialty">Cardiology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <span>5.0 (98)</span>
                    </div>
                    <p class="doctor-description">Specializes in interventional cardiology and heart rhythm disorders.</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Anusha Silva" data-specialty="Pediatrics">
                <img src="https://images.pexels.com/photos/5214995/pexels-photo-5214995.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. Anusha Silva">
                <div class="doctor-info">
                    <h4>Dr. Anusha Silva</h4>
                    <p class="doctor-title">Consultant Pediatrician</p>
                    <p class="doctor-specialty">Pediatrics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.7 (150)</span>
                    </div>
                    <p class="doctor-description">A friendly and dedicated pediatrician focused on child wellness.</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Nimal Fernando" data-specialty="Orthopedics">
                <img src="https://images.pexels.com/photos/5452293/pexels-photo-5452293.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. Nimal Fernando">
                <div class="doctor-info">
                    <h4>Dr. Nimal Fernando</h4>
                    <p class="doctor-title">Consultant Orthopedic Surgeon</p>
                    <p class="doctor-specialty">Orthopedics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                        <span>4.1 (85)</span>
                    </div>
                    <p class="doctor-description">Expert in joint replacement surgeries and sports injuries.</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Shalini Dias" data-specialty="Dermatology">
                <img src="https://images.pexels.com/photos/5214949/pexels-photo-5214949.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. Shalini Dias">
                <div class="doctor-info">
                    <h4>Dr. Shalini Dias</h4>
                    <p class="doctor-title">Consultant Dermatologist</p>
                    <p class="doctor-specialty">Dermatology</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <span>4.9 (210)</span>
                    </div>
                    <p class="doctor-description">Specializing in cosmetic dermatology and skin cancer screening.</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Mohan Raj" data-specialty="Neurology">
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
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. R. M. Bandara" data-specialty="Orthopedics">
                <img src="https://images.pexels.com/photos/5452201/pexels-photo-5452201.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. R. M. Bandara">
                <div class="doctor-info">
                    <h4>Dr. R. M. Bandara</h4>
                    <p class="doctor-title">Orthopedic Surgeon</p>
                    <p class="doctor-specialty">Orthopedics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                        <span>4.2 (76)</span>
                    </div>
                    <p class="doctor-description">Focuses on pediatric orthopedics and spinal disorders.</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Fatima Hassan" data-specialty="Gynaecology">
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
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Ajith Jayawardena" data-specialty="ENT">
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
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Kanishka Weerasinghe" data-specialty="Pediatrics">
                <img src="https://images.pexels.com/photos/6234601/pexels-photo-6234601.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. Kanishka Weerasinghe">
                <div class="doctor-info">
                    <h4>Dr. Kanishka Weerasinghe</h4>
                    <p class="doctor-title">Senior Pediatrician</p>
                    <p class="doctor-specialty">Pediatrics</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span>4.7 (133)</span>
                    </div>
                    <p class="doctor-description">Expert in newborn care and childhood developmental disorders.</p>
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Priya Kumari" data-specialty="Dermatology">
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
                    <a href="#" class="button">Book Appointment</a>
                </div>
            </div>

            <div class="doctor-card" data-name="Dr. Ravi Pathirana" data-specialty="General Practitioner">
                <img src="https://images.pexels.com/photos/5215017/pexels-photo-5215017.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Dr. Ravi Pathirana">
                <div class="doctor-info">
                    <h4>Dr. Ravi Pathirana</h4>
                    <p class="doctor-title">Family Physician</p>
                    <p class="doctor-specialty">General Practitioner</p>
                    <div class="doctor-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                        <span>4.4 (92)</span>
                    </div>
                    <p class="doctor-description">Your first point of contact for all non-emergency health concerns.</p>
                    <a href="#" class="button">Book Appointment</a>
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
                if (!allCards.length) return; // Exit if no cards found

                const nameQuery = nameInput.value.toLowerCase();
                const specialtyQuery = specialtySelect.value;
                let resultsFound = false;

                allCards.forEach(card => {
                    const name = card.getAttribute('data-name').toLowerCase();
                    const specialty = card.getAttribute('data-specialty');

                    const nameMatch = name.includes(nameQuery);
                    const specialtyMatch = (specialtyQuery === 'all' || specialty === specialtyQuery);

                    if (nameMatch && specialtyMatch) {
                        card.style.display = 'flex'; // Use 'flex' as per your card styles
                        resultsFound = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (noResultsMessage) {
                    noResultsMessage.style.display = resultsFound ? 'none' : 'block';
                }
            }

            if (nameInput) nameInput.addEventListener('keyup', filterDoctors);
            if (specialtySelect) specialtySelect.addEventListener('change', filterDoctors);
        });
    </script>

    <?php
    include 'footer.php';
    ?>
</body>

</html>