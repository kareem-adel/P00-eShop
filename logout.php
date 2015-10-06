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
	
    <title>Your virtual shop</title>
	
	
  </head>
  <body>
  <div style="float: none; height: 250;"><div id="logo" style="float: left;"><a href="index.php"><h1><div><img src="images/eshop-logo.png" width="100" height="100" > Your virtual shop </img></div></h1></a></div></div>
  </body>
</html>

<?php
session_unset();
session_destroy();
$_SESSION = array();
setcookie('email','',time()-1);
setcookie('user_id','',time()-1);
setcookie('user_image','',time()-1);
setcookie('user_fname','',time()-1);

								echo <<<EOT
	<div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div>
                  <a href="#" class="active">Success</a>
                </div>
              </div>
              <hr />
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
					
					<font size="5" color="green">You have logged out successfully. Redirecting to home page.</font>
                    <script>setTimeout("location.href = 'index.php';",2000);</script>
					
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
EOT;
?>