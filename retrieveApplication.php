<?php
require_once("support.php");

session_start();


$host = "localhost";
$user = "dbuser";
$password = "goodbyeWorld";
$database = "applicationdb";
$table = "applicants";
$db = connectToDB($host, $user, $password, $database);
$body = "<h2>Application found in the database with the following values: </h2><br>";

/* select from table */
$email = $_SESSION["appEmail"];
$sqlQuery = sprintf("select * from $table where email='%s'", $email); 
$result = mysqli_query($db, $sqlQuery);

if ($result) {
    $numberOfRows = mysqli_num_rows($result);
      if ($numberOfRows == 0) {
        $body .= "<h2>No entries exists in the table</h2><br>";
    } else {
        while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $name = $recordArray['name'];
            $gpa = $recordArray['gpa'];
            $year = $recordArray['year'];
            $gender = $recordArray['gender'];
         }
    }
    mysqli_free_result($result);
}  else {
    $body .= "Retrieving records failed.".mysqli_error($db);
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