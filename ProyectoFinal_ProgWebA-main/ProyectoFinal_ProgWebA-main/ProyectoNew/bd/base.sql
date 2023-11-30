create database Coding;
use Coding;
create table RegistroCoach(
id int auto_increment,
nombre varchar (25) not null,
correo varchar (25) not null,
institucion varchar (25) not null,
primary key (id)
);

create table RegistrodeEquipos(
NombreEquipo varchar (25) not null,
Estudiante1 varchar (25) not null,
Estudiante2 varchar (25) not null,
Estudiante3 varchar (25) not null
);