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
	
	
	<script>
  function handleFileSelect(evt) {
    var files = evt.target.files;

    for (var i = 0, f; f = files[i]; i++) {

	if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();
      reader.onload = (function(theFile) {
        return function(e) {
          document.getElementById('mProfileImage').innerHTML = ['<img width="100" height="100" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
		  document.getElementById('mProfileImage1').innerHTML = ['<img width="100" height="100" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
        };
      })(f);
	  
      reader.readAsDataURL(f);
    }
  }

  function validate() {
	var pass2 = document.getElementById("confirm-password").value;
	var pass1 = document.getElementById("new_password").value;
	if (pass1 != pass2) {
		swal({   title: "Passwords do not match !",   text: "Passwords do not match, please reenter your password.",   confirmButtonText: "OK",   closeOnConfirm: false });
		return false;
	} else {
		return true;
	}
}
  
</script>
	
  </head>
  <body>
  <div style="float: none; height: 250;"><div id="logo" style="float: left;"><a href="index.php"><h1><div><img src="images/eshop-logo.png" width="100" height="100" > Your virtual shop </img></div></h1></a></div>
  </body>
</html>

<?php
require('config.php');
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
	echo "</div>";
	
    if (isset($_GET{'remove_image'})) {
        $update_order = sprintf("UPDATE users SET image=null WHERE id = %s ", $_SESSION['user_id']);
        $stmt = $dbh->query($update_order);
        header("location: edit_profile.php");
    } elseif (isset($_POST{'submit'})) {
        $tmpName = $_FILES['image']['tmp_name'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        if ($email == null || $address == null) {
			echo "<script>swal({   title: \"Empty email or Address !\",   text: \"Empty email or Address !\",   confirmButtonText: \"OK\",   closeOnConfirm: false }, function(){  window.location.assign(\"edit_profile.php\"); });</script>";
        } else {
            $select_query = sprintf("SELECT count(*) FROM users WHERE email = '%s'", $email);
            $result = $dbh->prepare($select_query);
            $result->execute();
            $number_of_records1 = $result->fetchColumn();

            $select_query = sprintf("SELECT count(*) FROM users WHERE email = '%s' AND id = %s", $email, $_SESSION['user_id']);
            $result = $dbh->prepare($select_query);
            $result->execute();
            $number_of_records2 = $result->fetchColumn();
            if ($number_of_records1 <> $number_of_records2) {
				echo "<script>swal({   title: \"Used Email !\",   text: \"$email is already registered. You can not change your email to it.\",   confirmButtonText: \"OK\",   closeOnConfirm: false }, function(){  window.location.assign(\"edit_profile.php\"); });</script>";
            } else {
                if ($tmpName <> null) {
                    $fp = fopen($tmpName, 'r');
                    $data = fread($fp, filesize($tmpName));
                    $data = addslashes($data);
                    fclose($fp);
                    $update_order = sprintf("UPDATE users SET firstname='%s', lastname='%s', email='%s', address='%s', phone='%s', image='%s' WHERE id = %s ", $fname, $lname, $email, $address, $phone, $data, $_SESSION['user_id']);
                    $stmt = $dbh->query($update_order);
                    $_SESSION['email'] = $email;
                    $_SESSION['user_image'] = $data;
                    $_SESSION['user_fname'] = $fname;
                    if(isset($_COOKIE['email'])){
                      $_COOKIE['email'] = $_email;
                      $_COOKIE['user_image'] = $data;
                      $_COOKIE['user_fname'] = $fname;
                    }
                } else {
                    $update_order = sprintf("UPDATE users SET firstname='%s', lastname='%s', email='%s', address='%s', phone='%s' WHERE id = %s ", $fname, $lname, $email, $address, $phone, $_SESSION['user_id']);
                    $stmt = $dbh->query($update_order);
                    $_SESSION['email'] = $email;
                    $_SESSION['user_fname'] = $fname;
                    if(isset($_COOKIE['email'])){
                      $_COOKIE['email'] = $_email;
                      $_COOKIE['user_fname'] = $fname;
                    }
                }
				echo "<script>swal({   title: \"Your profile was updated successfully !\",   text: \"Your profile was updated successfully !\",   confirmButtonText: \"OK\",   closeOnConfirm: false }, function(){  window.location.assign(\"index.php\"); });</script>";
            }

        }


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
		$encoded_image = '';
        if ($image <> null) {
            $encoded_image = base64_encode($image);
			$final_image = "<img width=\"100\" height=\"100\" src=\"data:image/*;base64,$encoded_image\"/>";	
			/*
            echo "<img src='data:image/jpeg;base64,{$encoded_image}'>";
            $form = <<<EOT
			<form action='edit_profile.php' method=GET'>
			<input type='submit' value='Delete image' name='remove_image' />
			</form>
			
EOT;
            echo $form;
			*/
        }else{
			$final_image = "<img width=\"100\" height=\"100\" src=\"images/avatar.png\"/>";		
		}
		
        echo <<<EOT
		
    <div class="container">
      <div class="row">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div>
                  <a href="#" class="active">Edit Profile</a>
                </div>
              </div>
              <hr>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <form action="edit_profile.php" method="post" role="form" enctype='multipart/form-data'>
					<div style="margin-right: auto;margin-left: auto;margin-bottom: 10px;width: 100px">
					  <div id="mProfileImage" style="margin-right: auto;margin-left: auto;">$final_image</div>
					  <div style="margin-right: auto;margin-left: -10;"><input id="imgSrc" class="btn btn-default" type='file' name='image' accept='image/*' value="Choose Image"></input></div>
					  <script>document.getElementById('imgSrc').addEventListener('change', handleFileSelect, false);</script>
					</div>
                    <div class="form-group">
                      <input type="text" name="fname" id="fname" tabindex="1" class="form-control" placeholder="First name"
                      value="$fname" />
                    </div>
					<div class="form-group">
                      <input type="text" name="lname" id="lname" tabindex="2" class="form-control" placeholder="Last name"
                      value="$lname" />
                    </div>
                    <div class="form-group">
                      <input type="email" name="email" id="email" tabindex="3" class="form-control" placeholder="Email Address"
                      value="$email" />
                    </div>
					<div class="form-group">
                      <input type="text" name="address" id="address" tabindex="6" class="form-control" placeholder="Address"
                      value="$address" />
                    </div>
					<div class="form-group">
                      <input type="text" name="phone" id="phone" tabindex="7" class="form-control" placeholder="Phone number"
                      value="$phone" />
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <input id="button" type="submit" name="submit" id="register-submit" tabindex="8"
                          class="form-control btn btn-register" value="Confirm" />
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
	
				<div class="container">
				<div class="panel panel-login">
				<div class="panel-heading">
              <div class="row">
                <div>
                  <a href="#" class="active">Remove Profile Avatar</a>
                </div>
              </div>
              <hr>
            </div>
					<div style="margin-right: auto;margin-left: auto;margin-top: 20;width: 100px">
					  <div id="mProfileImage1" style="margin-right: auto;margin-left: auto;">$final_image</div>
					  <form action='edit_profile.php' method=GET'>
					  <div style="margin-top: 10px;margin-left: -2px;"><input class="btn btn-default" type='submit' value='Delete image' name='remove_image' /></div>
					  </form>
                    </div>
					</div>

				</div>
EOT;
		
		
		echo <<<EOT
		
		<div class="container">
      <div class="row">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div>
                  <a href="#" class="active">Edit Profile</a>
                </div>
              </div>
              <hr>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <form action="change_pass.php" method="post" role="form" enctype='multipart/form-data' onsubmit="return validate()">
                    <div class="form-group">
                      <input type="password" name="old_password" id="old_password" tabindex="1" class="form-control" placeholder="Old password"
                      value="" />
                    </div>
					<div class="form-group">
                      <input type="password" name="new_password" id="new_password" tabindex="2" class="form-control" placeholder="New password"
                      value="" />
                    </div>
                    <div class="form-group">
                      <input type="password" name="confirm-password" id="confirm-password" tabindex="3" class="form-control" placeholder="Password confirmation"
                      value="" />
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <input id="button" type="submit" name="submit" tabindex="8"
                          class="form-control btn btn-register" value="Change Password" />
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
EOT;
    }
}
