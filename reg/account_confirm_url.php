<?
	//session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "account_confirm_url.php" );
	\commons\log\_echo( "----------------------" );

	//include_once "include/auth.php";

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
	<!-- confirmation URL -->
	<?
		$id = $_GET['id'];
		$auth = $_GET['auth'];

		echo "id = " . $id . ", auth = " . $auth . "<br>";

		//$url = "<a href='account_confirm.php?id=" . $id . "&auth=" . $auth . "'>confirm</a>";

		// get domain:port + path + page //$_SERVER['...'];
		$url = "<a href='account_confirm.php?id=" . $id . "&auth=" . $auth . "'>";
		$url .=  "http://localhost/reg/account_confirm.php?id=" . $id . "&auth=" . $auth;
		$url .= "</a>";

		echo( $url );
	?>
</body>
</html>

