<?php
session_start();
if(!array_key_exists('email',$_SESSION)) {
    echo "<a href='login.php'>Login</a><br />";
    echo "<a href='register.php'>Register</a><br />";
}else{
    echo "<a href='logout.php'>logout</a><br />";
    echo $_SESSION['email'];
}
