<?php
	$conn = odbc_connect('TM4_DS', 'sa', 'password');
	if (!$conn)
	{
		exit("Connection Failed: " . odbc_error());
	}
?>