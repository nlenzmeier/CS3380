DROP TABLE IF EXISTS `userLogin`;
CREATE TABLE `userLogin`(
	`name` varchar(30) NOT NULL,
	`password` varchar(30) NOT NULL,
	PRIMARY KEY (`name`)
);
