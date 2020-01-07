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

$Admin= "Christos Andreou";
$Image = $_FILES["Image"] ["name"];
$Target= "Upload/".basename($_FILES["Image"]["name"]);





	global $ConnectingDB;
	$DeleteFromURL = $_GET['Delete'];
	$Query = "DELETE FROM admin_panel WHERE id='$DeleteFromURL'";
	$Execute=mysql_query($Query);
	move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
	if($Execute){
		$_SESSION["SuccessMessage"]= "Post Deleted Successfully";
	Redirect_to("Dashboard.php");
	}else{
		$_SESSION["ErrorMessage"]= "Something Went Wrong. Try Again!";
	Redirect_to("Dashboard.php");
	}

}
?>
<!DOCTYPE>

<html>
<head>
	<title>Delete Post</title>
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
			<li><a href="#">
			<span class="glyphicon glyphicon-user"></span>
		&nbsp;Manage Admins</a></li>
			<li><a href="#">
			<span class="glyphicon glyphicon-comment"></span>
		&nbsp;Comments</a></li>
			<li><a href="#">
			<span class="glyphicon glyphicon-equalizer"></span>
		&nbsp;Live Blog</a></li>
			<li><a href="#">
				<span class="glyphicon glyphicon-log-out"></span>
			&nbsp;Logout</a></li>
		</ul>
	</div><
	<div class="col-sm-10">
		<h1>Delete Post</h1>
		<div><?php echo Message(); 
		     echo  SuccessMessage();
		?></div>
		<div>
			<?php 
			$SerachQueryParameter = $_GET['Delete'];
			$ConnectingDB;
			$Query = "SELECT * FROM admin_panel WHERE id='$SerachQueryParameter'";
			$ExecuteQuery = mysql_query($Query);
			while ($DataRows = mysql_fetch_array($ExecuteQuery)) {
				
				$TitleToBeUpdated = $DataRows['title'];
				$CategoryToBeUpdated = $DataRows['category'];
				$ImageToBeUpdated = $DataRows['image'];
				$PostToBeUpdated = $DataRows['post'];
			}
			 ?>
			<form action="DeletePost.php?Delete=<?php echo $SerachQueryParameter; ?>" method="post" enctype="multipart/form-data">
				<fieldset>

					<div class="form-group">
					<label for="title"><span class="FieldInfo">Title:</span></label>
					<input disabled value="<?php echo $TitleToBeUpdated; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
					</div>

					<div class="form-group">
						<span class="FieldInfo">Existing Category: </span>
						<?php echo $CategoryToBeUpdated; ?>
						<br>
					<label for="categoryselect"><span class="FieldInfo">Category:</span></label>
					<select disabled class="form-control" id="categoryselect" name="Category">
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
					<span class="FieldInfo">Existing Image: </span>
						<img src="Upload/<?php echo $ImageToBeUpdated; ?>" width=170; height=70px;>
						<br>
					<label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
					<input disabled type="File" class="form-control" name="Image" id="imageselect">
				</div>

				<div class="form-group">
					<label for="postarea"><span class="FieldInfo">Post:</span></label>
					<textarea disabled class="form-control" name="Post" id="postarea">
						<?php echo $PostToBeUpdated; ?>
					</textarea>
				</div>

					<br>
					<input class="btn btn-danger btn-block" type="Submit" name="Submit" value="Delete Post">
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