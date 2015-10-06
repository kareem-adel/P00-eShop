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
require('config.php');

if (isset($_POST{'submit'})) {

    $data = array('email' => $_POST{'email'},
        'fname' => $_POST{'fname'},
        'lname' => $_POST{'lname'},
        'pass' => $_POST{'password'},
        'address' => $_POST{'address'},
        'phone' => $_POST{'phone'});
    //echo $_POST{'email'}==null;

    $select_query = sprintf("SELECT count(*) FROM users WHERE email = \"%s\";", $_POST{'email'});

    if ($prepare = $dbh->query($select_query) and $prepare->fetchColumn() > 0) {
								echo <<<EOT
	<div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-login">
            <div class="panel-heading">
              <div class="row">
                <div>
                  <a href="#" class="active">Redirecting</a>
                </div>
              </div>
              <hr />
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
					
					<font size="5" color="green">This email is already registered. Redirecting to login page.</font>
                    <script>setTimeout("location.href = 'LoginRegister.php';",2000);</script>
					
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
EOT;
		
    } else {
        if ($_POST{'email'} == null or $_POST{'password'} == null) {
            header("Location: LoginRegister.php");
            exit();
        } else {
            try {
                $insert_query = "INSERT INTO users (firstname, lastname, email, password, address, phone) VALUES (:fname, :lname, :email, :pass, :address, :phone);";
                $stmt = $dbh->prepare($insert_query);
                $stmt->execute($data);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
			
			//logging in step
			$email = $_POST{'email'};
            $password = $_POST{'password'};
            $check_query = sprintf("SELECT * FROM users WHERE email = \"%s\" AND password = \"%s\";", $email, $password);
            if ($prepare = $dbh->query($check_query) and $prepare->fetchColumn() > 0) {
                $_SESSION['email'] = $email;

                foreach ($dbh->query($check_query) as $row) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_image'] = $row['image'];
                    $_SESSION['user_fname'] = $row['firstname'];
                }
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
					
					<font size="5" color="green">You are now registered and logged in. Redirecting to home page.</font>
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

    }


} 
else {
	header("location: LoginRegister.php");
}
/*
else {
    $form = <<<EOT
<form action='register.php' method=POST>
First Name: <input type='text' name='fname' /><br />
Last Name: <input type='text' name='lname' /><br />
Email: <input type='text' name='email' /><br />
Password: <input type='password' name='password' /><br />
Address: <input type='text' name='address' /><br />
Phone Number: <input type='text' name='phone' /><br />
<input type='submit' value='Register' name='submit' />
</form>
EOT;
    echo $form;


}
*/
