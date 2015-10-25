<?
	session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "account_commit.php" );
	\commons\log\_echo( "----------------------" );

	$_SESSION['reg_new_account'] = true;

	include_once "include/auth.php";

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
	<form action="account_confirm_url.php" method="post" name="parcel_data">
		<?
			set_parcel_post();
		?>
	</form>

	<script language="JavaScript">
		document.parcel_data.submit();
	</script>
</body>
</html>

