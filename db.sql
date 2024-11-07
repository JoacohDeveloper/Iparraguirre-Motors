drop database db_utu2024;
create database db_utu2024;
use db_utu2024;

create table user(
	uuid VARCHAR(45) not null,
	full_name VARCHAR(65),
	username VARCHAR(25),
	slug VARCHAR(25),
	bio text,
	email VARCHAR(255),
	password VARCHAR(61),
	titulo_imagen VARCHAR(255),
	imagen VARCHAR(255),
	token VARCHAR(100),
	userType VARCHAR(100),
	isFirstLog tinyInt(1) default 1,
	isDeleted tinyint(1) DEFAULT 0,
	verify tinyInt(1) DEFAULT 0,
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(uuid) 
);

create table customer(
	uuid VARCHAR(45) not null,
	full_name VARCHAR(65),
	username VARCHAR(25),
	slug VARCHAR(25),
	email VARCHAR(255),
	phone VARCHAR(45),
	password VARCHAR(61),
	titulo_imagen VARCHAR(255),
	imagen VARCHAR(255),
	token VARCHAR(100),
	userType VARCHAR(100),
	isDeleted tinyint(1) DEFAULT 0,
	verify tinyInt(1) DEFAULT 0,
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(uuid)
);


create table cart(
	user_uuid VARCHAR(45),
	item_id VARCHAR(65),
	quanity VARCHAR(25),
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(cart_id)
);

create table wishlist(
	wish_id VARCHAR(40) not null,
	user_uuid VARCHAR(45),
	item_id VARCHAR(65),
	PRIMARY KEY(wish_id)
);

CREATE TABLE product (
    product_id VARCHAR(45) not null,
    nombre VARCHAR(255),
    descripcion TEXT,
    categoria VARCHAR(45),
    precio FLOAT,
    discount FLOAT,
    fabricante VARCHAR(255),
    modelo VARCHAR(255),
    discount_type VARCHAR(10),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(product_id)
);

CREATE TABLE vehicle (
    vehicle_id VARCHAR(45) NOT NULL,
    categoria VARCHAR(255),
    modelo VARCHAR(255),
    fabricante VARCHAR(255),
    year VARCHAR(45),
    color VARCHAR(45),
    matricula VARCHAR(45),
    transmision VARCHAR(45),
    tipo_carroceria VARCHAR(255),
    frenos_abs TINYINT(1),
    airbag TINYINT(1),
    traccion VARCHAR(45),
    direccion VARCHAR(45),
    control_estabilidad TINYINT(1),
    puertas INT,
    tipo_combustible VARCHAR(45),
    velocidad_max FLOAT,
    zero_to_houndred FLOAT,
    peso FLOAT,
    kilometros INT,
    caballos_potencia INT,
    FOREIGN KEY (vehicle_id) REFERENCES Product(product_id),
    PRIMARY KEY(vehicle_id)
);

create table vehicle_img(
	vehicle_id VARCHAR(45) not null,
	url VARCHAR(255),
	alt VARCHAR(150),
    constraint fk_vehicle_id foreign key(vehicle_id) references vehicle(vehicle_id),
	PRIMARY key(vehicle_id, url, alt)
);

CREATE TABLE refractions (
    refraction_id VARCHAR(45) NOT NULL,
    origin VARCHAR(255),
    url_img VARCHAR(255),
    alt_img VARCHAR(150),
    FOREIGN KEY (refraction_id) REFERENCES Product(product_id),
    PRIMARY KEY(refraction_id)
);

create table interactions(
	interactionID VARCHAR(25) not null,
	interactionOwner VARCHAR(45) not null,
	interactionType VARCHAR(50),
	interactionCost float,
	productName VARCHAR(255),
	productType VARCHAR(255),
	productLink VARCHAR(255),
	isPrivate tinyInt(1) DEFAULT 0,
	interactionDate datetime default CURRENT_TIMESTAMP,
	PRIMARY KEY(interactionID)
);

create table testdrive(
	testID int(11) not null auto_increment,
	userUUID VARCHAR(45) not null,
	productID VARCHAR(45) not null,
  productName VARCHAR(255) not null,
  reservedDate datetime default CURRENT_TIMESTAMP,
  createdAt datetime default CURRENT_TIMESTAMP,
	PRIMARY KEY(testID)
);

-- Production SQL code

CREATE TABLE `customer` (
  `uuid` varchar(45) NOT NULL,
  `full_name` varchar(65) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `slug` varchar(25) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `password` varchar(61) DEFAULT NULL,
  `titulo_imagen` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `userType` varchar(100) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT 0,
  `verify` tinyint(1) DEFAULT 0,
  `createdAt` datetime DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `interactions` (
  `interactionID` varchar(25) NOT NULL,
  `interactionOwner` varchar(45) NOT NULL,
  `interactionType` varchar(50) DEFAULT NULL,
  `interactionCost` float DEFAULT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productType` varchar(255) DEFAULT NULL,
  `productLink` varchar(255) DEFAULT NULL,
  `isPrivate` tinyint(1) DEFAULT 0,
  `interactionDate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`interactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `product` (
  `product_id` varchar(45) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `fabricante` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `discount_type` varchar(10) DEFAULT NULL,
  `createdAt` datetime DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `refractions` (
  `refraction_id` varchar(45) NOT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `url_img` varchar(255) DEFAULT NULL,
  `alt_img` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`refraction_id`),
  CONSTRAINT `refractions_ibfk_1` FOREIGN KEY (`refraction_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `user` (
  `uuid` varchar(45) NOT NULL,
  `full_name` varchar(65) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `slug` varchar(25) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(61) DEFAULT NULL,
  `titulo_imagen` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `userType` varchar(100) DEFAULT NULL,
  `isFirstLog` tinyint(1) DEFAULT 1,
  `isDeleted` tinyint(1) DEFAULT 0,
  `verify` tinyint(1) DEFAULT 0,
  `createdAt` datetime DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `vehicle` (
  `vehicle_id` varchar(45) NOT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `fabricante` varchar(255) DEFAULT NULL,
  `year` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `matricula` varchar(45) DEFAULT NULL,
  `transmision` varchar(45) DEFAULT NULL,
  `tipo_carroceria` varchar(255) DEFAULT NULL,
  `frenos_abs` tinyint(1) DEFAULT NULL,
  `airbag` tinyint(1) DEFAULT NULL,
  `traccion` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `control_estabilidad` tinyint(1) DEFAULT NULL,
  `puertas` int(11) DEFAULT NULL,
  `tipo_combustible` varchar(45) DEFAULT NULL,
  `velocidad_max` float DEFAULT NULL,
  `zero_to_houndred` float DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `kilometros` int(11) DEFAULT NULL,
  `caballos_potencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`vehicle_id`),
  CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `vehicle_img` (
  `vehicle_id` varchar(45) NOT NULL,
  `url` varchar(255) NOT NULL,
  `alt` varchar(150) NOT NULL,
  PRIMARY KEY (`vehicle_id`,`url`,`alt`),
  CONSTRAINT `fk_vehicle_id` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `wishlist` (
  `wish_id` varchar(40) NOT NULL,
  `user_uuid` varchar(45) DEFAULT NULL,
  `item_id` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`wish_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;