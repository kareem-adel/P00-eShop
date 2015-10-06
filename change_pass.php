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
  <div style="float: none; height: 250;"><div id="logo" style="float: left;"><a href="index.php"><h1><div><img src="images/eshop-logo.png" width="100" height="100" > Your virtual shop </img></div></h1></a></div>
  </body>
</html>

<?php
if(isset($_COOKIE['email'])){
$_SESSION['email'] = $_COOKIE['email'];
}
if(isset($_COOKIE['user_id'])){
$_SESSION['user_id'] = $_COOKIE['user_id'];
}
if(isset($_COOKIE['user_fname'])){
$_SESSION['user_fname'] = $_COOKIE['user_fname'];
}


require("config.php");

if (!isset($_SESSION['email'])) {
	echo "<script>window.location.assign(\"LoginRegister.php\");</script>";
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
    if (isset($_POST{'submit'})) {
            $select_query = sprintf("SELECT count(*) FROM users WHERE email = '%s'AND password = '%s'", $_SESSION['email'], $_POST['old_password']);
            $result = $dbh->prepare($select_query);
            $result->execute();
            $number_of_records = $result->fetchColumn();
            if ($number_of_records > 0) {
                if ($_POST['new_password'] == null) {
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
					
					<font size="5" color="Red">Please enter the new password.</font>
                    <script>setTimeout("location.href = 'edit_profile.php';",2000);</script>
					
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
EOT;
                }else{
                    $update_order = sprintf("UPDATE users SET password='%s' WHERE email = '%s'", $_POST['new_password'], $_SESSION['email']);
                    $stmt = $dbh->query($update_order);
					
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
					
					<font size="5" color="green">Password changed successfully</font>
                    <script>setTimeout("location.href = 'edit_profile.php';",2000);</script>
					
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
					
					<font size="5" color="Red">The old password is not correct.</font>
                    <script>setTimeout("location.href = 'edit_profile.php';",2000);</script>
					
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
		echo "<script>window.location.assign(\"edit_profile.php\");</script>";
		}
}
