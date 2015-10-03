<?php
require('config.php');
session_start();

if (isset($_POST{'submit'})) {
    if (!array_key_exists('email', $_SESSION)) {
        $email = $_POST{'email'};
        $password = $_POST{'password'};
        $check_query = sprintf("SELECT * FROM users WHERE email = %s AND password = %s;", $email, $password);
        if ($prepare = $dbh->query($check_query) and $prepare->fetchColumn() > 0) {
            $_SESSION['email'] = $email;
            echo 'You are now logged in';
            echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>";

        } else {
            echo 'Wrong email or password';
            echo "<script>setTimeout(\"location.href = 'login.php';\",1500);</script>";
        }

    } else {
        echo 'already logged in';
        echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>";

    }
} else {
    $form = <<<EOT
<form action='login.php' method=POST>
Email: <input type='text' name='email' /><br />
Password: <input type='password' name='password' /><br />
<input type='submit' value='Login' name='submit' />
</form>
EOT;
    echo $form;
}
