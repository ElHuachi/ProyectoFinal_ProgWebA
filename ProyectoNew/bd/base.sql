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
insert into Administradores values (default, 'Ad', 'Admin',sha2('123456',256));
select * from Tipo;
SELECT Administradores.idA, Tipo.Nombre AS Tipo, Administradores.UsuarioAd, Administradores.PassAd
FROM Administradores
JOIN Tipo ON Administradores.idTipo = Tipo.id;

-- Insertar datos en la tabla Instituciones
INSERT INTO Instituciones VALUES ('Institucion1');
INSERT INTO Instituciones VALUES ('Institucion2');

-- Insertar datos en la tabla Concursos
INSERT INTO Concursos (NombreC, FechaC, HoraC, LugarC, Institucion) VALUES ('Concurso1', '2023-01-01', '12:00:00', 'Lugar1', 'Institucion1');
INSERT INTO Concursos (NombreC, FechaC, HoraC, LugarC, Institucion) VALUES ('Concurso2', '2023-02-01', '14:00:00', 'Lugar2', 'Institucion2');

-- Insertar datos en la tabla Coach
INSERT INTO Coach (NombreC, CorreoC, Institucion, idTipo, PassCo) VALUES ('Coach1', 'coach1@example.com', 'Institucion1', 'Co', sha2('password', 256));
INSERT INTO Coach (NombreC, CorreoC, Institucion, idTipo, PassCo) VALUES ('Coach2', 'coach2@example.com', 'Institucion2', 'Co', sha2('password', 256));

-- Insertar datos en la tabla Equipos
INSERT INTO Equipos (NombreEquipo, Estudiante1, Estudiante2, Estudiante3, Institucion, Coach, FotoEquipo, Aprobado) VALUES ('Equipo1', 'Estudiante1', 'Estudiante2', 'Estudiante3', 'Institucion1', 'Coach1', '', 1);
INSERT INTO Equipos (NombreEquipo, Estudiante1, Estudiante2, Estudiante3, Institucion, Coach, FotoEquipo, Aprobado) VALUES ('Equipo2', 'Estudiante4', 'Estudiante5', 'Estudiante6', 'Institucion2', 'Coach2', '', 0);

-- Insertar datos en la tabla Auxiliares
INSERT INTO Auxiliares (NombreAx, UsuarioAx, PassAx, idTipo) VALUES ('Auxiliar1', 'aux1', sha2('password', 256), 'Ax');
INSERT INTO Auxiliares (NombreAx, UsuarioAx, PassAx, idTipo) VALUES ('Auxiliar2', 'aux2', sha2('password', 256), 'Ax');

-- Verificar los datos insertados
SELECT * FROM Instituciones;
SELECT * FROM Concursos;
SELECT * FROM Coach;
SELECT * FROM Equipos;
SELECT * FROM Auxiliares;
SELECT * FROM Administradores;

SELECT Auxiliares.idAx, Tipo.Nombre AS Tipo, Auxiliares.UsuarioAx
                                                    FROM Auxiliares
                                                    JOIN Tipo ON Auxiliares.idTipo = Tipo.id;