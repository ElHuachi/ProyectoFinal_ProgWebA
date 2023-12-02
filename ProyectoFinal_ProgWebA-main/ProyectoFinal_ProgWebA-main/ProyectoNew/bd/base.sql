create database Coding;

use Coding;

create table
    Tipo(
        idTipo char(2) not null,
        Nombre varchar(25) not null,
        primary key (id)
    );

create table
    Administradores (
        id int auto_increment not null,
        UsuarioAd varchar(25) not null,
        PassAd varchar(18) not null,
        IdTipo char(2) not null,
        primary key (Tipo)
    );

create table
    Instituciones (NombreI varchar(50), primary key (NombreI));

create table
    Concursos (
        IdC int auto_increment,
        NombreC varchar(50) not null,
        FechaC date not null,
        HoraC time not null,
        LugarC varchar(50) not null,
        Institucion varchar(50) not null,
        primary key (IdC),
        foreign key (Institucion) references Instituciones (NombreI)
    );

-- drop table equipos;
create table
    Coach (
        IdC int auto_increment,
        NombreC varchar(25) not null,
        CorreoC varchar(25) not null,
        Institucion varchar(25) not null,
        idTipo char(2) not null,
        PassCo varchar (25) not null,
        primary key (id),
        foreign key (Tipo) references Administradores (Tipo),
        foreign key (Institucion) references Instituciones (NombreI)
    );

create table
    Equipos (
        IdE int auto_increment,
        NombreEquipo varchar(50) not null,
        Estudiante1 varchar(25) not null,
        Estudiante2 varchar(25) not null,
        Estudiante3 varchar(25) not null,
        Coach varchar(25) not null,
        NombreI varchar(50) not null,
        foreign key (Institucion) references Instituciones
    );

create table Auxiliares (
        IdAx int auto_increment,
        NombreAx varchar(25) not null,
        UsuarioAx varchar(25) not null,
        PassAx varchar(18) not null,
        idTipo char(2) not null,
        foreign key (Tipo) references Tipo (idTipo)
    );              