<?
	session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "logout.php" );
	\commons\log\_echo( "----------------------" );

	$_SESSION['logout'] = "y";

	include_once "include/auth.php";

	\commons\log\_echo( "----------------------" );



	///*
	// For Mobile
	if ( \commons\util\non_browser_agent() ) {
		session_clear( null, false );
		\commons\response\json_ro( JSON_RESULT_SUCCESS );
		exit;
	}
	//*/


	session_clear( PAGE__HOME, true );

?>
