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
  </head>
  <body class="mode2">
	
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
                  <form id="login-form" action="login.php" method="post" role="form" style="display: block;">
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
      </div>
    </div>
  </body>
</html>
