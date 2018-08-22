<?php
/* This file will insert an applicant info into the database, and display the user input */
require_once("support.php");

session_start();


$host = "localhost";
$user = "dbuser";
$password = "goodbyeWorld";
$database = "applicationdb";
$table = "applicants";
$db = connectToDB($host, $user, $password, $database);
$body = "";

/* someone to be added to table */
// $name = $_POST['name'];
// $email = $_POST['email'];
// $gpa = $_POST['gpa'];
// $year = $_POST['year'];
// $gender = $_POST['gender'];
// $password = $_POST['pass'];

$email = $_SESSION["submitEmial"];
$name = $_SESSION["submitName"];
$gpa = $_SESSION["submitGpa"]; 
$year = $_SESSION["submitYear"];
$gender = $_SESSION["submitGender"]; 
$password = $_SESSION["submitPass"];

$sqlQuery = sprintf("insert into $table (name, email, gpa, year, gender, password) values ('%s', '%s', %s, %s, '%s', '%s')", 
            $name, $email, $gpa, $year, $gender, $password);
$result = mysqli_query($db, $sqlQuery);
if ($result) {
    $body .= "<h3>The entry has been added to the database!!</h3>";
} else { 				   
    $body .= "Inserting records failed.".mysqli_error($db);
}



$body .= <<<EOBODY
	<p>
		Name:  $name<br />
    	Email: $email<br />
        GPA: $gpa<br />
        Year: $year<br />
        Gender: $gender<br />
    </p>
EOBODY;

$body .= <<<EOBODY
    <form action="main.html" >	
        <input type="submit" name="returnToMain" value="Return to main menu"/><br>
    </form>	
EOBODY;


echo generatePage($body, "Info");



function connectToDB($host, $user, $password, $database) {
	$db = mysqli_connect($host, $user, $password, $database);
	if (mysqli_connect_errno()) {
		echo "Connect failed.\n".mysqli_connect_error();
		exit();
	}
	return $db;
}
?>