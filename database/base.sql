CREATE USER mont WITH ENCRYPTED PASSWORD 'hola123';
CREATE DATABASE defmon WITH OWNER mont;


\c defmon mont

CREATE TABLE ip(
		ipid SERIAL PRIMARY KEY,
		ipstring VARCHAR(16),
		http boolean,
		https boolean
);


CREATE TABLE servicio(
		servid SERIAL PRIMARY KEY,
		nombre VARCHAR(30) NOT NULL,
		cms VARCHAR(60)
);


CREATE TABLE recurso(
		recid SERIAL PRIMARY KEY,
		url VARCHAR(60),
		ipid INT REFERENCES ip(ipid)
);


CREATE TABLE recser(
		recid INT REFERENCES recurso(recid),
		servid INT REFERENCES servicio(servid),
		PRIMARY KEY (recid, servid)
);


CREATE TABLE top(
		tid SERIAL PRIMARY KEY,
		recid INT REFERENCES recurso(recid)
);


CREATE TABLE archivo(
		arid SERIAL PRIMARY KEY,
		loc VARCHAR(60) NOT NULL,
		md5 VARCHAR(50) NOT NULL,
		gen TIMESTAMP NOT NULL,
		recid INT REFERENCES recurso(recid)
);


CREATE TABLE deteccion(
		did SERIAL PRIMARY KEY,
		arid INT REFERENCES archivo(arid),
		descripcion VARCHAR(100) NOT NULL
);
