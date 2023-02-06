<?php
# check input validation
$inputvalid = 1;
if (empty($_POST["username"]))
{
    $inputvalid = 0;
    echo "<script>alert('username is mandatory')</script>";
}
if (empty($_POST["password"]))
{
    $inputvalid = 0;
    echo "<script>alert('password is mandatory')</script>";
}
if (empty($_POST["realname"]))
{
    $inputvalid = 0;
    echo "<script>alert('realname is mandatory')</script>";
}
if ($inputvalid == 0) 
{
    echo "<script>alert('fail to register')</script>";
    header("refresh:0; url = staffregister.html");
}
else
{
    # connect to mySQL
    $servername = "localhost";
    $username = "scyzw1";
    $password = "!WZL1101wzl";

    $conn = new mysqli($servername, $username, $password);

    if (mysqli_connect_error()) {
        die("fail to connect to server: " . mysqli_connect_error());
    } else {
        echo "Connecting to mySQL successfully<br>";
    }

    # create database
    $sql = "CREATE DATABASE scyzw1";
    if (mysqli_query($conn, $sql)) {
        echo "Database created successfully<br>";
    }
    else {
        echo "Error creating database: " . mysqli_error($conn) . "<br>";
    }            

    # connect database
    if (mysqli_select_db($conn, "scyzw1")) {
        echo "Connecting to hotel successfully<br>";
    } else {
        echo "Error connecting to hotel:".mysqli_error($conn) . "<br>";
    }

    # create table: roomers
    $tablesql = "CREATE TABLE staff (
    username VARCHAR(30) PRIMARY KEY NOT NULL,
    password VARCHAR(30) NOT NULL,
    realname VARCHAR(50) NOT NULL
    )";
    if (mysqli_query($conn, $tablesql)) {
        echo "Tabel: staff created successfully<br>";
    } else {
        echo "Error creating table: staff: " . mysqli_error($conn) . "<br>";
    }

    # upload personal information
    $sql = "INSERT INTO staff (username, password, realname)
    VALUES ('$_POST[username]', '$_POST[password]', '$_POST[realname]')";

    if (mysqli_query($conn, $sql)) {
        echo "Inserting user information successfully<br>";
    } else {
        echo "Error inserting user information:" . mysqli_error($conn) . "<br>";
    }
}
mysqli_close($conn);
header("refresh:0; url = stafflogin.html");
?>