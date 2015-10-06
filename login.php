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
require('config.php');
session_start();
if(isset($_COOKIE['email'])){
$_SESSION['email'] = $_COOKIE['email'];
}
if(isset($_COOKIE['user_id'])){
$_SESSION['user_id'] = $_COOKIE['user_id'];
}

if (!isset($_SESSION['email'])) {
    if (isset($_POST{'submit'})) {
        if (!array_key_exists('email', $_SESSION)) {
            $email = $_POST{'email'};
            $password = $_POST{'password'};
            $check_query = sprintf("SELECT * FROM users WHERE email = \"%s\" AND password = \"%s\";", $email, $password);
            if ($prepare = $dbh->query($check_query) and $prepare->fetchColumn() > 0) {
                $_SESSION['email'] = $email;

                foreach ($dbh->query($check_query) as $row) {
                    $_SESSION['user_id'] = $row['id'];
                }
				
				if(isset($_POST{'remember'}) and $_POST{'remember'}==1){
					setcookie('email',$email,time()+3600);
					setcookie('user_id',$row['id'],time()+3600);
				}
				
						echo <<<EOT
	<div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div>
                  <a href="#" class="active">success</a>
                </div>
              </div>
              <hr />
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
					
					<font size="5" color="green">You are now logged in</font>
                    <script>setTimeout("location.href = 'index.php';",2000);</script>
					
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
EOT;
				
            } else {
										echo <<<EOT
	<div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div>
                  <a href="#" class="active">Error</a>
                </div>
              </div>
              <hr />
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
					
					<font size="5" color="green">Wrong email or password</font>
                    <script>setTimeout("location.href = 'LoginRegister.php';",2000);</script>
					
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
EOT;
            }

        } else {
													echo <<<EOT
	<div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div>
                  <a href="#" class="active">Error</a>
                </div>
              </div>
              <hr />
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
					
					<font size="5" color="green">Already logged in !</font>
                    <script>setTimeout("location.href = 'index.php';",2000);</script>
					
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
EOT;
        }
    }else{
		header("location: index.php");
	}
} else {
    header("location: index.php");
}

