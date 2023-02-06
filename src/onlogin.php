<?php
# check input validation
$inputvalid = 1;
if (empty($_POST["username"]))
{
    $inputvalid = 0;
    echo "<script>alert('username is mandatory')</script>";
}
if (empty($_POST["password"])) {
    $inputvalid = 0;
    echo "<script>alert('password is mandatory')</script>";
}
if ($inputvalid == 0) 
{
    header("refresh:0; url = login.html");
} else {
    # connect mySQL
    $servername = "localhost";
    $username = "scyzw1";
    $password = "!WZL1101wzl";
    $conn = new mysqli($servername, $username, $password);

    if (mysqli_connect_error()) {
        die("fail to connect to server: " . mysqli_connect_error());
    }
    echo "connection successful";

    # connect database
    if (mysqli_select_db($conn, "scyzw1")) {
        echo "Connecting to hotel successfully<br>";
    } else {
        echo "Error connecting to hotel:".mysqli_error($conn) . "<br>";
    }

    $result = mysqli_query($conn, "SELECT * FROM roomers");
    while ($sqlarr = mysqli_fetch_array($result)) {
        echo $sqlarr["username"];
        echo $sqlarr["password"];
        if ($sqlarr["username"] == $_POST["username"]) {
            if ($sqlarr["password"] == $_POST["password"]) {
                echo "<script>alert('login successful')</script>";
                setcookie("username", $_POST["username"], time()+3600);
                header("refresh:0; url = room_book.html");
            } else {
                echo "<script>alert('invalid login')</script>";
                header("refresh:0; url = login.html");
            }

        } else {
            echo "<script>alert('invalid login')</script>";
            header("refresh:0; url = login.html");
        }   
    }
}







?>