<?php
require_once("support.php");

session_start();

$host = "localhost";
$user = "dbuser";
$password = "goodbyeWorld";
$database = "applicationdb";
$table = "applicants";
$db = connectToDB($host, $user, $password, $database);

$email = $_SESSION["updateEmail"];
$name = $_SESSION["updateName"];
$gpa = $_SESSION["updateGpa"];
$year = $_SESSION["updateYear"];
$gender = $_SESSION["updateGender"];
$password = $_SESSION["updatePass"];

/* update the database */
$sqlQuery = sprintf("update applicants set name='%s', email='%s', gpa=%s, year=%s, gender='%s', password='%s' where email='%s'", $name, $email, $gpa, $year, $gender, $password, $email); 
//$sqlQuery = "update applicants set name='$name', gpa=$gpa, gender='$gender', password='$password' where email='$email'";
$result = mysqli_query($db, $sqlQuery);

if ($result) {
    $body = "<h3>The entry has been updated in the database and the new values are: </h3><br>";
} else { 				   
    $body = "Inserting records failed.".mysqli_error($db);
}
    
/* Closing */
mysqli_close($db);

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


echo generatePage($body, "Update Confirmed");

function connectToDB($host, $user, $password, $database) {
    $db = mysqli_connect($host, $user, $password, $database);
    if (mysqli_connect_errno()) {
        echo "Connect failed.\n".mysqli_connect_error();
        exit();
    }
    return $db;
}
?>