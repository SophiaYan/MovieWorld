CREATE TABLE Movie (
	id INT UNIQUE PRIMARY KEY, 
	title VARCHAR(100) NOT NULL, 
	year INT, 
	rating VARCHAR(10), 
	company VARCHAR(50)
) ENGINE = INNODB;
-- Movie id is unique and primary key, title cannot be empty

CREATE TABLE Actor (
	id INT NOT NULL PRIMARY KEY, 
	last VARCHAR(20), 
	first VARCHAR(20), 
	sex VARCHAR(6), 
	dob DATE NOT NULL, 
	dod DATE,
	CHECK (dob <= dod)) ENGINE = INNODB;
-- Actor id cannot be not null and is primary key for the table. Date of birth must be indicated

CREATE TABLE Sales (
	mid INT, 
	ticketsSold INT, 
	totalIncome INT,
	PRIMARY KEY (mid),
	FOREIGN KEY (mid) REFERENCES Movie(id),
	CHECK (totalIncome >= 0)) ENGINE INNODB;
-- The primary key of sales is movie id, which is a foreign key from Movie table. Constraint: total income of a movie must be non-negative.

CREATE TABLE Director (
	id INT NOT NULL PRIMARY KEY, 
	last VARCHAR(20), 
	first VARCHAR(20), 
	dob DATE, 
	dod DATE,
	CHECK (dob <= dod)) ENGINE INNODB;
-- id cannot be null and is primary key of the table. Date of birth of a director is no later than that of date of death.

CREATE TABLE MovieGenre (
	mid INT, 
	genre VARCHAR(20),
	FOREIGN KEY (mid) REFERENCES Movie(id)) ENGINE INNODB;
-- movie id in the table is a foreign key in the Movie table.

CREATE TABLE MovieDirector (
	mid INT, 
	did INT,
	PRIMARY KEY (mid, did),
	FOREIGN KEY (mid) REFERENCES Movie(id),
	FOREIGN KEY (did) REFERENCES Director(id)) ENGINE INNODB;
-- The combination of movie id and director id is the primary key of table. Movie id and director id are foreign keys to match corresponding tables.

CREATE TABLE MovieActor (
	mid INT, 
	aid INT, 
	role VARCHAR(50),
	FOREIGN KEY (mid) REFERENCES Movie(id),
	FOREIGN KEY (aid) REFERENCES Actor(id)) ENGINE INNODB;
-- Movie id and actor id are foreign keys in corresponding tables.

CREATE TABLE MovieRating (
	mid INT PRIMARY KEY, 
	imdb INT, 
	rot INT) ENGINE INNODB;
-- Movie id is the primary key in the table.

CREATE TABLE Review (
	name VARCHAR(20), 
	time TIMESTAMP, 
	mid INT, 
	rating INT, 
	comment VARCHAR(500),
	FOREIGN KEY (mid) REFERENCES Movie(id)) ENGINE INNODB;
-- Movie id is the foreign key in reference to movie table.

CREATE TABLE MaxPersonID (id INT) ENGINE INNODB;
CREATE TABLE MaxMovieID (id INT) ENGINE INNODB;