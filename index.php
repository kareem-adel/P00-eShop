<?php
session_start();
?>
<html>
  <head>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootsnipp.min.css" />
    <link rel="stylesheet" href="css/main.css" />
	<script type="text/javascript" src="js/LoginRegister.js"></script>
    <link rel="stylesheet" href="css/LoginRegister.css" />
<script src="js/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/sweetalert.css">

	<script type="text/javascript">

	function validateReg() {
		var pass2 = document.getElementById("confirm-password").value;
		var pass1 = document.getElementById("Rpassword").value;
		if (pass1 != pass2) {
			swal({
				title : "Retype your password",
				text : "Passwords do not match !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php?state=register");
			});
			return false;
		}

		var fname = document.getElementById("fname").value;
		var lname = document.getElementById("lname").value;
		var Remail = document.getElementById("Remail").value;
		var Rpassword = document.getElementById("Rpassword").value;
		var confirm_password = document.getElementById("confirm-password").value;
		var address = document.getElementById("address").value;
		var phone = document.getElementById("phone").value;
		if (fname == null || fname == '') {
			swal({
				title : "Please insert your First name !",
				text : "Your First name is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php");
			});
			return false;
		} else if (lname == null || lname == '') {
			swal({
				title : "Please insert your Last name !",
				text : "Your Last name is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php");
			});
			return false;
		} else if (Remail == null || Remail == '') {
			swal({
				title : "Please insert your Email !",
				text : "Your Email is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php");
			});
			return false;
		} else if (Rpassword == null || Rpassword == '') {
			swal({
				title : "Please insert your password !",
				text : "Your password is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php");
			});
			return false;
		} else if (confirm_password == null || confirm_password == '') {
			swal({
				title : "Please insert your confirmation password !",
				text : "Your confirmation password is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php");
			});
			return false;
		} else if (address == null || address == '') {
			swal({
				title : "Please insert your address !",
				text : "Your address is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php");
			});
			return false;
		} else if (phone == null || phone == '') {
			swal({
				title : "Please insert your phone !",
				text : "Your phone is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php");
			});
			return false;
		} 
		
		return true;
	}

	function validateLogin() {
		var Lemail = document.getElementById("Lemail").value;
		var Lpassword = document.getElementById("Lpassword").value;
		if (Lemail == null || Lemail == '') {
			swal({
				title : "Please insert your email !",
				text : "Your email is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php");
			});
			return false;
		} else if (Lpassword == null || Lpassword == '') {
			swal({
				title : "Please insert your password !",
				text : "Your password is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php");
			});
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
require("config.php");

if(isset($_COOKIE['email'])){
$_SESSION['email'] = $_COOKIE['email'];
}
if(isset($_COOKIE['user_id'])){
$_SESSION['user_id'] = $_COOKIE['user_id'];
}
if(isset($_COOKIE['user_fname'])){
$_SESSION['user_fname'] = $_COOKIE['user_fname'];
}

if (!isset($_SESSION['email'])) {
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
                  <form id="login-form" action="login.php" method="post" role="form" style="display: block;" onsubmit="return validateLogin()">
                    <div class="form-group">
                      <input type="email" name="email" id="Lemail" tabindex="1" class="form-control" placeholder="email" value="">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" id="Lpassword" tabindex="2" class="form-control" placeholder="Password">
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
                  <form id="register-form" action="register.php" method="post" role="form" onsubmit="return validateReg()"
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
                      <input type="email" name="email" id="Remail" tabindex="3" class="form-control" placeholder="Email Address"
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
  $Userfname = $_SESSION['user_fname'];
  
  $final_image="<img width=\"30\" height=\"30\" src=\"images/avatar.png\"/>";
  $select_query = sprintf("SELECT * FROM users WHERE email = \"%s\" and image is not null;", $UserEmail);
  if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
    foreach ($dbh->query($select_query) as $row) {
        $encoded_image = base64_encode($row['image']);
        $final_image="<img width=\"30\" height=\"30\" src='data:image/jpeg;base64,{$encoded_image}'>";
    }

}
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
	<input type=\"submit\" name=\"edit_profile\" value=\"Edit Profile\" class=\"btn btn-default\">
	</form>
	</div>
	<div style=\"float: right;\">
	<form action='view_profile.php' method=POST>
	<input type=\"submit\" name=\"view_profile\" value=\"Account\" class=\"btn btn-default\">
	</form>
	</div>
	<div style=\"float: right;\">
	<font color=\"green\" size=\"5\" style=\"margin-right: 20px;font-weight: bold;\">Welcome </font>
	<font color=\"black\" size=\"5\" style=\"margin-right: 20px;font-weight: bold;\">{$Userfname}</font>
	</div>
	
	<div style=\"float: right;margin-right:10px\">
	$final_image
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
		$item_amount = $row['amount'];
		$encoded_image = base64_encode($row['image']);

		$available1="";
		$available2="type='submit'";
		$SoldOut="";
		if($item_amount <= 0){
			$available1="style=\"background-color:grey;\"";
			$available2="";
			$SoldOut="<h1>Sold out</h1>";
		}
echo <<<EOT
<form action='add_to_cart.php' method=GET>
	<div id="mItem" class="panel" $available1>
      <div class="product-image-wrapper" >
        <div class="single-products">
          <div class="productinfo text-center" style="margin-right: 10;margin-left: 10;margin-top: 10;">
            <img src="data:image;base64, {$encoded_image}" alt="" width="400" height="400" />
			$SoldOut
            <h2>{$item_price}</h2>
            <p>{$item_name}</p>
            <a href="#" class="btn btn-default add-to-cart">Add to cart</a>
          </div>
          <div class="product-overlay" $available1>
            <div class="overlay-content">
			  $SoldOut
              <h2>{$item_price}</h2>
              <p>{$item_description}</p>
			  <input type="hidden" name="product_id"  value="{$item_id}"/>
              <input $available2 name='add_to_cart' value='add to cart' class="btn btn-default add-to-cart""></a>
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
EOT;
    }

} else {
    echo '<h1 align="center"><font color="red">No Items to show</font></h1>';
}

// id =  '<?php echo htmlspecialchars($item_id); ?>

