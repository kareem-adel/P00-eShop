<html>
  <head>
    <title>Your virtual shop</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootsnipp.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/LoginRegister.js"></script>
    <link rel="stylesheet" href="css/LoginRegister.css" />
	<link rel="stylesheet" href="css/main.css" />
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
				window.location.assign("LoginRegister.php?state=register");
			});
			return false;
		} else if (lname == null || lname == '') {
			swal({
				title : "Please insert your Last name !",
				text : "Your Last name is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php?state=register");
			});
			return false;
		} else if (Remail == null || Remail == '') {
			swal({
				title : "Please insert your Email !",
				text : "Your Email is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php?state=register");
			});
			return false;
		} else if (Rpassword == null || Rpassword == '') {
			swal({
				title : "Please insert your password !",
				text : "Your password is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php?state=register");
			});
			return false;
		} else if (confirm_password == null || confirm_password == '') {
			swal({
				title : "Please insert your confirmation password !",
				text : "Your confirmation password is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php?state=register");
			});
			return false;
		} else if (address == null || address == '') {
			swal({
				title : "Please insert your address !",
				text : "Your address is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php?state=register");
			});
			return false;
		} else if (phone == null || phone == '') {
			swal({
				title : "Please insert your phone !",
				text : "Your phone is empty !",
				confirmButtonText : "OK",
				closeOnConfirm : false
			}, function () {
				window.location.assign("LoginRegister.php?state=register");
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
  </head>
  <body>
	
	<div id="logo"><a href="index.php"><h1><div><img src="images/eshop-logo.png" width="100" height="100" > Your virtual shop </img></div></h1></a></div>
	
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-6">
                  <a href="#" class="active" id="login-form-link">Login</a>
                </div>
                <div class="col-xs-6">
                  <a href="#" id="register-form-link">Register</a>
                </div>
              </div>
              <hr />
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <form id="login-form" action="login.php" method="post" role="form" style="display: block;" onsubmit="return validateLogin()">
                    <div class="form-group">
                      <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email"
                      value="" />
                    </div>
                    <div class="form-group">
                      <input type="text" name="password" id="Lpassword" tabindex="2" class="form-control"
                      placeholder="Password" />
                    </div>
                    <div class="form-group text-center">
                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember" /> 
                    <label for="remember">Remember Me</label></div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <input type="submit" name="submit" id="login-submit" tabindex="4"
                          class="form-control btn btn-login" value="Log In" />
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
      </div>
    </div>
	<?php
	
		if(isset($_GET{'state'})){
			$tmp =  $_GET{'state'};	
			if($tmp == 'register'){
				echo <<<EOT
		<script>$(function() {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$('#register-form-link').addClass('active');
	});</script>
	
EOT;

		}else if($tmp == 'login'){
			echo <<<EOT
		<script>$(function() {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$('#login-form-link').addClass('active');
	}
EOT;
			}
		}
	 ?>
  </body>
</html>
