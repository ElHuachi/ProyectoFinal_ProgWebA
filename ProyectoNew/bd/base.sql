create database Coding;
-- drop database Coding;
use Coding;

create table
    Tipo(
        id char(2) not null,
        Nombre varchar(25) not null,
        primary key (id)
    );

create table
    Administradores (
        idA int auto_increment not null,
        idTipo char(2) not null,
        UsuarioAd varchar(25) not null,
        PassAd varchar(18) not null,
        primary key (idA),
        foreign key (idTipo) references Tipo (id)
    );

create table
    Instituciones (NombreI varchar(50), primary key (NombreI));

create table
    Concursos (
        IdC int auto_increment,
        NombreC varchar(50) not null,
        FechaI date not null,
        FechaC date not null,
        HoraC time not null,
        LugarC varchar(50) not null,
        primary key (IdC)
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
        primary key (idC),
        foreign key (idTipo) references Tipo (id),
        foreign key (Institucion) references Instituciones (NombreI)
    );
    
create table
    Equipos (
        IdE int auto_increment,
        NombreEquipo varchar(50) not null,
        Estudiante1 varchar(25) not null,
        Estudiante2 varchar(25) not null,
        Estudiante3 varchar(25) not null,
        Institucion varchar(25) not null,
        Coach varchar(25) not null,
        FotoEquipo VARCHAR(255),
        Aprobado int not null,
        primary key (IdE),
        foreign key (Institucion) references Instituciones (NombreI)
    );

create table Auxiliares (
        IdAx int auto_increment,
        NombreAx varchar(25) not null,
        UsuarioAx varchar(25) not null,
        PassAx varchar(18) not null,
        idTipo char(2) not null,
        primary key (IdAx),
        foreign key (idTipo) references Tipo (id)
    );
insert into Tipo values ('Ax', 'Auxiliar');
insert into Tipo values ('Co', 'Coach');
insert into Tipo values ('Ad', 'Administrador');
insert into Administradores values (default, 'Ad', 'Admin','123456');
select * from Tipo;
SELECT Administradores.idA, Tipo.Nombre AS Tipo, Administradores.UsuarioAd, Administradores.PassAd
FROM Administradores
JOIN Tipo ON Administradores.idTipo = Tipo.id;

-- Insertar datos en la tabla Instituciones
INSERT INTO Instituciones VALUES ('Institucion1');
INSERT INTO Instituciones VALUES ('Institucion2');

-- Insertar datos en la tabla Concursos
INSERT INTO Concursos (NombreC, FechaI, FechaC, HoraC, LugarC) VALUES ('Concurso1', '2022-12-12', '2023-01-01', '12:00:00', 'Lugar1');
INSERT INTO Concursos (NombreC, FechaI, FechaC, HoraC, LugarC) VALUES ('Concurso2', '2022-12-12', '2023-02-01', '14:00:00', 'Lugar2');

-- Insertar datos en la tabla Coach
INSERT INTO Coach (NombreC, CorreoC, Institucion, idTipo, PassCo) VALUES ('Coach1', 'coach1@example.com', 'Institucion1', 'Co', 'password');
INSERT INTO Coach (NombreC, CorreoC, Institucion, idTipo, PassCo) VALUES ('Coach2', 'coach2@example.com', 'Institucion2', 'Co', 'password2');
SELECT IdC, NombreC FROM Coach WHERE PassCo='password';


-- Insertar datos en la tabla Equipos
INSERT INTO Equipos (NombreEquipo, Estudiante1, Estudiante2, Estudiante3, Institucion, Coach, FotoEquipo, Aprobado) VALUES ('Equipo1', 'Estudiante1', 'Estudiante2', 'Estudiante3', 'Institucion1', 'Coach1', '', 0);
INSERT INTO Equipos (NombreEquipo, Estudiante1, Estudiante2, Estudiante3, Institucion, Coach, FotoEquipo, Aprobado) VALUES ('Equipo2', 'Estudiante4', 'Estudiante5', 'Estudiante6', 'Institucion2', 'Coach2', '', 0);

-- Insertar datos en la tabla Auxiliares
INSERT INTO Auxiliares (NombreAx, UsuarioAx, PassAx, idTipo) VALUES ('Auxiliar1', 'aux1', 'password', 'Ax');
INSERT INTO Auxiliares (NombreAx, UsuarioAx, PassAx, idTipo) VALUES ('Auxiliar2', 'aux2', 'password', 'Ax');

-- Verificar los datos insertados
SELECT * FROM Instituciones;
SELECT * FROM Concursos;
SELECT * FROM Coach;
SELECT * FROM Equipos;
SELECT * FROM Auxiliares;
select * FROM TIPO;
SELECT * FROM Administradores;
SELECT * FROM Equipos WHERE Coach = 'Coach1';
SELECT idA, idTipo, UsuarioAd FROM Administradores WHERE UsuarioAd = 'Admin' AND PassAd = '123456';
SELECT PassAd FROM Administradores;
SELECT Auxiliares.idAx, Tipo.Nombre AS Tipo, Auxiliares.UsuarioAx
FROM Auxiliares
JOIN Tipo ON Auxiliares.idTipo = Tipo.id;