-- ========================================================
-- Database Setup Script for Contract Detail App
-- ========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- 1. Database for Contact Details: `contat`
--    Configured in `db.php` ($dbname = "contat")
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `contat` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `contat`;

--
-- Table structure for table `names` (Active Contacts)
--

CREATE TABLE IF NOT EXISTS `names` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sample data for table `names`
--

INSERT INTO `names` (`id`, `name`, `phone`) VALUES
(1, 'Subodh', '9800000000'),
(2, 'John Doe', '9812345678'),
(3, 'Jane Smith', '9876543210');

-- --------------------------------------------------------
-- Table structure for table `deleted_names`
-- Stores logically deleted contacts moved from `names`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `deleted_names` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `deleted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `deleted_by` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- (Optional) Table structure for table `login` in `contat` db
-- If you prefer using a single database, you can change
-- $db_name = "contat" in logincon.php to use this table.
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `login` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sample login data for `contat` database
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123'),
(2, 'user', 'user123');


-- --------------------------------------------------------
-- 2. Database for Login Authentication: `login`
--    Configured in `logincon.php` ($db_name = "login")
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `login` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `login`;

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sample login data for `login` database
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123'),
(2, 'user', 'user123');

COMMIT;
