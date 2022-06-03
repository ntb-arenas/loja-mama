<?php

// To do the connection: hostname, DB user, password, DB name
// $_conn=mysqli_connect("localhost","id17632851_id17632851_pap","K*1=5P4j<6X?S|x{","id17632851_projetoalmo");

$_conn=mysqli_connect("localhost","root","","projetoalmo");
$_conn->set_charset('utf8');

// Check if the connection failed...
if (mysqli_connect_error()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}