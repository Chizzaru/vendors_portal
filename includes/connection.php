<?php

$servername = "192.168.0.76";
$username = "ccn1";
$password = "ccn1@dm1n";
$dbname = "ccndb";

//create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }