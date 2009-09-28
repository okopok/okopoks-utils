CREATE TABLE monitoring(
	id serial PRIMARY KEY,
	status varchar(30) NOT NULL,
	errors TEXT,
	data TEXT,
	timestamp_start TIMESTAMP,
	timestamp_end TIMESTAMP
);

CREATE TABLE monitoring_plugins(
	id serial PRIMARY KEY,
	monitoring_id integer REFERENCES monitoring(id) NOT NULL,
	name varchar(100) NOT NULL,
	status varchar(30) NOT NULL,
	errors TEXT,
	data TEXT,
	timestamp_start TIMESTAMP,
	timestamp_end TIMESTAMP
);

