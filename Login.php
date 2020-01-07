<?php require_once("include/db.php");?>
<?php require_once("include/sessions.php");?>
<?php require_once("include/functions.php");?>
<?php
if(isset($_POST['Submit'])){

$Username = mysql_real_escape_string($_POST["Username"]);
$Password = mysql_real_escape_string($_POST["Password"]);

if(empty($Username) || empty($Password)){
	$_SESSION["ErrorMessage"]= "All Fields must be filled out";
	Redirect_to("login.php");
}
else{
	$Fount_Account = Login_Attempt($Username,$Password);
	$_SESSION["User_Id"] = $Fount_Account["id"];
	$_SESSION["Username"] = $Fount_Account["username"];
	if($Fount_Account){
		$_SESSION["SuccessMessage"]= "Welcome {$_SESSION["Username"]}";
	Redirect_to("dashboard.php");
	}else{
		$_SESSION["ErrorMessage"]= "Invalid Username/Password";
	Redirect_to("Login.php");
	}
	}
}
?>

<!DOCTYPE>
<html>
<head>
	<title>Admins</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/adminstyles.css">
	<style>
		.FieldInfo{
			color: rgb(251, 174, 44);
			font-family: Bitter,Georgia,"Times New Roman",Times, serif;
			font-size: 1.2em;
		}
		body{
			background-color: white;
		}
	</style>
</head>
<body>
<div style="height: 10px; background-color: #27aae1;"></div>
<nav class="navbar navbar-inverse" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
		<span class="sr-only">Toggle Navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
			</button>
<a class="navbar-brand" href="Blog.php">		
<img style="margin-top: -9px;" src="images/jazebakramcom.png" width= "200"; height="30">
</a>
		</div>
		<div class="collapse navbar-collapse" id="collapse">
	</div>
	</div>
</nav>
<div class="Line" style="height: 10px; background-color: #27aae1;"></div>
<div class="container-fluid">
<div class="row">
	
	<div class="col-sm-offset-4 col-sm-4">
		<br><br><br><br>
		<div><?php echo Message(); 
		     echo  SuccessMessage();
		?></div>

		<h2>Welcome Back</h2>
		<div>
			<form action="login.php" method="post">
				<fieldset>
					<div class="form-group">
						
					<label for="Username"><span class="FieldInfo">UserName:</span></label>
					<div class="input-group input-group-lg">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-envelope text-primary"></span>
							</span>
					<input class="form-control" type="text" name="Username" id="Username" placeholder="username">
				</div>
					</div>
					<div class="form-group">
					<label for="Password"><span class="FieldInfo">Password:</span></label>
					<div class="input-group input-group-lg">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-lock text-primary"></span>
							</span>
					<input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
					</div>
					</div>
					<br>
					<input class="btn btn-info btn-block" type="Submit" name="Submit" value="Login">
					<br>
				</fieldset>
			</form>
		</div>
	</div>
</div>
</div>
</body>
</html>