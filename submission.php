<?php
	require_once("support.php");

	session_start();
    $body = "";
    $bottomPart = "";
    $isGood = 0;
    $host = "localhost";
    $user = "dbuser";
    $password = "goodbyeWorld";
    $database = "applicationdb";
    $table = "applicants";
    $db = connectToDB($host, $user, $password, $database);

    if (isset($_POST["submitApplication"])) {
        $nameValue = trim($_POST["name"]);
        $emailValue = trim($_POST["email"]);
        $gpaValue = trim($_POST["gpa"]);
        $year = $_POST['year'];
        $gender = $_POST['gender'];
        $pass = trim($_POST["pass"]);
        $vrfyPass = trim($_POST["vrfyPass"]);

        // // add email check in database
        // $sqlQuery2 = sprintf("select * from $table where email='%s'", $emailValue); 
        // $result2 = mysqli_query($db, $sqlQuery);

        // if ($result2) {
        //     $numberOfRows = mysqli_num_rows($result2);
        //     if ($numberOfRows !== 0) {
        //         $isGood = 0;
        //         $bottomPart .= "<h2>This email is already in the table</h2><br>";
        //     } else {
        //         $isGood = 1;
        //     }
        //     mysqli_free_result($result2);
        // }  else {
        //     $bottomPart .= "Retrieving records failed 2.".mysqli_error($db);
        // }

        // password check
        if ($pass !== $vrfyPass) {
            $bottomPart .= "<strong><h1>Password must match.</h1></strong><br>";
            $pass = "";
            $vrfyPass = "";
            $isGood = 0;
        }

        if ($bottomPart === "") {
            $isGood = 1;
            $_SESSION["submitEmial"] = $emailValue;
            $_SESSION["submitName"] = $nameValue;
            $_SESSION["submitGpa"] = $gpaValue;
            $_SESSION["submitYear"] = $year;
            $_SESSION["submitGender"] = $gender;
            $_SESSION["submitPass"] = $pass;
			header('Location: info.php');
		}
        
    } else {
        $nameValue = "";
        $emailValue = "";
        $gpaValue = "";
        $pass = "";
        $vrfyPass = "";
    }

        $bigBody = <<<EOBODY
            <form action="{$_SERVER["PHP_SELF"]}" method="post">
                         Name: <input type="text" name="name" value="$nameValue" required/><br><br>
                         Email <input type="text" name="email" value="$emailValue" required/><br><br>
                         GPA <input type="text" name="gpa" value="$gpaValue" max="4" required/><br><br>
                         Year: 
                         <input type="radio" name="year" value="10" required/>10
                         <input type="radio" name="year" value="11" required/>11
                         <input type="radio" name="year" value="12" required/>12<br><br>
                         Gender: 
                         <input type="radio" name="gender" value="M" required/>M
                         <input type="radio" name="gender" value="F" required/>F<br><br>
                         Password: 
                         <input type="password" name="pass" value="$pass" required/><br><br>
                         Verify Password: 
                         <input type="password" name="vrfyPass" value="$vrfyPass" required/><br><br>
                         <input type="submit" name="submitApplication" />
            </form>	
             <form action="main.html" >	
                         <input type="submit" name="returnToMain" value="Return to main menu"/><br>
            </form>		
EOBODY;

    $body .= $bigBody.$bottomPart;
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