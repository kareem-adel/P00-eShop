<?php
require('config.php');
session_start();

if (!array_key_exists('email', $_SESSION)) {
    echo "You need to login. Redirecting to Login page.";
    header("location: index.php");
} else {

}