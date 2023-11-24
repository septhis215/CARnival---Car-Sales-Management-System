-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 09:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `carmodel`
--

CREATE TABLE `carmodel` (
  `modelID` int(30) NOT NULL,
  `manufacturerID` int(30) NOT NULL,
  `model` text NOT NULL,
  `engineType` text NOT NULL,
  `transmissionType` text NOT NULL,
  `carTypeID` int(30) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carmodel`
--

INSERT INTO `carmodel` (`modelID`, `manufacturerID`, `model`, `engineType`, `transmissionType`, `carTypeID`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(29, 27, 'Accord', 'Inline-4 Cylinder', 'Automatic', 10, 'The Honda Accord is a popular midsize sedan known for its reliability, comfort, and advanced technology features. It offers a smooth ride, spacious interior, and excellent fuel efficiency, making it a top choice for families and commuters.', 1, 0, '2023-10-26 20:20:31', '2023-10-26 20:20:31'),
(30, 27, 'CR-V', 'Turbocharged Inline-4 Cylinder', 'Continuously Variable Transmission (CVT)', 15, 'The Honda CR-V is a compact SUV renowned for its practicality and versatility. It boasts a spacious cabin, ample cargo space, and a comfortable ride. With advanced safety features and modern technology, the CR-V is a favorite among SUV enthusiasts.', 1, 0, '2023-10-26 20:21:10', '2023-10-26 20:21:10'),
(31, 27, 'Civic Hatchback', 'Inline-4 Cylinder', 'Manual (6-speed)', 14, 'The Honda Civic Hatchback combines sporty styling with practicality. It offers a responsive handling experience, a turbocharged engine for added performance, and a flexible cargo area. With its sleek design and spirited driving dynamics, it appeals to enthusiasts and urban drivers alike.', 1, 0, '2023-10-26 20:21:49', '2023-10-26 20:21:49'),
(32, 27, 'Civic Coupe', 'Inline-4 Cylinder', 'Automatic (CVT)', 19, 'The Honda Civic Coupe is a stylish two-door car known for its sleek design and agile performance. It features a well-appointed interior, user-friendly technology, and impressive fuel efficiency. The Civic Coupe offers a spirited driving experience and a youthful appeal.', 1, 0, '2023-10-26 20:23:45', '2023-10-26 20:23:45'),
(33, 27, 'Civic Type R', 'Turbocharged Inline-4 Cylinder', 'Manual (6-speed)', 10, 'The Honda Civic Type R is a high-performance sports car designed for enthusiasts seeking exhilarating driving experiences. With aggressive styling, a powerful turbocharged engine, and precise handling, the Civic Type R delivers impressive performance on both the road and the track. It&#039;s equipped with sport-tuned suspension and aerodynamic enhancements, making it a favorite among performance car enthusiasts.', 1, 0, '2023-10-26 20:25:08', '2023-10-26 20:25:08'),
(34, 27, 'Odyssey', 'V6', 'Automatic (10-speed)', 13, 'The Honda Odyssey is a family-friendly minivan designed with comfort and convenience in mind. It provides spacious seating for passengers, versatile cargo options, and a plethora of family-oriented features. With advanced safety technologies and a smooth ride, the Odyssey is a top choice for families on the go.', 1, 0, '2023-10-26 20:26:18', '2023-10-26 20:26:18'),
(35, 57, 'ES', 'V6 Engine', 'Automatic', 10, 'The Lexus ES is a luxurious sedan known for its elegant design, comfortable interior, and smooth ride. It offers advanced technology features and a refined driving experience, making it a popular choice among luxury sedan enthusiasts.', 1, 0, '2023-10-26 20:31:47', '2023-10-26 20:31:47'),
(36, 57, 'RX', 'V6 Engine (Hybrid Available)', 'Automatic', 15, 'The Lexus RX is a premium SUV that combines style, performance, and versatility. With a spacious interior, cutting-edge safety features, and an optional hybrid powertrain, the RX delivers a blend of luxury and efficiency for SUV enthusiasts.', 1, 0, '2023-10-26 20:32:34', '2023-10-26 20:32:34'),
(37, 57, 'IS', 'V8 Engine', 'Automatic', 10, 'The Lexus IS F is a high-performance sedan engineered for speed and precision. It boasts a powerful V8 engine, sport-tuned suspension, and aggressive styling. Designed for driving enthusiasts, the IS F offers exhilarating acceleration and dynamic handling.', 1, 0, '2023-10-26 20:33:24', '2023-10-26 21:38:55'),
(38, 57, 'LC', 'V8 Engine (Hybrid Available)', 'Automatic', 19, 'The Lexus LC is a stunning luxury coupe that combines breathtaking design with impressive performance. With a choice of V8 or hybrid powertrains, the LC offers a harmonious balance of power, agility, and elegance. Its interior is crafted with high-quality materials and advanced technology, creating a luxurious driving environment.', 1, 0, '2023-10-26 20:34:04', '2023-10-26 20:34:04'),
(39, 57, 'UX', 'Inline-4 Engine (Hybrid Available)', 'Automatic', 15, 'The Lexus UX is a compact luxury SUV designed for urban living. It combines a stylish exterior, a well-appointed interior, and fuel-efficient powertrains. The UX is perfect for those seeking a compact SUV with premium features and eco-friendly options.', 1, 0, '2023-10-26 20:34:42', '2023-10-26 20:34:42'),
(40, 57, 'LX', 'V8 Engine', 'Automatic', 15, 'The Lexus LX is a luxury SUV that combines opulent features with off-road capabilities. It offers a powerful V8 engine, three-row seating, and advanced technology. The LX is ideal for those who desire a luxurious SUV capable of tackling challenging terrains.', 1, 0, '2023-10-26 20:36:06', '2023-10-26 20:36:06'),
(41, 28, 'Mazda3', 'Inline-4 Skyactiv-X Engine', 'Automatic / Manual', 10, 'The Mazda3 is a stylish and agile compact sedan known for its elegant design, responsive handling, and efficient performance. It offers a comfortable interior, advanced infotainment features, and impressive fuel efficiency, making it a popular choice in its class.', 1, 0, '2023-10-26 20:37:09', '2023-10-26 20:41:22'),
(42, 28, 'CX-5', 'Inline-4 Turbocharged Engine', 'Automatic', 15, 'The Mazda CX-5 is a versatile compact SUV that combines sporty driving dynamics with practicality. It features a well-crafted interior, comfortable seating, and advanced safety technologies. The CX-5 offers a smooth ride and excellent handling, making it a favorite among SUV enthusiasts.', 1, 0, '2023-10-26 20:37:48', '2023-10-26 20:41:06'),
(43, 28, 'Mazda6', 'Inline-4 Turbocharged Engine', 'Automatic', 10, 'The Mazda6 is a midsize sedan that blends sophistication with performance. It boasts a premium interior, powerful engine options, and precise handling. With its upscale features and elegant design, the Mazda6 offers a refined driving experience.', 1, 0, '2023-10-26 20:38:22', '2023-10-26 20:41:35'),
(44, 28, 'Mazda2', 'Inline-4 Engine', 'Automatic / Manual', 14, 'The Mazda2 is designed for city driving and efficiency. It features a reliable inline-4 engine, making it an ideal choice for urban commuters.', 1, 0, '2023-10-26 20:42:11', '2023-10-26 20:42:11'),
(45, 28, 'CX-3', 'Inline-4 Engine', 'Automatic', 15, 'The Mazda CX-3 is a subcompact SUV that delivers a blend of style and functionality. It features eye-catching exterior design, a well-appointed interior, and a smooth ride. The CX-3 is suitable for urban adventures and offers convenient features for modern lifestyles.', 1, 0, '2023-10-26 20:42:57', '2023-10-26 20:42:57'),
(46, 28, 'MX-30 EV', 'Electric Motor', 'Automatic', 15, 'The Mazda MX-30 EV is Mazda&#039;s electric SUV offering zero-emission driving. It features a distinctive design, comfortable interior, and eco-friendly electric powertrain. The MX-30 EV is designed for environmentally conscious drivers looking for a sustainable driving solution.', 1, 0, '2023-10-26 20:43:45', '2023-10-26 20:43:45'),
(47, 23, 'Sentra', 'Inline-4 Engine', 'Automatic / Manual', 10, 'The Nissan Sentra is a reliable and fuel-efficient compact sedan. It offers a comfortable interior, modern technology features, and smooth handling, making it an excellent choice for everyday commuting.', 1, 0, '2023-10-26 20:45:19', '2023-10-26 20:45:19'),
(48, 23, 'Altima', 'V6 Engine ', 'Automatic', 10, 'The Nissan Altima is a midsize sedan known for its strong performance and spacious cabin. It combines a comfortable ride with capable engine options, providing a balanced driving experience.', 1, 0, '2023-10-26 20:45:54', '2023-10-26 20:45:54'),
(49, 23, 'Rogue', ' Inline-4 Engine', 'Automatic / CVT', 15, 'The Nissan Rogue is a popular compact SUV offering versatility and practicality. It features a well-designed interior, advanced safety technologies, and ample cargo space, making it ideal for families and adventurers.', 1, 0, '2023-10-26 20:46:27', '2023-10-26 20:46:27'),
(50, 23, 'Maxima', 'V6 Engine', 'Automatic', 10, 'The Nissan Maxima is a full-size sedan that emphasizes performance and luxury. It boasts a powerful V6 engine, upscale interior materials, and sporty handling. The Maxima provides a blend of comfort and sportiness in the full-size sedan segment.', 1, 0, '2023-10-26 20:47:08', '2023-10-26 20:47:08'),
(51, 23, 'Leaf', 'Electric Motor', 'Automatic', 14, 'The Nissan Leaf is a well-known electric car recognized for its eco-friendly performance and practicality. It offers a smooth and silent ride, ample range on a single charge, and modern features, making it a popular choice among electric vehicle enthusiasts.', 1, 0, '2023-10-26 20:47:59', '2023-10-26 20:47:59'),
(52, 23, 'Frontier', 'V6 Engine', 'Automatic / Manual', 12, 'The Nissan Frontier is a reliable midsize pickup truck offering robust performance and off-road capabilities. It features a sturdy V6 engine, towing capabilities, and a durable design, making it suitable for both work and leisure activities.', 1, 0, '2023-10-26 20:48:25', '2023-10-26 20:48:25'),
(53, 25, 'Axia', 'Inline-3 Engine', 'Automatic / Manual', 14, 'The Perodua Axia is a compact hatchback offering practicality and fuel efficiency. It is suitable for city driving, featuring a compact size, easy maneuverability, and comfortable interior.', 1, 0, '2023-10-26 20:49:39', '2023-10-26 20:49:39'),
(54, 25, 'Bezza', 'Inline-4 Engine', 'Automatic / Manual', 10, 'The Perodua Bezza is a compact sedan known for its economical fuel consumption and spacious cabin. It provides a smooth and comfortable ride, making it a popular choice for budget-conscious sedan buyers.', 1, 0, '2023-10-26 20:50:08', '2023-10-26 20:50:08'),
(55, 25, 'Ativa', 'Turbocharged Inline-3 Engine', 'Automatic', 15, 'The Perodua Ativa, also known as D55L in some regions, is a compact SUV equipped with modern technology and safety features. It offers a stylish design, responsive handling, and efficient performance, making it an attractive choice in the compact SUV segment.', 1, 0, '2023-10-26 20:50:52', '2023-10-26 20:50:52'),
(56, 25, 'Myvi', 'Inline-4 Engine', 'Automatic / Manual', 14, 'The Perodua Myvi is a popular hatchback known for its reliability and practicality. It features a spacious interior, user-friendly infotainment system, and smooth driving experience, making it a favorite among hatchback enthusiasts.', 1, 0, '2023-10-26 20:51:24', '2023-10-26 20:51:24'),
(57, 25, 'Alza', 'Inline-4 Engine', 'Automatic / Manual', 13, 'The Perodua Alza is a compact MPV offering versatility and ample seating capacity. It provides comfortable seating for families, flexible cargo space, and convenient features, making it suitable for family outings and daily use.', 1, 0, '2023-10-26 20:51:46', '2023-10-26 20:51:46'),
(58, 25, 'Kembara', 'Inline-4 Engine', 'Automatic / Manual', 15, 'The Perodua Kembara was a compact SUV produced by Perodua in the past. It offered off-road capabilities and a sturdy design, making it suitable for outdoor adventures and rough terrains.', 1, 0, '2023-10-26 20:52:26', '2023-10-26 20:56:50'),
(59, 24, 'Persona', 'Inline-4 Engine', 'Automatic / Manual', 10, 'The Proton Persona is a compact sedan offering a comfortable ride and practical features. It is known for its spacious interior, fuel efficiency, and modern technology, making it a popular choice among sedan buyers.', 1, 0, '2023-10-26 20:53:33', '2023-10-26 20:53:33'),
(60, 24, 'Iriz', 'Inline-4 Engine', 'Automatic / Manual', 14, 'The Proton Iriz is a versatile hatchback known for its sporty design and agile handling. It comes with advanced safety features, a user-friendly infotainment system, and a peppy engine, making it appealing to hatchback enthusiasts.', 1, 0, '2023-10-26 20:54:02', '2023-10-26 20:54:02'),
(61, 24, 'X50', 'Turbocharged Inline-3 Engine', 'Automatic', 15, 'The Proton X50 is a compact SUV equipped with modern technology and premium features. It offers a comfortable interior, responsive performance, and advanced safety systems, making it a competitive choice in the compact SUV segment.', 1, 0, '2023-10-26 20:54:31', '2023-10-26 20:54:31'),
(62, 24, 'X70', 'Turbocharged Inline-4 Engine', 'Automatic', 15, 'The Proton X70 is a midsize SUV offering a spacious cabin and luxurious features. It provides a smooth and refined ride, advanced infotainment options, and top-notch safety features, making it a popular choice among SUV enthusiasts.', 1, 0, '2023-10-26 20:54:53', '2023-10-27 16:09:20'),
(63, 24, 'Preve', 'Inline-4 Engine', 'Automatic / Manual', 10, 'The Proton Preve is a midsize sedan known for its aerodynamic design and performance-oriented features. It provides a comfortable interior, advanced safety systems, and efficient engine options, making it a value-for-money choice in the sedan segment.', 1, 0, '2023-10-26 20:57:59', '2023-10-26 20:57:59'),
(64, 24, 'Saga', 'Inline-4 Engine', 'Automatic / Manual', 10, 'The Proton Saga is a compact sedan known for its affordability and simplicity. It offers basic features, making it suitable for budget-conscious buyers looking for a reliable and economical sedan.', 1, 0, '2023-10-26 20:58:18', '2023-10-26 20:58:18'),
(65, 26, 'Camry', 'V6 Engine', 'Automatic', 10, 'The Toyota Camry is a midsize sedan known for its reliability, comfort, and advanced technology. It offers a smooth ride, spacious interior, and efficient engine options, making it a popular choice among sedan buyers.', 1, 0, '2023-10-26 20:59:38', '2023-10-26 20:59:38'),
(66, 26, 'RAV4', 'Inline-4 Engine', 'Automatic', 15, 'The Toyota RAV4 is a compact SUV offering versatility and practicality. It features a spacious cabin, excellent fuel efficiency, and a comfortable ride. The RAV4 is known for its strong performance both on and off the road.', 1, 0, '2023-10-26 21:00:16', '2023-10-26 21:00:16'),
(67, 26, 'Prius', 'Hybrid (Inline-4 Engine + Electric Motor)', 'Continuously Variable Transmission (CVT)', 14, 'The Toyota Prius is a hybrid hatchback famous for its exceptional fuel efficiency. It combines a conventional engine with an electric motor, providing eco-friendly driving without compromising on performance. The Prius is a pioneer in hybrid technology.', 1, 0, '2023-10-26 21:00:56', '2023-10-26 21:00:56'),
(68, 26, 'Highlander', 'V6 Engine', 'Automatic', 15, 'The Toyota Highlander is a midsize SUV offering a spacious interior, comfortable seating, and advanced safety features. It provides a smooth and stable ride, making it an ideal choice for families and long journeys.', 1, 0, '2023-10-26 21:02:09', '2023-10-26 21:02:09'),
(69, 26, 'Sienna', 'Hybrid (Inline-4 Engine + Electric Motor)', 'Continuously Variable Transmission (CVT)', 13, 'The Toyota Sienna is a hybrid minivan known for its spacious interior and family-friendly features. It offers comfortable seating, advanced infotainment options, and a smooth ride. The Sienna is an excellent choice for larger families.', 1, 0, '2023-10-26 21:02:56', '2023-10-26 21:02:56'),
(70, 26, 'Land Cruiser', 'V8 Engine', 'Automatic', 15, 'The Toyota Land Cruiser is a full-size SUV renowned for its off-road capabilities, luxury features, and reliability. It offers a powerful engine, sophisticated interior, and advanced technology, making it suitable for both urban and off-road driving.', 1, 0, '2023-10-26 21:03:32', '2023-10-26 21:03:32'),
(71, 24, 'test', '1.5 Turbo Engine', 'Automatic', 10, 'wqdqdqwd', 1, 1, '2023-10-27 10:40:29', '2023-10-27 10:40:48'),
(73, 26, 'testtoyota', 'test', 'test', 19, 'dqwdqwdqwdqw', 1, 1, '2023-11-09 15:26:03', '2023-11-09 15:26:08'),
(74, 24, 'test1', 'test1', 'test1', 13, 'test1', 1, 1, '2023-11-09 20:24:18', '2023-11-09 20:24:31'),
(75, 24, 'test1', 'test', 'test', 15, 'test', 1, 1, '2023-11-20 21:03:05', '2023-11-20 21:59:06');

-- --------------------------------------------------------

--
-- Table structure for table `cartype`
--

CREATE TABLE `cartype` (
  `carTypeID` int(30) NOT NULL,
  `carTypeName` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartype`
--

INSERT INTO `cartype` (`carTypeID`, `carTypeName`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(10, 'Sedan', 1, 0, '2023-09-28 21:17:09', '2023-09-28 21:17:09'),
(12, 'Pickup', 1, 0, '2023-09-28 21:17:30', '2023-09-28 21:17:30'),
(13, 'MPV', 1, 0, '2023-09-28 21:17:48', '2023-09-28 21:17:48'),
(14, 'Hatchback', 1, 0, '2023-09-28 21:17:56', '2023-09-28 21:17:56'),
(15, 'SUV', 1, 0, '2023-10-07 14:49:21', '2023-10-07 14:49:35'),
(19, 'Coupe', 1, 0, '2023-10-26 20:23:06', '2023-10-26 20:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custID` int(45) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phonenumber` varchar(45) NOT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(45) NOT NULL,
  `levelID` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`custID`, `firstname`, `lastname`, `email`, `phonenumber`, `sex`, `dob`, `address`, `levelID`, `date_added`, `date_updated`) VALUES
(7, 'Tony', 'Stark', 'tonystark@gmail.com', '01873974238', 'Male', '1970-05-29', '10880 Malibu Point, 90265', 0, '2023-11-20 13:25:57', '2023-11-20 13:25:57'),
(8, 'Steven', 'Rogers', 'stevenrogers@gmail.com', '0183478334', 'Male', '1920-07-04', '569 Leaman Place', 0, '2023-11-20 13:27:23', '2023-11-21 05:12:06'),
(9, 'Thor ', 'Odinson', 'thorodinson@gmail.com', '0178903423', 'Male', '1230-03-10', ' 5547 Highway 41, Galisteo, New Mexico, USA', 0, '2023-11-20 13:29:19', '2023-11-20 13:29:19'),
(14, 'Clint ', 'Barton', 'hawkeye@gmail.com', '0182634562', 'Male', '1975-09-01', '400 block of Quincy St', 0, '2023-11-21 05:09:39', '2023-11-21 05:09:39'),
(15, 'Bruce', 'Banner', 'hulk@gmail.com', '0172537649', 'Male', '1962-05-03', 'LLC 500 South Washington Street', 0, '2023-11-21 05:11:56', '2023-11-21 05:11:56'),
(16, 'Faizal', 'Alias', 'faizal@gmail.vom', '01274375892', 'Male', '2023-11-08', 'Subamg Jaya', 0, '2023-11-21 08:16:37', '2023-11-21 08:16:37');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventoryID` int(30) NOT NULL,
  `modelID` int(30) NOT NULL,
  `vr_number` text NOT NULL,
  `variant` text NOT NULL,
  `colors` varchar(255) NOT NULL,
  `engine_number` varchar(100) NOT NULL,
  `chasis_number` varchar(100) NOT NULL,
  `price` float(12,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Available,\r\n1=Sold',
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `imagePath` text DEFAULT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventoryID`, `modelID`, `vr_number`, `variant`, `colors`, `engine_number`, `chasis_number`, `price`, `status`, `delete_flag`, `date_created`, `date_updated`, `imagePath`, `photo`) VALUES
(28, 29, 'HON1001', 'LX, Sport, EX, EX-L, Touring', 'White, Silver, Black, Gray, Blue', 'ENG10001', 'CHA10001', 187400.00, 0, 0, '2023-10-26 21:12:54', '2023-11-06 08:12:25', 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/Honda_Accord_%28CV3%29_EX_eHEV%2C_2021%2C_front.jpg/800px-Honda_Accord_%28CV3%29_EX_eHEV%2C_2021%2C_front.jpg', 'Honda_Accord.jpg'),
(29, 32, 'HON1002', 'LX, Sport, EX, Touring', 'White, Silver, Black, Gray, Blue', 'ENG10002', 'CHA10002', 131900.00, 0, 0, '2023-10-26 21:15:42', '2023-10-26 21:15:42', 'https://upload.wikimedia.org/wikipedia/commons/1/11/2019_Honda_Civic_coupe_%28facelift%29%2C_rear_12.16.19_%282%29.jpg', ''),
(30, 31, 'HON1003', 'LX, Sport, EX, Sport Touring', 'White, Silver, Black, Gray, Blue', 'ENG10003', 'CHA10003', 132900.00, 0, 0, '2023-10-26 21:20:02', '2023-10-26 21:20:02', 'https://paultan.org/image/2021/06/2022-Honda-Civic-Hatchback-United-States-5-e1624500605737.jpg', ''),
(31, 33, 'HON1004', 'Type R', 'Championship White, Rallye Red, Crystal Black Pearl, Sonic Gray Pearl, Polished Metal Metallic', 'ENG10004', 'CHA10004', 333000.00, 1, 0, '2023-10-26 21:22:03', '2023-11-22 11:28:25', 'https://img.icarcdn.com/autospinn-my/body/000000020625_5edb3f36_26e3_492f_ade1_8065711a5ddf.png', ''),
(32, 30, 'HON1005', 'LX, EX, EX-L, Touring', 'White, Silver, Black, Gray, Blue', 'ENG10005', 'CHA10005', 146900.00, 0, 0, '2023-10-26 21:24:29', '2023-10-26 21:24:29', 'https://evault.honda.com.my/pixelvault/2020-11/e7971c0d40544b246885f4a19b586e224ec6425b9537.jpg', ''),
(33, 34, 'HON1006', 'LX, EX, EX-L, Touring, Elite', 'White, Silver, Black, Gray, Blue', 'ENG10006', 'CHA10006', 275311.00, 0, 0, '2023-10-26 21:26:39', '2023-10-26 21:26:39', 'https://images.wapcar.my/file/0e8a9ef4f1384d408590aeeb26d03876.jpg', ''),
(34, 35, 'LEX1001', 'Standard, Luxury, Ultra Luxury, F Sport', 'White Pearl, Silver, Black, Nebula Gray Pearl, Atomic Silver, Matador Red Mica, Nightfall Mica, Eminent White Pearl', 'ENG10007', 'CHA10007', 320888.00, 0, 0, '2023-10-26 21:34:26', '2023-10-26 21:34:26', 'https://www.lexus.com.my/content/dam/lexus-v3-blueprint/models/sedan/es/es-250/my22/features/comfort-and-design/es-250-comfort-and-design-bold-look.jpg', ''),
(35, 37, 'LEX1002', 'Base, F Sport, Luxury, Premium', 'White, Silver, Black, Gray, Blue', 'ENG10008', 'CHA10008', 409000.00, 0, 0, '2023-10-26 21:41:21', '2023-10-26 21:41:21', 'https://images.wapcar.my/file1/c63b31fc721840e184bf32ff9d2099d2_800.jpg', ''),
(36, 38, 'LEX1003', 'LC 500, LC 500h', 'White, Silver, Black, Gray, Blue, Red', 'ENG10009', 'CHA10009', 1205200.00, 0, 0, '2023-10-26 21:44:39', '2023-10-26 21:44:39', 'https://images.wapcar.my/file/752dbd0c2b1b45afbd80e8b09be6a397.jpg', ''),
(37, 40, 'LEX1004', 'Base, Three-Row, Luxury, F Sport', 'White, Silver, Black, Gray, Blue', 'ENG10010', 'CHA10010', 1225800.00, 0, 0, '2023-10-26 21:47:26', '2023-10-26 21:47:26', 'https://images.wapcar.my/file1/09d3c8ea1a38494db13f9a9ce30cefae_800.jpg', ''),
(38, 36, 'LEX1005', 'Base, F Sport, Luxury, Premium, RX L', 'White, Silver, Black, Gray, Blue', 'ENG10011', 'CHA10011', 468888.00, 0, 0, '2023-10-26 21:49:54', '2023-10-26 21:49:54', 'https://images.wapcar.my/file1/5f11c269afde4f93947f589774121434_1125x630.jpg', ''),
(39, 39, 'LEX1006', 'UX 200, UX 250h', 'White, Silver, Black, Gray, Blue', 'ENG10012', 'CHA10012', 235472.00, 0, 0, '2023-10-26 21:52:05', '2023-10-26 21:52:05', 'https://www.lexus.com.my/content/dam/lexus-v3-blueprint/models/suv/ux/mlp/my19/gallery/exterior/lexus-ux-gallery-ext-09-d.jpg', ''),
(40, 45, 'MAZ1001', 'Sport, Touring, Grand Touring', 'White, Silver, Black, Gray, Red', 'ENG10013', 'CHA10013', 135259.00, 0, 0, '2023-10-26 21:55:00', '2023-10-26 21:55:00', 'https://images.wapcar.my/file/bbd3d16c9e5b45b28cd4fa6d2158f4c3.jpg', ''),
(41, 42, 'MAZ1002', 'Sport, Touring, Grand Touring, Grand Touring Reserve, Signature', 'White, Silver, Black, Gray, Blue, Red', 'ENG10014', 'CHA10014', 137900.00, 0, 0, '2023-10-26 21:57:15', '2023-10-26 21:57:15', 'https://images.wapcar.my/file/327d95f7cfa94370899030ea2870ec6c.jpg', ''),
(42, 44, 'MAZ1003', 'Sport, Touring', 'Soul Red Crystal Metallic, Snowflake White Pearl Mica, Machine Gray Metallic, Deep Crystal Blue Mica, Jet Black Mica', 'ENG10015', 'CHA10015', 100870.00, 0, 0, '2023-10-26 22:00:50', '2023-10-26 22:00:50', 'https://images.wapcar.my/file1/5ab691c2fd2447ebad805268f7cad11b_1125x630.jpg', ''),
(43, 41, 'MAZ1004', 'i Sport, i Touring, i Grand Touring, s Touring, s Grand Touring', 'White Pearl, Snowflake White Pearl, Sonic Silver Metallic, Jet Black Mica, Deep Crystal Blue Mica, Eternal Blue Mica, Machine Gray Metallic, Soul Red Crystal Metallic', 'ENG10016', 'CHA10016', 149000.00, 0, 0, '2023-10-26 22:02:36', '2023-10-26 22:02:36', 'https://images.wapcar.my/file1/650564d7beb04b4fbf22221e406572cb_1125x630.jpg', ''),
(44, 43, 'MAZ1005', 'Sport, Touring, Grand Touring, Grand Touring Reserve, Signature', 'White, Silver, Black, Gray, Blue, Red, Soul Red Crystal ', 'ENG10017', 'CHA10017', 180000.00, 0, 0, '2023-10-26 22:05:12', '2023-10-26 22:05:12', 'https://images.wapcar.my/file/6dea6e3856514cef9dfa91c7db5b5a09.jpg', ''),
(45, 46, 'MAZ1006', 'Standard, Exclusive, Premium', 'White, Silver, Black, Gray, Blue, Soul Red Crystal Metallic', 'ENG10018', 'CHA10018', 199000.00, 0, 0, '2023-10-26 22:08:50', '2023-10-26 22:08:50', 'https://images.wapcar.my/file1/8fd92d7232544767ba69a11f24237ee8_1125x630.jpg', ''),
(46, 48, 'NIS1001', 'S, SR, SV, SL, Platinum', 'Super Black, Scarlet Ember Tintcoat, Pearl White Tricoat, Gun Metallic, Gray Sky Pearl, Glacier White, Garnet Pearl Metallic, Deep Blue Pearl, Brilliant Silver Metallic', 'ENG10019', 'CHA10019', 132450.00, 0, 0, '2023-10-26 22:13:11', '2023-10-26 22:13:11', 'https://www.ccarprice.com/products/Nissan_Altima_S_2022.jpg', ''),
(47, 52, 'NIS1002', 'S, SV, Pro-4X', 'Baja Storm Metallic, Cardinal Red TriCoat, Red Alert, and Tactical Green Metallic, Glacier White, Gun Metallic, Super Black, Deep Blue Pearl ', 'ENG10020', 'CHA10020', 149960.00, 0, 0, '2023-10-26 22:16:10', '2023-10-26 22:16:10', 'https://images.wapcar.my/file/c961788d3b0e4f71aa556e98f45f937f.jpg', ''),
(48, 51, 'NIS1003', 'S, SV, SL, S Plus, SV Plus, SL Plus', 'Brilliant Silver Metallic, Gun Metallic, Super Black and Deep Blue Pear, Glacier White', 'ENG10021', 'CHA10021', 168888.00, 0, 0, '2023-10-26 22:19:04', '2023-10-26 22:19:04', 'https://images.wapcar.my/file1/0aab10cd76f541bc8a483fb7e4c81334_1125x630.jpg', ''),
(49, 50, 'NIS1004', 'S, SV, SL, SR, Platinum', 'Pearl White TriCoat, Brilliant Silver Metallic, Gun Metallic, Scarlet Ember Tintcoat, Deep Blue Pearl, and Super Black', 'ENG10022', 'CHA10022', 152560.00, 0, 0, '2023-10-26 22:21:49', '2023-10-26 22:27:37', 'https://www.ccarprice.com/products/Nissan_Maxima_Platinum_2021.jpg', ''),
(50, 49, 'NIS1005', 'S, SV, SL, Platinum', 'Glacier White, Champagne Silver Metallic, Brilliant Silver Metallic, Gun Metallic, Super Black, Caspian Blue Metallic, Pearl White TriCoat, Scarlet Ember Tintcoat, or Boulder Gray Pearl', 'ENG10023', 'CHA10023', 154560.00, 0, 0, '2023-10-26 22:23:45', '2023-10-26 22:23:45', 'https://www.ccarprice.com/products/Nissan_Rogue_2023_2.jpg', ''),
(51, 47, 'NIS1006', 'S, SV, SR, SL', 'Metallic Blue, Blue Onyx, Espresso Black, Red Alert, Brilliant Silver, Magnetic Gray, Super Black, Red Brick and Aspen White.', 'ENG10024', 'CHA10024', 92530.00, 0, 0, '2023-10-26 22:31:01', '2023-10-26 22:31:01', 'https://images.wapcar.my/file/e83e7578a3b1464c8e41b2b5f3d4f72e.png', ''),
(67, 64, 'SELL1001', 'Standard, Executive, Premium', 'White, Silver, Black, Gray, Blue', 'SELL100001', 'SELL100001', 49000.00, 1, 0, '2023-11-20 22:10:14', '2023-11-20 22:12:02', 'https://images.wapcar.my/file1/a08d508f3da347e8a96fcba99b61a5d7_1125x630.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `manufacturerID` int(30) NOT NULL,
  `manufacturerName` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturerID`, `manufacturerName`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(23, 'Nissan', 1, 0, '2023-09-28 21:15:48', '2023-09-28 21:15:48'),
(24, 'Proton', 1, 0, '2023-09-28 21:15:53', '2023-09-28 21:15:53'),
(25, 'Perodua', 1, 0, '2023-09-28 21:15:59', '2023-09-28 21:15:59'),
(26, 'Toyota', 1, 0, '2023-09-28 21:16:09', '2023-09-28 21:16:09'),
(27, 'Honda', 0, 0, '2023-09-28 21:16:15', '2023-11-21 16:24:56'),
(28, 'Mazda', 1, 0, '2023-09-28 21:16:21', '2023-09-28 21:16:21'),
(57, 'Lexus', 1, 0, '2023-10-06 22:15:33', '2023-10-06 22:15:46'),
(58, 'Porsche', 1, 1, '2023-10-27 15:41:11', '2023-10-27 15:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Carnival Sales Management System'),
(6, 'short_name', 'CSMS'),
(11, 'logo', 'uploads/logo.png?v=1654130795'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1654130796'),
(17, 'phone', '456-987-1231'),
(18, 'mobile', '09123456987 / 094563212222 '),
(19, 'email', 'info@sample.com'),
(20, 'address', '7087 Henry St. Clifton Park, NY 12065 - updated address');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_list`
--

CREATE TABLE `transaction_list` (
  `id` int(30) NOT NULL,
  `vehicle_id` int(30) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `salesperson` varchar(45) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_list`
--

INSERT INTO `transaction_list` (`id`, `vehicle_id`, `firstname`, `lastname`, `salesperson`, `sex`, `dob`, `contact`, `email`, `address`, `date_created`, `date_updated`) VALUES
(11, 67, 'Simon', 'Jurkich', 'David Raya', 'Male', '2003-02-15', '01992748372', 'simonjurkich@gmail.com', '3, Jalan SS 15/8, Ss 15, 47500 Subang Jaya, Selangor', '2023-11-20 22:12:02', '2023-11-20 22:12:02'),
(13, 31, 'Faizal', 'Alias', 'Haily Steinfeld', 'Male', '2023-11-01', '2131312312', 'faizal@gmail.com', 'ibuvrbyiedcwib', '2023-11-22 11:28:25', '2023-11-22 11:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phonenumber` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `levelID` int(11) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `email`, `phonenumber`, `address`, `last_login`, `levelID`, `date_added`, `date_updated`) VALUES
(1, 'David', 'Raya', 'draya', '6752b4b078b0f7b57a370848e2cc33de', 'draya@gmail.com', '0162748689', 'Hornsey Rd, London N7 7AJ, UK', NULL, 1, '2023-10-08 21:31:18', '2023-10-08 21:31:18'),
(10, 'Tim', 'Ming', 'timming', 'a3de684dfb800403af501ea22faca0c8', 'timming@gmail.com', '01234567890', 'Kuala Lumpur City Centre, 50050 Kuala Lumpur,', NULL, 2, '2023-10-07 21:09:10', '2023-11-19 16:01:35'),
(12, 'Haily', 'Steinfeld', 'haily123', '0ad80eb119d9bf7775aa23786b05b391', 'sales@gmail.com', '01782781287', 'Petronas Twin Tower, Level 36, Tower 2, Kuala', NULL, 1, '2023-10-13 22:42:28', '2023-11-20 21:35:30'),
(13, 'John', 'Stamos', 'john123', '0192023a7bbd73250516f069df18b500', 'johnstamos@gmail.com', '0123456789', '9, Jalan Pinang, Kuala Lumpur, 50450 Kuala Lu', NULL, 2, '2023-10-27 15:40:34', '2023-11-20 21:34:41'),
(16, 'Teh ', 'Yan Yang', 'Brandon', '0192023a7bbd73250516f069df18b500', 'tyy@gmail.com', '0167897635', '19, Jalan USJ 17, 9C', NULL, 2, '2023-11-20 22:04:27', '2023-11-21 14:34:43'),
(17, 'Steven', 'Hanks', 'steven123', '0ad80eb119d9bf7775aa23786b05b391', 'stevenhanks@gmail.com', '0198756235', 'Jalan USJ 7/3C, Taman Subang Permai, USJ 7, 4', NULL, 1, '2023-11-21 12:53:32', '2023-11-21 12:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `levelID` int(11) NOT NULL,
  `levelName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`levelID`, `levelName`) VALUES
(0, 'Customer'),
(1, 'Salesperson'),
(2, 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carmodel`
--
ALTER TABLE `carmodel`
  ADD PRIMARY KEY (`modelID`),
  ADD KEY `brand_id` (`manufacturerID`),
  ADD KEY `car_type_id` (`carTypeID`);

--
-- Indexes for table `cartype`
--
ALTER TABLE `cartype`
  ADD PRIMARY KEY (`carTypeID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custID`) USING BTREE,
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `phonenumber_UNIQUE` (`phonenumber`),
  ADD UNIQUE KEY `salespersonID_UNIQUE` (`custID`) USING BTREE,
  ADD KEY `levelID` (`levelID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventoryID`),
  ADD KEY `model_id` (`modelID`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`manufacturerID`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_list`
--
ALTER TABLE `transaction_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `salespersonID` (`salesperson`),
  ADD KEY `custID` (`firstname`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `levelID` (`levelID`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`levelID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carmodel`
--
ALTER TABLE `carmodel`
  MODIFY `modelID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `cartype`
--
ALTER TABLE `cartype`
  MODIFY `carTypeID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `custID` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventoryID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `manufacturerID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transaction_list`
--
ALTER TABLE `transaction_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carmodel`
--
ALTER TABLE `carmodel`
  ADD CONSTRAINT `brand_id_fk_ml` FOREIGN KEY (`manufacturerID`) REFERENCES `manufacturers` (`manufacturerID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `car_type_id_fk_ml` FOREIGN KEY (`carTypeID`) REFERENCES `cartype` (`carTypeID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`levelID`) REFERENCES `user_level` (`levelID`),
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`levelID`) REFERENCES `user_level` (`levelID`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `model_id_fk_vl` FOREIGN KEY (`modelID`) REFERENCES `carmodel` (`modelID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`levelID`) REFERENCES `user_level` (`levelID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
