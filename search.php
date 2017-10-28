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


<form method="GET" action="search.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Search Section</h3>
		</div>
		<div class="form-group">
		  	<label for="usr">Any keyword in Actor or Movie:</label>
		  	<input type="text" class="form-control" id="keyword" name="keyword" style="width: 400px" maxlength="100">
		</div>
		<button type="submit" class="btn btn-default">Show Result!</button>
	</div>
</form>


<?php
$keyword = $_GET["keyword"];

if($keyword) {

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
		$errmsg = mysql_error($db_connection);
		print "Connection failed: '$errmsg' <br />";
		exit(1);
	}
	mysql_select_db("CS143", $db_connection);

	$exploded_keyword = explode(" ", $keyword);

	$query_actor = "select * from Actor where ";
	if (count($exploded_keyword) == 1) {
		$query_actor = $query_actor . "first like \"%" . $keyword . "%\" or last like \"%" . $keyword . "%\";";
	} else {
		$query_actor = 
			$query_actor . "first = \"" . $exploded_keyword[0] . "\" and last = \"" . $exploded_keyword[1]. "\";";
	}


	$result_actors = mysql_query($query_actor, $db_connection);
	$result_actors_num = mysql_num_rows($result_actors);
	if ($result_actors and $result_actors_num != 0) {
		$column_num = mysql_num_fields($result_actors);
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3>Related Actors</h3>";
		echo "<table class=\"table table-striped\">";
		echo "<thead> <tr>";
		for ($i = 0; $i < $column_num; $i++) {
			$column_name = mysql_field_name($result_actors, $i);
			echo "<th> $column_name </th>";
		}
		echo "</tr> </thead>";
		echo "<tbody>";

		while($row = mysql_fetch_row($result_actors)){
			echo "<tr>";
			for ($i = 0; $i < $column_num; $i++) {
				echo "<td> <a href=\"show_actor.php?aid=" . $row[0] . "\"> $row[$i] </a></td>";
			}
			echo "</tr>";
		}
		echo "</tbody> </table> </div>";

	} else {
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h4> There is no matched actor in our database. <h4>";
		echo "</div>";
	}

	// query movie
	$query_movie = "select * from Movie where title like \"%" . $exploded_keyword[0] . "%\"";
	if (count($exploded_keyword) > 1) {
		for ($i = 1; $i < count($exploded_keyword); $i++) {
			$query_movie = $query_movie . " or title like \"%" . $exploded_keyword[$i] . "%\""; 
		}
	}
	$query_movie = $query_movie . ";";	

	$result_movies = mysql_query($query_movie, $db_connection);
	$result_movies_num = mysql_num_rows($result_movies);
	if ($result_movies and $result_movies_num != 0) {
		$column_num = mysql_num_fields($result_movies);
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3>Related Movies</h3>";
		echo "<table class=\"table table-striped\">";
		echo "<thead> <tr>";
		for ($i = 0; $i < $column_num; $i++) {
			$column_name = mysql_field_name($result_movies, $i);
			echo "<th> $column_name </th>";
		}
		echo "</tr> </thead>";
		echo "<tbody>";
		while($row = mysql_fetch_row($result_movies)) {
			echo "<tr>";
			for ($i = 1; $i < $column_num; $i++) {
				if ($i == 1) {
					echo "<td> <a href=\"show_movie.php?mid=" . $row[0] . "\"> $row[$i] </a></td>";
				} else {
					echo "<td> $row[$i] </td>";
				}
			}
			echo "</tr>";
		}
		echo "</tbody> </table> </div>";

	} else {
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h4> There is no matched movie in our database. <h4>";
		echo "</div>";
	}

	mysql_close($db_connection);
}
?>

</body>
</html>