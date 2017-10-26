<!DOCTYPE html>
<html>
<head>
  <title>CS143 Project1</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
	div.alert {position: fixed; bottom: 0; right: 0; width: 300px;}
  </style>
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
			        <li><a href="add_director_or_director.php">Add director/director</a></li>
			        <li><a href="add_movie_info.php">Add Movie Info</a></li>
			        <li><a href="add_movie_director_relation.php">Add Movie/director Relation</a></li>
			        <li><a href="add_movie_director_relation.php">Add Movie/Director Relation</a></li>
		        </ul>
		    </li>
   	        <li class="dropdown">
		        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Browse Records
		        <span class="caret"></span></a>
		        <ul class="dropdown-menu">
		          	<li><a href="show_director.php">director Info</a></li>
		          	<li><a href="show_movie.php">Movie Info</a></li>
		        </ul>
		    </li>
		    <li class="dropdown">
		        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Search Records
		        <span class="caret"></span></a>
		        <ul class="dropdown-menu">
		          	<li><a href="search.php">director/Movie</a></li>
		        </ul>
		    </li>
	    </ul>
  	</div>
</nav>

<form method="POST" action="add_movie_director_relation.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Add Movie Director Relation Section</h3>
		</div>

		<div class="form-group">
		  	<label>Movie Title:</label>
		  	<input type="text" class="form-control" name="movie" style="width: 400px" maxlength="100">
		</div>

		<div class="form-group">
		  	<label>Director First Name:</label>
		  	<input type="text" class="form-control" name="director_first" style="width: 400px" maxlength="100">
		</div>

		<div class="form-group">
		  	<label>Director Last Name:</label>
		  	<input type="text" class="form-control" name="director_last" style="width: 400px" maxlength="100">
		</div>

		<button type="submit" class="btn btn-default">Add Movie Director Relation</button>
	</div>
</form>


<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$movie = $_POST["movie"];
	$director_first = $_POST["director_first"];
	$director_last = $_POST["director_last"];

	$empty_field = array();
	if($movie == null){
		array_push($empty_field, "Movie Title");
	}

	if($director_first == null) {
		array_push($empty_field, "Director First Name");
	}

	if($director_last == null) {
		array_push($empty_field, "Director Last Name");
	}

	if(sizeof($empty_field) > 0){
		$empty_field_list;
		foreach ($empty_field as $key => $value) {
			$empty_field_list.= $value." is empty <br>";
		}
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>Invalid Input!<br></strong>".$empty_field_list."
		</div>";
		exit;
	}

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection){
		die('Could not connect: '.mysql_error());
	}
	mysql_select_db("CS143", $db_connection);

	$movie_query = sprintf("SELECT id FROM Movie WHERE title = '%s'", mysql_real_escape_string($movie));
	$movie_query_result = mysql_query($movie_query, $db_connection);

	$director_query = sprintf("SELECT id FROM Director WHERE first = '%s' and last = '%s'", 
		mysql_real_escape_string($director_first), mysql_real_escape_string($director_last));
	$director_query_result = mysql_query($director_query, $db_connection);


	if(mysql_num_rows($movie_query_result) == 0){
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>Sorry, no movie matches the title you entered</strong></div>";
		exit;
	}else{
		$mid = mysql_fetch_assoc($movie_query_result)["id"];
	}

	if(mysql_num_rows($director_query_result) == 0){
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>Sorry, no director/Actress matches the name you entered</strong></div>";
		exit;
	}else{
		$did = mysql_fetch_assoc($director_query_result)["id"];
	}

	$movie_director_insertion = sprintf("INSERT INTO MovieDirector VALUES (%s, %s)", $mid, $did);

	if(mysql_query($movie_director_insertion, $db_connection)){
		echo "<div class=\"alert alert-success\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>New record inserted successfully</strong></div>";
	}else{
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>New record insertion failed</strong></div>";
	}

	mysql_close($db_connection);
}
?>

</body>
</html>