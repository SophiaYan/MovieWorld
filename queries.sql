SELECT CONCAT (a.first, " ", a.last) AS names
FROM Movie m, Actor a, MovieActor ma
WHERE m.title = 'Death to Smoochy' AND m.id = ma.mid AND a.id = ma.aid;
-- Give me the names of all the actors in the movie 'Death to Smoochy'.

SELECT COUNT(*) 
FROM (
	SELECT md.did 
	FROM MovieDirector md
	GROUP BY md.did
	HAVING COUNT(md.mid) >= 4
) AS ExcellentDirector;
-- Give me the count of all the directors who directed at least 4 movies.

SELECT COUNT(m.title)
FROM Movie m, Sales s
WHERE m.id = s.mid AND s.totalIncome >= 10000000 AND m.year >= 2000;
-- Give me the number of the movie with total income more than 10000000 after year 2000

SELECT m.title, mr.imdb
FROM Movie m INNER JOIN MovieRating mr ON mr.mid = m.id
WHERE mr.imdb >= 
	(SELECT MAX(MovieRating.imdb) FROM MovieRating);
-- Give me the title of the movie with best ibdb rating.
