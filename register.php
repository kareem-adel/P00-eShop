<?php
require('config.php');


if (isset($_POST{'submit'})) {

    $data = array('email' => $_POST{'email'},
        'fname' => $_POST{'fname'},
        'lname' => $_POST{'lname'},
        'pass' => $_POST{'password'},
        'address' => $_POST{'address'},
        'phone' => $_POST{'phone'});
    echo $_POST{'email'}==null;

    $select_query = sprintf("SELECT count(*) FROM users WHERE email = %s;", $_POST{'email'});

    if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
        echo "This email is already registered. Redirecting to login page";
        echo "<script>setTimeout(\"location.href = 'login.php';\",1500);</script>";

    } else {
        if ($_POST{'email'} == null or $_POST{'password'} == null) {
            header("Location: register.php");
            exit();
        } else {
            try {
                $insert_query = "INSERT INTO users (firstname, lastname, email, password, address, phone) VALUES (:fname, :lname, :email, :pass, :address, :phone);";
                $stmt = $dbh->prepare($insert_query);
                $stmt->execute($data);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            echo 'You are now registered. Redirecting to home page';
            echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>";
        }

    }


} else {
    $form = <<<EOT
<form action='register.php' method=POST>
First Name: <input type='text' name='fname' /><br />
Last Name: <input type='text' name='lname' /><br />
Email: <input type='text' name='email' /><br />
Password: <input type='password' name='password' /><br />
Address: <input type='text' name='address' /><br />
Phone Number: <input type='text' name='phone' /><br />
<input type='submit' value='Register' name='submit' />
</form>
EOT;
    echo $form;


}
