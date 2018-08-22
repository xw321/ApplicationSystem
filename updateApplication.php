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
    $genderCheckM = $genderCheckF = $yearCheck10 = $yearCheck11 = $yearCheck12 = "";
    

    /* select data from table */
    $email = $_SESSION["updateEmail"];
    $sqlQuery = sprintf("select * from $table where email='%s'", $email); 
    $result = mysqli_query($db, $sqlQuery);

    if ($result) {
        $numberOfRows = mysqli_num_rows($result);
        if ($numberOfRows == 0) {
            $bottomPart .= "<h2>No entries exists in the table</h2><br>";
        } else {
            while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $passDB = $recordArray['password'];
                $name = $recordArray['name'];
                $gpa = $recordArray['gpa'];
                $year = $recordArray['year'];
                $gender = $recordArray['gender'];
            }
        }
        mysqli_free_result($result);
    }  else {
        $bottomPart .= "Retrieving records failed.".mysqli_error($db);
    }

    if ($gender == "M") {
        $genderCheckM = "checked";
    } else {
        $genderCheckF = "checked";
    }

    if ($year == "10") {
        $yearCheck10 = "checked";
    } else if ($year == "11") {
        $yearCheck11 = "checked";
    } else {
        $yearCheck12 = "checked";
    }


    // post process
    if (isset($_POST["submitApplication"])) {
        $nameValue = trim($_POST["name"]);
        $emailValue = trim($_POST["email"]);
        $gpaValue = trim($_POST["gpa"]);
        $yearValue = $_POST['year'];
        $genderValue = $_POST['gender'];
        $passValue = trim($_POST["pass"]);
        $vrfyPassValue = trim($_POST["vrfyPass"]);

        // check password match
        if ($passValue !== $vrfyPassValue) {
            $bottomPart .= "<strong><h1>Password must match.</h1></strong><br>";
            $passValue = "";
            $vrfyPassValue = "";
            $isGood = 0;
        }

        if ($bottomPart === "") {
            $isGood = 1;
            $_SESSION["updateEmail"] = $emailValue;
            $_SESSION["updateName"] = $nameValue;
            $_SESSION["updateGpa"] = $gpaValue;
            $_SESSION["updateYear"] = $yearValue;
            $_SESSION["updateGender"] = $genderValue;
            $_SESSION["updatePass"] = $passValue;
            header('Location: updateConfirm.php');
		}
    } else {

    }

        $bigBody = <<<EOBODY
            <form action="{$_SERVER["PHP_SELF"]}" method="post">
                         Name: <input type="text" name="name" value="$name" required/><br><br>
                         Email <input type="text" name="email" value="$email" required/><br><br>
                         GPA <input type="text" name="gpa" value="$gpa" required/><br><br>
                         Year: 
                         <input type="radio" name="year" value="10" $yearCheck10 required/>10
                         <input type="radio" name="year" value="11" $yearCheck11 required/>11
                         <input type="radio" name="year" value="12" $yearCheck12 required/>12<br><br>
                         Gender: 
                         <input type="radio" name="gender" value="M" $genderCheckM required/>M
                         <input type="radio" name="gender" value="F" $genderCheckF required/>F<br><br>
                         Password: 
                         <input type="password" name="pass" value="$passDB" required/><br><br>
                         Verify Password: 
                         <input type="password" name="vrfyPass" value="$passDB" required/><br><br>
                         <input type="submit" name="submitApplication" />
            </form>	
             <form action="main.html" >	
                         <input type="submit" name="returnToMain" value="Return to main menu"/><br>
            </form>		
EOBODY;



    $body .= $bigBody.$bottomPart;
    echo generatePage($body, "Update Application!");


    function connectToDB($host, $user, $password, $database) {
        $db = mysqli_connect($host, $user, $password, $database);
        if (mysqli_connect_errno()) {
            echo "Connect failed.\n".mysqli_connect_error();
            exit();
        }
        return $db;
    }
?>