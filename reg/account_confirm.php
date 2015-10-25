<?
	session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "account_confirm.php" );
	\commons\log\_echo( "----------------------" );

	if ( isset($_SESSION['reg_confirm_account_done']) ) {
		unset( $_SESSION['reg_confirm_account'] );
		unset( $_SESSION['reg_confirm_account_done'] );
	}
	else {
		$_SESSION['reg_confirm_account'] = true;

		include_once "include/auth.php";
	}

	\commons\log\_echo( "----------------------" );



	\commons\log\_echo( "<hr>" );
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
	Account Created done! <br>
	Please <a href="login.php">login</a>
</body>
</html>

