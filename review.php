<?php
	require_once("support.php");

    session_start();
    $host = "localhost";
    $user = "dbuser";
    $password = "goodbyeWorld";
    $database = "applicationdb";
    $table = "applicants";
    $db = connectToDB($host, $user, $password, $database);

    $body = "";
    $bottomPart = "";
    $isGood = 0;

    if (isset($_POST["submitApplication"])) {
        $emailValue = trim($_POST["email"]);
        $pass = trim($_POST["pass"]);
        $sqlQuery = sprintf("select password from $table where email='%s'", $emailValue); 
	    $result = mysqli_query($db, $sqlQuery);

        if ($result) {
            $numberOfRows = mysqli_num_rows($result);
            if ($numberOfRows == 0) {
                $bottomPart .= "<h2>No entry exists in the database for the specified email and password</h2><br>";
            } else {
                // retrieve the password in DB
                while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $passDB = $recordArray['password'];
                }
                // check if pass matches
                if ($pass === $passDB) {
                    $_SESSION["appEmail"] = $emailValue;
                    header('Location: retrieveApplication.php');
                } else {
                    $bottomPart .= "<h2>No entry exists in the database for the specified email and password</h2><br>";
                }


            }
            mysqli_free_result($result);
        }  else {
            $bottomPart .= "Retrieving records failed.".mysqli_error($db);
        }


        if ($bottomPart == "") {
            $isGood = 1;
			//header('Location: info.php');
		}
        
    }




    $body .= <<<EOBODY
        <form action="{$_SERVER["PHP_SELF"]}" method="post">
                         Email associated with application: <input type="text" name="email" required/><br><br>
                         Password associated with application: 
                         <input type="password" name="pass" required/><br><br>
                         <input type="submit" name="submitApplication" />
        </form>	
        <form action="main.html" >	
                         <input type="submit" name="returnToMain" value="Return to main menu"/><br>
        </form>		
EOBODY;


    $body .= $bottomPart;
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