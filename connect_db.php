<?php 
	$conn = mysqli_connect //names variable $conn
	('localhost', 'Joe', '123', 'queue')
	OR die
	( mysqli_connect_error()) ; //if it can't connect kills the connection 
	mysqli_set_charset($conn, 'utf8') ;
?><!--DATABASE connection -->