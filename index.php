<html>
  <head>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootsnipp.min.css" />
    <link rel="stylesheet" href="css/main.css" />
	<script type="text/javascript" src="js/LoginRegister.js"></script>
    <link rel="stylesheet" href="css/LoginRegister.css" />
	
	<script type="text/javascript">
	
function validate(){
var pass2=document.getElementById("confirm-password").value;
var pass1=document.getElementById("Rpassword").value;
if(pass1!=pass2)
	{
	window.alert("Passwords do not match !");
	return false;
	}
else
	{
	return true;
	}
}
</script>
	
    <title>Your virtual shop</title>
	
	
  </head>
  <body class="mode1">
  <div style="float: none; height: 250;"><div id="logo" style="float: left;"><a href="index.php"><h1><div><img src="images/eshop-logo.png" width="100" height="100" > Your virtual shop </img></div></h1></a></div>
  </body>
</html>

<?php
session_start();
require("config.php");
if (!array_key_exists('email', $_SESSION)) {
    echo <<<EOT
	<div id="ILoginRegister" style="float: right;">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-6">
                  <a href="#" class="active" id="login-form-link">Login</a>
                </div>
                <div class="col-xs-6">
                  <a href="#" id="register-form-link" class="">Register</a>
                </div>
              </div>
              <hr>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <form id="login-form" action="login.php" method="post" role="form" style="display: block;">
                    <div class="form-group">
                      <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="email" value="">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group text-center">
                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember"> 
                    <label for="remember">Remember Me</label></div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <input type="submit" name="submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                        </div>
                      </div>
                    </div>
                  </form>
                  <form id="register-form" action="register.php" method="post" role="form" onsubmit="return validate()"
                  style="display: none;">
                    <div class="form-group">
                      <input type="text" name="fname" id="fname" tabindex="1" class="form-control" placeholder="First name"
                      value="" />
                    </div>
					<div class="form-group">
                      <input type="text" name="lname" id="lname" tabindex="2" class="form-control" placeholder="Last name"
                      value="" />
                    </div>
                    <div class="form-group">
                      <input type="email" name="email" id="email" tabindex="3" class="form-control" placeholder="Email Address"
                      value="" />
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" id="Rpassword" tabindex="4" class="form-control"
                      placeholder="Password" />
                    </div>
                    <div class="form-group">
                      <input type="password" name="confirm-password" id="confirm-password" tabindex="5" class="form-control"
                      placeholder="Confirm Password" />
                    </div>
					<div class="form-group">
                      <input type="text" name="address" id="address" tabindex="6" class="form-control" placeholder="Address"
                      value="" />
                    </div>
					<div class="form-group">
                      <input type="text" name="phone" id="phone" tabindex="7" class="form-control" placeholder="Phone number"
                      value="" />
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <input type="submit" name="submit" id="register-submit" tabindex="8"
                          class="form-control btn btn-register" value="Register Now" />
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </div>
EOT;
} else {
	$UserEmail = $_SESSION['email'];
    echo "
	<div style=\"float: right;\">
	<form action='logout.php' method=POST>
	<input type=\"submit\" name=\"Logout\" value=\"Log out\" class=\"btn btn-default\">
	<br/>
	</form>
	</div>
	<div style=\"float: right;\">
	<font color=\"green\" size=\"5\" style=\"margin-right: 20px;font-weight: bold;\">Welcome </font>
	<font color=\"black\" size=\"5\" style=\"margin-right: 20px;font-weight: bold;\">{$UserEmail}</font>
	</div>
	";
    
}
echo "</div>";
$select_query = sprintf("SELECT * FROM products;");
if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
    foreach ($dbh->query($select_query) as $row) {

        $item_name = $row['name'];
        $item_id = $row['id'];
		$item_price = $row['price'];
		$item_description = $row['description'];
		
        if (array_key_exists('email', $_SESSION)) {
            $LoginOrProceed = 'add_to_cart.php';
        } else {
            $LoginOrProceed = 'LoginRegister.php';
        }  
$form = <<<EOT
<form action='{$LoginOrProceed}' method=POST>
<div id="mItem">
      <div class="product-image-wrapper">
        <div class="single-products">
          <div class="productinfo text-center">
            <img src="images/home/product1.jpg" alt="" width="400" height="200" />
            <h2>{$item_price}</h2>
            <p>{$item_name}</p>
            <a href="#" class="btn btn-default add-to-cart">Add to cart</a>
          </div>
          <div class="product-overlay">
            <div class="overlay-content">
              <h2>{$item_price}</h2>
              <p>{$item_description}</p>
			  <input type="hidden" name="product_id"  value="{$item_id}"/>
              <input type='submit' name='add_to_cart' value='add to cart' class="btn btn-default add-to-cart"></a>
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
    echo 'No Items to show';
}

// id =  '<?php echo htmlspecialchars($item_id); ?>

