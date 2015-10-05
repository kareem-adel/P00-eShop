<?php
require('config.php');
session_start();


if (!array_key_exists('email', $_SESSION)) {
    header("location: login.php");
} else {
    if (isset($_GET{'remove_from_cart'})) {

        $delete_query = sprintf("DELETE FROM orders WHERE user_id = %s AND product_id = %s", $_SESSION['user_id'], $_GET['product_id']);
        $dbh->query($delete_query);
        header("location: cart.php");

    } elseif (isset($_GET{'checkout'})) {
        $message = "";
        $flag = 0;
        $select_query = sprintf("SELECT orders.amount AS order_amount, orders.product_id, products.name, products.description, products.price, products.amount AS product_amount, products.image FROM orders, products WHERE orders.product_id = products.id AND orders.is_confirmed = 0 AND orders.user_id = %s", $_SESSION['user_id']);
        if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
            foreach ($dbh->query($select_query) as $row) {
                if ($row['product_amount'] < $row['order_amount']) {
                    $flag = 1;
                    $message = $message . 'The item ' . $row['name'] . " has only " . $row['product_amount'] . " pieces left " . " but you ordered " . $row['order_amount'] . "<br />";
                }


            }
            if ($flag == 1) {
                echo $message . "<br />" . "Please click <a href='cart.php'>here<a/> to edit your cart";
            } else {

                $select_query = sprintf("SELECT orders.amount AS order_amount, orders.product_id, products.name, products.description, products.price, products.amount AS product_amount, products.image FROM orders, products WHERE orders.product_id = products.id AND orders.is_confirmed = 0 AND orders.user_id = %s", $_SESSION['user_id']);
                if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
                    foreach ($dbh->query($select_query) as $row) {
                        $update_order_to_confirm = sprintf("UPDATE orders SET is_confirmed= 1  WHERE user_id = %s AND product_id = %s AND is_confirmed = 0", $_SESSION['user_id'], $row['product_id']);
                        $stmt = $dbh->query($update_order_to_confirm);
                        $update_amount_in_products = sprintf("UPDATE products SET amount= amount-%s  WHERE id = %s", $row['order_amount'], $row['product_id']);
                        $stmt = $dbh->query($update_amount_in_products);
                    }
                    header("location: history.php");
                }
            }

        }
    } else {


        $total_cost = 0;
        $select_query = sprintf("SELECT orders.amount, orders.product_id, products.name, products.description, products.price, products.image FROM orders, products WHERE orders.product_id = products.id AND orders.is_confirmed = 0 AND orders.user_id = %s", $_SESSION['user_id']);
        if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
            foreach ($dbh->query($select_query) as $row) {
                echo "Product name: " . $row['name'];
                echo "<br />";
                $encoded_image = base64_encode($row['image']);
                echo "<img src='data:image/jpeg;base64,{$encoded_image}'>";
                $item_id = $row['product_id'];
                $form = <<<EOT
<form action='cart.php' method=GET>
<input type="hidden" name="product_id"  value="$item_id"/>
<input type='submit' name='remove_from_cart' value='Remove' />
</form>
EOT;
                echo $form;
                echo "Item Description: " . $row['description'];
                echo "<br />";
                echo "Price: " . $row['price'];
                echo "<br />";
                echo "Quantity: " . $row['amount'];
                echo "<br />";
                echo "Total price: " . ($row['amount'] * $row['price']);
                echo "<br />";
                echo "<br />";
                echo "<br />";
                $total_cost += $row['amount'] * $row['price'];


            }
            echo "<br />";
            echo "Total cost of all items in the cart is: " . $total_cost;


        } else {
            echo "You have no Items in the cart.";
        }
        echo "<br />";
        echo "<a href='index.php'>Add Items</a>";
        echo "<br />";
        echo "<br />";
        echo "<br />";
        $form = <<<EOT
<form action='cart.php' method=GET>
<input type='submit' name='checkout' value='Checkout' />
</form>
EOT;
        echo $form;
    }
}

