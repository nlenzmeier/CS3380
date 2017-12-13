DROP TABLE IF EXISTS `classes`;

CREATE TABLE `classes`(
	`name` varchar(255),
	`department` varchar(255),
	`course_id` varchar(10),
	 PRIMARY KEY (`course_id`),
	start TIME NULL,
	end TIME NULL,
	`days` varchar(8)
	);

