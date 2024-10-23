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
	isEncargado tinyint(1) DEFAULT 0,
	isFirstLog tinyInt(1) default 1,
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
	user_uuid VARCHAR(45),
	item_id VARCHAR(65),
	quanity VARCHAR(25),
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(cart_id)
);




create table Wishlist(
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


INSERT INTO user (uuid, full_name, username, slug, bio, email, password, titulo_imagen, imagen, token, isAdmin, isEncargado, isFirstLog, isDeleted, verify, createdAt, updatedAt) VALUES
('4fbcd277-9648-4887-bf76-bc362001b863', 'Joaquin Alvarez', 'Joacohj', 'jocohj', 'Me gusta el javascript', 'iambientloco@gmail.com', '$2y$10$9isv2Jhi2L.JlvyS.MMz7uBPf3mrtsGkfxwUTBw7PdJmJ6q4ec4Yy', 'imagen default de usuario', '/build/src/images/users/d66b262dc900437a5c2dc1f9725590c3.jpg', '', '1', '0', '0', '0', '0', '2024-09-26 19:49:24', '2024-10-09 13:55:41');

