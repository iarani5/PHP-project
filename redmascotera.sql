DROP DATABASE IF EXISTS redmascotera;
CREATE DATABASE redmascotera;
USE redmascotera;

CREATE TABLE ojos(
	ID TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	OJOS VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE provincia(
	ID TINYINT(2) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	PROVINCIA VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE publicacion(
	ID INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	DESCRIPCION TEXT, 
	ESTADO enum('Adopcion','Encontrado','Perdido'),
	SEXO enum('Hembra','Macho','No lo se'), 
	UBICACION  VARCHAR(255),
	FECHA_M VARCHAR(30),
	TELEFONO BIGINT(15) NOT NULL,
	RUTA_IMG VARCHAR(255),
	MAIL VARCHAR(35) NOT NULL,
	NOMBRE_ANIMAL VARCHAR(35),
	NOMBRE_HUMANO VARCHAR(35) NOT NULL,
	TAMANIO enum('Chico','Mediano','Grande'),
	EDAD enum('Bebe','Joven','Adulto','Viejito'),
	LOCALIDAD VARCHAR(45) NOT NULL,
	BARRIO VARCHAR(45) NOT NULL,
	RAZA VARCHAR(45),
	COLOR VARCHAR(45),
	ESPECIE enum('Perro','Gato'),
	
	FKPROVINCIA TINYINT(2) UNSIGNED,
	FKOJOS TINYINT(1) UNSIGNED,
	
	FOREIGN KEY (FKPROVINCIA) REFERENCES provincia(ID),
	FOREIGN KEY (FKOJOS) REFERENCES ojos(ID)
);

CREATE TABLE usuario(
	ID INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	CONTRASENIA VARCHAR(35) NOT NULL,
	NOMBRE VARCHAR(35) NOT NULL,
	APELLIDO VARCHAR(35) NOT NULL,
	MAIL VARCHAR(35) NOT NULL UNIQUE,
	TELEFONO BIGINT(35) NOT NULL,
	BORRADO enum('si','no'),
	ACTIVO enum('si','no'),
	NIVEL ENUM('admin','usuario')
);

CREATE TABLE publican(
	ID INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	FECHA_A DATE NOT NULL,
	FKNOMBRE INT(9) UNSIGNED,
	FKPUBLICACION INT(9) UNSIGNED,
	BORRADO enum('si','no'),
	FOREIGN KEY (FKNOMBRE) REFERENCES usuario(ID),
	FOREIGN KEY (FKPUBLICACION) REFERENCES publicacion(ID)
);

INSERT INTO 
usuario (CONTRASENIA, NOMBRE, APELLIDO, MAIL, TELEFONO, BORRADO, ACTIVO, NIVEL) 
VALUES 
	(md5('1234'), 'Shari', 'Parker', 'sharipar@gmail.com', '45421199', 'no', 'si', 'admin'),
	(md5('1234'), 'Germo', 'Rodar', 'germirodri@gmail.com', '43567789', 'no', 'si', 'admin'),
	(md5('1234'), 'Maca', 'Pila', 'macaapila@gmail.com', '43900234', 'no', 'si', 'usuario'),
	(md5('1234'), 'Matias', 'Morl', 'matimorl@gmail.com', '47861149', 'no', 'si', 'usuario'),
	(md5('1234'), 'Aldo', 'Brisa', 'aldobrisa@gmail.com', '45423299', 'no', 'si', 'usuario'),
	(md5('1234'), 'Brenda', 'Cheb', 'brendi98@gmail.com', '47889765', 'no', 'si', 'usuario'),
	(md5('1234'), 'Seba', 'Delux', 'seba.delux@gmail.com', '45663210', 'no', 'si', 'usuario'),
	(md5('1234'), 'Morena', 'Perez', 'more.more@gmail.com', '43475869', 'no', 'si', 'usuario');

INSERT INTO 
ojos(OJOS)
VALUES
('Negros'),('Marrones'),('Amarillos'),('Grises'),('Verdes'),('Celestes'),('Otros');

INSERT INTO 
provincia (PROVINCIA) 
VALUES 
	('Buenos Aires'),('Catamarca'),('Chaco'),('Chubut'),('Córdoba'),('Corrientes'),('Entre Ríos'),('Formosa'),('Jujuy'),('La Pampa'),('La Rioja'),('Mendoza'),('Misiones'),('Neuquén'),('Río Negro'),('Salta'),('San Juan'),('San Luis'),('Santa Cruz'),('Santa Fe'),('Santiago del Estero'),('Tierra del Fuego'),('Tucumán');
	
INSERT INTO 
publicacion(
	DESCRIPCION, 
	ESTADO,
	SEXO, 
	FECHA_M,
	TELEFONO,
	RUTA_IMG,
	MAIL,
	NOMBRE_ANIMAL,
	NOMBRE_HUMANO,
	TAMANIO,
	EDAD,
	LOCALIDAD,
	BARRIO,
	RAZA,
	COLOR,
	ESPECIE,
	
	FKPROVINCIA,
	FKOJOS,
	UBICACION
)
VALUES
(
'Buscamos hogar para esta gatita rescatada, es hermosa y muy buena!',
'Adopcion',
'Hembra',
'17/11/2014',
'49987766',
'18466156485',
'sharipar@gmail.com',
'Merla',
'Shari',
'Chico',
'Joven',
'CABA',
'Belgrano',
'Mestizo',
'negro',
'Gato',
'1',
'2',
''),
(
'Gata en adopcion',
'Adopcion',
'Hembra',
'18/11/2013',
'41234567',
'1846525647',
'more.more@gmail.com',
'Luci',
'Morena',
'Chico',
'Adulto',
'CABA',
'Saavedra',
'Mestizo',
'Marron y gris',
'Gato',
'1',
'3',
''
),
(
'Gatito en adopcion responsable, muy mimoso',
'Adopcion',
'Macho',
'16/01/2015',
'41234567',
'1846455647',
'more.more@gmail.com',
'Tango',
'Morena',
'Chico',
'Adulto',
'CABA',
'Nuñez',
'Mestizo',
'Gris',
'Gato',
'1',
'1',
''
),
(
'Luli en adopcion, hermosa, la rescatamos de la calle.',
'Adopcion',
'Hembra',
'16/01/2015',
'45634567',
'18460556464',
'aldobrisa@gmail.com',
'Luli',
'Aldo',
'Chico',
'Bebe',
'CABA',
'Versalles',
'Mestiza',
'Blanca',
'Gato',
'1',
'6',
''
),
(
'Milo busca hogar!!!',
'Adopcion',
'Macho',
'01/01/2012',
'45634567',
'18460156461',
'aldobrisa@gmail.com',
'Milo',
'Aldo',
'Chico',
'Adulto',
'CABA',
'Villa Uriquiza',
'Mestizo',
'Gris',
'Gato',
'1',
'3',
''
),
(
'Encontre a este gatito en la calle, esta castrado, Muy mimoso, parece que se perdio',
'Adopcion',
'Macho',
'01/01/2013',
'49934567',
'18350856290',
'macaagopian@hot.com',
'Luis',
'Maca',
'Chico',
'Adulto',
'CABA',
'Palermo',
'Mestizo',
'Atigrado',
'Gato',
'1',
'5',
''
),
(
'Muy mimoso, ideal para una persona sola. Da mucho amor. ',
'Adopcion',
'Macho',
'17/03/2013',
'41234567',
'1829005617133',
'macaapila@hot.com',
'Rubio',
'Olga',
'Chico',
'Adulto',
'GBA',
'La Matanza',
'Mestizo',
'Atigrado',
'Gato',
'1',
'5',
''
)
;

INSERT INTO 
publican(BORRADO,FKNOMBRE,FKPUBLICACION,FECHA_A)
VALUES
('no','2','1','2018-08-07'),
('no','8','2','2018-08-02'),
('no','8','3','2018-08-02'),
('no','5','4','2018-08-01'),
('no','5','5','2018-08-01'),
('no','3','6','2018-08-01'),
('no','3','7','2018-08-01')
;









