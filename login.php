<?php
	require_once("resources/connection.php");
	require_once("resources/functions.php");
	
	//LOGIN VALIDATION
	if(!empty($_POST['postback'])){
		$user;
		$valid = true;
		$login_email = $_POST['email'];
		$login_password = $_POST['password'];
		$error = array();
		
		if(!empty($login_email) && !empty($login_password)){
			$user = validateUser($login_email, $login_password);	
			if(is_null($user)) $valid = false;		
		}
		
		if(empty($login_email)) {
			$valid = false;
			$error["login_email"] = "Invalid Email";
		}
		if(empty($login_password)){
			$valid = false;
			$error["login_pass"] = "Invalid Password";
		}
		
		if($valid){
			session_start();
			$_SESSION['user_id'] = $user;
			header("Location: index.php");
		}
		
	}
	
	//SIGNUP VALIDATION
	if(!empty($_POST['signup-postback'])){
		$firstName = $_POST['first'];
		$lastName = $_POST['last'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		$valid = true;
		$error = array();
		$user;
		
		if(empty($firstName) || is_numeric($firstName)){
			$valid = false;
			$error['first'] = "Invalid first name";	
		}
		if(empty($lastName) || is_numeric($firstName)){
			$valid = false;
			$error['last'] = "Invalid last name";	
		}
		if(empty($email)){
			$valid = false;
			$error['email'] = "Invalid email address";	
		}
		if(empty($password) || empty($confirm) || $password != $confirm){
			$valid = false;
			$error['password'] = "Invalid Password";	
		}
		
		if($valid){
			$user = newUser($firstName, $lastName, $email, $password);	
			if($user){
				session_start();
				$_SESSION['user_id'] = $user;
				header("Location: index.php");	
			}
		}
   
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Grind | Time Tracking &amp Project Managment</title>
<!-- Styles -->
<link rel="stylesheet" type="text/css" href="<?php echo ROOT . "/resources/lib/chosen.css";?>" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT . "/resources/lib/jquery.datepicker.ui.min.css";?>" />
<link rel="stylesheet/less" type="text/css" href="<?php echo ROOT . "/css/main.less";?>"/>
<!-- Third Party Scripts-->
<script src="<?php echo ROOT . "/resources/lib/jquery-1.7.2.min.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/resources/lib/less-1.3.0.min.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/resources/lib/chosen.jquery.min.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/resources/lib/jquery.cookie.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/resources/lib/jquery.datepicker.ui.min.js";?>" type="text/javascript"></script>
<!-- Application Scripts-->
<script src="<?php echo ROOT . "/js/events.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/js/options.js";?>" type="text/javascript"></script>
</head>

<body>
   <section id="content" class="login-wrapper">
      <h1>Daily Grind</h1>
      <h2>A project Management tool for your time, tasks and expenses</h2>
      <a href="#" class="signup-btn button">Sign Up its FREE!</a>
      <div class="new-form" id="login">
         <h3>Login</h3>
         <form name="login" method="post" action="login.php">
            <input type="hidden" name="postback" value="set"/>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?php if(isset($login_email)) echo $login_email;?>"/>
            <span class="error"><?php if(isset($error['login_email'])) echo $error['login_email'];?></span>
            <br/>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password"/>
            <span class="error"><?php if(isset($error['login_pass'])) echo $error['login_pass'];?></span>
            <br/>
            <input type="submit" value="Login"/>
         </form>
      </div>
      <div class="new-form" id="signup">
         <h3>Signup</h3>
         <form name="signup" method="post" action="login.php">
            <input type="hidden" name="signup-postback" value="set"/>
            <label for="first">First Name:</label>
            <input type="text" name="first" id="first"  value="<?php if(isset($firstName)) echo $firstName;?>"/>
            <span class="error"><?php if(isset($error['first'])) echo $error['first'];?></span>
            <br/>
            <label for="last">Last Name:</label>
            <input type="text" name="last" id="last" value="<?php if(isset($lastName)) echo $lastName;?>"/>
            <span class="error"><?php if(isset($error['last'])) echo $error['last'];?></span>
            <br/>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?php if(isset($email)) echo $email;?>"/>
            <span class="error"><?php if(isset($error['email'])) echo $error['email'];?></span>
            <br/>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" />
            <br/>
            <label for="confirm">Confirm Password:</label>
            <input type="password" name="confirm" id="confirm"/>
            <span class="error"><?php if(isset($error['password'])) echo $error['password'];?></span>
            <br/>
            <input type="submit" value="Sign Up"/>
         </form>
      </div>
   </section>
</body>
</html>