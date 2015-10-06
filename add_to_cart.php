<html>
  <head>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootsnipp.min.css" />
    <link rel="stylesheet" href="css/main.css" />
<script src="js/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/sweetalert.css">

    <title>Your virtual shop</title>
	
	
  </head>
  <body>
  <div style="float: none; height: 150;"><div id="logo" style="float: left;"><a href="index.php"><h1><div><img src="images/eshop-logo.png" width="100" height="100" > Your virtual shop </img></div></h1></a></div></div>
  </body>
</html>

<?php
require('config.php');
session_start();
if(isset($_COOKIE['email'])){
$_SESSION['email'] = $_COOKIE['email'];
}
if(isset($_COOKIE['user_id'])){
$_SESSION['user_id'] = $_COOKIE['user_id'];
}

if (!isset($_SESSION['email'])) {
    header("location: LoginRegister.php");
} else {
    if (isset($_GET{'submit'})) {
        $data = array('amount' => $_GET{'quantity'},
            'user_id' => $_SESSION['user_id'],
            'product_id' => $_GET{'product_id'},
            'is_confirmed' => 0);

        $select_if_exists_before = sprintf("SELECT * FROM orders WHERE user_id = %s AND product_id = %s AND is_confirmed = 0;", $_SESSION['user_id'], $_GET['product_id']);
        if ($prepare = $dbh->query($select_if_exists_before) and $prepare->fetchColumn() > 0) {
            $update_order = sprintf("UPDATE orders SET amount=amount+%s WHERE user_id = %s AND product_id = %s AND is_confirmed = 0", $_GET{'quantity'}, $_SESSION['user_id'], $_GET{'product_id'});
            $stmt = $dbh->query($update_order);
            //$stmt->execute(array(':quantity'=> $_GET{'quantity'},':u_id' => $_SESSION['user_id'], ':p_id' => $_GET{'product_id'}));

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
		echo "<script>swal({   title: \"Added to cart !\",   text: \"Added to cart successfully!\",   confirmButtonText: \"OK\",   closeOnConfirm: false }, function(){  window.location.assign(\"index.php\"); });</script>";
		

    } elseif (isset($_GET{'add_to_cart'})) {
        $select_query = sprintf("SELECT * FROM products WHERE id = %s", $_GET{'product_id'});
        if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
            foreach ($dbh->query($select_query) as $row) {
				$item_name = $row['name'];
				$item_id = $row['id'];
				$item_price = $row['price'];
				$item_description = $row['description'];
				$item_amount = $row['amount'];
				$encoded_image = base64_encode($row['image']);
		
                $form = <<<EOT
<form action='add_to_cart.php' method=GET>
	<div id="mItem" class="panel panel-login">
      <div class="product-image-wrapper">
        <div class="single-products">
          <div class="productinfo text-center" style="margin-right: 10;margin-left: 10;margin-top: 10;">
            <img src="data:image;base64, {$encoded_image}" alt="" width="400" height="200" />
            <h2>{$item_price}</h2>
            <p>{$item_name}</p>
            <a href="#" class="btn btn-default add-to-cart">Add</a>
          </div>
          <div class="product-overlay">
            <div class="overlay-content">
              <h2>{$item_price}</h2>
              <p>{$item_description}</p>
			  <input type="hidden" name="product_id"  value="{$item_id}"/>
			  <div style="margin-top: 10;margin-bottom: 10;"><font color="green" size="5">Quantity: <input name='quantity' type='number' min='1' value='1'/><br /></div>
			  <input type='submit' value='Add' name='submit' class="btn btn-default add-to-cart"/>
            </div>
          </div>
        </div>
      </div>
    </div>
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