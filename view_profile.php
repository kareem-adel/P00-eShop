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
	
    <title>Your virtual shop</title>
	
		
  </head>
  <body>
  <div style="float: none; height: 250;"><div id="logo" style="float: left;"><a href="index.php"><h1><div><img src="images/eshop-logo.png" width="100" height="100" > Your virtual shop </img></div></h1></a></div>
  </body>
</html>

<?php
require('config.php');
if (isset($_COOKIE['email'])) {
    $_SESSION['email'] = $_COOKIE['email'];
}
if (isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
}
if (isset($_COOKIE['user_fname'])) {
    $_SESSION['user_fname'] = $_COOKIE['user_fname'];
}


if (!isset($_SESSION['email'])) {
    echo "<script>window.location.assign(\"LoginRegister.php\");</script>";
} else {
    $select_query = sprintf("SELECT * FROM users WHERE  email = '%s'", $_SESSION['email']);
    if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
        foreach ($dbh->query($select_query) as $row) {
            $fname = $row['firstname'];
            $lname = $row['lastname'];
            $email = $row['email'];
            $password = $row['password'];
            $address = $row['address'];
            $phone = $row['phone'];
            $image = $row['image'];


        }

    }
    $final_image_small="<img width=\"30px\" height=\"30px\" src=\"images/avatar.png\"/>";
	$final_image_big="<img width=\"100px\" height=\"100px\" src=\"images/avatar.png\"/>";
    if ($image <> null) {
        $encoded_image = base64_encode($image);
        $final_image_small="<img width=\"30px\" height=\"30px\" src='data:image/jpeg;base64,{$encoded_image}'>";
		$final_image_big="<img width=\"100px\" height=\"100px\" src='data:image/jpeg;base64,{$encoded_image}'/>";
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
	<font color=\"black\" size=\"5\" style=\"margin-right: 20px;font-weight: bold;\">{$fname}</font>
	</div>
	
	<div style=\"float: right;margin-right:10px\">
	$final_image_small
	</div>
	
	</div>";
	
	echo <<<EOT
		
    <div class="container">
      <div class="row">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div>
                  <a href="#" class="active">User Profile</a>
                </div>
              </div>
              <hr>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
					<div style="margin-right: auto;margin-left: auto;margin-bottom: 10px;width: 100px">
					  <div id="mProfileImage" style="margin-right: auto;margin-left: auto;">$final_image_big</div>
					</div>
					<br>
                    <div style="margin-right: auto;margin-left: auto;margin-bottom: 10px;width: 350px">
                      <font size="5" color="green">First Name : \t</font><font name="fname" id="fname" size="5" color="black">$fname</font>
                    </div>
					<br>
					<div style="margin-right: auto;margin-left: auto;margin-bottom: 10px;width: 350px">
                      <font size="5" color="green">Last name : \t</font><font name="lname" id="lname" size="5" color="black">$lname</font>
                    </div>
					<br>
                    <div style="margin-right: auto;margin-left: auto;margin-bottom: 10px;width: 350px">
                      <font size="5" color="green">Email : \t</font><font name="email" id="email" size="5" color="black">$email</font>
                    </div>
					<br>
					<div style="margin-right: auto;margin-left: auto;margin-bottom: 10px;width: 350px">
                      <font size="5" color="green">Address : \t</font><font name="address" id="address" size="5" color="black">Address : $address</font>
                    </div>
					<br>
					<div style="margin-right: auto;margin-left: auto;margin-bottom: 10px;width: 350px">
                      <font size="5" color="green">Phone : \t</font><font name="phone" id="phone" size="5" color="black">Phone : $phone</font>
                    </div>
                </div>
              </div>
          </div>
		  </div>
    </div>
	</div>
EOT;
}
