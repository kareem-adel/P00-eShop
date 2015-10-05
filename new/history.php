<?php
require('config.php');
session_start();


if (!array_key_exists('email', $_SESSION)) {
    header("location: login.php");
} else {

    $select_query = sprintf("SELECT orders.amount, orders.product_id, products.name, products.description, products.price, products.image FROM orders, products WHERE orders.product_id = products.id AND orders.is_confirmed = 1 AND orders.user_id = %s", $_SESSION['user_id']);
    if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
        foreach ($dbh->query($select_query) as $row) {
            echo "Product name: " . $row['name'];
            echo "<br />";
            $encoded_image = base64_encode($row['image']);
            echo "<img src='data:image/jpeg;base64,{$encoded_image}'>";
            echo $form;
            echo "Item Description: " . $row['description'];
            echo "<br />";
            echo "Price: " . $row['price'];
            echo "<br />";
            echo "Quantity: " . $row['amount'];
            echo "<br />";
            echo "<br />";
            echo "<br />";
        }
    } else {
        echo "You have Purchased no items.";
    }

}

