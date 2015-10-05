<?php
$user = 'shopping';
$pass = '1234';
//database source
$dsn = 'mysql:host=localhost;dbname=shopping';

//database handler
$dbh = new PDO($dsn, $user, $pass);