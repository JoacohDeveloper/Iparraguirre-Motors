drop database db_utu2024;
create database db_utu2024;
use db_utu2024;

create table User(
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
	isDeleted tinyint(1) DEFAULT 0,
	verify tinyInt(1) DEFAULT 0,
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(uuid)
);

create table Customer(
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

create table Cart(
	cart_id VARCHAR(40) not null,
	user_uuid VARCHAR(45),
	item_id VARCHAR(65),
	quanity VARCHAR(25),
	PRIMARY KEY(cart_id)
);
create table Wishlist(
	wish_id VARCHAR(40) not null,
	user_uuid VARCHAR(45),
	item_id VARCHAR(65),
	PRIMARY KEY(wish_id)
);

create table vehicle(
	id int(11) not null auto_increment,
	nombre VARCHAR(255),
	categoria VARCHAR(255),
	descripcion TEXT,
	modelo VARCHAR(255),
	fabricante VARCHAR(255),
	year VARCHAR(45),
	color VARCHAR(45),
	matricula VARCHAR(45),
	transmision VARCHAR(45),
	tipo_carroceria VARCHAR(255),
	frenos_abs tinyint(1),
	airbag tinyint(1),
	traccion VARCHAR(45),
	direccion VARCHAR(45),
	control_estabilidad tinyint(1),
	puertas int,
	tipo_combustible VARCHAR(45),
	precio float,
	discount float,
	discount_type VARCHAR(1),
	discount_start datetime,
	discount_end datetime,
	velocidad_max float,
	zero_to_houndred float,
	peso FLOAT,
	kilometros int,
	caballos_potencia int,
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
);

create table vehicle_img(
	vehicle_id int(11) not null,
	url VARCHAR(255),
	alt VARCHAR(150),
    constraint fk_vehicle_id foreign key(vehicle_id) references vehicle(id),
	PRIMARY key(vehicle_id, url, alt)
);

create table refractions(
	id int(11) not null auto_increment,
	nombre VARCHAR(255),
	descripcion TEXT,
	fabricante VARCHAR(255),
	precio float,
	discount float,
	discount_type VARCHAR(1),
	discount_start datetime,
	discount_end datetime,
	stock int(11),
	peso FLOAT,
	origen VARCHAR(255),
	url_img VARCHAR(255),
	alt_img VARCHAR(150),
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
);