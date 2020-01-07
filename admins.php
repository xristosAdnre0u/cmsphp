<?php require_once("include/db.php");?>
<?php require_once("include/sessions.php");?>
<?php require_once("include/functions.php");?>
<?php Confirm_Login(); ?>
<?php
if(isset($_POST['Submit'])){


$Username = mysql_real_escape_string($_POST["Username"]);
$Password = mysql_real_escape_string($_POST["Password"]);
$ConfirmPassword = mysql_real_escape_string($_POST["ConfirmPassword"]);
date_default_timezone_set("Europe/Athens");

$CurrentTime=time();

//$DateTime=strftime("%d-%m-%Y %H:%M:%S",$CurrentTime);

$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
$DateTime;

$Admin= $_SESSION["Username"];
//validations
if(empty($Username) || empty($Password) || empty($ConfirmPassword)){
	$_SESSION["ErrorMessage"]= "All Fields must be filled out";
	Redirect_to("admins.php");

}
elseif(strlen($Password)<4){
	$_SESSION["ErrorMessage"]= "Atleast 4 Characters for Password are required";
	Redirect_to("admins.php");
}
elseif($Password !== $ConfirmPassword){
	$_SESSION["ErrorMessage"]= "Password / ConfirmPassword does not match";
	Redirect_to("admins.php");
}
else{
	global $ConnectingDB;
	$Query="INSERT INTO registration(datetime,username,password,addedby)
	VALUES('$DateTime','$Username', '$Password', '$Admin')";
	$Execute=mysql_query($Query);
	if($Execute){
		$_SESSION["SuccessMessage"]= "Admin Added Successfully";
	Redirect_to("admins.php");
	}else{
		$_SESSION["ErrorMessage"]= "Category failed to Add";
	Redirect_to("admins.php");
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
		<ul class="nav navbar-nav">
			<li><a href="#">Home</a></li>
			<li class="active"><a href="Blog.php" target="_blank">Blog</a></li>
			<li><a href="#">About Us</a></li>
			<li><a href="#">Services</a></li>
			<li><a href="#">Contact Us</a></li>
			<li><a href="#">Feature</a></li>
		</ul>
		<form action="Blog.php" class="navbar-form navbar-right">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search" name="Search">
			</div>
			<button class="btn btn-default" name="SearchButton">Go</button>
		</form>
	</div>
	</div>
</nav>
<div class="Line" style="height: 10px; background-color: #27aae1;"></div>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-2">
		
		<ul id="Side_Menu" class="nav nav-pills nav-stacked">
			<li><a href="Dashboard.php">
				<span class="glyphicon glyphicon-th"></span>
			&nbsp;Dashboard</a></li>
			<li><a href="AddNewPost.php">
			<span class="glyphicon glyphicon-list-alt"></span>
		&nbsp;Add New Post</a></li>
			<li ><a href="categories.php">
			<span class="glyphicon glyphicon-tags"></span>
		&nbsp;Categories</a></li>
			<li class="active"><a href="admins.php">
			<span class="glyphicon glyphicon-user"></span>
		&nbsp;Manage Admins</a></li>
			<li><a href="Comments.php">
			<span class="glyphicon glyphicon-comment"></span>
		&nbsp;Comments</a></li>
			<li><a href="logout.php">
			<span class="glyphicon glyphicon-equalizer"></span>
		&nbsp;Live Blog</a></li>
			<li><a href="#">
				<span class="glyphicon glyphicon-log-out"></span>
			&nbsp;Logout</a></li>
		</ul>
	</div><
	<div class="col-sm-10">
		<h1>Manage Admin Access</h1>
		<div><?php echo Message(); 
		     echo  SuccessMessage();
		?></div>
		<div>
			<form action="admins.php" method="post">
				<fieldset>
					<div class="form-group">
					<label for="Username"><span class="FieldInfo">UserName:</span></label>
					<input class="form-control" type="text" name="Username" id="Username" placeholder="username">
					</div>
					<div class="form-group">
					<label for="Password"><span class="FieldInfo">Password:</span></label>
					<input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
					</div>
					<div class="form-group">
					<label for="categoryname"><span class="FieldInfo">Confirm Password:</span></label>
					<input class="form-control" type="Password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Retype same Password">
					</div>
					<br>
					<input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Admin">
					<br>
				</fieldset>
			</form>
		</div>

		<!-- View From Db -->
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Sr No.</th>
					<th>Date & Time</th>
					<th>Admin Name</th>
					<th>Added By</th>
					<th>Action</th>
				</tr>

				<?php

global $ConnectingDB;
$ViewQuery="SELECT * FROM registration ORDER BY datetime desc";
$Execute=mysql_query($ViewQuery);
$SrNo= 0;
while($DataRows= mysql_fetch_array($Execute)){
	$Id= $DataRows["id"];
	$DateTime= $DataRows["datetime"];
	$Username= $DataRows["username"];
	$Admin= $DataRows["addedby"];
	$SrNo++;
				?>

			<tr>
				<td><?php echo $SrNo; ?></td>
				<td><?php echo $DateTime; ?></td>
				<td><?php echo $Username; ?></td>
				<td><?php echo $Admin; ?></td>
				<td><a href="DeleteAdmin.php?id=<?php echo $Id;?>">
					<span class="btn btn-danger">Delete</span></a></td>
			</tr>

			<?php } ?>

			</table>

		</div>
	</div>
</div>

</div>

<div id="Footer">
		<hr><p>Theme By | Chris Andre | &copy;2018-2019 --- All right reserved.</p>
		<a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold;" href="">

	</div>
	<div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>