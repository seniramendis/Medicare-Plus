-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2025 at 12:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicare_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `appointment_time` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `doctor_id`, `patient_name`, `appointment_time`, `reason`, `status`) VALUES
(11, 7, 'Senira Mendis', '2025-11-26 (09:00 AM)', 'Fever', 'Completed'),
(12, 7, 'Senira Mendis', '2025-11-26 (11:00 AM)', 'coma', 'Completed'),
(13, 7, 'Senira Mendis', '2025-11-25 (09:00 AM)', 'Comaa\r\n', 'Completed'),
(14, 7, 'Senira Mendis', '2025-11-30 (09:00 AM)', 'Fever', 'Confirmed'),
(15, 19, 'John Silva', '2025-12-05 (10:00 AM)', 'Fever', 'Completed'),
(17, 19, 'John Silva', '2025-12-03 (09:00 AM)', 'Diabates', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user_identifier` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_type` enum('admin','doctor','patient','guest') NOT NULL,
  `last_message` text DEFAULT NULL,
  `last_activity` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `user_identifier`, `user_name`, `user_type`, `last_message`, `last_activity`) VALUES
(1, 'guest_6927283fc27c2', 'Guest Visitor', 'guest', 'Hey', '2025-11-26 21:52:13'),
(2, 'user_21', 'Senira Mendis', 'patient', '🔒 Encrypted Message', '2025-11-29 10:14:26'),
(3, 'guest_692753476b8b7', 'Guest Visitor', 'guest', 'Admin: heyy', '2025-11-27 00:59:56'),
(4, 'user_7', 'Dr. Gotabhaya Ranasinghe', 'patient', '🔒 Encrypted Message', '2025-11-28 22:14:06'),
(5, 'guest_69276f596d254', 'Guest Visitor', 'guest', '🔒 Encrypted Message', '2025-11-28 00:01:42'),
(6, 'guest_692974e46c0cf', 'Guest Visitor', 'guest', 'Admin: 🔒 Message', '2025-11-28 22:11:59'),
(7, 'user_22', 'John Silva', 'patient', 'Admin: 🔒 Message', '2025-12-02 02:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `affiliations` text DEFAULT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `qualifications` text DEFAULT NULL,
  `schedule` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `slug`, `name`, `title`, `specialty`, `image_url`, `bio`, `education`, `affiliations`, `availability`, `qualifications`, `schedule`) VALUES
(92, 'gotabhaya-ranasinghe', 'Dr. Gotabhaya Ranasinghe', 'Senior Consultant Cardiologist', 'Cardiology', 'images/Dr. Gotabhaya Ranasinghe.webp', 'Dr. Ranasinghe is a renowned expert in cardiac electrophysiology and complex interventional cardiology procedures. He leads the team focused on minimally invasive heart surgeries. His research focuses on preventative heart disease in South Asian populations.', NULL, NULL, NULL, 'MBBS, MD (Cardiology), Board Certified (SL), FACC (USA). 15+ years of experience in specialized cardiac care.', 'Monday: 9:00 AM - 1:00 PM\nTuesday: 3:00 PM - 7:00 PM\nFriday: 9:00 AM - 1:00 PM'),
(93, 's-a-perera', 'Dr. S.A. Perera', 'Consultant Cardiologist', 'Cardiology', 'https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=600', 'Dr. Perera specializes in heart rhythm disorders and the latest non-invasive diagnostic techniques. He is committed to providing personalized care and long-term management strategies for all cardiac patients.', NULL, NULL, NULL, 'MBBS, MRCP (UK), CCST (Cardiology). Extensive overseas training in non-invasive imaging.', 'Wednesday: 10:00 AM - 4:00 PM\nSaturday: 9:00 AM - 12:00 PM'),
(94, 'chandra-silva', 'Dr. Chandra Silva', 'Consultant Cardiologist', 'Cardiology', 'uploads/doc_9_1764282492.jpeg', 'Expert in preventive cardiology and managing heart failure.', NULL, NULL, NULL, 'MBBS, MD, Fellow in Preventive Cardiology (Australia). Certified Hypertension Specialist.', 'Thursday: 2:00 PM - 6:00 PM\nSaturday: 1:00 PM - 5:00 PM'),
(95, 'nayana-perera', 'Dr. Nayana Perera', 'Head of Cosmetic Dermatology', 'Dermatology', 'images/Nayana Perera.jpeg', 'Dr. Perera is a leading figure in cosmetic and aesthetic dermatology, specializing in laser treatments, anti-aging injectables, and complex skin resurfacing procedures.', NULL, NULL, NULL, 'MBBS, MD (Dermatology), Diploma in Aesthetic Medicine. Founder of the Advanced Skin Clinic.', 'Tuesday: 10:00 AM - 12:00 PM\nFriday: 2:00 PM - 6:00 PM'),
(96, 'saman-weerakoon', 'Dr. Saman Weerakoon', 'Consultant Dermatologist', 'Dermatology', 'uploads/doc_11_1764282706.jpeg', 'Focuses on medical dermatology, including psoriasis and eczema.', NULL, NULL, NULL, 'MBBS, MD, FCPS (Derm). Special interest in photodermatology.', 'Monday: 3:00 PM - 7:00 PM\nThursday: 9:00 AM - 1:00 PM'),
(97, 'priya-kumari', 'Priya Kumari', 'Dermatologist', 'Cardiology', 'uploads/doc_12_1764280655.jpeg', 'Provides treatment for all skin, hair, and nail conditions.', NULL, NULL, NULL, 'MBBS, PG Dip. Derm. Certified in Trichology.', 'Wednesday: 9:00 AM - 1:00 PM\nSaturday: 1:00 PM - 4:00 PM'),
(98, 'ashan-abeyewardene', 'Dr. Ashan Abeyewardene', 'Head of Joint Replacement', 'Orthopedics', 'images/Ashan Abeyewardene.jpeg', 'Dr. Abeyewardene is a top surgeon specializing in minimally invasive hip and knee replacement surgery, utilizing the latest robotic techniques for precision and faster recovery.', NULL, NULL, NULL, 'MBBS, MS (Orthopedics), FRCS (UK). Specialized fellowship in Robotic Surgery.', 'Monday: 8:00 AM - 12:00 PM\nThursday: 3:00 PM - 7:00 PM'),
(99, 'narendra-pinto', 'Dr. Narendra Pinto', 'Sports Medicine Specialist', 'Orthopedics', 'images/Narendra Pinto.jpg', 'Focusing on sports-related injuries, Dr. Pinto specializes in arthroscopic repair of the shoulder and knee, helping professional and amateur athletes return to peak performance.', NULL, NULL, NULL, 'MBBS, MD, Diploma in Sports Medicine. Team physician for national sports associations.', 'Tuesday: 9:00 AM - 1:00 PM\nFriday: 10:00 AM - 2:00 PM'),
(100, 'v-swarnakumaar', 'Dr. V. Swarnakumaar', 'Pediatric Orthopedic Surgeon', 'Orthopedics', 'images/Velayutham Swarnakumaar.jpeg', 'Dr. Swarnakumaar is dedicated to treating musculoskeletal problems in children, from congenital deformities to complex fractures and growth plate issues.', NULL, NULL, NULL, 'MBBS, MS, Pediatric Orthopedics Fellowship (Canada).', 'Wednesday: 1:00 PM - 5:00 PM\nSaturday: 8:00 AM - 12:00 PM'),
(101, 'shaman-rajindrajith', 'Prof. Shaman Rajindrajith', 'Consultant Pediatrician', 'Pediatrics', 'images/dr-shaman.png', 'A respected professor and clinician, Prof. Rajindrajith provides comprehensive care in general pediatrics, child development, and adolescent health.', NULL, NULL, NULL, 'MBBS, MD (Paediatrics), PhD. Fellow of the Royal College of Paediatrics.', 'Monday: 2:00 PM - 6:00 PM\nFriday: 9:00 AM - 1:00 PM'),
(102, 'pujitha-wickramasinghe', 'Prof. Pujitha Wickramasinghe', 'Pediatric Neurologist', 'Pediatrics', 'images/Prof-Pujitha-Wickramasinghe.jpg', 'Prof. Wickramasinghe is a specialist in neurological disorders affecting children, including epilepsy, developmental delays, and movement disorders.', NULL, NULL, NULL, 'MBBS, MD, Sub-specialty Certification in Pediatric Neurology. Extensive research publication history.', 'Tuesday: 1:00 PM - 5:00 PM\nThursday: 9:00 AM - 1:00 PM'),
(103, 'duminda-samarasinghe', 'Dr. Duminda Samarasinghe', 'Head of Neonatology', 'Pediatrics', 'images/Dr. Duminda Samarasinghe.jpeg', 'Dr. Samarasinghe leads our Neonatal Intensive Care Unit (NICU), specializing in the care of premature and critically ill newborns.', NULL, NULL, NULL, 'MBBS, MD, Neonatology Fellowship (UK). 20+ years dedicated to newborn health.', 'Wednesday: 8:00 AM - 12:00 PM\nSaturday: 3:00 PM - 6:00 PM'),
(104, 'elena-fernando', 'Dr. Elena Fernando', 'Senior General Practitioner', 'General Practitioner', 'images/Elena Fernando.jpeg', 'Dr. Fernando is an experienced GP with a strong interest in managing chronic conditions such as diabetes, hypertension, and preventative healthcare.', NULL, NULL, NULL, 'MBBS, MRCGP (UK), Diploma in Diabetes Care. Focus on holistic family care.', 'Monday: 9:00 AM - 1:00 PM\nWednesday: 2:00 PM - 6:00 PM\nFriday: 9:00 AM - 1:00 PM'),
(105, 'kevin-perera', 'Dr. Kevin Perera', 'General Practitioner', 'General Practitioner', 'images/Kevin Perera.jpg', 'Dr. Perera emphasizes preventative health and wellness, providing routine check-ups, vaccinations, and promoting healthy lifestyles for all ages.', NULL, NULL, NULL, 'MBBS, DFM (Family Medicine).', 'Tuesday: 2:00 PM - 6:00 PM\nThursday: 10:00 AM - 2:00 PM'),
(106, 'maria-silva', 'Dr. Maria Silva', 'General Practitioner & Family Medicine', 'General Practitioner', 'images/Maria Silva.jpeg', 'Dr. Silva provides continuous care for the entire family, with special expertise in pediatric check-ups and routine women\'s health screenings.', NULL, NULL, NULL, 'MBBS, Board Certified in Family Medicine.', 'Tuesday: 9:00 AM - 1:00 PM\nFriday: 3:00 PM - 7:00 PM'),
(107, 'mohan-raj', 'Dr. Mohan Raj', 'Consultant Neurologist', 'Neurology', 'https://images.pexels.com/photos/5794038/pexels-photo-5794038.jpeg?auto=compress&cs=tinysrgb&w=600', 'A leading expert in treating complex neurological conditions, including stroke, epilepsy, and persistent headache disorders.', NULL, NULL, NULL, 'MBBS, MD (Neurology), Fellowship in Stroke Management (USA).', 'Monday: 10:00 AM - 2:00 PM\nWednesday: 9:00 AM - 1:00 PM'),
(108, 'fatima-hassan', 'Dr. Fatima Hassan', 'Consultant Gynaecologist', 'Gynaecology', 'https://images.pexels.com/photos/5327921/pexels-photo-5327921.jpeg?auto=compress&cs=tinysrgb&w=600', 'Dr. Hassan provides compassionate care in women\'s health, focusing on obstetrics, adolescent gynaecology, and menopausal health management.', NULL, NULL, NULL, 'MBBS, MS (Obs/Gyn), FRCOG (UK).', 'Thursday: 1:00 PM - 5:00 PM\nSaturday: 10:00 AM - 1:00 PM'),
(109, 'ajith-jayawardena', 'Dr. Ajith Jayawardena', 'Consultant ENT Surgeon', 'ENT', 'https://images.pexels.com/photos/5407206/pexels-photo-5407206.jpeg?auto=compress&cs=tinysrgb&w=600', 'Dr. Jayawardena manages all types of ear, nose, and throat conditions, specializing in sinus surgery and audiology for both adults and children.', NULL, NULL, NULL, 'MBBS, MS (ENT), Fellowship in Head & Neck Surgery (Singapore).', 'Friday: 2:00 PM - 6:00 PM\nSaturday: 9:00 AM - 12:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `service_name` varchar(255) NOT NULL,
  `status` enum('unpaid','paid','partial') DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_edited` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `patient_id`, `doctor_id`, `appointment_id`, `amount`, `service_name`, `status`, `created_at`, `is_edited`) VALUES
(19, 21, 7, 11, 5000.00, 'Blood Test ', 'paid', '2025-11-24 21:32:23', 0),
(20, 21, 7, 13, 5000.00, 'Blood Test ', 'paid', '2025-11-24 23:51:30', 0),
(21, 21, 7, 14, 5000.00, 'Blood Test ', 'unpaid', '2025-11-29 04:51:59', 0),
(22, 22, 19, 15, 5000.00, 'Consultation', 'paid', '2025-12-01 20:20:03', 0),
(23, 22, 19, 15, 500.00, 'Consultation', 'paid', '2025-12-01 20:21:47', 0),
(24, 22, 19, 17, 2400.00, 'Blood Test ', 'paid', '2025-12-01 21:40:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` longtext DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `attachment`, `timestamp`, `is_read`) VALUES
(1, 6, 7, 'N3lDd3N4TlNnZjYycnFzc3hNRVBhZz09Ojp4Sbrhm3X9N2X7Lh8LT+ZL', NULL, '2025-11-24 01:07:12', 1),
(2, 6, 7, 'SVU3ZDBYUUh1REE4TmoyR0Mxc1BSdz09OjpJxrbKHgXf/qv8Q1RFsehL', '69236289db647.pdf', '2025-11-24 01:07:45', 1),
(3, 6, 7, 'MnR5WXNmQUN1T1VhWFh5SjBVQ2tOQT09Ojr0wN/NjeulIuMDGVdh8oY6', NULL, '2025-11-24 01:22:57', 1),
(4, 6, 7, 'Y2xiUVNiNVcrRlBrZUNEUjZNazNWUT09OjpyBvyVgqhMV7iLt/7xSG+w', NULL, '2025-11-24 01:22:59', 1),
(5, 6, 7, 'SFRYQy91NzhTWGZoOU9qb0RkSE1PZz09OjrHe7eGmWhyD6vNEtojdd3F', NULL, '2025-11-24 01:23:01', 1),
(6, 7, 6, 'ZWdtQ00vOHBVV2l3ZzhUTGRiMGRQdz09OjrKrOtTcrRTfH/EKXtgrPYi', NULL, '2025-11-24 01:23:28', 1),
(9, 7, 5, 'YitLV3QvdUJDVHFjK3YySGE1d1NQdz09OjoS03Uo+AAx63qjUxz7DvJC', NULL, '2025-11-26 20:09:42', 1),
(10, 7, 5, 'b21nQVRKNmxZZU5sWkZDZFRKT1J5QT09OjqMRGTSzWi/Z+gTZo5BCaMf', NULL, '2025-11-26 21:53:46', 0),
(11, 7, 5, 'Q0xlR2RrQ0Z6OU5VbVFDSFJPbnVidz09OjoY8Fm5Nb3AAg1/EkutZ3S8', NULL, '2025-11-27 02:12:22', 0),
(12, 7, 5, 'NmN6M0pjZy9sa292dEZvTkRGdGJ3dz09OjoP9WkO2Hbwl3P3Ldv9ozeY', NULL, '2025-11-27 02:12:26', 0),
(13, 7, 5, 'MUNYMC9pZ1pTVFJVamU1c0pRK0hZdz09OjqrmFgpDD2EHZPfz6kawNFm', NULL, '2025-11-27 02:50:12', 0),
(14, 7, 5, 'WnVxc2tHTjF2bytBR1NFKzg0OHZHQT09OjqeOCSTn2G+gEIsTYvDq4ut', NULL, '2025-11-27 03:08:36', 0),
(15, 7, 5, 'U0tRTjRLSXUySXZ1OEVXWkJtSkMyZz09OjoiAevYBDpb5dAxK2f+2OnX', NULL, '2025-11-27 03:11:25', 0),
(16, 7, 5, 'MHlBb2o3MndhUGtGUWd1M2RPL0kvZz09OjoyMd6Znob9UnhXKOz+RKCb', NULL, '2025-11-27 03:21:52', 0),
(17, 21, 7, 'TlUrQzN6bzVEak5lZlZkYjRncmxEQT09OjoE3vOOXdAknLzUXgQBo2S8', NULL, '2025-11-27 03:23:02', 1),
(18, 7, 21, 'd0VrckhaaDZDbGhaeGtDb0FKTTRzUT09OjqiiNSr5+I3CxEiIvXMCuiw', NULL, '2025-11-27 03:23:14', 1),
(19, 22, 7, 'RWVkL1A1ZVFSd0x2QW56SGRpVzgyUT09OjpaVrEEIns/NrjCDt2PFtSq', NULL, '2025-12-02 02:11:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages_chat`
--

CREATE TABLE `messages_chat` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_type` enum('admin','user') NOT NULL,
  `message_text` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `attachment_path` varchar(255) DEFAULT NULL,
  `iv` varchar(255) DEFAULT NULL,
  `is_deleted_by_user` tinyint(1) DEFAULT 0,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages_chat`
--

INSERT INTO `messages_chat` (`id`, `conversation_id`, `sender_type`, `message_text`, `created_at`, `attachment_path`, `iv`, `is_deleted_by_user`, `is_read`) VALUES
(16, 4, 'user', 'U0pFeW9JWEVGSmsxS2doUFduSnhzZz09', '2025-11-27 14:37:41', NULL, 'FogMS7tF30X40YwalMzMGQ==', 1, 1),
(17, 4, 'user', 'K1NUTW9tbDR4aVVMWktDeGtpczZydz09', '2025-11-27 15:45:32', NULL, 'MSjQLMlZCpvy3+/+mwgZWg==', 1, 1),
(18, 4, 'user', 'aytuMlV0dnMwTlhjbGVpN0ZPUFpXUT09', '2025-11-27 15:45:53', NULL, '4A3UOjvp4KxF9/voIlGs/w==', 1, 1),
(19, 4, 'user', 'bis1TzdvWVlnSHY2cFlFNGZxelZIZz09', '2025-11-27 15:50:46', NULL, '4C54AVpZUpBHuIG6fwTm4Q==', 1, 1),
(20, 5, 'user', 'dTBVL0IwSjR6amZBNXkwVm5jampCdz09', '2025-11-28 00:01:42', NULL, 'mvgl/4Zr63hsN6Xq8L0xIg==', 0, 1),
(21, 6, 'user', 'SHdXMTJSNWlvUU5FSDI4SXdxR0ZvQT09', '2025-11-28 22:10:49', NULL, 'oxNqcrnpMrHxfjtjYiJqHw==', 0, 1),
(22, 6, 'user', 'cTBDa01pYlNhNnBYaVdoUmZ5bDNmQT09', '2025-11-28 22:11:38', NULL, 'OjR/lpKPnPtCIkQFcrRO7Q==', 0, 1),
(23, 6, 'admin', 'cGtwRk5WT091YkZzaGVsN1NSZzJQQT09', '2025-11-28 22:11:59', NULL, 'Am/90yvyQAjPZ8bmTTPA7A==', 0, 0),
(24, 2, 'user', 'eEN4N09DNEs0bVhYZU5aL1lGT3VrQT09', '2025-11-28 22:12:25', NULL, 'rDUGOeSbXV5MFMMJSugVKQ==', 1, 1),
(25, 2, 'user', 'SVVyU2R3OGZZZ044aHVoTGw5OHg5QT09', '2025-11-28 22:12:48', NULL, '6AERgWfEK41HnmZ0A7zm1w==', 0, 1),
(26, 2, 'user', 'b2djWTMwVkN3UWt1ZUM0YUEzdlFjZz09', '2025-11-28 22:13:19', NULL, 'kuu+6SsXabUBbIA74CIS+g==', 1, 1),
(27, 4, 'user', 'SS9qbnhnMEIyVlV4clFEeVlCa2J1dz09', '2025-11-28 22:14:07', NULL, 'HvpLPTBkmuq4g97yt4NGrQ==', 1, 1),
(28, 2, 'user', 'RGhTbGdQMk03QzZWMXpEeUxwRWZ6eUN0WGRwUlhxNnFMMEUyTlpqdUZBQW15S1Y5THFhNWRBMWZzUzEzTUhvQQ==', '2025-11-29 10:14:26', NULL, 'beasxacy925RG3nn1yeMVw==', 0, 1),
(29, 7, 'user', 'NDJwcW1tOTVGaGNMRnB3SUVEVTQ2WlB4RTVHenk2NGl4TzN4RXFyS1pJTkdzZ1hXdU5jdXh5emhWeDNnRkYxVW5SUzZraUp1WEpmend4RUN5U25iQTdFamMzQWsrT3dJKzBMU3NkZm4rcUk9', '2025-12-02 02:50:06', NULL, 'JeSjjbAhJrjQUSbfIYHLIg==', 0, 1),
(30, 7, 'admin', 'VWRGVXAzNDZ0dW1Pa09PTUZ4dDN3U29rMG5nY1NVZU9VUlc1OTdnOGJqdz0=', '2025-12-02 02:50:33', NULL, 'ZeHjBdSgYRkhWZ47mjy5Sw==', 0, 1),
(31, 7, 'admin', 'SVI3WUlGbU95T3p6bHUyRG1HVTBRNGFWb1JjZFhzL0FDSnlWR1NnejQ1dXQwSlpRTHNIU0NhdlFyZ0xZMDlnTA==', '2025-12-02 02:51:10', NULL, 'iQMPUGokiB7dEcV39RPWuA==', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient_reports`
--

CREATE TABLE `patient_reports` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `type` enum('Prescription','Lab Report') DEFAULT 'Prescription',
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `report_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_reports`
--

INSERT INTO `patient_reports` (`id`, `patient_id`, `doctor_name`, `type`, `title`, `description`, `report_date`) VALUES
(5, 1, 'Dr. Gotabhaya Ranasinghe', 'Prescription', 'Viral Fever Treatment', 'Panadol (2x Daily), Amoxicillin (500mg)', '2025-11-25 05:00:52'),
(6, 1, 'Asiri Laboratories', 'Lab Report', 'Full Blood Count (FBC)', 'Hemoglobin: Normal, Platelets: 150,000 (Normal)', '2025-11-25 05:00:52'),
(7, 1, 'Dr. Perera', 'Prescription', 'Migraine Relief', 'Domperidone 10mg, Rest recommended', '2025-11-20 10:00:00'),
(8, 21, 'Dr. Gotabhaya Ranasinghe', 'Prescription', 'Viral Fever Treatment', 'Panadol (2x Daily), Amoxicillin (500mg)', '2025-11-25 05:02:31'),
(9, 21, 'Asiri Laboratories', 'Lab Report', 'Full Blood Count (FBC)', 'Hemoglobin: Normal, Platelets: 150,000', '2025-11-25 05:02:31');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'paid',
  `doctor_id` int(11) DEFAULT 0,
  `cause` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT 'Medical Consultation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `patient_id`, `amount`, `payment_date`, `paid_at`, `payment_method`, `status`, `doctor_id`, `cause`, `description`) VALUES
(3, NULL, 21, 5000.00, '2025-11-24 17:03:00', '2025-11-24 21:33:00', 'Credit Card', 'paid', 7, NULL, 'Medical Consultation'),
(4, NULL, 21, 5000.00, '2025-11-24 19:16:54', '2025-11-24 23:46:54', NULL, 'paid', 7, 'Fever Treatment', 'Medical Consultation'),
(5, 20, 21, 5000.00, '2025-11-24 23:54:54', '2025-11-24 19:24:54', 'Credit Card', 'paid', 7, NULL, 'Comaa\r\n'),
(6, 23, 22, 500.00, '2025-12-01 20:26:18', '2025-12-01 15:56:18', 'Credit Card', 'paid', 19, NULL, 'Fever'),
(7, 22, 22, 5000.00, '2025-12-01 20:27:12', '2025-12-01 15:57:12', 'Credit Card', 'paid', 19, NULL, 'Fever'),
(8, 24, 22, 2400.00, '2025-12-01 21:42:05', '2025-12-01 17:12:05', 'Credit Card', 'paid', 19, NULL, 'Diabates');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `medicine_list` text NOT NULL,
  `dosage_instructions` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `appointment_id`, `patient_id`, `doctor_id`, `diagnosis`, `medicine_list`, `dosage_instructions`, `created_at`) VALUES
(1, 0, 21, 7, 'fever', 'General Rx', 'Panadol 500mg', '2025-12-01 20:06:48'),
(2, 0, 22, 19, 'fever', 'General Rx', 'Panadol 500 mg', '2025-12-01 20:16:40');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `rating` int(1) NOT NULL,
  `review_text` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `doctor_id`, `user_id`, `user_name`, `rating`, `review_text`, `review_date`) VALUES
(4, 92, 21, 'Senira Mendis', 4, 'Dr. Ranasinghe provided exceptional care throughout my treatment. His expertise in cardiac electrophysiology and minimally invasive procedures made me feel completely confident and comfortable. He explained everything clearly and genuinely cared about my recovery. I’m truly grateful for his professionalism and compassion.', '2025-11-27 22:48:05'),
(5, 94, 21, 'Senira Mendis', 4, 'Highly recommended. 💯', '2025-11-27 22:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(10) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `nic` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('patient','doctor','admin') DEFAULT 'patient',
  `specialty` varchar(100) DEFAULT 'General Practitioner',
  `bio` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT 'images/placeholder_doctor.png',
  `rating` decimal(2,1) DEFAULT 4.5,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `title`, `full_name`, `email`, `phone`, `address`, `emergency_contact`, `dob`, `gender`, `nic`, `password`, `created_at`, `role`, `specialty`, `bio`, `profile_image`, `rating`, `profile_pic`) VALUES
(5, NULL, 'Medicare Admin', 'medicare@admin.info.lk', '+94 11 2 499 590', NULL, NULL, '2004-12-11', 'Male', NULL, '$2y$10$4Hfb700/IUzD2BKRH2Nde.fpSIKEm/meommifW9FQ5Uh85W/IVGsG', '2025-11-20 20:35:48', 'admin', 'General Practitioner', NULL, 'images/placeholder_doctor.png', 4.5, NULL),
(7, NULL, 'Dr. Gotabhaya Ranasinghe', 'gotabhaya@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Cardiology', 'Specializes in interventional cardiology and complex coronary procedures.', 'images/Dr. Gotabhaya Ranasinghe.webp', 4.5, NULL),
(8, NULL, 'Dr. S.A. Perera', 'saperera@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Cardiology', 'Specializes in heart rhythm disorders and electrophysiology.', 'https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=600', 5.0, NULL),
(9, NULL, 'Dr. Chandra Silva', 'chandra@medicare.com', '', NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Cardiology', 'Expert in preventive cardiology and managing heart failure.', 'uploads/doc_9_1764282492.jpeg', 4.7, NULL),
(10, NULL, 'Dr. Nayana Perera', 'nayana@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Dermatology', 'Specializes in advanced cosmetic procedures, including laser treatments.', 'images/Nayana Perera.jpeg', 5.0, NULL),
(11, NULL, 'Dr. Saman Weerakoon', 'saman@medicare.com', '', NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Dermatology', 'Focuses on medical dermatology, including psoriasis and eczema.', 'uploads/doc_11_1764282706.jpeg', 4.5, NULL),
(12, 'Dr.', 'Priya Kumari', 'priya@medicare.com', '', '', '', '0000-00-00', '', '', '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Cardiology', 'Provides treatment for all skin, hair, and nail conditions.', 'uploads/doc_12_1764280655.jpeg', 4.8, '1764276371_Dr.priya Kumari.jpeg'),
(13, NULL, 'Dr. Ashan Abeyewardene', 'ashan@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Orthopedics', 'A leading surgeon in minimally invasive hip and knee replacement surgery.', 'images/Ashan Abeyewardene.jpeg', 4.5, NULL),
(14, NULL, 'Dr. Narendra Pinto', 'narendra@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Orthopedics', 'Focuses on sports-related injuries, specializing in arthroscopic repair.', 'images/Narendra Pinto.jpg', 5.0, NULL),
(15, NULL, 'Dr. V. Swarnakumaar', 'swarna@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Orthopedics', 'Dedicated to treating musculoskeletal problems in children.', 'images/Velayutham Swarnakumaar.jpeg', 4.7, NULL),
(16, NULL, 'Prof. Shaman Rajindrajith', 'shaman@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Pediatrics', 'A trusted expert in general pediatrics and child development.', 'images/dr-shaman.png', 4.5, NULL),
(17, NULL, 'Prof. Pujitha Wickramasinghe', 'pujitha@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Pediatrics', 'Specializes in neurological disorders in children.', 'images/Prof-Pujitha-Wickramasinghe.jpg', 4.9, NULL),
(18, NULL, 'Dr. Duminda Samarasinghe', 'duminda@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'Pediatrics', 'Leads our Neonatal Intensive Care Unit (NICU).', 'images/Dr. Duminda Samarasinghe.jpeg', 4.8, NULL),
(19, NULL, 'Dr. Elena Fernando', 'elena@medicare.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$zCMbM8d/lMBsutzzWTMI8O3MfRZkv8AWTcUjSkoKmB4ZtxIgMOpVm', '2025-11-20 22:08:27', 'doctor', 'General Practitioner', 'Special interest in managing chronic conditions like diabetes.', 'images/Elena Fernando.jpeg', 4.6, NULL),
(21, 'Mr.', 'Senira Mendis', 'seniramendis41@gmail.com', '+94753356246', '8/11 Sri Mahindarama Road Mount Lavinia', '4567890', '2004-12-10', 'Male', '1234569', '$2y$10$e7noy/zr9/ypoJO7jjGGMe7701YJydxgb9v4JlxZj.wZv4xXCMprG', '2025-11-24 06:12:32', 'patient', '', '', 'images/placeholder_doctor.png', 4.5, NULL),
(22, '', 'John Silva', 'johnsilva@test.com', '0779999999', '', '', '1981-11-02', 'Male', '', '$2y$10$BPYLZ7ZP46spVRZRcgFO2.UBVqhopqanbq72RwPV3auwnxLHOo8Gm', '2025-12-01 19:14:14', 'patient', '', '', 'images/placeholder_doctor.png', 4.5, NULL),
(23, NULL, 'Sahan Mendis', 'sahanmendis@medicare.lk', '+94753356246', NULL, NULL, NULL, NULL, NULL, '$2y$10$LMi7rQthaHQ8LPrCWvTNIOLBYNFEnTvsiSPzNqoa4FeZh9HYgANYO', '2025-12-01 15:23:20', 'doctor', 'Neurology', 'Dr. Sahan Mendis is a skilled neurologist specializing in the diagnosis and treatment of stroke, epilepsy, migraines, and neurodegenerative disorders. He is known for his patient-centered approach, clear communication, and commitment to delivering high-quality neurological care.', 'uploads/doctor_1764618800.jpeg', 5.0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_identifier` (`user_identifier`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages_chat`
--
ALTER TABLE `messages_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- Indexes for table `patient_reports`
--
ALTER TABLE `patient_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `messages_chat`
--
ALTER TABLE `messages_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `patient_reports`
--
ALTER TABLE `patient_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages_chat`
--
ALTER TABLE `messages_chat`
  ADD CONSTRAINT `messages_chat_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
