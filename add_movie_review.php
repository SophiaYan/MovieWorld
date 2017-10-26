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

<form method="POST" action="add_movie_info.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Add Movie Review</h3>
		</div>
		<div class="form-group">
		  	<label>Title:</label>
		  	<input type="text" class="form-control" name="title" style="width: 400px" maxlength="100">
		</div>
		<div class="form-group">
		  	<label>Year:</label>
			<input class="form-control" name="year" placeholder="YYYY" type="text" style="width: 400px"/><br>
		</div>

		<div class="form-group">
		  <label for="rating">MPAA rating:</label>
		  <select class="form-control" name="rating" style="width: 400px">
		    <option>PG-13</option>
		    <option>R</option>
		    <option>PG</option>
		    <option>NC-17</option>
		    <option>surrendere</option>
		    <option>G</option>
		  </select>
		</div>

		<div class="form-group">
		  	<label>Company:</label>
		  	<input type="text" class="form-control" name="company" style="width: 400px" maxlength="50">
		</div>

		<div class="form-group">
			<label>Genre:</label>
		  <form>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Action">Action</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Adult">Adult</label>
		    </div>
			<div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Adventure">Adventure</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Animation">Animation</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Comedy">Comedy</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Crime">Crime</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Documentary">Documentary</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Drama">Drama</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Family">Family</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Fantasy">Fantasy</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Horror">Horror</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Musical">Musical</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Mystery">Mystery</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Romance">Romance</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Short">Short</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Thriller">Thriller</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="War">War</label>
		    </div>
		    <div class="checkbox-inline">
		      <label><input type="checkbox" name="genre[]" value="Western">Western</label>
		    </div>
		  </form>
		</div>

		<button type="submit" class="btn btn-default">Add Movie</button>
	</div>
</form>


<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$title = $_POST["title"];
	$year = $_POST["year"];
	$rating = $_POST["rating"];
	$company = $_POST["company"];
	$genre_list = $_POST["genre"];

	$empty_field = array();
	if($title == null){
		array_push($empty_field, "Title");
	}

	if($year == null) {
		array_push($empty_field, "Year");
	}

	if($company == null) {
		array_push($empty_field, "Company");
	}

	if($genre_list == null) {
		array_push($empty_field, "Genre");
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

	if(!is_numeric($year) || ((int)$year != (float)$year)){
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>Invalid value for Year!</strong></div>";
		exit;
	}

	$year = (int)$year;

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection){
		die('Could not connect: '.mysql_error());
	}
	mysql_select_db("TEST", $db_connection);
	$max_movie_id_query = "SELECT id FROM MaxMovieID";
	$query_result = mysql_query($max_movie_id_query, $db_connection);
	$old_max_movie_id = mysql_fetch_assoc($query_result)["id"];
	$new_max_movie_id = $old_max_movie_id + 1;

	$db_query = sprintf("INSERT INTO Movie VALUES(".$new_max_movie_id.", '%s', %s, '%s', '%s')", mysql_real_escape_string($title),
	 mysql_real_escape_string($year), mysql_real_escape_string($rating), mysql_real_escape_string($company));

	if(mysql_query($db_query, $db_connection)){
		echo "<div class=\"alert alert-success\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>New record inserted successfully</strong></div>";
		$update_MaxMovieID = "UPDATE MaxMovieID SET id=".$new_max_movie_id." where id=".$old_max_movie_id;
		mysql_query($update_MaxMovieID, $db_connection);

		foreach($genre_list as $genre){
			$insert_genre_query = sprintf("INSERT INTO MovieGenre VALUES(%s, '%s')", $new_max_movie_id, mysql_real_escape_string($genre));
			mysql_query($insert_genre_query, $db_connection);
		}

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