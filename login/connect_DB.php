<?php

// To do the connection: hostname, DB user, password, DB name

$_conn=mysqli_connect("localhost","root","","projetoalmo");
$_conn->set_charset('utf8');

// Check if the connection failed...
if (mysqli_connect_error()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}