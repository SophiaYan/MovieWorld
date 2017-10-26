-- Three primary key constraints 
INSERT INTO Movie VALUES (NULL, "Talk to Chenchen forever", 2018, 10, "Chenchen's Father");
-- Violate movie id cannot be null

INSERT INTO Actor VALUES (1, "Chen", "Chen", "Female", "1995-02-20", NULL);
-- Violate that Actor id cannot be duplicated (there is already an actor with id 1 in Actor table)

INSERT INTO MovieDirector VALUES (1, 3);
INSERT INTO MovieDirector VALUES (1 ,3);
-- Violate that combination of moive id and actor id are primary key of the table.


-- Six referential integrity constraints
INSERT INTO Sales VALUES (5000, 10000, 100000);
-- Violate the constraint that mid in Sales must be a foreign key in Movie table
-- (MaxMovieID = 4750)

INSERT INTO MovieGenre VALUES (5000, "Realistic style");
-- Violate the constraint that mid in MovieGenre must be a foreigh key in Movie table

UPDATE MovieDirector SET mid = 320, aid = 70000 WHERE mid = 320 AND aid = 68572;
-- Violate the constraint that aid in MovieDirector must be a foreigh key in Actor table, when max Director id is 68626

UPDATE MovieActor SET aid = 70000 WHERE mid = 998;
-- Violate the constraint that aid in MovieActor must be a foreign key in Actor table, when max Actor id is 68635

DELETE FROM Movie WHERE id = 1296;
-- Violate that mid in MovieActor must be a foreign key in movie table
-- (mid: 1296, aid: 58668, role: Matt Spencer) is a row in MovieActor

INSERT INTO Review VALUES ("Movie I love", "2017-10-16", 70000, 9, "Good Realistic movie.");
-- Violate that mid in Review must be a foreign key in Movie table (max movie id is 4750)


-- Three check constraints
INSERT INTO Actor VALUES (1, "Chen", "Chen", "Female", "1995-10-16", "1990-01-07");
-- Violate the constraint that dob is no later than dod

UPDATE Sales SET totalIncome = -100 WHERE mid = 320;
-- Violate the constraint that totalIncome in Sales cannot be negative

UPDATE Director SET dob = "2017-10-16", dod = "1970-07-02" WHERE id = 30972;
-- Violate the constraint that dob of a director is no later than his/her dod