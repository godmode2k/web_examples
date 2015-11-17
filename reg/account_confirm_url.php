<?
	//session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "account_confirm_url.php" );
	\commons\log\_echo( "----------------------" );

	//include_once "include/auth.php";

	\commons\log\_echo( "----------------------" );


	///*
	{
		// For Mobile
		if ( \commons\util\non_browser_agent() ) {
			//\commons\response\json_rkv( JSON_RESULT_FAIL, JSON_LOGIN_LOCKED, JSON_RESULT_TRUE );
			//JSON_LOGIN_CONFIRM_URL
			$json_data = Array();
			if ( is_array($json_data) ) {
				// POST
				//$confirm_url = "<a href='account_confirm.php?id="
				//				. $m_reg_login_id . "&auth=" . $auth . "'>confirm url</a>";

				$confirm_url = "account_confirm.php?id="
								. $_GET['id'] . "&auth=" . $_GET['auth'];

				$json_data[JSON_RESULT] = JSON_RESULT_SUCCESS;
				$json_data[JSON_LOGIN_LOCKED] = JSON_RESULT_SUCCESS;
				$json_data[JSON_LOGIN_CONFIRM_URL] = $confirm_url;
				\commons\response\json_array( $json_data );
			}

			exit;
		}
	}
	//*/



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

