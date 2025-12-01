Medicare Plus - Hospital Management System

Your Partner for a Lifetime of Health.

Medicare Plus is a comprehensive, web-based hospital management system designed to bridge the gap between patients, doctors, and hospital administrators. It facilitates seamless appointment booking, digital prescriptions, medical record management, and secure communication channels.

🚀 Key Features

🏥 For Patients

User Dashboard: View upcoming appointments, medical history, and billing status.

Appointment Booking: Search for doctors by specialty and book slots instantly.

Digital Prescriptions: Access and print prescriptions issued by doctors.

Online Payments: Pay medical bills securely via the portal.

Doctor Chat: Secure, encrypted messaging system to communicate with doctors.

Medical History: Keep track of past diagnoses and treatments.

👨‍⚕️ For Doctors

Doctor Dashboard: Overview of total patients, pending appointments, and earnings.

Appointment Management: Confirm, reschedule, or complete patient visits.

e-Prescribing: Create and send digital prescriptions directly to patient profiles.

Invoicing: Generate bills for services rendered.

Earnings Tracker: Real-time view of revenue and transaction history.

Patient Chat: Communicate with patients and share attachments.

🛡️ For Administrators

Admin Panel: Full control over the system's users and data.

User Management: Add, edit, or remove doctors and patients.

Financial Overview: Track hospital revenue, daily income, and transaction logs.

System Monitoring: View system status and server information.

Admin Inbox: Centralized messaging for support inquiries.

🛠️ Technology Stack

Frontend: HTML5, CSS3 (Custom & Responsive), JavaScript (jQuery)

Backend: PHP (Vanilla, Object-Oriented & Procedural)

Database: MySQL

Security: Password Hashing (password_hash), Prepared Statements (SQL Injection Prevention), Session Management

Icons: FontAwesome 6

Fonts: Inter, Poppins

⚙️ Installation & Setup

Prerequisites

XAMPP / WAMP / LAMP Stack (Apache, MySQL, PHP)

Web Browser

Steps

Clone/Download:
Place the project folder inside your server's root directory (e.g., C:/xampp/htdocs/medicare-plus).

Database Configuration:

Open phpMyAdmin (usually http://localhost/phpmyadmin).

Create a new database named medicare_db.

Import the SQL schema (see Database Schema section below) or import the provided .sql file if available.

Connect Database:
Ensure db_connect.php has the correct credentials:

$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "medicare_db";


Run the Project:
Open your browser and navigate to:
http://localhost/medicare-plus/Home.php

🗄️ Database Schema (Quick Reference)

If you don't have the SQL file, create these core tables to get started:

-- 1. Users Table (Stores Admin, Doctors, and Patients)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'doctor', 'patient'),
    phone VARCHAR(20),
    specialty VARCHAR(50), -- For doctors
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Appointments
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT,
    patient_name VARCHAR(100),
    appointment_time VARCHAR(50),
    reason TEXT,
    status VARCHAR(20) DEFAULT 'Scheduled'
);

-- 3. Prescriptions
CREATE TABLE prescriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT,
    patient_id INT,
    diagnosis VARCHAR(255),
    dosage_instructions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Invoices & Payments
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    amount DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'unpaid'
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT,
    patient_id INT,
    amount DECIMAL(10,2),
    status VARCHAR(20),
    paid_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Messages
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    message TEXT,
    is_read TINYINT DEFAULT 0,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


📂 Project Structure

medicare-plus/
├── 📂 images/              # Static assets (logos, banners)
├── 📂 uploads/             # User uploaded files (avatars, attachments)
├── 📄 db_connect.php       # Database connection string
├── 📄 Home.php             # Landing Page
├── 📄 Login.php            # User Login (Doctor/Patient)
├── 📄 admin_login.php      # Dedicated Admin Login
├── 📄 register.php         # Patient Registration
├── 📄 dashboard_admin.php  # Administrator Control Panel
├── 📄 dashboard_doctor.php # Doctor's Workspace
├── 📄 dashboard_patient.php# Patient's Personal Portal
├── 📄 messages.php         # Chat System
└── ... (Service pages, CSS, JS)


🔐 Default Credentials (For Testing)

Note: Passwords in the database are hashed. You may need to create new users via register.php or use fix_passwords.php to reset doctor passwords during development.

Admin URL: admin_login.php

Doctor/Patient URL: Login.php

👨‍💻 Author

Senira Mendis

Undergraduate Software Engineer

Cardiff Metropolitan University

© 2025 Medicare Plus. All Rights Reserved.
