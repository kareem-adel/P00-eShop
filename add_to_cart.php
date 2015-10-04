<?php
require('config.php');
session_start();

if (!array_key_exists('email', $_SESSION)) {
    echo "<a href='login.php'>Login</a><br />";
    echo "<a href='register.php'>Register</a><br />";
} else {


    if (isset($_POST{'submit'})) {

    echo 'this is submit';
    echo $_POST{'quantity'};
    echo $_POST{'product_id'};

    } elseif (isset($_POST{'add_to_cart'})) {
        $select_query = sprintf("SELECT * FROM products WHERE id = %s", $_POST{'product_id'});
        if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
            foreach ($dbh->query($select_query) as $row) {
                $encoded_image = base64_encode($row['image']);
                echo "<img src='data:image/jpeg;base64,{$encoded_image}'>";
                echo "<br />";
                $item_id = $row['id'];
                $form = <<<EOT
<form action='add_to_cart.php' method=POST>
<input type="hidden" name="product_id"  value="$item_id"/>
Quantity: <input name='quantity' type='number' min='0'/><br />
<input type='submit' value='Add' name='submit' />
</form>
EOT;
                echo $form;

            }
        } else {

        }


    }else{
        header("location: index.php");
    }
}