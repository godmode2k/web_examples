<?
	session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "login.php" );
	\commons\log\_echo( "----------------------" );
	
	\commons\log\_echo( "----------------------" );



	//\commons\log\logd( $TAG, "<script> alert( 'login = " . $_SESSION['logged_in'] . ", user_id = "
	//		. $_SESSION['user_id'] . "'); </script>" );
	\commons\log\logd( TAG_LOGIN, "login = " . $_SESSION['logged_in']
			. ", user_id = " . $_SESSION['user_id']
			. ", new account = " . $_SESSION['reg_new_account'] . "<br>" );

	if ( $_SESSION['reg_new_account']  ) {
		header( 'Location: account_user_sign_up.php' );
		exit;
	}

	if ( isset($_SESSION['logged_in']) && isset($_SESSION['user_id']) ) {
		header( 'Location: reserv.php' );
		exit;
	}



	//echo "<hr>";
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
	<form action="login_chk.php" method="post">
		<table border="0">
		<tr>
			<td> ID </td> <td> <input type="text" name="reg_login_id"> </td>
		</tr>
		<tr>
			<td> Password </td> <td> <input type="password" maxlength="8" name="reg_login_passwd"> </td>
			<td> (8 length) </td>
		</tr>

		<tr>
			<td> <input type="submit" value="Sign-in"> </td>
			<!--
			<td>
				<form action="account_user.php" method="post">
					<input type="submit" value="가입">
				</form>
			</td>
			-->
		</tr>
		</table>
	</form>

	<form action="account_sign_up.php" method="post">
		<table border="0">
		<tr>
			<td> <input type="submit" value="Sign-up"> </td>
		</tr>
		</table>
	</form>
</body>
</html>

