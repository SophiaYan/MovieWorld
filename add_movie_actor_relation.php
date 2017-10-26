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

<form method="POST" action="add_movie_actor_relation.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Add Movie Actor Relation Section</h3>
		</div>

		<div class="form-group">
		  	<label>Movie Title:</label>
		  	<input type="text" class="form-control" name="movie" style="width: 400px" maxlength="100">
		</div>

		<div class="form-group">
		  	<label>Actor First Name:</label>
		  	<input type="text" class="form-control" name="actor_first" style="width: 400px" maxlength="100">
		</div>

		<div class="form-group">
		  	<label>Actor Last Name:</label>
		  	<input type="text" class="form-control" name="actor_last" style="width: 400px" maxlength="100">
		</div>

		<div class="form-group">
		  	<label>Role:</label>
		  	<input type="text" class="form-control" name="role" style="width: 400px" maxlength="100">
		</div>
		<button type="submit" class="btn btn-default">Add Movie Actor Relation</button>

	</div>
</form>


<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$movie = $_POST["movie"];
	$actor_first = $_POST["actor_first"];
	$actor_last = $_POST["actor_last"];
	$role = $_POST["role"];

	$empty_field = array();
	if($movie == null){
		array_push($empty_field, "Movie Title");
	}

	if($actor_first == null) {
		array_push($empty_field, "Actor First Name");
	}

	if($actor_last == null) {
		array_push($empty_field, "Actor Last Name");
	}

	if($role == null) {
		array_push($empty_field, "Role");
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

	$actor_query = sprintf("SELECT id FROM Actor WHERE first = '%s' and last = '%s'", 
		mysql_real_escape_string($actor_first), mysql_real_escape_string($actor_last));
	$actor_query_result = mysql_query($actor_query, $db_connection);


	if(mysql_num_rows($movie_query_result) == 0){
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>Sorry, no movie matches the title you entered</strong></div>";
		exit;
	}else{
		$mid = mysql_fetch_assoc($movie_query_result)["id"];
	}

	if(mysql_num_rows($actor_query_result) == 0){
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>Sorry, no Actor/Actress matches the name you entered</strong></div>";
		exit;
	}else{
		$aid = mysql_fetch_assoc($actor_query_result)["id"];
	}

	$movie_actor_insertion = sprintf("INSERT INTO MovieActor VALUES (%s, %s, '%s')", $mid, $aid, $role);

	if(mysql_query($movie_actor_insertion, $db_connection)){
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