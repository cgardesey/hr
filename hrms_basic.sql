-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2018 at 03:19 PM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hrms_basic`
--

-- --------------------------------------------------------

--
-- Table structure for table `addloans`
--

CREATE TABLE IF NOT EXISTS `addloans` (
  `addloansid` int(11) NOT NULL,
  `loantypeid` int(11) DEFAULT NULL,
  `loan_interestrate` varchar(45) DEFAULT NULL,
  `loan_remarks` varchar(256) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE IF NOT EXISTS `announcement` (
  `announcementid` int(11) NOT NULL,
  `to_usertypeid` int(11) DEFAULT NULL,
  `to_userid` int(11) DEFAULT NULL,
  `from_usertypeid` int(11) DEFAULT NULL,
  `from_userid` int(11) DEFAULT NULL,
  `announcement_subject` varchar(100) DEFAULT NULL,
  `announcement_message` varchar(256) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcementid`, `to_usertypeid`, `to_userid`, `from_usertypeid`, `from_userid`, `announcement_subject`, `announcement_message`, `financialyearid`, `companyid`) VALUES
(1, 3, 3, 1, 1, 'Woooow', 'Heybeybey', 1, 1),
(2, 1, 1, 3, 3, 'Kob', 'Qwetuopknbvnbvbvbvbvbv', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assignloan`
--

CREATE TABLE IF NOT EXISTS `assignloan` (
  `assignloanid` int(11) NOT NULL,
  `addloansid` int(11) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `designationid` int(11) DEFAULT NULL,
  `interest_rate` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `amount` varchar(45) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `authassignment`
--

CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '1', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitem`
--

CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authitem`
--

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, NULL, NULL, 'N;'),
('Authenticated', 2, NULL, NULL, 'N;'),
('Guest', 2, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bankdetails`
--

CREATE TABLE IF NOT EXISTS `bankdetails` (
  `bankdetailsid` int(11) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `bank_address` varchar(45) DEFAULT NULL,
  `bank_phone` varchar(45) DEFAULT NULL,
  `bank_branch` varchar(45) DEFAULT NULL,
  `bank_ifsc` varchar(45) DEFAULT NULL,
  `bank_accountno` varchar(45) DEFAULT NULL,
  `bank_ddpayableaddress` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(255) NOT NULL,
  `categoryDescription` longtext NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `categoryName`, `categoryDescription`, `creationDate`, `updationDate`) VALUES
(1, 'Promotion', 'E-commerce', '2017-03-28 07:10:55', ''),
(2, 'Transfer', 'dsdas', '2017-06-11 10:54:06', '');

-- --------------------------------------------------------

--
-- Table structure for table `circular`
--

CREATE TABLE IF NOT EXISTS `circular` (
  `circularid` int(11) NOT NULL,
  `circular_subject` varchar(256) DEFAULT NULL,
  `circular_refferenceno` varchar(256) DEFAULT NULL,
  `circular_contents` text,
  `circular_date` datetime DEFAULT NULL,
  `circular_status` varchar(45) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `companyid` int(11) NOT NULL,
  `company_name` varchar(45) DEFAULT NULL,
  `company_address` varchar(256) DEFAULT NULL,
  `company_email` varchar(45) DEFAULT NULL,
  `company_phone` varchar(15) DEFAULT NULL,
  `company_mobile` varchar(15) DEFAULT NULL,
  `company_fax` varchar(45) DEFAULT NULL,
  `company_contactperson` varchar(45) DEFAULT NULL,
  `company_country` varchar(45) DEFAULT NULL,
  `company_state` varchar(45) DEFAULT NULL,
  `company_currency` varchar(60) DEFAULT NULL,
  `company_language` varchar(45) DEFAULT NULL,
  `company_code` varchar(45) DEFAULT NULL,
  `company_timezone` varchar(60) DEFAULT NULL,
  `company_logo` varchar(60) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`companyid`, `company_name`, `company_address`, `company_email`, `company_phone`, `company_mobile`, `company_fax`, `company_contactperson`, `company_country`, `company_state`, `company_currency`, `company_language`, `company_code`, `company_timezone`, `company_logo`) VALUES
(1, 'Ghana Education Service', 'P.O.Box 1789', 'admin@ges.org', '+23332204565', '+23332204565', '+23332204565', 'Dr. Frimpong Mannso', 'Ghana', 'Greater Accra', 'CDF', 'English', '72832-039843', 'European Central Time(ECT) - GMT+01:00', '02042018044302.png');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `departmentid` int(11) NOT NULL,
  `department_name` varchar(45) DEFAULT NULL,
  `department_code` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentid`, `department_name`, `department_code`, `financialyearid`, `companyid`) VALUES
(1, 'Finance and Administration', '000', 1, 1),
(2, 'Inspectorate', '001', 1, 1),
(3, 'Human Resource', '010', 1, 1),
(5, 'Planning and Statistics', '101', 1, 1),
(6, 'Welfare', '110', 1, 1),
(7, 'Teaching Staff', '111', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE IF NOT EXISTS `designation` (
  `designationid` int(11) NOT NULL,
  `designation_name` varchar(60) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `departmentid` int(11) DEFAULT NULL,
  `divisionid` int(11) DEFAULT NULL,
  `jobcategoryid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`designationid`, `designation_name`, `financialyearid`, `companyid`, `departmentid`, `divisionid`, `jobcategoryid`) VALUES
(1, 'Chief Controllers Office', 1, 1, 1, 1, 1),
(2, 'Head', 1, 1, 7, 8, 8),
(3, 'Chaplain', 1, 1, 7, 8, 11),
(4, 'Tutor', 1, 1, 7, 8, 10),
(5, 'Western Region', 1, 1, 7, 8, 5),
(6, 'Brong Ahafo Region', 1, 1, 7, 8, 5),
(7, 'Ashanti region', 1, 1, 7, 8, 5),
(8, 'Volta Region', 1, 1, 7, 8, 5),
(9, 'Central Region', 1, 1, 7, 8, 5),
(10, 'Eastern Region', 1, 1, 7, 9, 7),
(11, 'Northern Region', 1, 1, 7, 9, 7),
(12, 'Greater Accra', 1, 1, 7, 9, 6),
(13, 'Remote', 1, 1, 2, 10, 12),
(14, 'Mobile Unit', 1, 1, 2, 10, 12),
(15, 'Basic schools', 1, 1, 2, 10, 14),
(16, 'Auditor', 1, 1, 1, 11, 17),
(17, 'Chief Auditors Office', 1, 1, 1, 11, 17),
(18, 'Fees', 1, 1, 1, 12, 16),
(19, 'Capitation Grants', 1, 1, 1, 12, 16);

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE IF NOT EXISTS `division` (
  `divisionid` int(11) NOT NULL,
  `division_name` varchar(60) DEFAULT NULL,
  `departmentid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`divisionid`, `division_name`, `departmentid`, `financialyearid`, `companyid`) VALUES
(1, 'JHS', 1, 1, 1),
(2, 'SHS', 1, 1, 1),
(3, 'Tertiary', 1, 1, 1),
(4, 'Religious Schools', 3, 1, 1),
(5, 'Governmental Schools', 3, 1, 1),
(6, 'Students', 6, 1, 1),
(7, 'Staff', 6, 1, 1),
(8, 'Religious School', 7, 1, 1),
(9, 'Government Schools', 7, 1, 1),
(10, 'General', 2, 1, 1),
(11, 'Accounts', 1, 1, 1),
(12, 'Finance', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `emailid` int(11) NOT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `to_userid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `from_userid` int(11) DEFAULT NULL,
  `email_subject` varchar(100) DEFAULT NULL,
  `email_content` varchar(256) DEFAULT NULL,
  `email_attachment_path` varchar(45) DEFAULT NULL,
  `email_status` varchar(20) DEFAULT NULL COMMENT '0=>waiting,1=>unread,2=>read,3=>purge',
  `email_time` time DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`emailid`, `financialyearid`, `to_userid`, `companyid`, `from_userid`, `email_subject`, `email_content`, `email_attachment_path`, `email_status`, `email_time`) VALUES
(1, 1, 1, 1, 3, 'Lol', 'mgkhkjhkkhkhgkhghgfkhghghghghggfgfhgfhgfhdhdfgdfhdhfd', NULL, '1', '00:00:23');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `employeeid` int(11) NOT NULL,
  `employee_code` varchar(45) DEFAULT NULL,
  `employee_firstname` varchar(45) DEFAULT NULL,
  `employee_middlename` varchar(45) DEFAULT NULL,
  `employee_lastname` varchar(45) DEFAULT NULL,
  `employee_joiningdate` date DEFAULT NULL,
  `employee_qualification` varchar(45) DEFAULT NULL,
  `employee_totalexperiance` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `departmentid` int(11) DEFAULT NULL,
  `designationid` int(11) DEFAULT NULL,
  `usertypeid` int(11) DEFAULT NULL,
  `divisionid` int(11) DEFAULT NULL,
  `employee_dob` date DEFAULT NULL,
  `employee_gender` varchar(10) DEFAULT NULL COMMENT '1=>Male,2=>Female',
  `employee_address1` varchar(256) DEFAULT NULL,
  `employee_address2` varchar(256) DEFAULT NULL,
  `employee_country` varchar(45) DEFAULT NULL,
  `employee_state` varchar(45) DEFAULT NULL,
  `employee_city` varchar(45) DEFAULT NULL,
  `employee_pincode` varchar(45) DEFAULT NULL,
  `employee_phone` varchar(15) DEFAULT NULL,
  `employee_mobile` varchar(15) DEFAULT NULL,
  `employee_email` varchar(45) DEFAULT NULL,
  `employee_photo` varchar(45) DEFAULT NULL,
  `employee_status` varchar(45) DEFAULT NULL COMMENT '1=>existing,2=>resigned,3=>terminated',
  `termination_date` date DEFAULT NULL,
  `termination_reason` varchar(256) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeid`, `employee_code`, `employee_firstname`, `employee_middlename`, `employee_lastname`, `employee_joiningdate`, `employee_qualification`, `employee_totalexperiance`, `financialyearid`, `companyid`, `departmentid`, `designationid`, `usertypeid`, `divisionid`, `employee_dob`, `employee_gender`, `employee_address1`, `employee_address2`, `employee_country`, `employee_state`, `employee_city`, `employee_pincode`, `employee_phone`, `employee_mobile`, `employee_email`, `employee_photo`, `employee_status`, `termination_date`, `termination_reason`) VALUES
(1, 'e72832-039843101', 'Steve', '', 'Bandor', '2018-04-19', 'Bachelors Degree', '16', 1, 1, 3, 1, 3, 4, '1981-07-16', '1', '', 'P.O.Box 1890 ', '-1', '', 'Kumasi', '1234', '', '0244790911', 'kwabena@gmail.com', '19042018055053.jpg', '1', NULL, NULL),
(2, 'e72832-039843102', 'Kofi', '', 'Yaw', '2018-04-19', 'Bachelors Degree', '12', 1, 1, 7, 5, 6, 8, '2017-11-16', '1', '', 'Ghana', 'Ghana', 'Ashanti', 'Kumasi', '12345678', '', '0244790911', 'powerme@ymail.com', NULL, '1', NULL, NULL),
(3, 'AndyKofi', 'Yaa', '', 'Wenawome', '2018-04-11', 'Bachelors Degree', '3', 1, 1, 7, 2, 6, 9, '2018-04-01', '2', '', '14th Street Prempeh Road Santasi', 'Ghana', 'Upper East', 'Nkran', '12345678', '', '0244790911', 'powerme1@ymail.com', NULL, '1', NULL, NULL),
(4, 'AkwwaboaIsaac', 'Papa', '', 'Lolo', '2018-04-19', 'Bachelors Degree', '12', 1, 1, 3, 8, 5, 4, '2018-04-02', '1', '', '14th Street Prempeh Road Santasi', 'Ghana', 'Upper East', '', '', '', '0244790911', 'powerme3@ymail.com', NULL, '1', NULL, NULL),
(5, 'e72832-039843105', 'Kwesi', '', 'Ata', '2018-04-19', 'Bachelors Degree', '12', 1, 1, 7, 6, 6, 8, '2018-04-03', '1', '', '14th Street Prempeh Road Santasi', 'Ghana', 'Central', '', '', '', '0244790911', 'powerme4@ymail.com', NULL, '1', NULL, NULL),
(6, 'e72832-039843106', 'Humedu', '', 'Siisi', '2018-04-19', 'Bachelors Degree', '12', 1, 1, 7, 4, 6, 9, '2018-01-16', '2', '', '14th Street Prempeh Road Santasi', 'Ghana', 'Eastern', '', '', '', '0244790911', 'powerme23@ymail.com', NULL, '1', NULL, NULL),
(7, 'e72832-039843107', 'Joice', '', 'Woo', '2018-04-19', 'Bachelors Degree', '12', 1, 1, 7, 12, 6, 9, '2018-04-02', '2', '', '14th Street Prempeh Road Santasi', 'Ghana', 'Eastern', '', '', '', '0244790911', 'powerme@fmail.com', NULL, '1', NULL, NULL),
(8, 'e72832-039843108', 'Mansa', '', 'Jackie', '2018-04-19', 'Bachelors Degree', '5', 1, 1, 1, 16, 3, 11, '2018-04-03', '2', '', '14th Street Prempeh Road Santasi', 'Ghana', 'Greater Accra', '', '', '', '0244790911', 'powerm@ymail.com', NULL, '1', NULL, NULL),
(9, 'e72832-039843109', 'Efo', '', 'Dagadu', '2018-04-19', 'Bachelors Degree', '3', 1, 1, 1, 19, 2, 12, '2018-04-03', '1', '', '14th Street Prempeh Road Santasi', '-1', '', '', '', '', '0244790911', 'poerme@ymail.com', NULL, '1', NULL, NULL),
(10, 'e72832-039843110', 'Baba', '', 'Jamal', '2018-04-19', 'Bachelors Degree', '5', 1, 1, 2, 14, 4, 10, '2018-04-02', '1', '', '14th Street Prempeh Road Santasi', 'Ghana', 'Brong-Ahafo', '', '', '', '0244790911', 'owerme@ymail.com', NULL, '1', NULL, NULL),
(11, 'e72832-039843111', 'Nadia', '', 'Buari', '2018-04-19', 'Bachelors Degree', '5', 1, 1, 2, 13, 4, 10, '2018-04-09', '2', '', '14th Street Prempeh Road Santasi', 'Ghana', 'Brong-Ahafo', 'Sunyani', '', '', '0244790911', 'powme@ymail.com', NULL, '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employeeattendance`
--

CREATE TABLE IF NOT EXISTS `employeeattendance` (
  `employeeattendanceid` int(11) NOT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `remarks` varchar(256) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employeesalary`
--

CREATE TABLE IF NOT EXISTS `employeesalary` (
  `employeesalaryid` int(11) NOT NULL,
  `designationid` int(11) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `month` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `year` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employeesalarydetails`
--

CREATE TABLE IF NOT EXISTS `employeesalarydetails` (
  `employeesalarydetailsid` int(11) NOT NULL,
  `payhead` varchar(45) DEFAULT NULL,
  `amount` varchar(45) DEFAULT NULL,
  `employeesalaryid` int(11) DEFAULT NULL,
  `additionordeduction` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employeetraining`
--

CREATE TABLE IF NOT EXISTS `employeetraining` (
  `employeetrainingid` int(11) NOT NULL,
  `departmentid` int(11) DEFAULT NULL,
  `jobcategoryid` int(11) DEFAULT NULL,
  `employeetraining_title` varchar(100) DEFAULT NULL,
  `training_provider` varchar(60) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `employeetraining_location` varchar(60) DEFAULT NULL,
  `employeetraining_time` time DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `employeetraining_startdate` date DEFAULT NULL,
  `employeetraining_enddate` date DEFAULT NULL,
  `divisionid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employementstatus`
--

CREATE TABLE IF NOT EXISTS `employementstatus` (
  `employementstatusid` int(11) NOT NULL,
  `employementstatus_name` varchar(60) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employementstatus`
--

INSERT INTO `employementstatus` (`employementstatusid`, `employementstatus_name`, `financialyearid`, `companyid`) VALUES
(1, 'Full-Time Contract', 1, 1),
(2, 'Part-Time Contract', 1, 1),
(3, 'Freelance', 1, 1),
(4, 'Full-Time Probation', 1, 1),
(5, 'Full-Time Permanent', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `eventid` int(11) NOT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `eventtypeid` int(11) DEFAULT NULL,
  `event_name` varchar(60) DEFAULT NULL,
  `event_startdate` date DEFAULT NULL,
  `event_enddate` date DEFAULT NULL,
  `event_description` varchar(256) DEFAULT NULL,
  `event_created_on` date DEFAULT NULL,
  `usertypeid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `isholiday` int(11) DEFAULT NULL,
  `event_for` int(11) DEFAULT NULL,
  `departmentid` int(11) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eventtype`
--

CREATE TABLE IF NOT EXISTS `eventtype` (
  `eventtypeid` int(11) NOT NULL,
  `eventtype_name` varchar(60) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `financialyear`
--

CREATE TABLE IF NOT EXISTS `financialyear` (
  `financialyearid` int(11) NOT NULL,
  `financialyear_startyear` varchar(45) DEFAULT NULL,
  `financialyear_endyear` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `financialyear`
--

INSERT INTO `financialyear` (`financialyearid`, `financialyear_startyear`, `financialyear_endyear`, `status`) VALUES
(1, '2017', '2018', 1),
(2, '2016', '2017', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobcategory`
--

CREATE TABLE IF NOT EXISTS `jobcategory` (
  `jobcategoryid` int(11) NOT NULL,
  `jobcategory_name` varchar(60) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `divisionid` int(11) DEFAULT NULL,
  `departmentid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobcategory`
--

INSERT INTO `jobcategory` (`jobcategoryid`, `jobcategory_name`, `financialyearid`, `companyid`, `divisionid`, `departmentid`) VALUES
(1, 'Financial Controller', 1, 1, 1, 1),
(2, 'Accounts Officer', 1, 1, 2, 1),
(3, 'Recruiter', 1, 1, 4, 3),
(4, 'Head Teacher', 1, 1, 8, 7),
(5, 'Tutor', 1, 1, 8, 7),
(6, 'Principal', 1, 1, 9, 7),
(7, 'Teacher', 1, 1, 9, 7),
(8, 'Catholic Education Unit', 1, 1, 8, 7),
(9, 'Methodist  Education Unit', 1, 1, 8, 7),
(10, 'Presby Education Unit', 1, 1, 8, 7),
(11, 'Islamic Education Unit', 1, 1, 8, 7),
(12, 'Head Office', 1, 1, 10, 2),
(13, 'District Level', 1, 1, 10, 2),
(14, 'Sector Level', 1, 1, 10, 2),
(15, 'Southern Sector', 1, 1, 11, 1),
(16, 'Northern Sector', 1, 1, 12, 1),
(17, 'Audits', 1, 1, 11, 1),
(18, 'Southern Belt', 1, 1, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobdetails`
--

CREATE TABLE IF NOT EXISTS `jobdetails` (
  `jobdetailsid` int(11) NOT NULL,
  `jobdetails_subunit` varchar(45) DEFAULT NULL,
  `jobdetails_location` varchar(60) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `workshiftid` int(11) DEFAULT NULL,
  `jobcategoryid` int(11) DEFAULT NULL,
  `jobtitleid` int(11) DEFAULT NULL,
  `job_specification` varchar(60) DEFAULT NULL,
  `employementstatusid` int(11) DEFAULT NULL,
  `contract_startdate` date DEFAULT NULL,
  `contract_enddate` date DEFAULT NULL,
  `contract_description` text
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobdetails`
--

INSERT INTO `jobdetails` (`jobdetailsid`, `jobdetails_subunit`, `jobdetails_location`, `employeeid`, `financialyearid`, `companyid`, `workshiftid`, `jobcategoryid`, `jobtitleid`, `job_specification`, `employementstatusid`, `contract_startdate`, `contract_enddate`, `contract_description`) VALUES
(2, 'Head Office', NULL, 1, 1, 1, 1, 16, 5, NULL, 1, '2018-04-23', '2019-02-23', '');

-- --------------------------------------------------------

--
-- Table structure for table `jobtitle`
--

CREATE TABLE IF NOT EXISTS `jobtitle` (
  `jobtitleid` int(11) NOT NULL,
  `jobtitle_title` varchar(100) DEFAULT NULL,
  `jobtitle_description` varchar(256) DEFAULT NULL,
  `jobtitle_specification` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobtitle`
--

INSERT INTO `jobtitle` (`jobtitleid`, `jobtitle_title`, `jobtitle_description`, `jobtitle_specification`, `financialyearid`, `companyid`) VALUES
(1, 'Chief Accountant', 'Must account for all the budget allocation for GES', NULL, 1, 1),
(2, 'Teacher', 'Must teach students', NULL, 1, 1),
(3, 'Securty ', 'Must secure GES environment', NULL, 1, 1),
(4, 'Human Resource Manager', 'Must manage intake of new teachers', NULL, 1, 1),
(5, 'Statistician', 'For statistics', NULL, 1, 1),
(6, 'Finance Officer', 'For handling finance operations', NULL, 1, 1),
(7, 'Accounts Officer', 'Handles accounts of GES', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplication`
--

CREATE TABLE IF NOT EXISTS `leaveapplication` (
  `leaveapplicationid` int(11) NOT NULL,
  `leavedetailsid` int(11) DEFAULT NULL,
  `fromdate` date DEFAULT NULL,
  `todate` date DEFAULT NULL,
  `reason` varchar(256) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT '0=>waiting,1=>Approved,2=>ApprovedLOP,3=>Rejected,4=>absent without leave',
  `employeeid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leavecategory`
--

CREATE TABLE IF NOT EXISTS `leavecategory` (
  `leavecategoryid` int(11) NOT NULL,
  `leavecategory_name` varchar(60) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leavedetails`
--

CREATE TABLE IF NOT EXISTS `leavedetails` (
  `leavedetailsid` int(11) NOT NULL,
  `leavecategoryid` int(11) DEFAULT NULL,
  `designationid` int(11) DEFAULT NULL,
  `count` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loantype`
--

CREATE TABLE IF NOT EXISTS `loantype` (
  `loantypeid` int(11) NOT NULL,
  `loantype_name` varchar(60) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payabletype`
--

CREATE TABLE IF NOT EXISTS `payabletype` (
  `payabletypeid` int(11) NOT NULL,
  `payabletype_name` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payabletype`
--

INSERT INTO `payabletype` (`payabletypeid`, `payabletype_name`, `financialyearid`, `companyid`) VALUES
(1, 'Cash', 1, 1),
(2, 'Cheque', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payheadmaster`
--

CREATE TABLE IF NOT EXISTS `payheadmaster` (
  `payheadmasterid` int(11) NOT NULL,
  `payheadname` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `isadditionordeduction` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payheadmaster`
--

INSERT INTO `payheadmaster` (`payheadmasterid`, `payheadname`, `description`, `isadditionordeduction`, `financialyearid`, `companyid`) VALUES
(1, 'Basic Salary', '', '1', 1, 1),
(2, 'TA', '', '1', 1, 1),
(3, 'TDS', '', '2', 1, 1),
(4, 'HRA', '', '1', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE IF NOT EXISTS `privilege` (
  `privilegeid` int(11) NOT NULL,
  `usertypeid` int(11) DEFAULT NULL,
  `privilege_link` varchar(45) DEFAULT NULL,
  `enable_disable` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`user_id`, `lastname`, `firstname`) VALUES
(1, 'Admin', 'Administrator'),
(2, 'Demo', 'Demo');

-- --------------------------------------------------------

--
-- Table structure for table `profiles_fields`
--

CREATE TABLE IF NOT EXISTS `profiles_fields` (
  `id` int(10) NOT NULL,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profiles_fields`
--

INSERT INTO `profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `recruitment`
--

CREATE TABLE IF NOT EXISTS `recruitment` (
  `recruitmentid` int(11) NOT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `vacancyid` int(11) DEFAULT NULL,
  `candidate_name` varchar(45) DEFAULT NULL,
  `date_of_application` date DEFAULT NULL,
  `emailid` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT '1=>apln initiated,2=>shortlisted,3=>interview scheduled,4=>interview passed,5=>failed,6=>job offered,7=>offer declined,8=>rejected,9=>hired',
  `resume` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salarydetails`
--

CREATE TABLE IF NOT EXISTS `salarydetails` (
  `salarydetailsid` int(11) NOT NULL,
  `designationid` int(11) DEFAULT NULL,
  `payheadmasterid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `unit` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `smsnotificationsettings`
--

CREATE TABLE IF NOT EXISTS `smsnotificationsettings` (
  `smsnotificationsettingsid` int(11) NOT NULL,
  `url` varchar(256) DEFAULT NULL,
  `joining` varchar(45) DEFAULT NULL,
  `event` varchar(45) DEFAULT NULL,
  `absent` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `joining_msg` varchar(45) DEFAULT NULL,
  `event_msg` varchar(45) DEFAULT NULL,
  `absent_msg` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `taskmanager`
--

CREATE TABLE IF NOT EXISTS `taskmanager` (
  `taskmanagerid` int(11) NOT NULL,
  `task_heading` varchar(60) DEFAULT NULL,
  `task_description` varchar(256) DEFAULT NULL,
  `task_priority` varchar(45) DEFAULT NULL COMMENT '1=>highest priority,2=>high,3=>normal,4=>low',
  `task_date` date DEFAULT NULL,
  `task_status` varchar(45) DEFAULT NULL COMMENT '1=>open,2=>on hold,3=>resolved,4=>closed',
  `usertypeid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taskmanager`
--

INSERT INTO `taskmanager` (`taskmanagerid`, `task_heading`, `task_description`, `task_priority`, `task_date`, `task_status`, `usertypeid`, `userid`, `companyid`, `financialyearid`) VALUES
(1, 'Census of Teachers', 'Head count of teaching staff', '1', '2018-04-26', '1', 2, 9, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcomplaints`
--

CREATE TABLE IF NOT EXISTS `tblcomplaints` (
  `complaintNumber` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `complaintDetails` mediumtext NOT NULL,
  `complaintFile` varchar(255) DEFAULT NULL,
  `regDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) DEFAULT NULL,
  `lastUpdationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcomplaints`
--

INSERT INTO `tblcomplaints` (`complaintNumber`, `userId`, `category`, `complaintDetails`, `complaintFile`, `regDate`, `status`, `lastUpdationDate`) VALUES
(4, 2, 1, 'jhhhhhhhhhhhhhhhhhh', '', '2018-05-09 08:38:25', 'closed', '2018-05-09 09:29:37'),
(5, 2, 1, 'kloklok', '', '2018-05-09 08:39:28', NULL, '0000-00-00 00:00:00'),
(6, 2, 1, 'kloklok', '', '2018-05-09 09:00:23', NULL, '0000-00-00 00:00:00'),
(8, 2, 2, 'Now now Now', '', '2018-05-09 10:04:37', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE IF NOT EXISTS `todo` (
  `todoid` int(11) NOT NULL,
  `todo_subject` varchar(60) DEFAULT NULL,
  `todo_content` varchar(256) DEFAULT NULL,
  `todo_date` date DEFAULT NULL,
  `usertypeid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` int(10) NOT NULL DEFAULT '0',
  `lastvisit_at` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `usertypeid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`, `usertypeid`, `userid`, `companyid`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', 'fa1050e67daa1ec6fd6d0c71d14b544c', 2015, 2018, 1, 1, 0, 1, 1),
(2, 'demo', '21232f297a57a5a743894a0e4a801fc3', 'demo@example.com', '099f825543f7850cc038b90aaff39fac', 2015, 2018, 0, 1, 10000, 0, 1),
(3, '1e72832-039843101', '21232f297a57a5a743894a0e4a801fc3', 'kwabena@gmail.com', '94b091953a4409d1f9facbe23629f479', 0, 0, 0, 1, 3, 1, 1),
(4, 'AkwwaboaIsaac', 'd6590ba44401e89d5243bdb42a3af760', 'powerme@ymail.com', 'df856edd0cb10e145906be261f4d8c87', 0, 2018, 0, 1, 6, 2, 1),
(5, '1e72832-039843103', '44b330e60d6760b93c0986bbea84e24e', 'powerme1@ymail.com', '024cf1bb285897b2c219d11baf64062e', 0, 0, 0, 1, 6, 3, 1),
(6, '1e72832-039843104', '2f64e83dce44aeaed7e26c92a96681fd', 'powerme3@ymail.com', 'baed6c6a6ff30f05188cb44bd239cc4e', 0, 0, 0, 1, 5, 4, 1),
(7, '1e72832-039843105', 'bcdbcac53eeb964e76921ec7ca6c97a2', 'powerme4@ymail.com', '7dcf62222d96958235bec709a36f321a', 0, 0, 0, 1, 6, 5, 1),
(8, '1e72832-039843106', '2e6cc108f09091c417f4760eed1aa3a5', 'powerme23@ymail.com', '8f682ff8f5d3758ad5b9891b3eeaf45b', 0, 0, 0, 1, 6, 6, 1),
(9, '1e72832-039843107', '9080d2f13402433cd6ce53f25168341b', 'powerme@fmail.com', '341e66dd5d2a241a6fe125d629f77beb', 0, 0, 0, 1, 6, 7, 1),
(10, '1e72832-039843108', '69d6eafb1be30b177e26cb10da033838', 'powerm@ymail.com', '19d2ee68443c7ec5263c79e2b2319f6e', 0, 0, 0, 1, 3, 8, 1),
(11, '1e72832-039843109', '5a69558ec75b4571d14b85f117d7b732', 'poerme@ymail.com', '4a865191320b5155cde0bce767537ea1', 0, 0, 0, 1, 2, 9, 1),
(12, '1e72832-039843110', '547e3448e3c990b0a4c1b18f7f7cbd59', 'owerme@ymail.com', '1fc954c84aa7765ecbd1e38c8afae3cb', 0, 0, 0, 1, 4, 10, 1),
(13, '1e72832-039843111', 'd5e83c960a33751ea9d448300a8cc31d', 'powme@ymail.com', 'e1cf6dba92ae819ada58e9b9d8042926', 0, 0, 0, 1, 4, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_hrdb`
--

CREATE TABLE IF NOT EXISTS `users_hrdb` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_hrdb`
--

INSERT INTO `users_hrdb` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE IF NOT EXISTS `usertype` (
  `usertypeid` int(11) NOT NULL,
  `usertype_name` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`usertypeid`, `usertype_name`, `financialyearid`, `companyid`) VALUES
(1, 'Admin', 1, 1),
(2, 'Statistician', 1, 1),
(3, 'Accountant', 1, 1),
(4, 'Inspectorate', 1, 1),
(5, 'Human Resource', 1, 1),
(6, 'Teacher', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vacancy`
--

CREATE TABLE IF NOT EXISTS `vacancy` (
  `vacancyid` int(11) NOT NULL,
  `jobcategoryid` int(11) DEFAULT NULL,
  `vacancy_name` varchar(60) DEFAULT NULL,
  `vacancy_description` varchar(100) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT '1=>active,2=>closed',
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE IF NOT EXISTS `workers` (
  `id` int(11) NOT NULL,
  `worker_fname` varchar(255) NOT NULL,
  `worker_lname` varchar(255) NOT NULL,
  `profilepic` varchar(255) NOT NULL,
  `esi` int(11) NOT NULL,
  `advance` int(11) NOT NULL,
  `month` date NOT NULL,
  `year` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`id`, `worker_fname`, `worker_lname`, `profilepic`, `esi`, `advance`, `month`, `year`) VALUES
(12, 'Kofi', 'Lolo', '', 0, 0, '0000-00-00', '0000-00-00'),
(12, 'Kofi', 'Lolo', '', 0, 0, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `worker_acc`
--

CREATE TABLE IF NOT EXISTS `worker_acc` (
  `id` int(11) NOT NULL,
  `accno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worker_acc`
--

INSERT INTO `worker_acc` (`id`, `accno`) VALUES
(12, 2147483647),
(12, 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `worker_varys`
--

CREATE TABLE IF NOT EXISTS `worker_varys` (
  `id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `workdays` int(11) NOT NULL,
  `pf` int(11) NOT NULL,
  `esi` int(11) NOT NULL,
  `advance` int(11) NOT NULL,
  `month` date NOT NULL,
  `year` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worker_varys`
--

INSERT INTO `worker_varys` (`id`, `rate`, `workdays`, `pf`, `esi`, `advance`, `month`, `year`) VALUES
(12, 826, 5, 10, 20, 2, '0000-00-00', '0000-00-00'),
(12, 826, 5, 10, 20, 2, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `workshift`
--

CREATE TABLE IF NOT EXISTS `workshift` (
  `workshiftid` int(11) NOT NULL,
  `workshift_name` varchar(60) DEFAULT NULL,
  `workshift_starttime` time DEFAULT NULL,
  `workshift_endtime` time DEFAULT NULL,
  `workshift_hoursperday` varchar(45) DEFAULT NULL,
  `financialyearid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workshift`
--

INSERT INTO `workshift` (`workshiftid`, `workshift_name`, `workshift_starttime`, `workshift_endtime`, `workshift_hoursperday`, `financialyearid`, `companyid`) VALUES
(1, 'Weekend', '08:00:00', '02:00:00', '4.3958333333333', 1, 1),
(2, 'Weekday', '08:05:00', '05:05:00', '9', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addloans`
--
ALTER TABLE `addloans`
  ADD PRIMARY KEY (`addloansid`), ADD KEY `fk_addloans_loantype1_idx` (`loantypeid`), ADD KEY `fk_addloans_company1_idx` (`companyid`), ADD KEY `fk_addloans_financialyear1_idx` (`financialyearid`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcementid`), ADD KEY `fk_announcement_financialyear1_idx` (`financialyearid`), ADD KEY `fk_announcement_company1_idx` (`companyid`);

--
-- Indexes for table `assignloan`
--
ALTER TABLE `assignloan`
  ADD PRIMARY KEY (`assignloanid`), ADD KEY `fk_assignloan_addloans1_idx` (`addloansid`), ADD KEY `fk_assignloan_employee1_idx` (`employeeid`), ADD KEY `fk_assignloan_designation1_idx` (`designationid`), ADD KEY `fk_assignloan_company1_idx` (`companyid`), ADD KEY `fk_assignloan_financialyear1_idx` (`financialyearid`);

--
-- Indexes for table `authassignment`
--
ALTER TABLE `authassignment`
  ADD PRIMARY KEY (`itemname`,`userid`);

--
-- Indexes for table `authitem`
--
ALTER TABLE `authitem`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `authitemchild`
--
ALTER TABLE `authitemchild`
  ADD PRIMARY KEY (`parent`,`child`), ADD KEY `child` (`child`);

--
-- Indexes for table `bankdetails`
--
ALTER TABLE `bankdetails`
  ADD PRIMARY KEY (`bankdetailsid`), ADD KEY `fk_bankdetails_employee1_idx` (`employeeid`), ADD KEY `fk_bankdetails_financialyear1_idx` (`financialyearid`), ADD KEY `fk_bankdetails_company1_idx` (`companyid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `circular`
--
ALTER TABLE `circular`
  ADD PRIMARY KEY (`circularid`), ADD KEY `fk_circular_company1_idx` (`companyid`), ADD KEY `companyid` (`companyid`), ADD KEY `financialyearid` (`financialyearid`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`companyid`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentid`), ADD KEY `fk_department_financialyear_idx` (`financialyearid`), ADD KEY `fk_department_company1_idx` (`companyid`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`designationid`), ADD KEY `fk_designation_financialyear1_idx` (`financialyearid`), ADD KEY `fk_designation_company1_idx` (`companyid`), ADD KEY `fk_designation_department1_idx` (`departmentid`), ADD KEY `fk_designation_division1_idx` (`divisionid`), ADD KEY `fk_designation_jobcategory1_idx` (`jobcategoryid`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`divisionid`), ADD KEY `fk_division_department1_idx` (`departmentid`), ADD KEY `fk_division_company1_idx` (`companyid`), ADD KEY `fk_division_financialyear1_idx` (`financialyearid`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`emailid`), ADD KEY `fk_email_financialyear1_idx` (`financialyearid`), ADD KEY `fk_email_company1_idx` (`companyid`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeid`), ADD KEY `fk_employee_financialyear1_idx` (`financialyearid`), ADD KEY `fk_employee_company1_idx` (`companyid`), ADD KEY `fk_employee_department1_idx` (`departmentid`), ADD KEY `fk_employee_designation1_idx` (`designationid`), ADD KEY `fk_employee_usertype1_idx` (`usertypeid`), ADD KEY `divisionid` (`divisionid`);

--
-- Indexes for table `employeeattendance`
--
ALTER TABLE `employeeattendance`
  ADD PRIMARY KEY (`employeeattendanceid`), ADD KEY `fk_employeeattendance_employee1_idx` (`employeeid`), ADD KEY `fk_employeeattendance_financialyear1_idx` (`financialyearid`), ADD KEY `fk_employeeattendance_company1_idx` (`companyid`);

--
-- Indexes for table `employeesalary`
--
ALTER TABLE `employeesalary`
  ADD PRIMARY KEY (`employeesalaryid`), ADD KEY `fk_employeesalary_designation1_idx` (`designationid`), ADD KEY `fk_employeesalary_employee1_idx` (`employeeid`), ADD KEY `fk_employeesalary_financialyear1_idx` (`financialyearid`), ADD KEY `fk_employeesalary_company1_idx` (`companyid`);

--
-- Indexes for table `employeesalarydetails`
--
ALTER TABLE `employeesalarydetails`
  ADD PRIMARY KEY (`employeesalarydetailsid`), ADD KEY `fk_employeesalarydetails_employeesalary1_idx` (`employeesalaryid`), ADD KEY `fk_employeesalarydetails_financialyear1_idx` (`financialyearid`), ADD KEY `fk_employeesalarydetails_company1_idx` (`companyid`);

--
-- Indexes for table `employeetraining`
--
ALTER TABLE `employeetraining`
  ADD PRIMARY KEY (`employeetrainingid`), ADD KEY `fk_employeetraining_department1_idx` (`departmentid`), ADD KEY `fk_employeetraining_jobcategory1_idx` (`jobcategoryid`), ADD KEY `fk_employeetraining_employee1_idx` (`employeeid`), ADD KEY `fk_employeetraining_financialyear1_idx` (`financialyearid`), ADD KEY `fk_employeetraining_company1_idx` (`companyid`), ADD KEY `fk_employeetraining_division1_idx` (`divisionid`);

--
-- Indexes for table `employementstatus`
--
ALTER TABLE `employementstatus`
  ADD PRIMARY KEY (`employementstatusid`), ADD KEY `fk_employementstatus_financialyear1_idx` (`financialyearid`), ADD KEY `fk_employementstatus_company1_idx` (`companyid`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventid`), ADD KEY `fk_event_eventtype1_idx` (`eventtypeid`), ADD KEY `fk_event_financialyear1_idx` (`financialyearid`), ADD KEY `fk_event_company1_idx` (`companyid`);

--
-- Indexes for table `eventtype`
--
ALTER TABLE `eventtype`
  ADD PRIMARY KEY (`eventtypeid`), ADD KEY `fk_eventtype_financialyear1_idx` (`financialyearid`), ADD KEY `fk_eventtype_company1_idx` (`companyid`);

--
-- Indexes for table `financialyear`
--
ALTER TABLE `financialyear`
  ADD PRIMARY KEY (`financialyearid`);

--
-- Indexes for table `jobcategory`
--
ALTER TABLE `jobcategory`
  ADD PRIMARY KEY (`jobcategoryid`), ADD KEY `fk_jobcategory_company1_idx` (`companyid`), ADD KEY `fk_jobcategory_department1_idx` (`departmentid`), ADD KEY `fk_jobcategory_financialyear1_idx` (`financialyearid`), ADD KEY `fk_jobcategory_division1_idx` (`divisionid`);

--
-- Indexes for table `jobdetails`
--
ALTER TABLE `jobdetails`
  ADD PRIMARY KEY (`jobdetailsid`), ADD KEY `fk_jobdetails_employee1_idx` (`employeeid`), ADD KEY `fk_jobdetails_financialyear1_idx` (`financialyearid`), ADD KEY `fk_jobdetails_company1_idx` (`companyid`), ADD KEY `fk_jobdetails_workshift1_idx` (`workshiftid`), ADD KEY `fk_jobdetails_jobcategory1_idx` (`jobcategoryid`), ADD KEY `fk_jobdetails_jobtitle1_idx` (`jobtitleid`), ADD KEY `fk_jobdetails_employementstatus1_idx` (`employementstatusid`);

--
-- Indexes for table `jobtitle`
--
ALTER TABLE `jobtitle`
  ADD PRIMARY KEY (`jobtitleid`), ADD KEY `fk_jobtitle_financialyear1_idx` (`financialyearid`), ADD KEY `fk_jobtitle_company1_idx` (`companyid`);

--
-- Indexes for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD PRIMARY KEY (`leaveapplicationid`), ADD KEY `fk_leaveapplication_leavedetails1_idx` (`leavedetailsid`), ADD KEY `fk_leaveapplication_employee1_idx` (`employeeid`), ADD KEY `fk_leaveapplication_financialyear1_idx` (`financialyearid`), ADD KEY `fk_leaveapplication_company1_idx` (`companyid`);

--
-- Indexes for table `leavecategory`
--
ALTER TABLE `leavecategory`
  ADD PRIMARY KEY (`leavecategoryid`), ADD KEY `fk_leavecategory_financialyear1_idx` (`financialyearid`), ADD KEY `fk_leavecategory_company1_idx` (`companyid`);

--
-- Indexes for table `leavedetails`
--
ALTER TABLE `leavedetails`
  ADD PRIMARY KEY (`leavedetailsid`), ADD KEY `fk_leavedetails_leavecategory1_idx` (`leavecategoryid`), ADD KEY `fk_leavedetails_designation1_idx` (`designationid`), ADD KEY `fk_leavedetails_financialyear1_idx` (`financialyearid`), ADD KEY `fk_leavedetails_company1_idx` (`companyid`);

--
-- Indexes for table `loantype`
--
ALTER TABLE `loantype`
  ADD PRIMARY KEY (`loantypeid`), ADD KEY `fk_loantype_company1_idx` (`companyid`), ADD KEY `fk_loantype_financialyear1_idx` (`financialyearid`);

--
-- Indexes for table `payabletype`
--
ALTER TABLE `payabletype`
  ADD PRIMARY KEY (`payabletypeid`), ADD KEY `fk_payabletype_financialyear1_idx` (`financialyearid`), ADD KEY `fk_payabletype_company1_idx` (`companyid`);

--
-- Indexes for table `payheadmaster`
--
ALTER TABLE `payheadmaster`
  ADD PRIMARY KEY (`payheadmasterid`), ADD KEY `fk_payheadmaster_financialyear1_idx` (`financialyearid`), ADD KEY `fk_payheadmaster_company1_idx` (`companyid`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`privilegeid`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `profiles_fields`
--
ALTER TABLE `profiles_fields`
  ADD PRIMARY KEY (`id`), ADD KEY `varname` (`varname`,`widget`,`visible`);

--
-- Indexes for table `recruitment`
--
ALTER TABLE `recruitment`
  ADD PRIMARY KEY (`recruitmentid`), ADD KEY `fk_recruitment_financialyear1_idx` (`financialyearid`), ADD KEY `fk_recruitment_company1_idx` (`companyid`), ADD KEY `fk_recruitment_vacancy1_idx` (`vacancyid`);

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`itemname`);

--
-- Indexes for table `salarydetails`
--
ALTER TABLE `salarydetails`
  ADD PRIMARY KEY (`salarydetailsid`), ADD KEY `fk_salarydetails_designation1_idx` (`designationid`), ADD KEY `fk_salarydetails_payheadmaster1_idx` (`payheadmasterid`), ADD KEY `fk_salarydetails_company1_idx` (`companyid`), ADD KEY `fk_salarydetails_employee1_idx` (`employeeid`), ADD KEY `fk_salarydetails_financialyear1_idx` (`financialyearid`);

--
-- Indexes for table `smsnotificationsettings`
--
ALTER TABLE `smsnotificationsettings`
  ADD PRIMARY KEY (`smsnotificationsettingsid`), ADD KEY `fk_smsnotificationsettings_financialyear1_idx` (`financialyearid`), ADD KEY `fk_smsnotificationsettings_company1_idx` (`companyid`);

--
-- Indexes for table `taskmanager`
--
ALTER TABLE `taskmanager`
  ADD PRIMARY KEY (`taskmanagerid`), ADD KEY `fk_taskmanager_company1_idx` (`companyid`), ADD KEY `fk_taskmanager_financialyear1_idx` (`financialyearid`);

--
-- Indexes for table `tblcomplaints`
--
ALTER TABLE `tblcomplaints`
  ADD PRIMARY KEY (`complaintNumber`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`todoid`), ADD KEY `fk_todo_financialyear1_idx` (`financialyearid`), ADD KEY `fk_todo_company1_idx` (`companyid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD KEY `status` (`status`), ADD KEY `superuser` (`superuser`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`usertypeid`), ADD KEY `fk_usertype_financialyear1_idx` (`financialyearid`), ADD KEY `fk_usertype_company1_idx` (`companyid`);

--
-- Indexes for table `vacancy`
--
ALTER TABLE `vacancy`
  ADD PRIMARY KEY (`vacancyid`), ADD KEY `fk_vacancy_jobcategory1_idx` (`jobcategoryid`), ADD KEY `fk_vacancy_employee1_idx` (`employeeid`), ADD KEY `fk_vacancy_financialyear1_idx` (`financialyearid`), ADD KEY `fk_vacancy_company1_idx` (`companyid`);

--
-- Indexes for table `workshift`
--
ALTER TABLE `workshift`
  ADD PRIMARY KEY (`workshiftid`), ADD KEY `fk_workshift_financialyear1_idx` (`financialyearid`), ADD KEY `fk_workshift_company1_idx` (`companyid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addloans`
--
ALTER TABLE `addloans`
  MODIFY `addloansid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcementid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `assignloan`
--
ALTER TABLE `assignloan`
  MODIFY `assignloanid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bankdetails`
--
ALTER TABLE `bankdetails`
  MODIFY `bankdetailsid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `circular`
--
ALTER TABLE `circular`
  MODIFY `circularid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `companyid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `designationid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `divisionid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `emailid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employeeid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `employeeattendance`
--
ALTER TABLE `employeeattendance`
  MODIFY `employeeattendanceid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employeesalary`
--
ALTER TABLE `employeesalary`
  MODIFY `employeesalaryid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employeesalarydetails`
--
ALTER TABLE `employeesalarydetails`
  MODIFY `employeesalarydetailsid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employeetraining`
--
ALTER TABLE `employeetraining`
  MODIFY `employeetrainingid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employementstatus`
--
ALTER TABLE `employementstatus`
  MODIFY `employementstatusid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `eventtype`
--
ALTER TABLE `eventtype`
  MODIFY `eventtypeid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `financialyear`
--
ALTER TABLE `financialyear`
  MODIFY `financialyearid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobcategory`
--
ALTER TABLE `jobcategory`
  MODIFY `jobcategoryid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `jobdetails`
--
ALTER TABLE `jobdetails`
  MODIFY `jobdetailsid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobtitle`
--
ALTER TABLE `jobtitle`
  MODIFY `jobtitleid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  MODIFY `leaveapplicationid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leavecategory`
--
ALTER TABLE `leavecategory`
  MODIFY `leavecategoryid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leavedetails`
--
ALTER TABLE `leavedetails`
  MODIFY `leavedetailsid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loantype`
--
ALTER TABLE `loantype`
  MODIFY `loantypeid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payabletype`
--
ALTER TABLE `payabletype`
  MODIFY `payabletypeid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `payheadmaster`
--
ALTER TABLE `payheadmaster`
  MODIFY `payheadmasterid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `privilegeid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `profiles_fields`
--
ALTER TABLE `profiles_fields`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `recruitment`
--
ALTER TABLE `recruitment`
  MODIFY `recruitmentid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `salarydetails`
--
ALTER TABLE `salarydetails`
  MODIFY `salarydetailsid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `smsnotificationsettings`
--
ALTER TABLE `smsnotificationsettings`
  MODIFY `smsnotificationsettingsid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `taskmanager`
--
ALTER TABLE `taskmanager`
  MODIFY `taskmanagerid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tblcomplaints`
--
ALTER TABLE `tblcomplaints`
  MODIFY `complaintNumber` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `todoid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `usertypeid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `vacancy`
--
ALTER TABLE `vacancy`
  MODIFY `vacancyid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workshift`
--
ALTER TABLE `workshift`
  MODIFY `workshiftid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `addloans`
--
ALTER TABLE `addloans`
ADD CONSTRAINT `fk_addloans_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_addloans_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_addloans_loantype1` FOREIGN KEY (`loantypeid`) REFERENCES `loantype` (`loantypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
ADD CONSTRAINT `fk_announcement_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_announcement_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `assignloan`
--
ALTER TABLE `assignloan`
ADD CONSTRAINT `fk_assignloan_addloans1` FOREIGN KEY (`addloansid`) REFERENCES `addloans` (`addloansid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_assignloan_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_assignloan_designation1` FOREIGN KEY (`designationid`) REFERENCES `designation` (`designationid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_assignloan_employee1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_assignloan_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `authassignment`
--
ALTER TABLE `authassignment`
ADD CONSTRAINT `authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `authitemchild`
--
ALTER TABLE `authitemchild`
ADD CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bankdetails`
--
ALTER TABLE `bankdetails`
ADD CONSTRAINT `fk_bankdetails_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_bankdetails_employee1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_bankdetails_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `circular`
--
ALTER TABLE `circular`
ADD CONSTRAINT `circular_ibfk_1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`),
ADD CONSTRAINT `circular_ibfk_2` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
ADD CONSTRAINT `fk_department_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_department_financialyear` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `designation`
--
ALTER TABLE `designation`
ADD CONSTRAINT `fk_designation_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_designation_department1` FOREIGN KEY (`departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_designation_division1` FOREIGN KEY (`divisionid`) REFERENCES `division` (`divisionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_designation_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_designation_jobcategory1` FOREIGN KEY (`jobcategoryid`) REFERENCES `jobcategory` (`jobcategoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `division`
--
ALTER TABLE `division`
ADD CONSTRAINT `fk_division_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_division_department1` FOREIGN KEY (`departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_division_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `email`
--
ALTER TABLE `email`
ADD CONSTRAINT `fk_email_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_email_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
ADD CONSTRAINT `fk_employee_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employee_department1` FOREIGN KEY (`departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employee_designation1` FOREIGN KEY (`designationid`) REFERENCES `designation` (`designationid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employee_division1` FOREIGN KEY (`divisionid`) REFERENCES `division` (`divisionid`),
ADD CONSTRAINT `fk_employee_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employee_usertype1` FOREIGN KEY (`usertypeid`) REFERENCES `usertype` (`usertypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employeeattendance`
--
ALTER TABLE `employeeattendance`
ADD CONSTRAINT `fk_employeeattendance_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeeattendance_employee1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeeattendance_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employeesalary`
--
ALTER TABLE `employeesalary`
ADD CONSTRAINT `fk_employeesalary_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeesalary_designation1` FOREIGN KEY (`designationid`) REFERENCES `designation` (`designationid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeesalary_employee1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeesalary_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employeesalarydetails`
--
ALTER TABLE `employeesalarydetails`
ADD CONSTRAINT `fk_employeesalarydetails_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeesalarydetails_employeesalary1` FOREIGN KEY (`employeesalaryid`) REFERENCES `employeesalary` (`employeesalaryid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeesalarydetails_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employeetraining`
--
ALTER TABLE `employeetraining`
ADD CONSTRAINT `fk_employeetraining_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeetraining_department1` FOREIGN KEY (`departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeetraining_division1` FOREIGN KEY (`divisionid`) REFERENCES `division` (`divisionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeetraining_employee1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeetraining_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_employeetraining_jobcategory1` FOREIGN KEY (`jobcategoryid`) REFERENCES `jobcategory` (`jobcategoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
ADD CONSTRAINT `fk_event_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_event_eventtype1` FOREIGN KEY (`eventtypeid`) REFERENCES `eventtype` (`eventtypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_event_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `eventtype`
--
ALTER TABLE `eventtype`
ADD CONSTRAINT `fk_eventtype_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_eventtype_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jobcategory`
--
ALTER TABLE `jobcategory`
ADD CONSTRAINT `fk_jobcategory_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobcategory_department1` FOREIGN KEY (`departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobcategory_division1` FOREIGN KEY (`divisionid`) REFERENCES `division` (`divisionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobcategory_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jobdetails`
--
ALTER TABLE `jobdetails`
ADD CONSTRAINT `fk_jobdetails_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobdetails_employee1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobdetails_employementstatus1` FOREIGN KEY (`employementstatusid`) REFERENCES `employementstatus` (`employementstatusid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobdetails_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobdetails_jobcategory1` FOREIGN KEY (`jobcategoryid`) REFERENCES `jobcategory` (`jobcategoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobdetails_jobtitle1` FOREIGN KEY (`jobtitleid`) REFERENCES `jobtitle` (`jobtitleid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobdetails_workshift1` FOREIGN KEY (`workshiftid`) REFERENCES `workshift` (`workshiftid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jobtitle`
--
ALTER TABLE `jobtitle`
ADD CONSTRAINT `fk_jobtitle_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_jobtitle_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
ADD CONSTRAINT `fk_leaveapplication_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_leaveapplication_employee1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_leaveapplication_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_leaveapplication_leavedetails1` FOREIGN KEY (`leavedetailsid`) REFERENCES `leavedetails` (`leavedetailsid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leavecategory`
--
ALTER TABLE `leavecategory`
ADD CONSTRAINT `fk_leavecategory_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_leavecategory_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leavedetails`
--
ALTER TABLE `leavedetails`
ADD CONSTRAINT `fk_leavedetails_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_leavedetails_designation1` FOREIGN KEY (`designationid`) REFERENCES `designation` (`designationid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_leavedetails_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_leavedetails_leavecategory1` FOREIGN KEY (`leavecategoryid`) REFERENCES `leavecategory` (`leavecategoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `loantype`
--
ALTER TABLE `loantype`
ADD CONSTRAINT `fk_loantype_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_loantype_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recruitment`
--
ALTER TABLE `recruitment`
ADD CONSTRAINT `fk_recruitment_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_recruitment_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_recruitment_vacancy1` FOREIGN KEY (`vacancyid`) REFERENCES `vacancy` (`vacancyid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rights`
--
ALTER TABLE `rights`
ADD CONSTRAINT `rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salarydetails`
--
ALTER TABLE `salarydetails`
ADD CONSTRAINT `fk_salarydetails_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_salarydetails_designation1` FOREIGN KEY (`designationid`) REFERENCES `designation` (`designationid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_salarydetails_employee1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_salarydetails_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_salarydetails_payheadmaster1` FOREIGN KEY (`payheadmasterid`) REFERENCES `payheadmaster` (`payheadmasterid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `smsnotificationsettings`
--
ALTER TABLE `smsnotificationsettings`
ADD CONSTRAINT `fk_smsnotificationsettings_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_smsnotificationsettings_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `taskmanager`
--
ALTER TABLE `taskmanager`
ADD CONSTRAINT `fk_taskmanager_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_taskmanager_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `todo`
--
ALTER TABLE `todo`
ADD CONSTRAINT `fk_todo_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_todo_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vacancy`
--
ALTER TABLE `vacancy`
ADD CONSTRAINT `fk_vacancy_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_vacancy_employee1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_vacancy_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_vacancy_jobcategory1` FOREIGN KEY (`jobcategoryid`) REFERENCES `jobcategory` (`jobcategoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `workshift`
--
ALTER TABLE `workshift`
ADD CONSTRAINT `fk_workshift_company1` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_workshift_financialyear1` FOREIGN KEY (`financialyearid`) REFERENCES `financialyear` (`financialyearid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
