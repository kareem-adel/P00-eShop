<?php
session_start();
require("config.php");
if (!array_key_exists('email', $_SESSION)) {
    echo "<a href='login.php'>Login</a><br />";
    echo "<a href='register.php'>Register</a><br />";
} else {
    echo "<a href='logout.php'>logout</a><br />";
    echo $_SESSION['email'];
}

$select_query = sprintf("SELECT * FROM products;");
if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
    foreach ($dbh->query($select_query) as $row) {

        echo $row['name'];
        $item_id = $row['id'];
        echo '<br />';
        echo $item_id;
        echo '<br />';
        if (array_key_exists('email', $_SESSION)) {
            $form = <<<EOT
<form action='add_to_cart.php' method=POST>
<input type="hidden" name="product_id"  value="$item_id"/>
<input type='submit' name='add_to_cart' value='add to cart' />
</form>
EOT;
        } else {
            $form = <<<EOT
<form action='login.php' method=POST>
<input type="hidden" name="product_id"  value="$item_id"/>
<input type='submit' name='add_to_cart' value='add to cart' />
</form>
EOT;
        }

        echo $form;
    }

} else {
    echo 'No Items to show';
}

// id =  '<?php echo htmlspecialchars($item_id); ?>


