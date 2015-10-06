<html>
  <head>
    <title>Shopping Cart</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootsnipp.min.css" />
    <link rel="stylesheet" type="text/css" href="css/custom.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/customjs.js"></script>
    <script type="text/javascript" src="js/LoginRegister.js"></script>
    <link rel="stylesheet" href="css/LoginRegister.css" />
	<script src="js/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
  </head>
  <body>
    <div style="float: none; height: 250;">
      <div id="logo" style="float: left;">
        <a href="index.php">
          <div>
            <h1>
            <img src="images/eshop-logo.png" width="100" height="100" /> Your virtual shop</h1>
          </div>
        </a>
      </div><?php 
      session_start();
	if(isset($_COOKIE['email'])){
$_SESSION['email'] = $_COOKIE['email'];
}
if(isset($_COOKIE['user_id'])){
$_SESSION['user_id'] = $_COOKIE['user_id'];
}
if(isset($_COOKIE['user_image'])){
$_SESSION['user_image'] = $_COOKIE['user_image'];
}
if(isset($_COOKIE['user_fname'])){
$_SESSION['user_fname'] = $_COOKIE['user_fname'];
}

      require("config.php");
      if (!isset($_SESSION['email'])) {
          header("location: LoginRegister.php");
      } else {
              $UserEmail = $_SESSION['email'];
          echo "
              <div style=\"float: right;\">
	<form action='logout.php' method=POST>
	<input type=\"submit\" name=\"Logout\" value=\"Log out\" class=\"btn btn-default\">
	</form>
	</div>
	<div style=\"float: right;\">
	<form action='cart.php' method=POST>
	<input type=\"submit\" name=\"cart\" value=\"Cart\" class=\"btn btn-default\">
	</form>
	</div>
	<div style=\"float: right;\">
	<form action='history.php' method=POST>
	<input type=\"submit\" name=\"history\" value=\"History\" class=\"btn btn-default\">
	</form>
	</div>
	<div style=\"float: right;\">
	<form action='edit_profile.php' method=POST>
	<input type=\"submit\" name=\"edit_profile\" value=\"Profile\" class=\"btn btn-default\">
	</form>
	</div>
              <div style=\"float: right;\">
              <font color=\"green\" size=\"5\" style=\"margin-right: 20px;font-weight: bold;\">Welcome </font>
              <font color=\"black\" size=\"5\" style=\"margin-right: 20px;font-weight: bold;\">{$UserEmail}</font>
              </div>
              ";
          
      }
      echo "</div>";
              ?>
      <div style="margin-top: 50px;">
        <div class="container text-center">
          <div class="text-left">
            <ul>
              <li class="row list-inline columnCaptions">
              <span>QTY</span> 
              <span>ITEM</span> 
              <span>Price</span></li>
			  <?php
              require('config.php');


              if (!array_key_exists('email', $_SESSION)) {
                  header("location: LoginRegister.php");
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
                                  $message = $message . 'The item ' . $row['name'] . " has only " . $row['product_amount'] . " pieces left " . " but you ordered " . $row['order_amount'] . ", please edit your cart.";
                              }


                          }
                          if ($flag == 1) {
                              //echo $message . "<br />" . "Please click <a href='cart.php'>here<a/> to edit your cart";
							  echo "<script>swal({   title: \"Over the stock !\",   text: \"$message\",   confirmButtonText: \"OK\",   closeOnConfirm: false }, function(){  window.location.assign(\"cart.php\"); });</script>";
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
                                              $encoded_image = base64_encode($row['image']);
                                              $total_cost += $row['amount'] * $row['price'];
                                              $cost_with_quantity = $row['amount'] * $row['price'];
              echo <<<EOT
                                                      <li class="row">
                                                              
                                                              <span class="quantity">{$row['amount']}</span>
                                                              <span class="itemName">{$row['name']} ( {$row['description']} )</span>
                                                              <form action='cart.php' method=GET>
                                                              <input type="hidden" name="product_id"  value="{$row['product_id']}"/>
                                                              <span class="popbtn"><input type='submit' name='remove_from_cart' class="btn btn-default" style="margin-top: -15px" value="Remove"></input></span>
                                                              <span class="price">$ {$cost_with_quantity}</span>
                                                              </form>
                                                              
                                                      </li>
EOT;
                          }

                      } else {
                          echo "<h1 align=\"center\"><font color=\"green\">You have no Items in the cart.</font><h1>";
                      }
                      echo "<br />";
                      echo "<div style=\"width: 100;margin-left: auto;margin-right: auto;\"><a href='index.php' class=\"btn btn-default\">Add Items</a></div>";
                      echo "<br />";
                      echo "<br />";
                      echo "<br />";
                      
                      $select_query = sprintf("SELECT count(*) FROM orders WHERE user_id = %s AND is_confirmed=0", $_SESSION['user_id']);
                      $result = $dbh->prepare($select_query);
                      $result->execute();
                      $number_of_records1 = $result->fetchColumn();
                      if($number_of_records1 > 0){
                        $form = <<<EOT
                                                      <li class="row totals">
                                                              <span class="itemName">Total:</span>
                                                              <span class="price">$ {$total_cost}</span>
                                                              <form action='cart.php' method=GET>
                                                              <span class="order"> <input type='submit' name='checkout' class="btn btn-default" value="Checkout"></input></span>
                                                              </form>
                                                      </li>
EOT;
                      }else{
                        $form = <<<EOT
                                                      <li class="row totals">
                                                              <span class="itemName">Total:</span>
                                                              <span class="price">$ {$total_cost}</span>
                                                              <form action='cart.php' method=GET>
                                                              <span class="order"> <input type='submit' name='checkout' class="btn btn-default" value="Checkout" disabled="disabled"></input></span>
                                                              </form>
                                                      </li>
EOT;
                      }

                      echo $form;

                  }
              }

              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
