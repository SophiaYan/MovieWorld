<!DOCTYPE html>
<html>
<head>
  <title>CS143 Project1</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<nav class="navbar navbar-inverse">
 	 <div class="container-fluid">
	    <div class="navbar-header">
	      	<a class="navbar-brand" href="query.php">The Movie World</a>
	    </div>
	    <ul class="nav navbar-nav">
		    <li><a href="query.php">Home</a></li>
		    <li class="dropdown">
		        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Add Records
		        <span class="caret"></span></a>
		        <ul class="dropdown-menu">
			        <li><a href="add_actor_or_director.php">Add actor/director</a></li>
			        <li><a href="add_movie_info.php">Add Movie Info</a></li>
			        <li><a href="add_movie_review.php">Add Movie Review</a></li>
			        <li><a href="add_movie_actor_relation.php">Add Movie/Actor Relation</a></li>
			        <li><a href="add_movie_director_relation.php">Add Movie/Director Relation</a></li>
		        </ul>
		    </li>
   	        <li class="dropdown">
		        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Browse Records
		        <span class="caret"></span></a>
		        <ul class="dropdown-menu">
		          	<li><a href="show_actor.php">Actor Info</a></li>
		          	<li><a href="show_movie.php">Movie Info</a></li>
		        </ul>
		    </li>
		    <li class="dropdown">
		        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Search Records
		        <span class="caret"></span></a>
		        <ul class="dropdown-menu">
		          	<li><a href="search.php">Actor/Movie</a></li>
		        </ul>
		    </li>
	    </ul>
  	</div>
</nav>

<form method="GET" action="show_movie.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Show Movie Section</h3>
		</div>
		<div class="form-group">
		  	<label for="usr">Movie Name:</label>
		  	<input type="text" class="form-control" id="movie_name" name="movie_name" style="width: 400px" maxlength="100">
		</div>
		<button type="submit" class="btn btn-default">Show Movies</button>
	</div>
</form>



<?php
// search movie
$movie_name = $_GET["movie_name"];

if($movie_name) {

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
		$errmsg = mysql_error($db_connection);
		print "Connection failed: '$errmsg' <br />";
		exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	$query = "select * from Movie where title like \"%" . mysql_real_escape_string($movie_name) . "%\";";

	$rs = mysql_query($query, $db_connection);
	$rs_num = mysql_num_rows($rs);
	
	if ($rs and $rs_num != 0) {
		$column_num = mysql_num_fields($rs);
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3>Search Movie Results</h3>";
		echo "<table class=\"table table-striped\">";
		echo "<thead> <tr>";
		for ($i = 0; $i < $column_num; $i++) {
			$column_name = mysql_field_name($rs, $i);
			echo "<th> $column_name </th>";
		}
		echo "</tr> </thead>";
		echo "<tbody>";
		while($row = mysql_fetch_row($rs)) {
			echo "<tr>";
			for ($i = 0; $i < $column_num; $i++) {
				echo "<td> <a href=\"show_movie.php?mid=" . $row[0] . "\"> $row[$i] </a></td>";
			}
			echo "</tr>";
		}
		echo "</tbody> </table> </div>";

	} else {
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3> There is no matched record in our database. <h3>";
		echo "</div>";
	}

	mysql_close($db_connection);
}

// search actor related movie
$id = $_GET["mid"];
if ($id) {

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
		$errmsg = mysql_error($db_connection);
		print "Connection failed: '$errmsg' <br />";
		exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	$query_find_movie = "select * from Movie where id = " . mysql_real_escape_string($id) . ";";

	$result_movies = mysql_query($query_find_movie, $db_connection);
	if ($result_movies) {
		$column_num = mysql_num_fields($result_movies);
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3>Movie Basic Info</h3>";
	
		$row = mysql_fetch_assoc($result_movies);
		$movie_title = $row["title"];
		echo "<strong>Title: $movie_title<br>";
		$year = $row["year"];
		echo "Year: $year<br>";
		$mpaa_rating = $row["rating"];
		echo "MPAA Rating: $mpaa_rating <br>";
		$company = $row["company"];
		echo "Company: $company<br></strong>";

		$director_query = "SELECT first, last FROM MovieDirector, Director WHERE mid=".$id." AND did=id";
		$director_query_result = mysql_query($director_query, $db_connection);
		if(mysql_num_rows($director_query_result) > 0){
			echo "<strong>Director:<br> </strong>";
			while ($row = mysql_fetch_row($director_query_result)){
				echo "$row[0] $row[1]<br>";
			}
		}

		$genre_query = "SELECT genre FROM MovieGenre WHERE mid=".$id;
		$genre_query_result = mysql_query($genre_query, $db_connection);
		if(mysql_num_rows($genre_query_result)>0){
			echo "<strong>Genre:</strong><br>";
			while($row = mysql_fetch_row($genre_query_result)){
				echo "$row[0]<br>";
			}
		}

		echo "</div>";

		$web_rating_query = "select * from MovieRating where mid = ".$id.";";
		$web_rating_result = mysql_query($web_rating_query, $db_connection);

		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3> Website Ratings</h3>";
		echo "<table class=\"table table-striped\">";
		echo "<thead><tr> <th>IMDB</th> <th>Rotten Tomatoes</th></tr></thead>";
		echo "<tbody>";
		if(mysql_num_rows($web_rating_result) > 0){
			$web_rating_row = mysql_fetch_assoc($web_rating_result);
			$imdb = $web_rating_row["imdb"];
			$rot = $web_rating_row["rot"];
			echo "<tr><td> $imdb </td> <td> $rot </td> </tr>";

		}else {
			echo "<tr><td> NaN </td> <td> NaN </td> </tr>";
		}
		echo "</tbody>";
		echo "</table></div>";

		$reviewer_rating_query = "select * from Review where mid =".$id.";";
		$reviewer_rating_result = mysql_query($reviewer_rating_query, $db_connection);

		if(mysql_num_rows($reviewer_rating_result) > 0){
			echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
			echo "<h3> Reviewer Ratings</h3>";
			echo "<table class=\"table table-striped\">";
			echo "<thead><tr> <th>Reviewer</th> <th>Time</th><th>Rating</th><th>Comment</th></tr></thead>";
			echo "<tbody>";
			while($row = mysql_fetch_assoc($reviewer_rating_result)){
				echo "<tr>";
				$reviewer_name = $row["name"];
				$time = $row["time"];
				$rating = $row["rating"];
				$comment = $row["comment"];
				echo "<tr><td>$reviewer_name</td><td>$time</td><td>$rating</td><td>$comment</td></tr>";
				echo "</tr>";
			}

			echo "</tbody>";
			echo "</table></div>";
			
			$average_rating_query = "SELECT AVG(rating) AS average_rating FROM Review WHERE mid = ".$id.";";
			$average_rating_result = mysql_query($average_rating_query, $db_connection);
			$average_rating = mysql_fetch_assoc($average_rating_result)["average_rating"];
			echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">
				<h4>Average Ratings: $average_rating </h4></div>";
		}

	} else {
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3> There is no matched record in our database. <h3>";
		echo "</div>";
	}

	$query_find_movie = "select a.id, CONCAT(a.first, ' ', a.last) as Actor_Name, ma.role 
							from MovieActor as ma inner join Actor as a 
							on ma.aid = a.id
							where ma.mid = " . $id . ";";

	$result_movies = mysql_query($query_find_movie, $db_connection);
	if ($result_movies) {
		$column_num = mysql_num_fields($result_movies);
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3>Cast</h3>";
		echo "<table class=\"table table-striped\">";
		echo "<thead> <tr>";
		for ($i = 1; $i < $column_num; $i++) {
			$column_name = mysql_field_name($result_movies, $i);
			echo "<th> $column_name </th>";
		}
		echo "</tr> </thead>";
		echo "<tbody>";
		while($row = mysql_fetch_row($result_movies)) {
			echo "<tr>";
			for ($i = 1; $i < $column_num; $i++) {
				if ($i == 1) {
					echo "<td> <a href=\"show_actor.php?aid=" . $row[0] . "\"> $row[$i] </a></td>";
				} else {
					echo "<td> $row[$i] </td>";
				}
			}
			echo "</tr>";
		}
		echo "</tbody> </table> </div>";
	} else {
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3> No movies found for this actor / actress <h3>";
		echo "</div>";
	}

	mysql_close($db_connection);
}
?>

</body>
</html>