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

<form method="POST" action="add_actor_or_director.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Add Actor Section</h3>
		</div>

		<div class="form-group">
		  	<label>Last Name:</label>
		  	<input type="text" class="form-control" id="last_name" name="last_name" style="width: 400px">
		</div>
		<div class="form-group">
		  	<label>First Name:</label>
		  	<input type="text" class="form-control" id="first_name" name="first_name" style="width: 400px">
		</div>
		
		<label> Sex: </label><br>
		<label class="radio-inline"><input type="radio" name="sex" value="Female" checked>Female</label>
		<label class="radio-inline"><input type="radio" name="sex" value="Male">Male</label><br><br>
		
		<label> Date of Birth: </label><br>
		<input class="form-control" id="date" name="dob" placeholder="YYYY-MM-DD" type="text" style="width: 400px"/><br>
		
		<label> Date of Death: (leave blank if not apply) </label><br>
		<input class="form-control" id="date" name="dod" placeholder="YYYY-MM-DD" type="text" style="width: 400px"/><br>
		<button type="submit" class="btn btn-default" name="table_name" value="Actor">Add Actor</button>
	</div>
</form>


<form method="POST" action="add_actor_or_director.php">
	<div class="container-fluid" style="margin-left: 20px">
		<div class="page-header">
		  	<h3>Add Director Section</h3>
		</div>
		<div class="form-group">
		  	<label>Last Name:</label>
		  	<input type="text" class="form-control" id="last_name" name="last_name" style="width: 400px">
		</div>
		<div class="form-group">
		  	<label>First Name:</label>
		  	<input type="text" class="form-control" id="first_name" name="first_name" style="width: 400px">
		</div>
		
		<label> Date of Birth: </label><br>
		<input class="form-control" id="date" name="dob" placeholder="YYYY-MM-DD" type="text" style="width: 400px"/><br>
		
		<label> Date of Death: (leave blank if not apply) </label><br>
		<input class="form-control" id="date" name="dod" placeholder="YYYY-MM-DD" type="text" style="width: 400px"/><br>
		<button type="submit" class="btn btn-default" name="table_name" value="Director">Add Director</button>
	</div>
</form>


<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$table_name = $_POST["table_name"];
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$gender = $_POST["sex"];
	$dob = $_POST["dob"];
	$dod = $_POST["dod"];

	$empty_field = array();
	if($first_name == null){
		array_push($empty_field, "First Name");
	}

	if($last_name == null) {
		array_push($empty_field, "Last Name");
	}

	if($dob == null) {
		array_push($empty_field, "Date of Birth");
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

	function validateDate($date, $format="Y-m-d"){
		$d = date_create_from_format($format, $date);
		return $d && $d->format('Y-m-d') == $date;
	}

	if(!validateDate($dob) || ($dod!=NULL &&!validateDate($dod))) {
		echo "<div class=\"alert alert-danger\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>Date formating issue</strong></div>";
		exit;
	}

	$db_connection = mysql_connect("localhost", "cs143", "");
	if(!$db_connection){
		die('Could not connect: '.mysql_error());
	}
	mysql_select_db("CS143", $db_connection);
	$max_person_id_query = "SELECT id FROM MaxPersonID";
	$query_result = mysql_query($max_person_id_query, $db_connection);
	$old_max_person_id = mysql_fetch_assoc($query_result)["id"];
	$new_max_person_id = $old_max_person_id + 1;

	if($table_name==='Actor'){
		$db_query = sprintf("INSERT INTO Actor VALUES(".$new_max_person_id.", '%s', '%s', '%s', '%s', ", mysql_real_escape_string($last_name), mysql_real_escape_string($first_name), mysql_real_escape_string($gender), $dob);
	}else{
		$db_query = sprintf("INSERT INTO Director VALUES(".$new_max_person_id.", '%s', '%s', '%s', ", mysql_real_escape_string($last_name), mysql_real_escape_string($first_name), $dob);
	}
	if($dod != null) {$db_query = $db_query."'".mysql_real_escape_string($dod)."');";}
	else {$db_query.="NULL);";}

	if(mysql_query($db_query, $db_connection)){
		echo "<div class=\"alert alert-success\" role=\"alert\"> 
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"
		aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
		<strong>New record inserted successfully</strong></div>";
		$update_MaxPersonID = "UPDATE MaxPersonID SET id=".$new_max_person_id." where id=".$old_max_person_id;
		mysql_query($update_MaxPersonID, $db_connection);
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