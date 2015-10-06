<?php
require('config.php');
session_start();

if (!array_key_exists('email', $_SESSION)) {
    header("location: login.php");
} else {
    if (isset($_GET{'remove_image'})) {
        $update_order = sprintf("UPDATE users SET image=null WHERE id = %s ", $_SESSION['user_id']);
        $stmt = $dbh->query($update_order);
        header("location: edit_profile.php");
    } elseif (isset($_POST{'submit'})) {
        $tmpName = $_FILES['image']['tmp_name'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        if ($email == null || $address == null) {
            echo "Empty email or Address.";
            echo "<script>setTimeout(\"location.href = 'edit_profile.php';\",1500);</script>";
        } else {
            $select_query = sprintf("SELECT count(*) FROM users WHERE email = '%s'", $email);
            $result = $dbh->prepare($select_query);
            $result->execute();
            $number_of_records1 = $result->fetchColumn();

            $select_query = sprintf("SELECT count(*) FROM users WHERE email = '%s' AND id = %s", $email, $_SESSION['user_id']);
            $result = $dbh->prepare($select_query);
            $result->execute();
            $number_of_records2 = $result->fetchColumn();
            if ($number_of_records1 <> $number_of_records2) {
                echo "This email is already registered. You can not change your email to it.";
                echo "<script>setTimeout(\"location.href = 'edit_profile.php';\",1500);</script>";
            } else {
                if ($tmpName <> null) {
                    $fp = fopen($tmpName, 'r');
                    $data = fread($fp, filesize($tmpName));
                    $data = addslashes($data);
                    fclose($fp);
                    $update_order = sprintf("UPDATE users SET firstname='%s', lastname='%s', email='%s', address='%s', phone='%s', image='%s' WHERE id = %s ", $fname, $lname, $email, $address, $phone, $data, $_SESSION['user_id']);
                    $stmt = $dbh->query($update_order);
                    $_SESSION['email'] = $email;
                } else {
                    $update_order = sprintf("UPDATE users SET firstname='%s', lastname='%s', email='%s', address='%s', phone='%s' WHERE id = %s ", $fname, $lname, $email, $address, $phone, $_SESSION['user_id']);
                    $stmt = $dbh->query($update_order);
                    $_SESSION['email'] = $email;
                }
                echo "Your profile was updates successfully";
                echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>";
            }

        }


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
            $form = <<<EOT
<form action='edit_profile.php' method=GET'>
<input type='submit' value='Delete image' name='remove_image' />
</form>
EOT;
            echo $form;
        }
        $form = <<<EOT
<form action='edit_profile.php' method=POST enctype='multipart/form-data'>
<input type='file' name='image' accept='image/*'/><br />
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
