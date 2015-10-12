<?
	echo "----------------------" . "<br>";
	echo "logout.php" . "<br>";
	echo "----------------------" . "<br>";

	session_start();

	$_SESSION['logout'] = "y";

	include_once "include/commons.php";
	include_once "include/auth.php";

	//$TAG = "logout.php";
	echo "----------------------" . "<br>";



	session_clear( PAGE__HOME );

?>
