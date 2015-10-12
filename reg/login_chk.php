<?
	echo "----------------------" . "<br>";
	echo "login_chk.php" . "<br>";
	echo "----------------------" . "<br>";

	session_start();

	include_once "include/commons.php";
	include_once "include/auth.php";

	//$TAG = "login_chk.php";
	echo "----------------------" . "<br>";

?>



<!DOCTYPE HTML>
<html>
<head lang="kr">
	<title>:: TEST ::</title>
	<!--<META http-equiv="Content-Type" content="text/html; charset=KS_C_5601-1987">-->
	<META charset="utf-8">

	<style type="text/css">
	</style>
</head>

<body>
	<form action="reserv.php" method="post" name="parcel_data">
		<?
			set_parcel_post();
		?>
	</form>

	<script language="JavaScript">
		document.parcel_data.submit();
	</script>
</body>
</html>

