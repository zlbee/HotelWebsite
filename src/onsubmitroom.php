<?php
$roominfo = $_POST["selectedroom"];
$checkin = $_COOKIE["checkin"];
$checkout = $_COOKIE["checkout"];
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
# update booked dates
$change = "INSERT INTO bookedrooms (username, roomname, checkin, checkout)
VALUES ('$usr', '$roominfo', '$checkin', '$checkout')";
if (mysqli_query($conn, $change)) {
    echo "Updating booked dates successfully<br>";
    echo "<script>alert('booking room successfully')</script>";
	header("refresh:0; url = deleteapp.php");
} else {
    echo "Error updating booked dates:" . mysqli_error($conn) . "<br>";
}


?>