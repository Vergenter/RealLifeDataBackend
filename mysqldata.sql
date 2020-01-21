DROP DATABASE IF EXISTS `real_life_data`;
CREATE DATABASE `real_life_data`; 
USE `real_life_data`;

SET NAMES utf8mb4 ;
SET character_set_client = utf8mb4 ;

CREATE TABLE `entry_type` (
  `entry_type_id` tinyint NOT NULL AUTO_INCREMENT,
  `entry_type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`entry_type_id`)
);
INSERT INTO `entry_type` VALUES (1,'Object');
INSERT INTO `entry_type` VALUES (2,'Feature');

CREATE TABLE `entry` (
  `entry_id` int NOT NULL AUTO_INCREMENT,
  `entry_type_id` tinyint,
  `entry_name` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`entry_id`),
  FOREIGN KEY (`entry_type_id`)
    REFERENCES `entry_type`(`entry_type_id`)
    ON DELETE CASCADE
);

CREATE TABLE `data` (
  `entry_id` int NOT NULL,
  `creation_time`     DATETIME DEFAULT CURRENT_TIMESTAMP,
  `value` DECIMAL(20,10) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`entry_id`),
  FOREIGN KEY (`entry_id`)
        REFERENCES `entry`(`entry_id`)
        ON DELETE CASCADE
);

CREATE TABLE `restrictions` (
  `entry_id` int NOT NULL,
  `min_value` DECIMAL(20,10) NOT NULL,
  `max_value` DECIMAL(20,10) NOT NULL,
  `step` DECIMAL(20,10) NOT NULL,
  PRIMARY KEY (`entry_id`),
    FOREIGN KEY (`entry_id`)
        REFERENCES `entry`(`entry_id`)
        ON DELETE CASCADE
);

CREATE TABLE `role` (
  `role_id` tinyint NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
);
INSERT INTO `role` VALUES (1,'Admin');
INSERT INTO `role` VALUES (2,'User');

CREATE TABLE `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `entry_id` int NOT NULL,
  `role_id` tinyint NOT NULL,
  FOREIGN KEY (`role_id`)
        REFERENCES `role`(`role_id`)
        ON DELETE CASCADE,
  FOREIGN KEY (`entry_id`)
        REFERENCES `entry`(`entry_id`)
        ON DELETE CASCADE,
  PRIMARY KEY (`user_id`)
);

CREATE TABLE `blacklist` (
  `user_id` int NOT NULL,
  `jti` int NOT NULL,
  PRIMARY KEY (`user_id`,`jti`),
  FOREIGN KEY (`user_id`)
        REFERENCES `user`(`user_id`)
        ON DELETE CASCADE
);

CREATE TABLE `relation` (
  `parent_id` int NOT NULL,
  `child_id` int NOT NULL,
  PRIMARY KEY (`parent_id`,`child_id`),
  FOREIGN KEY (`parent_id`)
        REFERENCES `entry`(`entry_id`)
        ON DELETE CASCADE,
  FOREIGN KEY (`child_id`)
        REFERENCES `entry`(`entry_id`)
        ON DELETE RESTRICT
);
delimiter //
CREATE TRIGGER `try_clean_child`
AFTER DELETE ON `relation` 
FOR EACH ROW
BEGIN
  DELETE FROM `entry` e WHERE e.`entry_id` = 2 ;
END;//
delimiter ;

CREATE FUNCTION double_to_decimal (num DOUBLE)
RETURNS DECIMAL(20,10) DETERMINISTIC
RETURN CAST(num as DECIMAL(20,10));

CREATE VIEW `full_user` AS 
SELECT `user_id`, `user_name` , `role_name`
FROM `user`
NATURAL JOIN `role` ;

CREATE VIEW `full_feature` AS 
SELECT `entry_id`, `entry_name`, `description`, `min_value`, `max_value`,  `step`
FROM `entry`
NATURAL JOIN `restrictions` ;

INSERT INTO `entry` VALUES (1,1,'Admin',NULL);
INSERT INTO `entry` VALUES (2,1,'User',NULL);
INSERT INTO `relation` VALUES (1,2);
DELETE FROM `entry`
WHERE `entry_id`=1;

