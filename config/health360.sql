-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2014 at 08:57 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `health360`
--




-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `user_first_name` varchar(100) NOT NULL,
  `user_last_name` varchar(100) DEFAULT NULL,
  `user_email_id` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_address1` varchar(100) NOT NULL,
  `user_address2` varchar(100) NOT NULL,
  `user_country` int(11) NOT NULL,
  `user_state` int(11) NOT NULL,
  `user_city` int(11) NOT NULL,
  `user_postal_code` bigint(11) NOT NULL,
  `user_gender` tinyint(1) NOT NULL,
  `user_birthdate` datetime NOT NULL,
  `user_phone` bigint(11) DEFAULT NULL,
  `user_phone2` varchar(45) DEFAULT NULL,
  `user_phone3` varchar(45) DEFAULT NULL,
  `user_mobile` bigint(11) DEFAULT NULL,
  `user_mobile2` varchar(45) DEFAULT NULL,
  `user_mobile3` varchar(45) DEFAULT NULL,
  `user_profile_pic_loc` varchar(256) NOT NULL,
  `user_blood_group` varchar(5) NOT NULL,
  `user_verification_code` varchar(100) NOT NULL,
  `user_status` varchar(1) NOT NULL,
  `user_created` datetime NOT NULL,
  `user_modified` datetime NOT NULL,
  `user_last_login` datetime NOT NULL,
  `user_role_default_id` int(11) DEFAULT NULL,
  `user_secret_question` text,
  `user_secret_question_ans` text,
  `attri_1` varchar(45) DEFAULT NULL,
  `attri_2` varchar(45) DEFAULT NULL,
  `attri_3` varchar(45) DEFAULT NULL,
  `userscol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_first_name`, `user_last_name`, `user_email_id`, `user_password`, `user_address1`, `user_address2`, `user_country`, `user_state`, `user_city`, `user_postal_code`, `user_gender`, `user_birthdate`, `user_phone`, `user_phone2`, `user_phone3`, `user_mobile`, `user_mobile2`, `user_mobile3`, `user_profile_pic_loc`, `user_blood_group`, `user_verification_code`, `user_status`, `user_created`, `user_modified`, `user_last_login`, `user_role_default_id`, `user_secret_question`, `user_secret_question_ans`, `attri_1`, `attri_2`, `attri_3`, `userscol`) VALUES
(26, 'tsets', 'kumar', 'jdoe@example.com', '900150983cd24fb0d6963f7d28e17f72', '', '', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '2015-01-29 03:58:32', '2015-01-29 03:58:32', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'Raj', 'Kumar', 'jdoe1@example.com', '900150983cd24fb0d6963f7d28e17f72', '', '', 0, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '2015-01-29 05:29:25', '2015-01-29 05:29:25', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_email_id` (`user_email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;


-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
`id` int(11) NOT NULL,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `artist`, `title`) VALUES
(1, 'The  Military  Wives', 'In  My  Dreams11'),
(2, 'Adele', '21'),
(3, 'Bruce  Springsteen', 'Wrecking Ball (Deluxe)'),
(4, 'Lana  Del  Rey', 'Born  To  Die'),
(5, 'Gotye', 'Making  Mirrors'),
(6, 'artist aaa', 'title a'),
(7, '22', 'rr'),
(8, 'asdf', 'sadf');

-- --------------------------------------------------------

--
-- Table structure for table `h360_appointments_table`
--

CREATE TABLE IF NOT EXISTS `h360_appointments_table` (
`appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `apptime` datetime NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `ref_doctor_id` int(11) NOT NULL,
  `ref_doctor_sep` int(11) NOT NULL,
  `appointment_status` tinyint(1) NOT NULL COMMENT '0=>New/Pending,1=>Accept, 2=>Reject',
  `created_date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `h360_appointments_table`
--

INSERT INTO `h360_appointments_table` (`appointment_id`, `doctor_id`, `patient_id`, `apptime`, `subject`, `message`, `ref_doctor_id`, `ref_doctor_sep`, `appointment_status`, `created_date`) VALUES
(1, 1, 1, '2014-12-20 00:00:00', 'HEadache', 'Severe pain', 0, 0, 1, '2014-12-20 00:00:00'),
(2, 1, 1, '2014-12-20 00:00:00', 'HEadache2', 'Severe pain2', 0, 0, 1, '2014-12-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `h360_clinic_labdetails`
--

CREATE TABLE IF NOT EXISTS `h360_clinic_labdetails` (
  `labdetail_id` int(10) NOT NULL,
  `lab_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `labdetail_name` varchar(256) NOT NULL,
  `labdetail_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h360_diagnosis_table`
--

CREATE TABLE IF NOT EXISTS `h360_diagnosis_table` (
`id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `diagnosis` text NOT NULL,
  `suggestion` mediumtext NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `h360_diagnosis_table`
--

INSERT INTO `h360_diagnosis_table` (`id`, `patient_id`, `doctor_id`, `diagnosis`, `suggestion`, `created_date`) VALUES
(3, 2, 1, '9999', '8888', '0000-00-00 00:00:00'),
(4, 1, 1, 'Diagnosis summary', 'Suggestion', '0000-00-00 00:00:00'),
(5, 2, 1, 'Seems Malaria', 'Take Blood test', '0000-00-00 00:00:00'),
(6, 1, 1, 'sss', 'sssss', '0000-00-00 00:00:00'),
(7, 1, 1, 'aaa', 'aaaaa', '0000-00-00 00:00:00'),
(8, 1, 1, 'fr q', 'sdafasfs', '0000-00-00 00:00:00'),
(9, 2, 1, 'diag', 'desc', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `h360_doctors_table`
--

CREATE TABLE IF NOT EXISTS `h360_doctors_table` (
`doctor_id` int(11) NOT NULL,
  `med_coun_num` varchar(50) NOT NULL,
  `doctor_fname` varchar(40) NOT NULL,
  `doctor_lname` varchar(40) NOT NULL,
  `doctor_photo` varchar(100) NOT NULL,
  `doctor_registration_number` varchar(50) NOT NULL,
  `doctor_email_id` varchar(100) NOT NULL,
  `doctor_password` varchar(100) DEFAULT NULL,
  `doctor_address` text,
  `doctor_country` varchar(40) NOT NULL,
  `doctor_state` varchar(40) NOT NULL,
  `doctor_postal_code` int(11) DEFAULT NULL,
  `doctor_gender` enum('male','female') NOT NULL DEFAULT 'male',
  `doctor_dob` date NOT NULL,
  `doctor_status` enum('active','suspend') NOT NULL DEFAULT 'active',
  `doctor_department` varchar(100) DEFAULT NULL,
  `doctor_specialized_in` varchar(100) DEFAULT NULL,
  `doctor_reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `doctor_mobile` varchar(15) NOT NULL,
  `encrpt_password` varchar(100) NOT NULL,
  `login_status` varchar(10) NOT NULL,
  `doctor_specailization` varchar(100) NOT NULL,
  `doctor_hospital` varchar(256) NOT NULL,
  `doctor_qualification` varchar(100) NOT NULL,
  `doctor_logo` varchar(256) NOT NULL,
  `doctor_created` datetime NOT NULL,
  `doctor_modified` datetime NOT NULL,
  `doctor_last_login` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=27 ;

--
-- Dumping data for table `h360_doctors_table`
--

INSERT INTO `h360_doctors_table` (`doctor_id`, `med_coun_num`, `doctor_fname`, `doctor_lname`, `doctor_photo`, `doctor_registration_number`, `doctor_email_id`, `doctor_password`, `doctor_address`, `doctor_country`, `doctor_state`, `doctor_postal_code`, `doctor_gender`, `doctor_dob`, `doctor_status`, `doctor_department`, `doctor_specialized_in`, `doctor_reg_date`, `doctor_mobile`, `encrpt_password`, `login_status`, `doctor_specailization`, `doctor_hospital`, `doctor_qualification`, `doctor_logo`, `doctor_created`, `doctor_modified`, `doctor_last_login`) VALUES
(1, '', 'Suresh', 'Ramachandran', '', 'REG010', 'suresh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'suresh address', '', '', NULL, 'male', '0000-00-00', 'active', NULL, '', '2014-10-09 19:59:34', '9042690256', '', '', '', '', '', '', '2014-10-09 21:59:34', '2014-12-20 19:09:07', '2014-12-23 10:56:39'),
(26, '', 'mubarak', 'doctorlname', '', '', 'suresh1@gmail.com', '25d55ad283aa400af464c76d713c07ad', NULL, '', '', NULL, 'male', '0000-00-00', 'active', NULL, NULL, '2014-11-28 21:06:15', '', '', '', '', '', '', '', '2014-11-28 22:06:15', '2014-11-28 22:06:15', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `h360_healthrecords_table`
--

CREATE TABLE IF NOT EXISTS `h360_healthrecords_table` (
`id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `weight` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `bp_level_high` varchar(10) NOT NULL,
  `bp_level_low` varchar(10) NOT NULL,
  `sugar_level_fasting` varchar(10) NOT NULL,
  `sugar_level_pp` varchar(10) NOT NULL,
  `sugar_level_random` varchar(10) NOT NULL,
  `hba1c` varchar(10) NOT NULL,
  `systolic` varchar(100) NOT NULL,
  `diastolic` varchar(100) NOT NULL,
  `temprature` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `h360_healthrecords_table`
--

INSERT INTO `h360_healthrecords_table` (`id`, `patient_id`, `weight`, `height`, `bp_level_high`, `bp_level_low`, `sugar_level_fasting`, `sugar_level_pp`, `sugar_level_random`, `hba1c`, `systolic`, `diastolic`, `temprature`, `created_date`, `modified_date`) VALUES
(1, 1, 121, 121, '12', '12', '', '', '', '', '', '', '1231', '2014-11-28 17:45:57', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `h360_labs_table`
--

CREATE TABLE IF NOT EXISTS `h360_labs_table` (
`lab_id` int(10) NOT NULL,
  `lab_name` varchar(256) NOT NULL,
  `lab_email_id` varchar(100) NOT NULL,
  `lab_password` varchar(100) NOT NULL,
  `lab_address` text NOT NULL,
  `lab_logo` varchar(256) NOT NULL,
  `lab_mobile` varchar(11) NOT NULL,
  `lab_phone` int(11) NOT NULL,
  `lab_orgpassword` varchar(100) NOT NULL,
  `lab_status` varchar(10) NOT NULL,
  `lab_created` datetime NOT NULL,
  `lab_modified` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `h360_labs_table`
--

INSERT INTO `h360_labs_table` (`lab_id`, `lab_name`, `lab_email_id`, `lab_password`, `lab_address`, `lab_logo`, `lab_mobile`, `lab_phone`, `lab_orgpassword`, `lab_status`, `lab_created`, `lab_modified`) VALUES
(1, 'Apollo', 'lab@gmail.com', '25d55ad283aa400af464c76d713c07ad', '', '', '90426902561', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'ssfasdf', 'lab1@gmail.com', '25d55ad283aa400af464c76d713c07ad', '', '', '', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `h360_lab_pres_tests`
--

CREATE TABLE IF NOT EXISTS `h360_lab_pres_tests` (
`lab_pres_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `signature` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `lab_tests` longtext NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `h360_lab_pres_tests_results`
--

CREATE TABLE IF NOT EXISTS `h360_lab_pres_tests_results` (
`lab_test_id` int(11) NOT NULL,
  `lab_pres_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `lab_pres_test_id` int(11) NOT NULL,
  `lab_test_actual_value` varchar(256) NOT NULL,
  `lab_test_description` text NOT NULL,
  `lab_test_created` datetime DEFAULT NULL,
  `lab_test_status` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `h360_lab_tests`
--

CREATE TABLE IF NOT EXISTS `h360_lab_tests` (
`test_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `test_name` varchar(256) NOT NULL,
  `test_normal_value` varchar(256) NOT NULL,
  `test_status` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `h360_lab_tests`
--

INSERT INTO `h360_lab_tests` (`test_id`, `category_id`, `test_name`, `test_normal_value`, `test_status`) VALUES
(1, 1, 'Heamogram (CBC)', '1-1', '1'),
(2, 1, 'TC', '2-2', '1'),
(3, 1, 'DC', '3-3', '1'),
(4, 1, 'ESR', '4-4', '1'),
(5, 1, 'Hb', '5-5', '1');

-- --------------------------------------------------------

--
-- Table structure for table `h360_lab_tests_category`
--

CREATE TABLE IF NOT EXISTS `h360_lab_tests_category` (
  `category_id` int(10) NOT NULL DEFAULT '0',
  `category_name` varchar(256) NOT NULL,
  `category_type` varchar(10) NOT NULL,
  `category_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `h360_lab_tests_category`
--

INSERT INTO `h360_lab_tests_category` (`category_id`, `category_name`, `category_type`, `category_status`) VALUES
(1, 'HEAMATOLOGY', '', 'Active'),
(2, 'BIO-CHEMISTRY', '', 'Active'),
(3, 'COAGULATION', '', 'Active'),
(4, 'CLINICAL PATHOLOGY URINE', '', 'Active'),
(5, 'PROFILES', '', 'Active'),
(6, 'TUMOUR MARKERS', '', 'Active'),
(7, 'ENDOCRINOLOGY', '', 'Active'),
(8, 'HEPATATIS PANEL', '', 'Active'),
(9, 'URINE BIO-CHEMISTRY (24 Hours)', '', 'Active'),
(10, 'DIGITAL IMAGING', '', 'Active'),
(11, 'INTRA ORAL IMAGING', '', 'Active'),
(12, 'MOTION', '', 'Active'),
(13, 'SEMEM', '', 'Active'),
(14, 'MICROBIOLOGY-CULTURE &amp; SENSITIVITY', '', 'Active'),
(15, 'MICROBIOLOGY-STAINS', '', 'Active'),
(16, 'SEROLOGY', '', 'Active'),
(17, 'ENZYNES', '', 'Active'),
(18, 'IMMUNOLOGY', '', 'Active'),
(19, 'TORCH PANEL', '', 'Active'),
(20, 'SPOT', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `h360_medicalhistory_table`
--

CREATE TABLE IF NOT EXISTS `h360_medicalhistory_table` (
`medicalhistory_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `major_complaints` text NOT NULL,
  `associated_complaints` text NOT NULL,
  `history_major_complaints` text NOT NULL,
  `past_history` text NOT NULL,
  `treatment_history` text NOT NULL,
  `treatment_result` text NOT NULL,
  `family_history` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `did` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `h360_medicalhistory_table`
--

INSERT INTO `h360_medicalhistory_table` (`medicalhistory_id`, `patient_id`, `major_complaints`, `associated_complaints`, `history_major_complaints`, `past_history`, `treatment_history`, `treatment_result`, `family_history`, `created_date`, `did`) VALUES
(1, 1, 'major_complaints', 'associated_complaints', 'history_major_complaints', 'past_history', 'treatment_history', 'treatment_result', 'family_history', '2010-09-23 17:49:30', 84),
(2, 1, 'major_complaints', 'associated_complaints', 'history_major_complaints', 'past_history', 'treatment_history', 'treatment_result', 'family_history', '2010-08-12 15:23:13', 85),
(3, 1, 'major_complaintssdf', 'associated_complaints', 'history_major_complaints', 'past_history', 'treatment_history', 'treatment_result', 'family_history', '2010-09-21 16:12:28', 0),
(4, 1, 'major_complaints', 'associated_complaints', 'history_major_complaints', 'past_history', 'treatment_history', 'treatment_result', 'family_history', '2010-08-12 15:23:13', 84),
(5, 1, 'major_complaints', 'associated_complaints', 'history_major_complaints', 'past_history', 'treatment_history', 'treatment_result', 'family_history', '2010-08-12 15:23:13', 75),
(6, 1, 'major_complaints', 'associated_complaints', 'history_major_complaints', 'past_history', 'treatment_history', 'treatment_result', 'family_history', '2010-08-12 15:23:13', 86);

-- --------------------------------------------------------

--
-- Table structure for table `h360_medicalprescription_medicine`
--

CREATE TABLE IF NOT EXISTS `h360_medicalprescription_medicine` (
`tablet_id` int(11) NOT NULL,
  `pre_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `pharmacy_id` int(10) NOT NULL,
  `tablet_type` varchar(25) NOT NULL,
  `tablet_name` varchar(50) NOT NULL,
  `tablet_dosage` varchar(10) NOT NULL,
  `morning` varchar(5) NOT NULL,
  `afternoon` varchar(5) NOT NULL,
  `evening` varchar(5) NOT NULL,
  `night` varchar(5) NOT NULL,
  `tablet_description` text NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `status` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `h360_medicalprescription_table`
--

CREATE TABLE IF NOT EXISTS `h360_medicalprescription_table` (
`pre_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `signature` varchar(100) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `pharmacy_id` int(10) NOT NULL,
  `mp_status` tinyint(1) NOT NULL COMMENT '0=>New/Pending, 1=>Packed'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `h360_medicalprescription_table`
--

INSERT INTO `h360_medicalprescription_table` (`pre_id`, `description`, `signature`, `created_date`, `patient_id`, `doctor_id`, `pharmacy_id`, `mp_status`) VALUES
(1, 'HEacache description', '', '2014-12-20 00:00:00', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `h360_messages_table`
--

CREATE TABLE IF NOT EXISTS `h360_messages_table` (
`message_id` int(11) NOT NULL,
  `sent_to_id` int(11) NOT NULL,
  `sent_by_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `sent_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `is_sent` int(11) NOT NULL,
  `inbox` tinyint(1) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `trash` int(11) DEFAULT NULL,
  `is_read` int(11) DEFAULT NULL,
  `sender_identity` tinyint(4) DEFAULT NULL COMMENT '1=>patient,2 =>doctor',
  `is_new` tinyint(1) DEFAULT NULL,
  `is_reply` tinyint(1) DEFAULT NULL,
  `reply_to_id` int(11) DEFAULT NULL,
  `medicalhistory_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `h360_messages_table`
--

INSERT INTO `h360_messages_table` (`message_id`, `sent_to_id`, `sent_by_id`, `subject`, `message`, `sent_on`, `is_sent`, `inbox`, `is_deleted`, `trash`, `is_read`, `sender_identity`, `is_new`, `is_reply`, `reply_to_id`, `medicalhistory_id`) VALUES
(1, 1, 1, 'Hi', 'Hi this is mubarak', '2014-12-20 23:41:51', 0, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `h360_patients_doctor_table`
--

CREATE TABLE IF NOT EXISTS `h360_patients_doctor_table` (
`id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `h360_patients_doctor_table`
--

INSERT INTO `h360_patients_doctor_table` (`id`, `patient_id`, `doctor_id`, `created_date`) VALUES
(1, 1, 1, '2014-11-27 00:00:00'),
(2, 2, 1, '2014-11-26 00:00:00'),
(3, 1, 2, '2014-11-19 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `h360_patients_table`
--

CREATE TABLE IF NOT EXISTS `h360_patients_table` (
`patient_id` int(11) NOT NULL,
  `patient_fname` varchar(100) NOT NULL,
  `patient_lname` varchar(100) NOT NULL,
  `patient_email_id` varchar(100) NOT NULL,
  `patient_password` varchar(100) NOT NULL,
  `patient_country` varchar(40) NOT NULL,
  `patient_state` varchar(40) NOT NULL,
  `patient_postal_code` int(11) NOT NULL,
  `patient_status` enum('active','suspend','unverified') NOT NULL,
  `patient_reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `patient_gender` varchar(100) NOT NULL DEFAULT 'male',
  `patient_type` varchar(100) NOT NULL,
  `patient_plan` int(11) NOT NULL DEFAULT '0',
  `patient_paid` varchar(100) NOT NULL DEFAULT 'unpaid',
  `patient_phone` varchar(100) DEFAULT NULL,
  `patient_age` varchar(100) NOT NULL,
  `patient_address1` varchar(100) NOT NULL,
  `patient_address2` varchar(100) NOT NULL,
  `patient_height` varchar(10) NOT NULL,
  `patient_weight` varchar(10) NOT NULL,
  `patient_bplow` int(3) NOT NULL,
  `patient_bphigh` int(3) NOT NULL,
  `patient_sugar` int(3) NOT NULL,
  `patient_temperature` varchar(50) NOT NULL,
  `patient_logo` varchar(256) NOT NULL,
  `patient_registration_code` varchar(10) NOT NULL,
  `patient_encrpt_password` varchar(100) NOT NULL,
  `patient_general_allergies` text NOT NULL,
  `patient_medicine_allergies` text NOT NULL,
  `patient_food_allergies` text NOT NULL,
  `patient_created` datetime NOT NULL,
  `patient_modified` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `h360_patients_table`
--

INSERT INTO `h360_patients_table` (`patient_id`, `patient_fname`, `patient_lname`, `patient_email_id`, `patient_password`, `patient_country`, `patient_state`, `patient_postal_code`, `patient_status`, `patient_reg_date`, `patient_gender`, `patient_type`, `patient_plan`, `patient_paid`, `patient_phone`, `patient_age`, `patient_address1`, `patient_address2`, `patient_height`, `patient_weight`, `patient_bplow`, `patient_bphigh`, `patient_sugar`, `patient_temperature`, `patient_logo`, `patient_registration_code`, `patient_encrpt_password`, `patient_general_allergies`, `patient_medicine_allergies`, `patient_food_allergies`, `patient_created`, `patient_modified`) VALUES
(1, 'Kumar', 'Biswasa', 'biswa@gmail.com', '25d55ad283aa400af464c76d713c07ad', '', '', 0, '', '2014-10-24 00:22:57', 'male', '', 0, 'unpaid', '9008908901', '29', '', '', '', '', 0, 0, 0, '', '', '', '', 'this is just general allergy info', 'this is just medicine allergy info', 'this is just food allergy info', '0000-00-00 00:00:00', '2014-11-26 11:20:15'),
(2, 'biswa', 'kum', 'biswa2@gmail.com', '25d55ad283aa400af464c76d713c07ad', '', '', 0, 'active', '2014-11-28 21:12:35', 'male', '', 0, 'unpaid', NULL, '', '', '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `h360_pharmacies_table`
--

CREATE TABLE IF NOT EXISTS `h360_pharmacies_table` (
`pharmacy_id` int(10) NOT NULL,
  `pharmacy_name` varchar(256) NOT NULL,
  `pharmacy_address` text NOT NULL,
  `pharmacy_email_id` varchar(100) NOT NULL,
  `pharmacy_password` varchar(100) NOT NULL,
  `pharmacy_mobile` varchar(11) NOT NULL,
  `pharmacy_phone` int(15) NOT NULL,
  `pharmacy_logo` varchar(256) NOT NULL,
  `pharmacy_orgpassword` varchar(100) NOT NULL,
  `pharmacy_status` varchar(10) NOT NULL,
  `pharmacy_created` datetime NOT NULL,
  `pharmacy_modified` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `h360_pharmacies_table`
--

INSERT INTO `h360_pharmacies_table` (`pharmacy_id`, `pharmacy_name`, `pharmacy_address`, `pharmacy_email_id`, `pharmacy_password`, `pharmacy_mobile`, `pharmacy_phone`, `pharmacy_logo`, `pharmacy_orgpassword`, `pharmacy_status`, `pharmacy_created`, `pharmacy_modified`) VALUES
(1, 'medicareb', '', 'apollo@gmail.com', '25d55ad283aa400af464c76d713c07ad', '89089711111', 0, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'asdfasfasdf', '', 'narunkumar1.88@gmail.com', '25d55ad283aa400af464c76d713c07ad', '', 0, '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h360_appointments_table`
--
ALTER TABLE `h360_appointments_table`
 ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `h360_clinic_labdetails`
--
ALTER TABLE `h360_clinic_labdetails`
 ADD PRIMARY KEY (`labdetail_id`);

--
-- Indexes for table `h360_diagnosis_table`
--
ALTER TABLE `h360_diagnosis_table`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h360_doctors_table`
--
ALTER TABLE `h360_doctors_table`
 ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `h360_healthrecords_table`
--
ALTER TABLE `h360_healthrecords_table`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h360_labs_table`
--
ALTER TABLE `h360_labs_table`
 ADD PRIMARY KEY (`lab_id`), ADD UNIQUE KEY `lab_email_id` (`lab_email_id`);

--
-- Indexes for table `h360_lab_pres_tests`
--
ALTER TABLE `h360_lab_pres_tests`
 ADD PRIMARY KEY (`lab_pres_id`);

--
-- Indexes for table `h360_lab_pres_tests_results`
--
ALTER TABLE `h360_lab_pres_tests_results`
 ADD PRIMARY KEY (`lab_test_id`);

--
-- Indexes for table `h360_lab_tests`
--
ALTER TABLE `h360_lab_tests`
 ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `h360_lab_tests_category`
--
ALTER TABLE `h360_lab_tests_category`
 ADD PRIMARY KEY (`category_id`), ADD UNIQUE KEY `category_id` (`category_id`);

--
-- Indexes for table `h360_medicalhistory_table`
--
ALTER TABLE `h360_medicalhistory_table`
 ADD PRIMARY KEY (`medicalhistory_id`);

--
-- Indexes for table `h360_medicalprescription_medicine`
--
ALTER TABLE `h360_medicalprescription_medicine`
 ADD PRIMARY KEY (`tablet_id`);

--
-- Indexes for table `h360_medicalprescription_table`
--
ALTER TABLE `h360_medicalprescription_table`
 ADD PRIMARY KEY (`pre_id`);

--
-- Indexes for table `h360_messages_table`
--
ALTER TABLE `h360_messages_table`
 ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `h360_patients_doctor_table`
--
ALTER TABLE `h360_patients_doctor_table`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h360_patients_table`
--
ALTER TABLE `h360_patients_table`
 ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `h360_pharmacies_table`
--
ALTER TABLE `h360_pharmacies_table`
 ADD PRIMARY KEY (`pharmacy_id`), ADD UNIQUE KEY `pharmacy_email_id` (`pharmacy_email_id`), ADD UNIQUE KEY `pharmacy_email_id_2` (`pharmacy_email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `h360_appointments_table`
--
ALTER TABLE `h360_appointments_table`
MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `h360_diagnosis_table`
--
ALTER TABLE `h360_diagnosis_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `h360_doctors_table`
--
ALTER TABLE `h360_doctors_table`
MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `h360_healthrecords_table`
--
ALTER TABLE `h360_healthrecords_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `h360_labs_table`
--
ALTER TABLE `h360_labs_table`
MODIFY `lab_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `h360_lab_pres_tests`
--
ALTER TABLE `h360_lab_pres_tests`
MODIFY `lab_pres_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `h360_lab_pres_tests_results`
--
ALTER TABLE `h360_lab_pres_tests_results`
MODIFY `lab_test_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `h360_lab_tests`
--
ALTER TABLE `h360_lab_tests`
MODIFY `test_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `h360_medicalhistory_table`
--
ALTER TABLE `h360_medicalhistory_table`
MODIFY `medicalhistory_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `h360_medicalprescription_medicine`
--
ALTER TABLE `h360_medicalprescription_medicine`
MODIFY `tablet_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `h360_medicalprescription_table`
--
ALTER TABLE `h360_medicalprescription_table`
MODIFY `pre_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `h360_messages_table`
--
ALTER TABLE `h360_messages_table`
MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `h360_patients_doctor_table`
--
ALTER TABLE `h360_patients_doctor_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `h360_patients_table`
--
ALTER TABLE `h360_patients_table`
MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `h360_pharmacies_table`
--
ALTER TABLE `h360_pharmacies_table`
MODIFY `pharmacy_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
