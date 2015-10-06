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
		swal({   title: "Passwords do not match !",   text: "Passwords do not match !",   confirmButtonText: "OK",   closeOnConfirm: false });
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
			$final_image = "<img width=\"100\" height=\"100\" src=\"data:image/png;base64,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\"/>";		
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
