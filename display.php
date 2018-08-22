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
$tablePart = "<table>";
$sqlQuery = "select ";


if (isset($_POST['sort'])) {
    $sort = $_POST['sort'];
}

if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
}
if (isset($_POST['fields'])) {
    $fields = $_POST['fields'];
}

$tablePart .= "<tr>";
foreach ($_POST['fields'] as $entry) {
    $sqlQuery .= " "."$entry".","; 
    $tablePart .= "<th>".$entry."</th>";
}
$tablePart .= "</tr>";

/* Format the SQL COMMAND and do the query */
$newSqlQuery = rtrim($sqlQuery,", ");
$newSqlQuery .=" from applicants where ".$filter." order by ".$sort." ASC";   // not sure if need the ';'
$result = mysqli_query($db, $newSqlQuery);

if ($result) {
    $numberOfRows = mysqli_num_rows($result);
      if ($numberOfRows == 0) {
        $body .= "<h2>No entries exists in the table</h2><br>";
    } else {
        while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            //MAKE THE BEAUTIFUL TABLE HERE
            $tablePart .= "<tr>";
            for ($i = 0; $i < sizeof($fields); $i++) {
                $tablePart .= "<td>";
                $tablePart .= $recordArray[$fields[$i]];
                $tablePart .= "</td>";
            }
            $tablePart .= "</tr>";
            // $gpa = $recordArray['gpa'];
            // $year = $recordArray['year'];
            // $gender = $recordArray['gender'];
         }
    }
    mysqli_free_result($result);
}  else {
    $body .= "Retrieving records failed.".mysqli_error($db);
}

$tablePart .= "</table><br><br>";




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




$buttonPart = <<<EOBODY
    <form action="main.html" >	
        <input type="submit" name="returnToMain" value="Return to main menu"/><br>
    </form>	
EOBODY;

$body .= $tablePart.$buttonPart;

echo generatePage($body, "Display Applications");



function connectToDB($host, $user, $password, $database) {
	$db = mysqli_connect($host, $user, $password, $database);
	if (mysqli_connect_errno()) {
		echo "Connect failed.\n".mysqli_connect_error();
		exit();
	}
	return $db;
}
?>