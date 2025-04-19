-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 04:47 AM
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
-- Database: `medical_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `working_hours` text DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `title`, `description`, `mission`, `vision`, `address`, `phone`, `email`, `working_hours`, `last_updated`) VALUES
(1, 'HealthyLife Medical Store', 'HealthyLife Medical Store is a one-stop solution for all your healthcare needs. We offer a wide range of authentic medicines, over-the-counter products, wellness items, and medical equipment to support a healthy lifestyle. Our store is committed to serving the community with integrity, professionalism, and care.\r\n\r\nWhether you need prescription medicines, health supplements, or personal care products, we ensure that every item on our shelves meets strict quality and safety standards. With knowledgeable staff and a customer-first approach, we aim to make your pharmacy experience smooth, reliable, and stress-free.\r\n\r\nIn addition to in-store purchases, we also offer home delivery services, online order placement, and pharmacist consultation to ensure convenience for our customers. At HealthyLife, your health is our top priority.', 'At HealthyLife Medical Store, our mission is to enhance the health and well-being of our community by providing easy access to safe, reliable, and affordable healthcare products. We are committed to maintaining the highest standards of customer service, product authenticity, and ethical practices.\r\nWe strive to build long-term relationships with our customers by offering personalized care, health advice, and convenient services such as home delivery and online ordering. Our goal is not just to sell medicines—but to contribute positively to the health journeys of every individual we serve.', 'Our vision is to become the most trusted and innovative healthcare provider in Bangladesh and beyond. We aim to set a new benchmark in the pharmaceutical retail industry by integrating technology with personalized service, expanding access to healthcare for both urban and rural communities.\r\nWe envision a future where everyone can receive the right healthcare products at the right time—without compromise. Through continuous improvement, digital transformation, and a deep sense of responsibility, we aspire to be a household name in health and wellness.', 'House #12, Road #5, Dhanmondi, Dhaka-1209, Bangladesh', '+880 1700-123456', 'info@healthylife.com', 'Saturday – Thursday: 9:00 AM – 10:00 PM\r\nFriday: Closed', '2025-04-14 14:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `userpassword` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id`, `username`, `userpassword`) VALUES
(1, 'admin', 'admin123'),
(2, 'Juthy', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `hospital` varchar(200) NOT NULL,
  `morning_schedule` varchar(50) NOT NULL,
  `evening_schedule` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `number`, `email`, `specialty`, `hospital`, `morning_schedule`, `evening_schedule`, `age`, `gender`, `description`, `fee`, `image`) VALUES
(7, 'Sagor Kumar Pal', '01739355272', 'pal2305101870@diu.edu.bd', 'Medicine', 'Bangladesh Medical ', '9:00-12:00', '6:30-8:30', 23, 'Male', 'Dr. Sagor Kumar Pal is a dedicated medical professional serving at Bangladesh Hospital. With a strong passion for patient care and a commitment to excellence, Dr. Sagor provides compassionate and reliable healthcare to ensure the well-being of every patient.', 600.00, '1744640773_ChatGPT Image Apr 14, 2025, 08_24_20 PM.png'),
(8, 'Farzana Akter Juthy', '01749591596', 'juthy2305101979@diu.edu.bd', 'Medicine', 'Bangladesh Medical ', '8:00-9:30', '5:00-12:00', 23, 'Female', 'Dr. Juthy is a compassionate and dedicated medical specialist in internal medicine. Known for her calm demeanor and warm smile, she brings expertise and empathy to every patient interaction. Her commitment to healing and community wellness makes her a trusted figure in the field of medicine.', 600.00, '1744640894_WhatsApp Image 2025-04-14 at 12.46.30_f35f5eed.jpg'),
(9, 'Md. Assaduzzaman', '01794970122', 'assad2305101269@gmail.com', 'Physician', 'Bangladesh Medical ', '8:00-10:00', '6:30-8:30', 24, 'Male', 'A dedicated and compassionate medical professional with a strong commitment to patient care, evidence-based practice, and continuous learning. Skilled in diagnosing and managing a wide range of medical conditions with a focus on holistic wellness and personalized treatment plans. Passionate about improving lives through preventive care, empathetic communication, and community health outreach.\r\nSpecial interests include [insert specialties if applicable, e.g., Internal Medicine, Pediatrics, Emergency Medicine], and actively engaged in advancing healthcare accessibility and innovation.', 600.00, '1744641093_photo_2025-04-14_20-29-20.jpg'),
(10, 'MD.Abrar Hasnat', '01749591599', 'abrar2305101263@diu.edu.bd', 'Neurology', 'Bangladesh Medical ', '8:00-9:30', '5:00-12:00', 23, 'Male', 'Dr. Md. Abrar Hasnat is a skilled neurologist dedicated to diagnosing and treating disorders of the brain, spine, and nervous system. Serving at Bangladesh Hospital, he combines advanced medical knowledge with compassionate care to help patients manage conditions such as epilepsy, stroke, migraines, and neurological disorders with confidence and support.', 600.00, '1744641325_ChatGPT Image Apr 14, 2025, 01_09_51 PM.png'),
(11, 'Shahriar Islam', '01749591580', 'shahriar.islam@diu.edu.bd', 'Physician', 'Bangladesh Medical ', '9:00-12:00', '5:00-12:00', 23, 'Male', 'A devoted and caring medical professional with a deep commitment to patient-centered care, evidence-based medicine, and ongoing education. Experienced in diagnosing and treating a broad spectrum of health conditions, with an emphasis on holistic well-being and individualized treatment approaches. Passionate about transforming lives through preventive health measures, compassionate communication, and community health programs', 600.00, '1744642165_photo_2025-04-14_20-44-50.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_price_history`
--

CREATE TABLE `product_price_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `new_price` decimal(10,2) DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_price_history`
--

INSERT INTO `product_price_history` (`id`, `product_id`, `old_price`, `new_price`, `changed_at`) VALUES
(1, 106, 220.00, 220000.00, '2025-04-14 13:59:41'),
(2, 107, 220.00, 220000.00, '2025-04-14 13:59:41'),
(3, 124, 7868626.00, 9898.00, '2025-04-14 20:15:19');

-- --------------------------------------------------------

--
-- Table structure for table `reward_point_history`
--

CREATE TABLE `reward_point_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblappointments`
--

CREATE TABLE `tblappointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `payment_method` varchar(20) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `tblappointments`
--
DELIMITER $$
CREATE TRIGGER `after_appointment_cancel` AFTER UPDATE ON `tblappointments` FOR EACH ROW BEGIN
IF NEW.status = 'Cancelled' AND OLD.status != 'Cancelled' THEN
INSERT INTO reward_point_history (user_id, appointment_id, message)
VALUES (NEW.user_id, NEW.id,
CONCAT('Your appointment has been cancelled. Your payment of ',
NEW.amount_paid, ' Taka will be refunded within 24 hours.'));
IF OLD.payment_method = 'reward_points' THEN
UPDATE tbluser
SET reward_points = reward_points + OLD.amount_paid
WHERE Id = OLD.user_id;
END IF;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `delivery_address` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(50) NOT NULL,
  `reward_points_used` decimal(10,2) DEFAULT 0.00,
  `reward_points_earned` decimal(10,2) DEFAULT 0.00,
  `tracking` varchar(50) DEFAULT 'Processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `tblorders`
--
DELIMITER $$
CREATE TRIGGER `after_order_insert` AFTER INSERT ON `tblorders` FOR EACH ROW BEGIN
UPDATE tbluser
SET reward_points = reward_points + NEW.reward_points_earned - NEW.reward_points_used
WHERE Id = NEW.user_id;
INSERT INTO reward_point_history (user_id, message)
VALUES (NEW.user_id, CONCAT('Your order #', NEW.order_id, ' has been placed successfully. You earned ', NEW.reward_points_earned, ' reward points!'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `Id` int(11) NOT NULL,
  `Pname` varchar(255) NOT NULL,
  `Pprice` decimal(10,2) NOT NULL,
  `Pimage` varchar(255) NOT NULL,
  `Pcategory` varchar(100) NOT NULL,
  `Pdescription` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`Id`, `Pname`, `Pprice`, `Pimage`, `Pcategory`, `Pdescription`, `created_at`) VALUES
(50, 'Napa One', 2.00, 'Upload_image/napa_1 (Custom).jpeg', 'Medecine', 'Napa One 1000 mg is indicated for fever, common cold and influenza, headache, toothache, earache, bodyache, myalgia, neuralgia, dysmenorrhoea, sprains, colic pain, back pain, post-operative pain, postpartum pain, inflammatory pain and post vaccination pain in children.', '2025-04-14 06:00:23'),
(51, 'Napa One', 2.00, 'Upload_image/napa_1 (Custom).jpeg', 'Home', 'Napa One 1000 mg is indicated for fever, common cold and influenza, headache, toothache, earache, bodyache, myalgia, neuralgia, dysmenorrhoea, sprains, colic pain, back pain, post-operative pain, postpartum pain, inflammatory pain and post vaccination pain in children.', '2025-04-14 06:00:23'),
(52, 'Napa Extend', 2.00, 'Upload_image/Napa_extend (Custom).jpeg', 'Medecine', 'Napa Extend Tablet is used for the relief of fever and the relief of mild to moderate pain including: headache, migraine, toothache, pain after dental procedures, neuralgia, muscular aches and joint pains, pain of osteoarthritis, rheumatic pain, period pain, pain after vaccination, sore throat and the discomfort from', '2025-04-14 06:01:03'),
(53, 'Napa Extend', 2.00, 'Upload_image/Napa_extend (Custom).jpeg', 'Home', 'Napa Extend Tablet is used for the relief of fever and the relief of mild to moderate pain including: headache, migraine, toothache, pain after dental procedures, neuralgia, muscular aches and joint pains, pain of osteoarthritis, rheumatic pain, period pain, pain after vaccination, sore throat and the discomfort from', '2025-04-14 06:01:03'),
(54, 'Fexo Tablet 120mg', 9.00, 'Upload_image/Fexo Tablet 120mg (Custom).png', 'Medecine', 'Fexo 120mg Tablet is an anti-allergy medicine used in the treatment of allergic symptoms such as runny nose, congestion or stuffiness, sneezing, itching, swelling, and watery eyes. It also helps treat skin allergies with itching, redness, or swelling.', '2025-04-14 06:02:03'),
(55, 'Fexo Tablet 120mg', 9.00, 'Upload_image/Fexo Tablet 120mg (Custom).png', 'Home', 'Fexo 120mg Tablet is an anti-allergy medicine used in the treatment of allergic symptoms such as runny nose, congestion or stuffiness, sneezing, itching, swelling, and watery eyes. It also helps treat skin allergies with itching, redness, or swelling.', '2025-04-14 06:02:03'),
(66, 'Joytrip 300mcg', 10.00, 'Upload_image/joytrip (Custom).png', 'Medecine', 'Joytrip 300mcg is a medication that contains LSD (Lysergic Acid Diethylamide) in microdose form. It is used for enhancing mood, creativity, and mental clarity. Typically taken in small, non-hallucinogenic doses, it may support focus and emotional balance. This product is not intended for recreational use and should be used responsibly. Always consult a healthcare professional before use, especially for mental health concerns.', '2025-04-14 06:31:03'),
(67, 'Joytrip 300mcg', 10.00, 'Upload_image/joytrip (Custom).png', 'Home', 'Joytrip 300mcg is a medication that contains LSD (Lysergic Acid Diethylamide) in microdose form. It is used for enhancing mood, creativity, and mental clarity. Typically taken in small, non-hallucinogenic doses, it may support focus and emotional balance. This product is not intended for recreational use and should be used responsibly. Always consult a healthcare professional before use, especially for mental health concerns.', '2025-04-14 06:31:03'),
(68, 'Mediplus Fluoride Gel', 100.00, 'Upload_image/Mediplus Fluoride Gel (Custom).png', 'Medecine', 'Mediplus Fluoride Gel Toothpaste 100 gm is a fluoride-enriched gel toothpaste designed to promote oral health. It helps prevent cavities and strengthens tooth enamel, offering protection against acid erosion. The toothpaste provides relief from tooth sensitivity and includes a gentle whitening system to remove surface stains. ', '2025-04-14 06:32:51'),
(69, 'Mediplus Fluoride Gel', 100.00, 'Upload_image/Mediplus Fluoride Gel (Custom).png', 'Home', 'Mediplus Fluoride Gel Toothpaste 100 gm is a fluoride-enriched gel toothpaste designed to promote oral health. It helps prevent cavities and strengthens tooth enamel, offering protection against acid erosion. The toothpaste provides relief from tooth sensitivity and includes a gentle whitening system to remove surface stains. ', '2025-04-14 06:32:51'),
(70, 'Himalaya Face Wash ', 229.00, 'Upload_image/HIMALAYA FACE WASH (Custom).png', 'Medecine', 'Himalaya Face Wash is a herbal cleanser made with natural ingredients like neem, aloe vera, and turmeric, designed to gently purify the skin. It helps fight acne, remove excess oil, and maintain a clear, healthy complexion without over-drying. Suitable for daily use and all skin types.', '2025-04-14 06:38:32'),
(71, 'Himalaya Face Wash ', 229.00, 'Upload_image/HIMALAYA FACE WASH (Custom).png', 'Home', 'Himalaya Face Wash is a herbal cleanser made with natural ingredients like neem, aloe vera, and turmeric, designed to gently purify the skin. It helps fight acne, remove excess oil, and maintain a clear, healthy complexion without over-drying. Suitable for daily use and all skin types.', '2025-04-14 06:38:32'),
(72, 'Sensodyne Fresh Mint ', 180.00, 'Upload_image/SENSODYNE FRESH MINT (Custom).png', 'Medecine', 'sensodyne fresh mint is a toothpaste specifically designed for people with sensitive teeth. It provides gentle yet effective cleaning while offering a fresh mint flavor, helping to relieve tooth sensitivity and protect against cavities. Its formula strengthens enamel and provides long-lasting protection.', '2025-04-14 06:45:02'),
(73, 'Sensodyne Fresh Mint ', 180.00, 'Upload_image/SENSODYNE FRESH MINT (Custom).png', 'Home', 'sensodyne fresh mint is a toothpaste specifically designed for people with sensitive teeth. It provides gentle yet effective cleaning while offering a fresh mint flavor, helping to relieve tooth sensitivity and protect against cavities. Its formula strengthens enamel and provides long-lasting protection.', '2025-04-14 06:45:02'),
(74, 'Monas Tablet 10mg', 18.00, 'Upload_image/Monas Tablet 10mg.png', 'Medecine', 'Monas is indicated for:Prophylaxis and chronic treatment of asthma.Acute prevention of Exercise-Induced Bronchoconstriction (EIB).Relief of symptoms of Allergic Rhinitis (AR): Seasonal & Perennial Allergic Rhinitis.', '2025-04-14 06:50:50'),
(75, 'Monas Tablet 10mg', 18.00, 'Upload_image/Monas Tablet 10mg.png', 'Home', 'Monas is indicated for:Prophylaxis and chronic treatment of asthma.Acute prevention of Exercise-Induced Bronchoconstriction (EIB).Relief of symptoms of Allergic Rhinitis (AR): Seasonal & Perennial Allergic Rhinitis.', '2025-04-14 06:50:50'),
(76, 'Seclo Capsule 20mg', 6.00, 'Upload_image/Seclo Capsule 20mg.png', 'Medecine', 'Seclo is indicated for the treatment of-Gastric and duodenal ulcer.NSAID-associated duodenal and gastric ulcer.As prophylaxis in patients with a history of NSAID-associated duodenal and gastric ulcer Gastro-esophageal reflux disease.Long-term management of acid reflux disease.Acid-related dyspepsia.', '2025-04-14 06:55:13'),
(77, 'Seclo Capsule 20mg', 6.00, 'Upload_image/Seclo Capsule 20mg.png', 'Home', 'Seclo is indicated for the treatment of-Gastric and duodenal ulcer.NSAID-associated duodenal and gastric ulcer.As prophylaxis in patients with a history of NSAID-associated duodenal and gastric ulcer Gastro-esophageal reflux disease.Long-term management of acid reflux disease.Acid-related dyspepsia.', '2025-04-14 06:55:13'),
(78, 'Febustat Tablet 40mg', 13.00, 'Upload_image/Febustat Tablet 40mg.png', 'Medecine', 'Febustat tablets are indicated for the chronic management of hyperuricemia in patients with gout. Febustat tablets are not recommended for the treatment of asymptomatic hyperuricemia.', '2025-04-14 07:09:00'),
(79, 'Febustat Tablet 40mg', 13.00, 'Upload_image/Febustat Tablet 40mg.png', 'Home', 'Febustat tablets are indicated for the chronic management of hyperuricemia in patients with gout. Febustat tablets are not recommended for the treatment of asymptomatic hyperuricemia.', '2025-04-14 07:09:00'),
(80, 'Dexpoten Plus Syrup 100ml', 110.00, 'Upload_image/Screenshot 2025-04-14 131726.png', 'Syrup', 'This preparation is a mixture of antitussive, decongestant and antihistamine agent. Dextromethorphan is a safe, effective, non-narcotic antitussive agent which has a central action on the cough centre in the medulla.', '2025-04-14 07:36:12'),
(81, 'Dexpoten Plus Syrup 100ml', 110.00, 'Upload_image/Screenshot 2025-04-14 131726.png', 'Home', 'This preparation is a mixture of antitussive, decongestant and antihistamine agent. Dextromethorphan is a safe, effective, non-narcotic antitussive agent which has a central action on the cough centre in the medulla.', '2025-04-14 07:36:12'),
(82, 'Tusca Plus Syrup 100ml', 85.00, 'Upload_image/Screenshot 2025-04-14 131925.png', 'Syrup', 'Guaifenesin is reported to reduce the viscosity of tenacious sputum end is used as an expectorant. Levomenthol has mild local anesthetic and decongestant properties. Diphenhydramine Hydrochloride possesses antitussive, antihistaminic, and anticholinergic properties.', '2025-04-14 07:38:28'),
(83, 'Tusca Plus Syrup 100ml', 85.00, 'Upload_image/Screenshot 2025-04-14 131925.png', 'Home', 'Guaifenesin is reported to reduce the viscosity of tenacious sputum end is used as an expectorant. Levomenthol has mild local anesthetic and decongestant properties. Diphenhydramine Hydrochloride possesses antitussive, antihistaminic, and anticholinergic properties.', '2025-04-14 07:38:28'),
(84, 'Adovas Syrup 200ml', 110.00, 'Upload_image/Screenshot 2025-04-14 132029.png', 'Syrup', 'Adhatoda vasica (Basok): Relieves cough & bronchial spasm. It liquefies mucous.Piper longum (Pipul): Relieves cold allergy & asthma.Glycyrrhiza glabra (Jashthi Modhu) : Relieves irritation of throat. Enhances the immune system. It is anti-inflammatory, demulcent & expectorant.', '2025-04-14 07:40:10'),
(85, 'Adovas Syrup 200ml', 110.00, 'Upload_image/Screenshot 2025-04-14 132029.png', 'Home', 'Adhatoda vasica (Basok): Relieves cough & bronchial spasm. It liquefies mucous.Piper longum (Pipul): Relieves cold allergy & asthma.Glycyrrhiza glabra (Jashthi Modhu) : Relieves irritation of throat. Enhances the immune system. It is anti-inflammatory, demulcent & expectorant.', '2025-04-14 07:40:10'),
(86, 'Adovas Syrup 100ml', 70.00, 'Upload_image/Screenshot 2025-04-14 132148.png', 'Syrup', 'This syrup is a preparation of a combination of effective herbs which is helpful in all types of cough & cold. The used herbs are well tolerated, safe & non-sedating with potent antiallergic properties. DEVAS syrup is good for both children and adults. It is free of side effects.', '2025-04-14 07:43:35'),
(87, 'Adovas Syrup 100ml', 70.00, 'Upload_image/Screenshot 2025-04-14 132148.png', 'Home', 'This syrup is a preparation of a combination of effective herbs which is helpful in all types of cough & cold. The used herbs are well tolerated, safe & non-sedating with potent antiallergic properties. DEVAS syrup is good for both children and adults. It is free of side effects.', '2025-04-14 07:43:35'),
(90, 'Dextrim Syrup 100ml', 100.00, 'Upload_image/Screenshot 2025-04-14 133245.png', 'Syrup', 'This preparation is a mixture of antitussive, decongestant and antihistamine agent. Dextromethorphan is a safe, effective, non-narcotic antitussive agent which has a central action on the cough centre in the medulla. Although structurally related to Morphine, it has no analgesic and habit forming properties and in general it has little sedative activity.', '2025-04-14 07:44:40'),
(91, 'Dextrim Syrup 100ml', 100.00, 'Upload_image/Screenshot 2025-04-14 133245.png', 'Home', 'This preparation is a mixture of antitussive, decongestant and antihistamine agent. Dextromethorphan is a safe, effective, non-narcotic antitussive agent which has a central action on the cough centre in the medulla. Although structurally related to Morphine, it has no analgesic and habit forming properties and in general it has little sedative activity.', '2025-04-14 07:44:40'),
(92, 'Beclomin Inhaler 100mcg/puff', 270.00, 'Upload_image/Screenshot 2025-04-14 133314.png', 'Syrup', 'Beclomethasone dipropionate produces anti-inflammatory and vasoconstrictor effects. The mechanisms responsible for the anti-inflammatory action of beclomethasone dipropionate are unknown. ', '2025-04-14 07:45:09'),
(93, 'Beclomin Inhaler 100mcg/puff', 270.00, 'Upload_image/Screenshot 2025-04-14 133314.png', 'Home', 'Beclomethasone dipropionate produces anti-inflammatory and vasoconstrictor effects. The mechanisms responsible for the anti-inflammatory action of beclomethasone dipropionate are unknown. ', '2025-04-14 07:45:09'),
(96, 'Urinary Catheter Bag', 28.00, 'Upload_image/Screenshot 2025-04-14 194929.png', 'Equipment', 'Kink resistant tube, 2000 ml capacity, soft clinical grade PVC sheeting, non-return valve, easy to read both in adult and pediatric, single-use, 20 pcs in a box.', '2025-04-14 13:50:49'),
(97, 'Urinary Catheter Bag', 28.00, 'Upload_image/Screenshot 2025-04-14 194929.png', 'Home', 'Kink resistant tube, 2000 ml capacity, soft clinical grade PVC sheeting, non-return valve, easy to read both in adult and pediatric, single-use, 20 pcs in a box.', '2025-04-14 13:50:49'),
(98, 'Dayang DY072001S Medical IV Stand', 4500.00, 'Upload_image/Screenshot 2025-04-14 194900.png', 'Equipment', 'Dayang DY072001S is a medical IV stand manufactured using a quality chromed steel base. Its robust, telescopic, stainless steel rod can be easily adjusted with a positive locking hand wheel. It has 5 strong wheels for movement so it can be easily moved to any room.', '2025-04-14 13:52:08'),
(99, 'Dayang DY072001S Medical IV Stand', 4500.00, 'Upload_image/Screenshot 2025-04-14 194900.png', 'Home', 'Dayang DY072001S is a medical IV stand manufactured using a quality chromed steel base. Its robust, telescopic, stainless steel rod can be easily adjusted with a positive locking hand wheel. It has 5 strong wheels for movement so it can be easily moved to any room.', '2025-04-14 13:52:08'),
(100, 'ER-005 3 in 1 Ear cleaner Camera for Android and PC', 1500.00, 'Upload_image/Screenshot 2025-04-14 195320.png', 'Equipment', 'Endoscope 3 in 1 ear cleaning tools support android phones and PC with an electronic micro-camera that can show the whole process of extracting the ear canal in real-time via the USB data cable.', '2025-04-14 13:53:42'),
(101, 'ER-005 3 in 1 Ear cleaner Camera for Android and PC', 1500.00, 'Upload_image/Screenshot 2025-04-14 195320.png', 'Home', 'Endoscope 3 in 1 ear cleaning tools support android phones and PC with an electronic micro-camera that can show the whole process of extracting the ear canal in real-time via the USB data cable.', '2025-04-14 13:53:42'),
(102, 'Beyond BYZ-810 Syringe Pump', 38000.00, 'Upload_image/Screenshot 2025-04-14 195456.png', 'Equipment', '4.3 inch HD LCD display, high power sound, friendly user interface, dynamically display working status. Audible and visual alarm for expansion, empty, empty, low battery, end of a charge, syringe loss, for the incorrect setting. Compatible with 5/10/20/30/50 / 60ml syringes of any brand. The number of preset solutions to reduce the workload of nurses. Three functional modes and three levels of termination purge and ball function.', '2025-04-14 13:55:36'),
(103, 'Beyond BYZ-810 Syringe Pump', 38000.00, 'Upload_image/Screenshot 2025-04-14 195456.png', 'Home', '4.3 inch HD LCD display, high power sound, friendly user interface, dynamically display working status. Audible and visual alarm for expansion, empty, empty, low battery, end of a charge, syringe loss, for the incorrect setting. Compatible with 5/10/20/30/50 / 60ml syringes of any brand. The number of preset solutions to reduce the workload of nurses. Three functional modes and three levels of termination purge and ball function.', '2025-04-14 13:55:36'),
(104, 'Tynor Compression Stocking Below Knee Classic', 1500.00, 'Upload_image/Screenshot 2025-04-14 195701.png', 'Equipment', 'This stocking below knee classic from Tynor can be used as a lower knee support. It can prevent abnormal blood flow in your knee by controlling compression. It also compresses the outer walls of superficial veins to prevent varicose veins. This item is suitable for both men & women.', '2025-04-14 13:57:19'),
(105, 'Tynor Compression Stocking Below Knee Classic', 1500.00, 'Upload_image/Screenshot 2025-04-14 195701.png', 'Home', 'This stocking below knee classic from Tynor can be used as a lower knee support. It can prevent abnormal blood flow in your knee by controlling compression. It also compresses the outer walls of superficial veins to prevent varicose veins. This item is suitable for both men & women.', '2025-04-14 13:57:19'),
(106, 'TMI-1209 Derma Chair', 220000.00, 'Upload_image/Screenshot 2025-04-14 195829.png', 'Equipment', 'TMI-1209 derma chair is compatible with all cosmetology, dermatology, and laser surgery. It includes three independent motors that help to adjust the height, leg section, and back section. Additionally, contains a remote control that can be used to automatically adjust the height, leg section, and back part. This derma chair is made of medical-grade stainless steel, which makes it hygienic and long-lasting.', '2025-04-14 13:58:54'),
(107, 'TMI-1209 Derma Chair', 220000.00, 'Upload_image/Screenshot 2025-04-14 195829.png', 'Home', 'TMI-1209 derma chair is compatible with all cosmetology, dermatology, and laser surgery. It includes three independent motors that help to adjust the height, leg section, and back section. Additionally, contains a remote control that can be used to automatically adjust the height, leg section, and back part. This derma chair is made of medical-grade stainless steel, which makes it hygienic and long-lasting.', '2025-04-14 13:58:54'),
(108, 'Infitek PR5-250 Single Door Laboratory Refrigerator', 250000.00, 'Upload_image/Screenshot 2025-04-14 200058.png', 'Equipment', 'This Infitek PR5-250 Single Door Laboratory Refrigerator designed with a capacity of 226 liters. It utilizes a forced air cooling system to maintain a stable temperature range of 2 to 8 degrees Celsius. It has an auto defrost function and a microprocessor temperature controller, that ensures precise climate control for laboratory applications.', '2025-04-14 14:01:25'),
(109, 'Infitek PR5-250 Single Door Laboratory Refrigerator', 250000.00, 'Upload_image/Screenshot 2025-04-14 200058.png', 'Home', 'This Infitek PR5-250 Single Door Laboratory Refrigerator designed with a capacity of 226 liters. It utilizes a forced air cooling system to maintain a stable temperature range of 2 to 8 degrees Celsius. It has an auto defrost function and a microprocessor temperature controller, that ensures precise climate control for laboratory applications.', '2025-04-14 14:01:25'),
(110, 'Aeonmed Shangrila 510S Portable Ventilator', 480000.00, 'Upload_image/Screenshot 2025-04-14 200217.png', 'Equipment', 'The Aeonmed Shangrila 510S is a state-of-the-art portable ventilator that provides advanced respiratory support and is easy to carry. This ventilator is designed with the latest technology that offers powerful versatile performance. Moreover, it is suitable for providing a wide range of clinical services. This portable ventilator has a 5\" LCD screen display, and it provides 4.5 hours of battery operating time.', '2025-04-14 14:02:51'),
(111, 'Aeonmed Shangrila 510S Portable Ventilator', 480000.00, 'Upload_image/Screenshot 2025-04-14 200217.png', 'Home', 'The Aeonmed Shangrila 510S is a state-of-the-art portable ventilator that provides advanced respiratory support and is easy to carry. This ventilator is designed with the latest technology that offers powerful versatile performance. Moreover, it is suitable for providing a wide range of clinical services. This portable ventilator has a 5\" LCD screen display, and it provides 4.5 hours of battery operating time.', '2025-04-14 14:02:51'),
(112, 'Urine Collector Bag', 1000.00, 'Upload_image/Screenshot 2025-04-14 200408.png', 'Equipment', 'This Urine Collector Bag is made of Silicone + cotton Material. It is leakproof so it does not spoil easily and can be used for a long time. This bag has a urine capacity of 1000/2000 ml. It is suitable for the sick, old, weak, disabled, paralysis, fractures, urinary frequency, urinary urgency, urinary incontinence, etc.', '2025-04-14 14:04:47'),
(113, 'Urine Collector Bag', 1000.00, 'Upload_image/Screenshot 2025-04-14 200408.png', 'Home', 'This Urine Collector Bag is made of Silicone + cotton Material. It is leakproof so it does not spoil easily and can be used for a long time. This bag has a urine capacity of 1000/2000 ml. It is suitable for the sick, old, weak, disabled, paralysis, fractures, urinary frequency, urinary urgency, urinary incontinence, etc.', '2025-04-14 14:04:47'),
(114, 'White Medical Apron', 500.00, 'Upload_image/Screenshot 2025-04-14 200555.png', 'Equipment', 'This is the best quality medical apron suitable for doctors, medical colleges / hospitals, laboratories, nursing homes etc. This apron is made from very high and fine quality raw material fabric which ensures high durability at the end of the user.', '2025-04-14 14:06:28'),
(115, 'White Medical Apron', 500.00, 'Upload_image/Screenshot 2025-04-14 200555.png', 'Home', 'This is the best quality medical apron suitable for doctors, medical colleges / hospitals, laboratories, nursing homes etc. This apron is made from very high and fine quality raw material fabric which ensures high durability at the end of the user.', '2025-04-14 14:06:28'),
(116, 'KY-C4 Emergency Medicine Trolley', 55000.00, 'Upload_image/Screenshot 2025-04-14 200725.png', 'Equipment', 'This KY-C4 is an emergency medicine trolley which is used in hospital ICU, SDU, CCU, NICU. It holds essential medicines and essential herbs. It has 5 drawers, an IV pole. It is made by ABS plastic material which is strong and can be used for a long time. It has 4 strong wheels, so it can be easily pushed anywhere', '2025-04-14 14:07:49'),
(117, 'KY-C4 Emergency Medicine Trolley', 55000.00, 'Upload_image/Screenshot 2025-04-14 200725.png', 'Home', 'This KY-C4 is an emergency medicine trolley which is used in hospital ICU, SDU, CCU, NICU. It holds essential medicines and essential herbs. It has 5 drawers, an IV pole. It is made by ABS plastic material which is strong and can be used for a long time. It has 4 strong wheels, so it can be easily pushed anywhere', '2025-04-14 14:07:49'),
(118, 'Micomme B5 Sleep Apnea Solution BiPAP Machine', 70000.00, 'Upload_image/Screenshot 2025-04-14 200821.png', 'Equipment', 'Micomme B5 is a BiPAP machine that can be used by patients who are suffering from sleep apnea. This machine includes essential elements that help patients to receive fresh oxygen which increases the possibility of comfortable sleeping during the night.', '2025-04-14 14:08:55'),
(119, 'Micomme B5 Sleep Apnea Solution BiPAP Machine', 70000.00, 'Upload_image/Screenshot 2025-04-14 200821.png', 'Home', 'Micomme B5 is a BiPAP machine that can be used by patients who are suffering from sleep apnea. This machine includes essential elements that help patients to receive fresh oxygen which increases the possibility of comfortable sleeping during the night.', '2025-04-14 14:08:55'),
(120, 'A-Cof Syrup 100ml', 100.00, 'Upload_image/Screenshot 2025-04-14 201156.png', 'Syrup', 'This preparation is a mixture of antitussive, decongestant and antihistamine agent. Dextromethorphan is a safe, effective, non-narcotic antitussive agent which has a central action on the cough centre in the medulla. Although structurally related to Morphine, it has no analgesic and habit forming properties and in general it has little sedative activity.', '2025-04-14 14:13:13'),
(121, 'A-Cof Syrup 100ml', 100.00, 'Upload_image/Screenshot 2025-04-14 201156.png', 'Home', 'This preparation is a mixture of antitussive, decongestant and antihistamine agent. Dextromethorphan is a safe, effective, non-narcotic antitussive agent which has a central action on the cough centre in the medulla. Although structurally related to Morphine, it has no analgesic and habit forming properties and in general it has little sedative activity.', '2025-04-14 14:13:13'),
(122, 'Valoate Syrup 200mg/100ml', 100.00, 'Upload_image/Screenshot 2025-04-14 201457.png', 'Syrup', 'Sodium Valproate, the active ingredient of this preparation is endowed with anti-epileptic activity against a variety of seizures. The mechanism by which Sodium Valproate exerts its anti-epileptic effects has not been established. However, it has been suggested that its activity is related to increase brain levels of gamma-aminobutyric acid (GABA).', '2025-04-14 14:15:34'),
(123, 'Valoate Syrup 200mg/100ml', 100.00, 'Upload_image/Screenshot 2025-04-14 201457.png', 'Home', 'Sodium Valproate, the active ingredient of this preparation is endowed with anti-epileptic activity against a variety of seizures. The mechanism by which Sodium Valproate exerts its anti-epileptic effects has not been established. However, it has been suggested that its activity is related to increase brain levels of gamma-aminobutyric acid (GABA).', '2025-04-14 14:15:34'),
(124, 'gdjggja', 9898.00, 'Upload_image/20250412_124751.mp4', 'Medecine', 'asopapapiaspiaspisap', '2025-04-14 20:14:51');

--
-- Triggers `tblproduct`
--
DELIMITER $$
CREATE TRIGGER `before_product_update` BEFORE UPDATE ON `tblproduct` FOR EACH ROW BEGIN
IF NEW.Pprice != OLD.Pprice THEN
INSERT INTO product_price_history (product_id, old_price, new_price)
VALUES (OLD.Id, OLD.Pprice, NEW.Pprice);
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `Id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Number` varchar(200) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `reward_points` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointment_id_2` (`appointment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `product_price_history`
--
ALTER TABLE `product_price_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reward_point_history`
--
ALTER TABLE `reward_point_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `tblappointments`
--
ALTER TABLE `tblappointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `product_price_history`
--
ALTER TABLE `product_price_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reward_point_history`
--
ALTER TABLE `reward_point_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblappointments`
--
ALTER TABLE `tblappointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`Id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`appointment_id`) REFERENCES `tblappointments` (`id`);

--
-- Constraints for table `product_price_history`
--
ALTER TABLE `product_price_history`
  ADD CONSTRAINT `product_price_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tblproduct` (`Id`);

--
-- Constraints for table `reward_point_history`
--
ALTER TABLE `reward_point_history`
  ADD CONSTRAINT `reward_point_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`Id`),
  ADD CONSTRAINT `reward_point_history_ibfk_2` FOREIGN KEY (`appointment_id`) REFERENCES `tblappointments` (`id`);

--
-- Constraints for table `tblappointments`
--
ALTER TABLE `tblappointments`
  ADD CONSTRAINT `tblappointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`Id`),
  ADD CONSTRAINT `tblappointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD CONSTRAINT `tblcart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`Id`);

--
-- Constraints for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD CONSTRAINT `tblorders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
