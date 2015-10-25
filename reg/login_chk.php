<?
	session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "login_chk.php" );
	\commons\log\_echo( "----------------------" );

	include_once "include/auth.php";

	\commons\log\_echo( "----------------------" );


	///*
	// For Mobile
	if ( \commons\util\non_browser_agent() ) {
		exit;
	}
	//*/

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

