<?php
# connect mySQL
$inputvalid = 1;
$roomname = $_POST["roomname"];
if (empty($roomname)) {
	$inputvalid = 0;
    echo "<script>alert('roomname is mandatory')</script>";
}

if ($inputvalid == 0) 
{
    echo "<script>alert('fail to check')</script>";
    header("refresh:0; url = checkapp.html");
}

$servername = "localhost";
$username = "scyzw1";
$password = "!WZL1101wzl";

$conn = new mysqli($servername, $username, $password);


if (mysqli_connect_error()) {
    die("fail to connect to server: " . mysqli_connect_error());
} else {
	//echo "Connecting to mySQL successfully<br>";
}

# connect database
if (mysqli_select_db($conn, "scyzw1")) {
    //echo "Connecting to hotel successfully<br>";
} else {
    echo "Error connecting to hotel:" . mysqli_error($conn) . "<br>";
}

echo "
<!DOCTYPE html>
<html>
<head>
	<link href='https://fonts.googleapis.com/css?family=Didact+Gothic' rel='stylesheet'>
	<link rel='stylesheet' type='text/css' href='pagestyle.css'>
	<title>Delete Appointment | Sunny Isle</title>
</head>
<body>
	<div id = 'interface'>
		<div>
			<p>";
			$selectedsql = "SELECT * FROM bookedrooms WHERE roomname = '$roomname'";
			$result = mysqli_query($conn, $selectedsql);
			if (mysqli_num_rows($result) == 0) {
				echo "<script>alert('no result found')</script>";
			} else {
				while ($row = mysqli_fetch_assoc($result)) {
		    	echo "Username: " . $row['username'] . " Checkin Time: " . $row['checkin'] . " Checkout Time: " . $row['checkout'];
		    	}
			}
			header(url = "index.html");
echo			"</p>
			<button href='index.html'>EXIT</button>
		</div>
	</div>
</body>
</html>";



?>