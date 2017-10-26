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

<form method="GET" action="http://localhost:1438/~cs143/show_actor.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Show Actor Section</h3>
		</div>
		<div class="form-group">
		  	<label for="usr">Actor Name:</label>
		  	<input type="text" class="form-control" id="actor_name" name="actor_name" style="width: 400px" maxlength="100">
		</div>
		<button type="submit" class="btn btn-default">Show Actors</button>
	</div>
</form>

<?php
// search actor
$actor_name = $_GET["actor_name"];

if($actor_name) {

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
		$errmsg = mysql_error($db_connection);
		print "Connection failed: '$errmsg' <br />";
		exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	$query = "select * from Actor where last = \"" . mysql_real_escape_string($actor_name) . "\" or first = \"" . mysql_real_escape_string($actor_name) . "\";";

	$rs = mysql_query($query, $db_connection);
	if ($rs) {
		$column_num = mysql_num_fields($rs);
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3>Search Actor Results</h3>";
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
				echo "<td> <a href=\"show_actor.php?aid=" . $row[0] . "\"> $row[$i] </a></td>";
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
$id = $_GET["aid"];
if ($id) {

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
		$errmsg = mysql_error($db_connection);
		print "Connection failed: '$errmsg' <br />";
		exit(1);
	}

	mysql_select_db("CS143", $db_connection);

	$query_find_actor = "select * from Actor where id = " . mysql_real_escape_string($id) . ";";

	$result_actors = mysql_query($query_find_actor, $db_connection);
	if ($result_actors) {
		$column_num = mysql_num_fields($result_actors);
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3>Actor Basic Info</h3>";
		echo "<table class=\"table table-striped\">";
		echo "<thead> <tr>";
		for ($i = 0; $i < $column_num; $i++) {
			$column_name = mysql_field_name($result_actors, $i);
			echo "<th> $column_name </th>";
		}
		echo "</tr> </thead>";
		echo "<tbody>";
		$row = mysql_fetch_row($result_actors);
		echo "<tr>";
		for ($i = 0; $i < $column_num; $i++) {
			echo "<td> $row[$i] </td>";
		}
		echo "</tr>";
		echo "</tbody> </table> </div>";

	} else {
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3> There is no matched record in our database. <h3>";
		echo "</div>";
	}


	$query_find_movie = "select m.id, m.title, m.year, m.rating, m.company, ma.role 
							from MovieActor as ma inner join Movie as m 
							on ma.mid = m.id
							where ma.aid = " . $id . ";";

	$result_movies = mysql_query($query_find_movie, $db_connection);
	if ($result_movies) {
		$column_num = mysql_num_fields($result_movies);
		echo "<div class=\"container-fluid\" style=\"margin-left: 20px\">";
		echo "<h3>Related Movies</h3>";
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
		echo "<h3> No movies found for this actor / actress <h3>";
		echo "</div>";
	}

	mysql_close($db_connection);

}
?>

</body>
</html>