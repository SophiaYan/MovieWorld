LOAD DATA LOCAL INFILE 'movie.del' INTO TABLE Movie FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE 'actor1.del' INTO TABLE Actor FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE 'actor2.del' INTO TABLE Actor FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE 'actor3.del' INTO TABLE Actor FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE 'sales.del' INTO TABLE Sales FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'director.del' INTO TABLE Director FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE 'moviegenre.del' INTO TABLE MovieGenre FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE 'moviedirector.del' INTO TABLE MovieDirector FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'movieactor1.del' INTO TABLE MovieActor FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE 'movieactor2.del' INTO TABLE MovieActor FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE 'movierating.del' INTO TABLE MovieRating FIELDS TERMINATED BY ',';
INSERT INTO MaxPersonID VALUES (69000);
INSERT INTO MaxMovieID VALUES (4750);