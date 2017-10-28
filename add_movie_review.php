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

<form method="GET" action="add_movie_review.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Add Movie Review</h3>
		</div>
		<div class="form-group">
		  	<label>Reviewer:</label>
		  	<input type="text" class="form-control" name="reviewer" style="width: 400px" maxlength="100">
		</div>
		<div class="form-group">
		  	<label>Movie:</label>
		  	<input type="text" class="form-control" name="movie" style="width: 400px" maxlength="100">
		</div>
		<div class="form-group">
		  	<label>Rating:</label>
			<input class="form-control" name="rating" placeholder="0~10" type="text" style="width: 400px"/><br>
		</div>

		<div class="form-group">
		  	<label>Comment:</label><br>
			<TEXTAREA NAME="comment" ROWS=10 COLS=70></TEXTAREA>
		</div>
		<button type="submit" class="btn btn-default">Add Movie</button>
	</div>
</form>


<?php
if(count($_GET) != 0){
	$reviewer = $_GET["reviewer"];
	$movie = $_GET["movie"];
	$rating = $_GET["rating"];
	$comment = $_GET["comment"];

	$empty_field = array();
	if($reviewer == null){
		array_push($empty_field, "Reviewer");
	}

	if($movie == null) {
		array_push($empty_field, "Movie");
	}

	if($rating == null) {
		array_push($empty_field, "Rating");
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

	if(!is_numeric($rating) || ((int)$rating != (float)$rating) || (int)$rating > 10){
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>Invalid value for Rating!</strong></div>";
		exit;
	}

	$rating = (int)$rating;

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection){
		die('Could not connect: '.mysql_error());
	}
	mysql_select_db("CS143", $db_connection);

	$movie_query = sprintf("SELECT id FROM Movie WHERE title = '%s'", mysql_real_escape_string($movie));
	$movie_query_result = mysql_query($movie_query, $db_connection);

	if(mysql_num_rows($movie_query_result) == 0){
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>Sorry, no movie matches the title you entered</strong></div>";
		exit;
	}else{
		$mid = mysql_fetch_assoc($movie_query_result)["id"];
	}

	$insert_review_query = sprintf("INSERT INTO Review VALUES('%s', NOW(), %s, %s, ", mysql_real_escape_string($reviewer),
		$mid, $rating);

	if($comment==NULL){
		$insert_review_query.="NULL)";
	}else{
		$insert_review_query.= (sprintf("'%s')", mysql_real_escape_string($comment)));
	}

	if(mysql_query($insert_review_query, $db_connection)){
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