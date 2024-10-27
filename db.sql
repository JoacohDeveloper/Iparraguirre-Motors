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
	isAdmin tinyint(1) DEFAULT 1,
	isEncargado tinyint(1) DEFAULT 0,
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
	isAdmin tinyint(1) DEFAULT 0,
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