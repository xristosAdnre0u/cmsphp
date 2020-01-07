<?php require_once("include/db.php");?>
<?php require_once("include/sessions.php");?>
<?php require_once("include/functions.php");?>
<?php Confirm_Login(); ?>
<?php

if(isset($_POST['Submit'])){

$Title = mysql_real_escape_string($_POST["Title"]);
$Category = mysql_real_escape_string($_POST["Category"]);
$Post = mysql_real_escape_string($_POST["Post"]);


date_default_timezone_set("Europe/Athens");

$CurrentTime=time();

//$DateTime=strftime("%d-%m-%Y %H:%M:%S",$CurrentTime);

$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
$DateTime;

$Admin= $_SESSION["Username"];
$Image = $_FILES["Image"] ["name"];
$Target= "Upload/".basename($_FILES["Image"]["name"]);

//validations
if(empty($Title)){
	$_SESSION["ErrorMessage"]= "Title can't be empty";
	Redirect_to("AddNewPost.php");

}
elseif(strlen($Title) < 2){
	$_SESSION["ErrorMessage"]= "Title Should be at-least 2 Characters";
	Redirect_to("AddNewPost.php");
}
else{
	global $ConnectingDB;
	$Query="INSERT INTO admin_panel(datetime,title,category,author,image,post)
	VALUES('$DateTime','$Title', '$Category', '$Admin'  '$Author', '$Image', '$Post')";
	$Execute=mysql_query($Query);
	move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
	if($Execute){
		$_SESSION["SuccessMessage"]= "Post Added Successfully";
	Redirect_to("AddNewPost.php");
	}else{
		$_SESSION["ErrorMessage"]= "Something Went Wrong. Try Again!";
	Redirect_to("AddNewPost.php");
	}
}
}
?>
<!DOCTYPE>

<html>
<head>
	<title>Add New Post</title>
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

<div class="container-fluid">
<div class="row">
	<div class="col-sm-2">
		
		<ul id="Side_Menu" class="nav nav-pills nav-stacked">
			<li><a href="Dashboard.php">
				<span class="glyphicon glyphicon-th"></span>
			&nbsp;Dashboard</a></li>
			<li class="active"><a href="AddNewPost.php">
			<span class="glyphicon glyphicon-list-alt"></span>
		&nbsp;Add New Post</a></li>
			<li ><a href="categories.php">
			<span class="glyphicon glyphicon-tags"></span>
		&nbsp;Categories</a></li>
			<li><a href="admins.php">
			<span class="glyphicon glyphicon-user"></span>
		&nbsp;Manage Admins</a></li>
			<li><a href="Comments.php">
			<span class="glyphicon glyphicon-comment"></span>
		&nbsp;Comments</a></li>
			<li><a href="#">
			<span class="glyphicon glyphicon-equalizer"></span>
		&nbsp;Live Blog</a></li>
			<li><a href="logout.php">
				<span class="glyphicon glyphicon-log-out"></span>
			&nbsp;Logout</a></li>
		</ul>
	</div><
	<div class="col-sm-10">
		<h1>Add New Post</h1>
		<div><?php echo Message(); 
		     echo  SuccessMessage();
		?></div>
		<div>
			<form action="AddNewPost.php" method="post" enctype="multipart/form-data">
				<fieldset>

					<div class="form-group">
					<label for="title"><span class="FieldInfo">Title:</span></label>
					<input class="form-control" type="text" name="Title" id="title" placeholder="Title">
					</div>

					<div class="form-group">
					<label for="categoryselect"><span class="FieldInfo">Category:</span></label>
					<select class="form-control" id="categoryselect" name="Category">
						 <?php
global $ConnectingDB;
$ViewQuery="SELECT * FROM category ORDER BY datetime desc";
$Execute=mysql_query($ViewQuery);
while($DataRows= mysql_fetch_array($Execute)){
	$Id= $DataRows["id"];
	$CategoryName= $DataRows["name"];
				?> 
				<option><?php echo $CategoryName; ?></option>
				<?php  } ?>
					</select>
				</div>

				<div class="form-group">
					<label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
					<input type="File" class="form-control" name="Image" id="imageselect">
				</div>

				<div class="form-group">
					<label for="postarea"><span class="FieldInfo">Post:</span></label>
					<textarea class="form-control" name="Post" id="postarea"></textarea>
				</div>

					<br>
					<input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Post">
					<br>
				</fieldset>
			</form>
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