/*
MEMBERS: 

Nicolle Lenzmeier
Murphy Ward
Jacob Krajewski
Darrell Martin
Ryan Cobb
Aaron Thomas
*/

DROP TABLE IF EXISTS `employee`;
DROP TABLE IF EXISTS `website_Login`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `conductor`;
DROP TABLE IF EXISTS `engineer`;
DROP TABLE IF EXISTS `administrators`;
DROP TABLE IF EXISTS `travel_Log`;
DROP TABLE IF EXISTS `trains`;
DROP TABLE IF EXISTS `equipment`;

CREATE TABLE `website_Login`(
	ip_address VARCHAR(45) NOT NULL,
	date_time_of_access DATETIME   
    /* format YYYY-MM-DD HH:MI:SS*/  
	);

CREATE TABLE `customers`(
	company_id SMALLINT NOT NULL,  /*How many characters do we need?*/
	/*`password` VARCHAR(30) NOT NULL, /*Bottom limit of?*/
    PRIMARY KEY(`company_id`)	
);

CREATE TABLE `employee`(
	username VARCHAR(40) NOT NULL, /*Bottom Limit*/
	`password` VARCHAR(255) NOT NULL,
	first_name VARCHAR(20), 
	last_name VARCHAR(20),
	PRIMARY KEY(`username`)
    is_admin ENUM ('T', 'F'),
    is_engineer ENUM ('T', 'F'),
    is_conductor ENUM ('T', 'F')
	);

CREATE TABLE `conductor`(
	`status` ENUM('active', 'inactive'), /*Inactive or active*/  
    	rank ENUM('junior', 'senior'), /*junior or senior*/
    	username VARCHAR(50),
    	PRIMARY KEY (username),
    	FOREIGN KEY fk_username(username) REFERENCES employee(username) 
);

CREATE TABLE `engineer`(
	`status` ENUM ('active', 'inactive'), /*Active or Inactive*/
    	hoursTraveling FLOAT(10, 2),
    	rank ENUM('junior', 'senior'), /*junior engineer or senior engineer*/
    	username VARCHAR(50),
    	PRIMARY KEY (username),
    	FOREIGN KEY fk_username(username) REFERENCES employee(username)
); 

CREATE TABLE `administrator`(
	username VARCHAR(50),
    	PRIMARY KEY (username),
    	FOREIGN KEY fk_admin_username(username) REFERENCES employee(username) 
);

CREATE TABLE `travel_Log`(
	`condition` VARCHAR(40),
    	ID_number VARCHAR(50),
	username VARCHAR(50),
	PRIMARY KEY (ID_number, username),
    	FOREIGN KEY fk_id_number(ID_number) REFERENCES trains(ID_number),
    	FOREIGN KEY fk_username(status) REFERENCES engineer(username)
);

CREATE TABLE `train`(
	id_number INT NOT NULL,
	`from` VARCHAR(25), 
	`to` VARCHAR(25), 
	time_traveling VARCHAR(17), /*M Tu W Th F Sa Su
    Can this be more than one day? Do we want spaces?*/
	engine_numbers SMALLINT NOT NULL,
    PRIMARY KEY(id_number)
    //FOREIGN KEY fk_conductor_ID(conductor_username) REFERENCES conductor(username)
);

CREATE TABLE `equipment`(
	serial_number INTEGER NOT NULL,
	load_capacity INTEGER, 
	type VARCHAR(12),
    train_id_number INTEGER NOT NULL,
	location VARCHAR(8), /*Not sure length*/
	manufacturer VARCHAR(8), /*Not sure length*/
	price DECIMAL(6,2), 
    PRIMARY KEY(serial_number), 
    FOREIGN KEY(train_id_number) REFERENCES train(id_number)	
);

CREATE TABLE orders(
	order_num INT PRIMARY KEY,
	serial_number VARCHAR(50),
	company_ID VARCHAR(50),
	FOREIGN KEY fk1_serial_num(serial_number) REFERENCES equipment(serial_number),
	FOREIGN KEY fk1_company_id(company_ID) REFERENCES customer(company_ID)
);

