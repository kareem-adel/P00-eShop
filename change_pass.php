<?php
session_start();
require("config.php");

if (!array_key_exists('email', $_SESSION)) {
    header("location: LoginRegister.php");
} else {
    if (isset($_POST{'submit'})) {
            $select_query = sprintf("SELECT count(*) FROM users WHERE email = '%s'AND password = '%s'", $_SESSION['email'], $_POST['old_password']);
            $result = $dbh->prepare($select_query);
            $result->execute();
            $number_of_records = $result->fetchColumn();
            if ($number_of_records > 0) {
                if ($_POST['new_password'] == null) {
                    echo 'Please enter the new password';
                    echo "<script>setTimeout(\"location.href = 'change_pass.php';\",1000);</script>";
                }else{
                    $update_order = sprintf("UPDATE users SET password='%s' WHERE email = '%s'", $_POST['new_password'], $_SESSION['email']);
                    $stmt = $dbh->query($update_order);
                    echo "Password changed successfully";
                    echo "<script>setTimeout(\"location.href = 'index.php';\",1000);</script>";
                }

            }else{
                echo "The old password is not correct.";
                echo "<script>setTimeout(\"location.href = 'change_pass.php';\",1000);</script>";
            }

    } else {
        header("location: edit_profile.php");
		}
}