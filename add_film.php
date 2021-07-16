<!DOCTYPE html>
<!--	Author: Anthony Storti
		Date:	October 31, 2019
		File:	add_film.php
		Purpose:add film to MariaDB Sakila Database
-->

<html>
<head>
	<title>Add Film Results</title>
	<link rel ="stylesheet" type="text/css" href="sample.css">
</head>

<body>

<?php

$server = "localhost";
$user = "root";
$pw = "";
$db = "sakila";

//create a new connection to the database
$mysqli = new mysqli($server, $user, $pw, $db);
if($mysqli->connect_error) {
  exit('Error connecting to database');  //Should be a message a typical user could understand in production
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli->set_charset("utf8mb4");

//grab the info from the $_POST array
$title = $_POST['title'];
$desc = $_POST['desc'];
$rYear = $_POST['rYear'];
$lId = $_POST['lId'];
$rDur = $_POST['rDur'];
$rRate = $_POST['rRate'];
$len  = $_POST['len'];
$repCost = $_POST['repCost'];
$rat = $_POST['MPAA'];
$specF = $_POST['specF'];


$stmt = $mysqli->prepare("INSERT INTO sakila.film (title, description, release_year, language_id, rental_duration, rental_rate, length, replacement_cost, rating, special_features) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");

$stmt->bind_param("ssiiididss", $title, $desc, $rYear, $lId, $rDur, $rRate, $len, $repCost, $rat, $specF);

$stmt->execute(); //submit query to SQL server
$result = $stmt->get_result();  //get the result

if($stmt->affected_rows === 0) {
   exit('No rows updated');
} else {
	print("	<h1>SUCCESSFUL ADDITION</h1>");
}

 //close the connection
$stmt->close();

$mysqli->close();


?>
<form>
<button type="submit" formaction="manager.html">Return to Manager</button>
</form>
</body>
</html>
