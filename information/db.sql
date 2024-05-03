drop database db_utu2024;
create database db_utu2024;
use db_utu2024;

create table User(

	uuid VARCHAR(45) not null,
	full_name VARCHAR(65),
	username VARCHAR(25),
	slug VARCHAR(25),
	email VARCHAR(255),
	password VARCHAR(61),
	telefono VARCHAR(45),
	titulo_imagen VARCHAR(255),
	imagen VARCHAR(255),
	token VARCHAR(100),
	isAdmin tinyint(1) DEFAULT 0,
	verify tinyInt(1) DEFAULT 0,
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(uuid)
);



create table vehicle(

	id int(11) not null auto_increment,
	id_unidad int(11),
	descripcion TEXT,
	nombre VARCHAR(255),
	modelo VARCHAR(255),
	fabricante VARCHAR(255),
	year VARCHAR(45),
	color VARCHAR(45),
	titulo_imagen VARCHAR(255),
	imagen VARCHAR(255),
	matricula VARCHAR(45),
	numero_motor VARCHAR(45),
	transmision VARCHAR(45),
	tipo_carroceria VARCHAR(244),
	frenos_abs tinyint(1),
	airbag tinyint(1),
	traccion VARCHAR(45),
	tipo_vidrio VARCHAR(45),
	direccion VARCHAR(45),
	control_estabilidad tinyint(1),
	puertas int,
	volumen_combustible float,
	tipo_combustible VARCHAR(45),
	base_combustible float,
	voltaje float,
	vencimiento_seguro datetime,
	tipo_de_vehiculo VARCHAR(45),
	precio float,
	velocidad_max float,
	zero_to_houndred float,
	pais VARCHAR(45),
	stock int,
	poliza_seguro VARCHAR(45),
	peso FLOAT,
	kilometros int,
	caballos_potencia int,
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
)

