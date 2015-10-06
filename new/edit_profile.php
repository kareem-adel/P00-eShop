<?php
require('config.php');
session_start();

if (!array_key_exists('email', $_SESSION)) {
    header("location: login.php");
} else {
    if (isset($_POST{'submit'})) {
        echo $_SESSION['user_id'];
        $check_query = sprintf("SELECT count(*) FROM users WHERE email = '%s' AND id = %s", $_POST['email'], $_SESSION['user_id']);
        $result = $dbh->prepare($check_query);
        $result->execute();
        $number_of_records = $result->fetchColumn();
    } else {
        $select_query = sprintf("SELECT * FROM users WHERE  email = '%s'", $_SESSION['email']);
        if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
            foreach ($dbh->query($select_query) as $row) {
                $fname = $row['firstname'];
                $lname = $row['lastname'];
                $email = $row['email'];
                $password = $row['password'];
                $address = $row['address'];
                $phone = $row['phone'];
                $image = $row['image'];


            }

        }
        if ($image <> null) {
            $encoded_image = base64_encode($image);
            echo "<img src='data:image/jpeg;base64,{$encoded_image}'>";
        }
        $form = <<<EOT
<form action='edit_profile.php' method=POST>
<input type='file' name='image' accept='image/*' enctype='multipart/form-data'><br />
First Name: <input type='text' name='fname' value="$fname" /><br />
Last Name: <input type='text' name='lname' value="$lname" /><br />
Email: <input type='text' name='email' value="$email" /><br />
Address: <input type='text' name='address' value="$address" /><br />
Phone Number: <input type='text' name='phone' value="$phone" /><br />
<input type='submit' value='Update' name='submit' />
</form>
EOT;
        echo $form;
        echo "<a href='change_pass.php'>Change Password</a>";
    }
}
