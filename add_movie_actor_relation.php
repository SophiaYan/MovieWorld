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

<form method="POST" action="http://localhost:1438/~cs143/add_movie_info.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Add Movie Actor Relation Section</h3>
		</div>

		<div class="form-group">
		  <label for="movie_title">Movie title:</label>
		  <select class="form-control" id="movie_title" style="width: 400px">
		    <option>PG-13</option>
		    <option>R</option>
		    <option>PG</option>
		    <option>NC-17</option>
		    <option>surrendere</option>
		    <option>G</option>
		  </select>
		</div>

		<div class="form-group">
		  <label for="movie_title">Actor:</label>
		  <select class="form-control" id="actor" style="width: 400px">
		    <option>PG-13</option>
		    <option>R</option>
		    <option>PG</option>
		    <option>NC-17</option>
		    <option>surrendere</option>
		    <option>G</option>
		  </select>
		</div>

		<button type="button" class="btn btn-default">Add Movie Actor Relation</button>

	</div>
</form>


<?php

$date = DateTime::createFromFormat("d-m-Y", $_POST['date'])->format('Y-m-d');

$query = $_POST["query"];
if($query) {

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection) {
		$errmsg = mysql_error($db_connection);
		print "Connection failed: '$errmsg' <br />";
		exit(1);
	}

	mysql_select_db("CS143", $db_connection);
	$query_to_issue = mysql_real_escape_string($query);

	$rs = mysql_query($query_to_issue, $db_connection);
	if ($rs) {
		$column_num = mysql_num_fields($rs);
		
		echo "<h3> Result from MySQL: </h3>";
		echo "<table border=\"1\" cellspacing=\"1\" cellpadding=\"2\">";
		for ($i = 0; $i < $column_num; $i++) {
			$column_name = mysql_field_name($rs, $i);
			echo "<td> $column_name </td>";
		}

		while($row = mysql_fetch_row($rs)) {
			echo "<tr>";
			for ($i = 0; $i < $column_num; $i++) {
				echo "<td> $row[$i] </td>";
			}
			echo "</tr>";
		}
		echo "</table>";

	} else {
		echo "There is no matched record in our database. ";
	}
	mysql_close($db_connection);

}
?>

</body>
</html>