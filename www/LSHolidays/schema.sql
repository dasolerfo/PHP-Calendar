CREATE DATABASE IF NOT EXISTS AC1_project_db;
USE AC1_project_db;

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
    `user_id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Month`;
CREATE TABLE `Month` (
    `month_number` INT NOT NULL,
    `month_name` VARCHAR(255),
    PRIMARY KEY (`month_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Day`;
CREATE TABLE `Day` (
    `day_number` INT NOT NULL,
    `month_number` INT NOT NULL,
    `holiday_name` VARCHAR(255),
    `holiday_description` TEXT,
    PRIMARY KEY (`day_number`),
    FOREIGN KEY (`month_number`) REFERENCES `Month`(`month_number`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;