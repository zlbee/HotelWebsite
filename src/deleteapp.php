<?php
# connect mySQL
$servername = "localhost";
$username = "scyzw1";
$password = "!WZL1101wzl";

$conn = new mysqli($servername, $username, $password);

$username = $_COOKIE["username"];

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
			<form action = 'ondelete.php' method='post'>
				<p>";
				$selectedsql = "SELECT * FROM bookedrooms WHERE username = '$username'";
				$result = mysqli_query($conn, $selectedsql);
				while ($row = mysqli_fetch_assoc($result)) {
			    	echo "<input type='radio' name='deleteroom' value = " . $row['roomname'] . ">Roomname: " . $row['roomname'] . "<br>";
			    }
 
echo		"</p>
				<input id = 'button' type = 'submit' value = 'SUBMIT'>
			</form>
			<a href = 'index.html'>
				<button>EXIT</button>
			</a>
		</div>
	</div>
	
	
</body>
</html>
";
?>