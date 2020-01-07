<?php require_once("include/db.php");?>
<?php require_once("include/sessions.php");?>
<?php
function Redirect_to($New_Location){
	header("Location:".$New_Location);
	exit;
}
function Login_Attempt($Username, $Password){
	$ConnectingDB;
	$Query = "SELECT * FROM registration 
	WHERE username = '$Username' AND password = '$Password'";
	$Exequte = mysql_query($Query);
	if($admin = mysql_fetch_assoc($Exequte)){
		return $admin;
	}else{
		return null;
	}
}
function Login(){
	if(isset($_SESSION["User_Id"])){
		return true;
	}
}
function Confirm_Login(){
	if(!Login()){
		$_SESSION["ErrorMessage"]="Login Required!";
		Redirect_to("Login.php");
	}
}
?>