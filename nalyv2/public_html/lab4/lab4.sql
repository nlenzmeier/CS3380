DROP TABLE IF EXISTS `order_item`;
DROP TABLE IF EXISTS `product`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `person`;

CREATE TABLE `person`(
	`person_id` int,
	`name` varchar(255),
	PRIMARY KEY(`person_id`)
);

CREATE TABLE `product`(
	`product_id` int,
	`name` varchar(255),
	`sku` int,
	PRIMARY KEY(`product_id`)
);

CREATE TABLE `orders`(
	`order_id` int,
	`person_id` int,
	`order_date` DATE,
	`order_number` int,
	PRIMARY KEY(`order_id`),
	FOREIGN KEY(`person_id`) REFERENCES person(`person_id`)
);

CREATE TABLE `order_item`(
	`order_item_id` int,
	`product_id` int,
	`order_id` int,
	`quantity` int,
	PRIMARY KEY(`order_item_id`),
	FOREIGN KEY(`product_id`) REFERENCES product(`product_id`),
	FOREIGN KEY(`order_id`) REFERENCES orders(`order_id`)
);


