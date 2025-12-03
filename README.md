<!-- BANNER AND HEADER -->

<div align="center">
<img src="images/Slideshow1.png" alt="Medicare Plus Banner" width="100%" style="border-radius: 10px;">

<br />
<br />

<img src="images/Logo.png" alt="Medicare Plus Logo" width="120">

<h1 style="margin-top: 0;">Medicare Plus</h1>

<p>
<b>A Comprehensive Hospital Management System</b>
</p>

<p>
<i>"Your Partner for a Lifetime of Health."</i>
</p>

<!-- BADGES -->

<p>
<img src="https://www.google.com/search?q=https://img.shields.io/badge/PHP-7.x%252F8.x-777BB4%3Fstyle%3Dfor-the-badge%26logo%3Dphp%26logoColor%3Dwhite" alt="PHP" />
<img src="https://www.google.com/search?q=https://img.shields.io/badge/MySQL-8.0-00000F%3Fstyle%3Dfor-the-badge%26logo%3Dmysql%26logoColor%3Dwhite" alt="MySQL" />
<img src="https://www.google.com/search?q=https://img.shields.io/badge/Apache-2.4-D22128%3Fstyle%3Dfor-the-badge%26logo%3Dapache%26logoColor%3Dwhite" alt="Apache" />
<img src="https://www.google.com/search?q=https://img.shields.io/badge/Frontend-HTML5%2520%252F%2520CSS3-E34F26%3Fstyle%3Dfor-the-badge%26logo%3Dhtml5%26logoColor%3Dwhite" alt="Frontend" />
<img src="https://www.google.com/search?q=https://img.shields.io/badge/Status-Active-success%3Fstyle%3Dfor-the-badge" alt="Status" />
</p>
</div>

📖 Overview

Medicare Plus is a modern, web-based platform designed to streamline hospital operations. It bridges the gap between patients, medical professionals, and administrators by offering a unified interface for appointment booking, medical records, and financial management.

This project focuses on efficiency, security, and user experience, utilizing a robust PHP backend and a responsive frontend design.

✨ Key Features

🏥 For Patients

👨‍⚕️ For Doctors

🛡️ For Admins

Online Booking



Book appointments 24/7 with ease.

Dashboard



Track patients, earnings, and schedules.

User Control



Manage doctors, patients, and staff.

e-Prescriptions



View and download digital prescriptions.

e-Prescribing



Issue prescriptions digitally.

Financials



Monitor revenue and daily transactions.

Bill Payments



Secure online invoicing and payments.

Invoicing



Generate bills for consultations.

System Logs



View server status and logs.

Doctor Chat



Private, encrypted messaging.

Patient Chat



Secure communication with patients.

Support Inbox



Handle inquiries centrally.

🛠️ Technology Stack

<div align="center">

Component

Technology Used

Backend

PHP (OOP & Procedural), MySQLi

Database

MySQL (Relational)

Frontend

HTML5, CSS3 (Custom + Flexbox/Grid), JavaScript

Security

password_hash() (Bcrypt), Prepared Statements, Session Management

Server

Apache (XAMPP/WAMP)

</div>

⚙️ Installation & Setup

Follow these steps to deploy Medicare Plus on your local machine.

1. Prerequisites

Ensure you have XAMPP, WAMP, or a LAMP stack installed.

2. Clone the Repository

cd C:/xampp/htdocs/
git clone [https://github.com/yourusername/medicare-plus.git](https://github.com/yourusername/medicare-plus.git)


3. Database Configuration

Open phpMyAdmin (http://localhost/phpmyadmin).

Create a new database named: medicare_db

Import the SQL schema provided below.

Update db_connect.php if you have a custom MySQL password:

$servername = "localhost";
$username = "root";
$password = ""; // Your Password
$dbname = "medicare_db";


4. Launch

Visit http://localhost/medicare-plus/Home.php in your browser.

🗄️ Database Schema

Run this SQL to set up the core tables for Users, Appointments, and Finances.

-- 1. Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'doctor', 'patient'),
    specialty VARCHAR(50),
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

-- 3. Payments
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT,
    patient_id INT,
    amount DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'paid',
    paid_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


📂 Project Structure

medicare-plus/
├── 📁 images/              # Assets (Logos, Banners)
├── 📁 uploads/             # User Uploads (Profile Pics)
├── 📄 db_connect.php       # Database Connection
├── 📄 Home.php             # Landing Page
├── 📄 Login.php            # Unified Login
├── 📄 dashboard_admin.php  # Admin Panel
├── 📄 dashboard_doctor.php # Doctor Panel
├── 📄 dashboard_patient.php# Patient Panel
└── 📄 HomeStyles.css       # Main Stylesheet


🔐 Default Login

Note: Passwords are hashed. To log in as a doctor or admin for the first time, you may need to register a new user or use the fix_passwords.php utility script.

Admin Login: admin_login.php

User Login: Login.php

<div align="center">
<p>
<b>👨‍💻 Developed by Senira Mendis</b>




Undergraduate Software Engineer | Cardiff Metropolitan University
</p>
<p>
&copy; 2025 Medicare Plus. All Rights Reserved.
</p>
</div>
