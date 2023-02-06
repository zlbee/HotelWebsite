<?php
$roominfo = $_POST["deleteroom"];
$usr = $_COOKIE["username"];
# connect mySQL
$servername = "localhost";
$username = "scyzw1";
$password = "!WZL1101wzl";

$conn = new mysqli($servername, $username, $password);

if (mysqli_connect_error()) {
    die("fail to connect to server: " . mysqli_connect_error());
} else {
	echo "Connecting to mySQL successfully<br>";
}

# connect database
if (mysqli_select_db($conn, "scyzw1")) {
    echo "Connecting to hotel successfully<br>";
} else {
    echo "Error connecting to hotel:" . mysqli_error($conn) . "<br>";
}

$dltsql = "DELETE FROM bookedrooms
WHERE username = '$usr' AND roomname = '$roominfo'";
if (mysqli_query($conn, $dltsql)) {
    echo "<script>alert('Deleting successfully')</script>";
    setcookie("username", "", time()-3600);
    header("refresh:0; url = index.html");
} else {
    echo "Error deleting:" . mysqli_error($conn) . "<br>";
}








?>