<?php
require('config.php');
session_start();

if (!array_key_exists('email', $_SESSION)) {
    echo "You need to login. Redirecting to Login page.";
    header("location: index.php");
} else {


    if (isset($_POST{'submit'})) {
        $data = array('amount' => $_POST{'quantity'},
            'user_id' => $_SESSION['user_id'],
            'product_id' => $_POST{'product_id'},
            'is_confirmed' => 0);

        $select_if_exists_before = sprintf("SELECT * FROM orders WHERE user_id = %s AND product_id = %s AND is_confirmed = 0;", $_SESSION['user_id'], $_POST['product_id']);
        if ($prepare = $dbh->query($select_if_exists_before) and $prepare->fetchColumn() > 0) {
            $update_order = sprintf("UPDATE orders SET amount=amount+%s WHERE user_id = %s AND product_id = %s AND is_confirmed = 0", $_POST{'quantity'}, $_SESSION['user_id'], $_POST{'product_id'});
            $stmt = $dbh->query($update_order);
            //$stmt->execute(array(':quantity'=> $_POST{'quantity'},':u_id' => $_SESSION['user_id'], ':p_id' => $_POST{'product_id'}));

        } else {
            try {

                $insert_query = "INSERT INTO orders (amount, user_id, product_id, is_confirmed) VALUES (:amount, :user_id, :product_id, :is_confirmed);";
                $stmt = $dbh->prepare($insert_query);
                $stmt->execute($data);
            } catch (PDOException $e) {
                echo 'exception0';
                echo $e->getMessage();

            }
        }

        echo 'Added to cart successfully';
        //echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>";

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
Quantity: <input name='quantity' type='number' min='1' value='1'/><br />
<input type='submit' value='Add' name='submit' />
</form>
EOT;
                echo $form;

            }
        } else {

        }


    } else {
        header("location: index.php");
    }
}