<?php
$checkin = $_POST["checkin"];
setcookie("checkin", $checkin, time()+3600);
$checkout = $_POST["checkout"];
setcookie("checkout", $checkout, time()+3600);
$roomtype = $_POST["roomtype"]; 
echo $roomtype;
echo gettype($roomtype);
# check input validation
$inputvalid = 1;
$now = date("Y-m-d");
if ($_POST["checkin"] <= $now) {
	echo "<script>alert('Booking date is overdue')</script>";
	$inputvalid = 0;
}
if ($_POST["checkin"] >= $_POST["checkout"]) {
	echo "<script>alert('Checkin date is over checkout date')</script>";
	$inputvalid = 0;
}
if (empty($_POST["roomtype"])) {
	echo "<script>alert('Please select one room type')</script>";
}

if ($inputvalid === 0) {
	header("refresh:0; url = room_book.html");
} else {	
	# connect mySQL
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
        echo "Error connecting to hotel:".mysqli_error($conn) . "<br>";
    }

    # create table: rooms
    $rsql = "CREATE TABLE rooms (
    roomname VARCHAR(255),
    floor INT NOT NULL,
    roomNo VARCHAR(255) NOT NULL,
    roomtype TEXT NOT NULL
    )";
    if (mysqli_query($conn, $rsql)) {
        //echo "Tabel: rooms created successfully<br>";

        for ($i = 1; $i < 11; $i++) { 
		    $sql = "
		    INSERT INTO rooms (roomname, floor, roomNo, roomtype)
		    VALUES 
		    ($i" . "01" . ", $i, '01', 'largeroomwithdoublebeds'),
		    ($i" . "02" . ", $i, '02', 'largeroomwithdoublebeds'),
		    ($i" . "03" . ", $i, '03', 'largeroomwithalargesinglebed'),
		    ($i" . "04" . ", $i, '04', 'largeroomwithalargesinglebed'),
		    ($i" . "05" . ", $i, '05', 'smallroomwithasinglebed'),
		    ($i" . "06" . ", $i, '06', 'smallroomwithasinglebed'),
		    ($i" . "07" . ", $i, '07', 'smallroomwithasinglebed'),
		    ($i" . "08" . ", $i, '08', 'smallroomwithasinglebed'),
		    ($i" . "09" . ", $i, '09', 'largeroomwithalargesinglebed'),
		    ($i" . "10" . ", $i, '10', 'largeroomwithalargesinglebed'),
		    ($i" . "11" . ", $i, '11', 'largeroomwithdoublebeds'),
		    ($i" . "12" . ", $i, '12', 'largeroomwithdoublebeds'),
		    ($i" . "13" . ", $i, '13', 'VIProom')
		    ";
		    if (mysqli_query($conn, $sql)) {
	            echo "Inserting room information successfully<br>";
		    } else {
	            echo "Error inserting room information:" . mysqli_error($conn) . "<br>";
		    }
    	}


    } else {
        echo "Error creating table: rooms: " . mysqli_error($conn) . "<br>";
    }

    # create table: bookedrooms
    $brsql = "CREATE TABLE bookedrooms (
    username VARCHAR(255),
    roomtype VARCHAR(255),
    roomname VARCHAR(255),
    floor VARCHAR(255),
    roomNo VARCHAR(255),
    checkin DATE,
    checkout DATE
    )";
    if (mysqli_query($conn, $brsql)) {
		//echo "Creating table: bookedrooms successfully<br>";
	} else {
		echo "Error creating table: bookedrooms:" . mysqli_error($conn) . "<br>";
	}		

    # output avialable required rooms
	$finalrooms = "SELECT roomtype, floor, roomNo, roomname FROM rooms 
	WHERE (roomtype = '$roomtype')
    AND roomname NOT IN 
    (SELECT roomname FROM bookedrooms WHERE
    
        ((checkin <= '$checkin') AND ('$checkin' <= checkout))
     OR 
        ((checkin <= '$checkout') AND ('$checkout' <= checkout))
     OR 
        ((checkin >= '$checkin') AND (checkout <= '$checkout'))
    )";

    if (mysqli_query($conn, $finalrooms)) {
        echo "Creating available data successfully<br>";

        $result = mysqli_query($conn, $finalrooms);
        $num_rows = mysqli_num_rows($result);
        echo $num_rows . "rows";

	    # output result to user
	    echo "
        <!DOCTYPE html>
        <html>
        <head>
            <link href='https://fonts.googleapis.com/css?family=Didact+Gothic' rel='stylesheet'>
            <link rel='stylesheet' type='text/css' href='pagestyle.css'>
            <title> Room Book | Sunny Isle</title>
        </head>
        <body>
            <div id = 'interface'>
            <div>
                <p>Choose your room</p>
                <form action = 'onsubmitroom.php' method = 'post'>";
                mysqli_data_seek($result, 0);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<input type='radio' name='selectedroom' value = " . $row['roomname'] . ">Floor: " . $row['floor'] . " Room number: " . $row['roomNo'] . "<br>";
                }
        echo "
                    <input id = 'button' type = 'submit' value = 'SUBMIT'>
                </form>
            </div>
        </div>
        </body>
        </html>";
    } else {
        echo "Error creating available data:" . mysqli_error($conn) . "<br>";
    }


    
}





?>