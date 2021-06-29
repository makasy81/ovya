\c postgres

DROP database IF EXISTS ovya_recrutement;
CREATE DATABASE ovya_recrutement OWNER ovya ENCODING 'utf8' TEMPLATE template0;

\c ovya_recrutement

CREATE TABLE IF NOT EXISTS acq (
	id serial PRIMARY KEY,
	nom TEXT NOT NULL,
	email TEXT UNIQUE NOT NULL,
	password VARCHAR ( 50 )
) WITH (
  OIDS = FALSE
);

CREATE TABLE IF NOT EXISTS ccial (
	id serial PRIMARY KEY,
	nom TEXT NOT NULL,
	email TEXT UNIQUE
) WITH (
  OIDS = FALSE
);

CREATE TABLE IF NOT EXISTS dossier (
	id serial PRIMARY KEY,
	date_insert TIMESTAMP NOT NULL,
	ccial_id INT,
	FOREIGN KEY (ccial_id)
      REFERENCES ccial (id)
) WITH (
  OIDS = FALSE
);

CREATE TABLE IF NOT EXISTS visite (
	id serial PRIMARY KEY,
	date_start TIMESTAMP NOT NULL,
	date_end TIMESTAMP NOT NULL,
	acq_id INT NOT NULL,
	ccial_id INT  NOT NULL,
	dossier_id INT  NOT NULL,
	canceled BOOLEAN NOT NULL,
	FOREIGN KEY  (acq_id)
      REFERENCES acq (id),
	FOREIGN KEY (ccial_id)
      REFERENCES ccial (id),
	FOREIGN KEY (dossier_id)
      REFERENCES dossier (id)  
) WITH (
  OIDS = FALSE
);

CREATE INDEX fk_dossier_ccial_id_idx 
ON dossier(ccial_id);
CREATE INDEX fk_visite_acq_id_idx 
ON visite(acq_id);
CREATE INDEX fk_visite_ccial_id_idx
ON visite(ccial_id);
CREATE INDEX fk_visite_dossier_id_idx
ON visite(dossier_id);

\d