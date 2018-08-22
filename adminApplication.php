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
$body = "<h1>Applications</h1><br>";

/* someone to be added to table */
// $name = $_POST['name'];
// $email = $_POST['email'];
// $gpa = $_POST['gpa'];
// $year = $_POST['year'];
// $gender = $_POST['gender'];
// $password = $_POST['pass'];

// $sqlQuery = sprintf("insert into $table (name, email, gpa, year, gender, password) values ('%s', '%s', %s, %s, '%s', '%s')", 
//             $name, $email, $gpa, $year, $gender, $password);
// $result = mysqli_query($db, $sqlQuery);
// if ($result) {
//     $body .= "<h3>The entry has been added to the database!!</h3>";
// } else { 				   
//     $body .= "Inserting records failed.".mysqli_error($db);
// }



$body .= <<<EOBODY
    <form action="display.php" method="post">
        Select fields to display<br>
            <select id = "scroll" name="fields[]" multiple="multiple" required>
                <option name="name" value="name">name</option>
                <option name="email" value="email">email</option>
                <option name="gpa" value="gpa">gpa</option>
                <option name="year" value="year">year</option>
                <option name="gender" value="gender">gender</option>
            </select><br><br>
        Select field to sort applications<br>
            <select id="sort" name="sort" required>
                <option name="nameSort" value="name">name</option>
                <option name="emailSort" value="email">email</option>
                <option name="gpaSort" value="gpa">gpa</option>
                <option name="yearSort" value="year">year</option>
                <option name="genderSort" value="gender">gender</option>
            </select><br><br>
        Filter condition: <input type="text" name="filter" required/><br><br>
        <input type="submit" name="display" value="Display Applications"/><br>
    </form><br>
EOBODY;

$body .= <<<EOBODY
    <form action="main.html" >	
        <input type="submit" name="returnToMain" value="Return to main menu"/><br>
    </form>	
EOBODY;


echo generatePage($body, "Admin");



function connectToDB($host, $user, $password, $database) {
	$db = mysqli_connect($host, $user, $password, $database);
	if (mysqli_connect_errno()) {
		echo "Connect failed.\n".mysqli_connect_error();
		exit();
	}
	return $db;
}
?>