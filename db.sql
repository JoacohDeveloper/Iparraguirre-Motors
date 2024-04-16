create database db_utu2024;
use db_utu2024;

create table User(

	uuid VARCHAR(45) not null,
	full_name VARCHAR(65),
	username VARCHAR(25),
	slug varchar(25),
	email VARCHAR(255),
	password VARCHAR(61),
	token VARCHAR(100),
	verify tinyInt(1) DEFAULT 0,
	createdAt datetime default CURRENT_TIMESTAMP,
	updatedAt datetime ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(uuid)
);

--hay que agregar campos: telefono, imagen, etc.