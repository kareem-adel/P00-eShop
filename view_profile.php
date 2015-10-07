<?php
session_start();
?>

<?php
require('config.php');
if (isset($_COOKIE['email'])) {
    $_SESSION['email'] = $_COOKIE['email'];
}
if (isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
}
if (isset($_COOKIE['user_fname'])) {
    $_SESSION['user_fname'] = $_COOKIE['user_fname'];
}


if (!isset($_SESSION['email'])) {
    echo "<script>window.location.assign(\"LoginRegister.php\");</script>";
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
    $final_image="<img src=\"images/avatar.png\"/>";
    if ($image <> null) {
        $encoded_image = base64_encode($image);
        $final_image="<img src='data:image/jpeg;base64,{$encoded_image}'>";
    }
    echo $final_image;
    echo "<br />";
    echo $fname . " " . $lname;
    echo "<br />";
    echo "Email: " . $email;
    echo "<br />";
    echo "Address: " . $address;
    echo "<br />";
    echo "Phone No.: " . $phone;
    echo "<br />";
    echo "<a href='edit_profile.php'>Edit Profile</a>";
}
