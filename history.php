<html>
  <head>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootsnipp.min.css" />
    <link rel="stylesheet" href="css/main.css" />

	<script type="text/javascript">
	
function validate() {
	var pass2 = document.getElementById("confirm-password").value;
	var pass1 = document.getElementById("Rpassword").value;
	if (pass1 != pass2) {
		window.alert("Passwords do not match !");
		return false;
	} else {
		return true;
	}
}
	</script>
	
    <title>Your virtual shop</title>
	
	
  </head>
  <body>
  <div style="float: none; height: 250;"><div id="logo" style="float: left;"><a href="index.php"><h1><div><img src="images/eshop-logo.png" width="100" height="100" > Your virtual shop </img></div></h1></a></div>
  </body>
</html>
<?php
require('config.php');
session_start();


if (!array_key_exists('email', $_SESSION)) {
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
	
	echo "</div>";
    
	$select_query = sprintf("SELECT orders.amount, orders.product_id, products.name, products.description, products.price, products.image FROM orders, products WHERE orders.product_id = products.id AND orders.is_confirmed = 1 AND orders.user_id = %s", $_SESSION['user_id']);
    if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
        foreach ($dbh->query($select_query) as $row) {
			$item_name = $row['name'];
			$item_price = $row['price'];
			$item_description = $row['description'];
			$item_amount = $row['amount'];
			$encoded_image = base64_encode($row['image']);
			$total_price = $row['amount']*$row['price'];
			
			echo <<<EOT
	<div id="mItem" class="panel">
      <div class="product-image-wrapper">
        <div class="single-products">
          <div class="productinfo text-center" style="margin-right: 10;margin-left: 10;margin-top: 10;">
            <img src="data:image;base64, {$encoded_image}" alt="" width="400" height="200" />
            <h2>{$item_price}</h2>
            <p>{$item_name}</p>
            <p>Quantity: {$item_amount}</p>
			<p>Total price: {$total_price}</p>
          </div>
          <div class="product-overlay">
            <div class="overlay-content">
              <h2>{$item_price}</h2>
              <p>{$item_description}</p>
			  <p>Quantity: {$item_amount}</p>
			  <p>Total price: {$total_price}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
EOT;
        }
    } else {
		echo "<h1 align=\"center\"><font color=\"green\">You have Purchased no items.</font><h1>";
    }

}

