<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
} else {
    echo "<p>Hello amigo.</p>";
    $body =<<<EOBODY
    <form action="main.html" >	
    <input type="submit" name="returnToMain" value="Return to main menu"/><br>
</form>		
EOBODY;
    if (($_SERVER['PHP_AUTH_USER'] !== "main") || ($_SERVER['PHP_AUTH_PW'] !== "terps")) {
        echo "You don't have access";
        echo $body;
    } else {
        header('Location: adminApplication.php');
    }
}
?>