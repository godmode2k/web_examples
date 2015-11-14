<?
	session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "reserv_register_commit.php" );
	\commons\log\_echo( "----------------------" );

	include_once "include/auth.php";

	\commons\log\_echo( "----------------------" );



	$m_reg_name = $_POST['reg_name'];
	//$m_reg_phone1 = $_POST['reg_phone1'];
	//$m_reg_phone2 = $_POST['reg_phone2'];
	//$m_reg_phone3 = $_POST['reg_phone3'];
	//$m_reg_phone = $m_reg_phone1 . "-" . $m_reg_phone2 . "-" . $m_reg_phone3;
	$m_reg_auth = $_POST['reg_auth'];
	$m_reg_date = $_POST['reg_date'];
	$m_reg_timelist_hh = $_POST['reg_timelist_hh'];
	$m_reg_timelist_mm = $_POST['reg_timelist_mm'];
	$m_reg_timelist_ampm = $_POST['reg_timelist_ampm'];
	$m_reg_date_to = $_POST['reg_date_to'];
	$m_reg_timelist_hh_to = $_POST['reg_timelist_hh_to'];
	$m_reg_timelist_mm_to = $_POST['reg_timelist_mm_to'];
	$m_reg_timelist_ampm_to = $_POST['reg_timelist_ampm_to'];
	// get query type
	$m_reg_query_type = $_POST['db_query_type'];

	// old datetime data
	// format: '2013-11-15 10:00:00' to '20131115100000'
	$m_reg_db_user_old_reg_datetime_full_from = $_POST['reg_db_old_datetime_full_from'];
	$m_reg_db_user_old_reg_datetime_full_to = $_POST['reg_db_old_datetime_full_to'];
	$m_reg_db_user_old_reg_datetime_full_from = str_replace( " ", "", $m_reg_db_user_old_reg_datetime_full_from );
	$m_reg_db_user_old_reg_datetime_full_from = str_replace( "-", "", $m_reg_db_user_old_reg_datetime_full_from );
	$m_reg_db_user_old_reg_datetime_full_from = str_replace( ":", "", $m_reg_db_user_old_reg_datetime_full_from );
	$m_reg_db_user_old_reg_datetime_full_to = str_replace( " ", "", $m_reg_db_user_old_reg_datetime_full_to );
	$m_reg_db_user_old_reg_datetime_full_to = str_replace( "-", "", $m_reg_db_user_old_reg_datetime_full_to );
	$m_reg_db_user_old_reg_datetime_full_to = str_replace( ":", "", $m_reg_db_user_old_reg_datetime_full_to );


	// Session data {
	//$m_reg_user_uid = $_SESSION['user_uid'];
	$m_reg_user_id = $_SESSION['user_id'];
	$m_reg_user_name = $_SESSION['user_name'];
	//$m_reg_user_passwd = $_SESSION['user_passwd'];
	$m_reg_user_phone = $_SESSION['user_phone'];
	//$m_reg_user_last_reg_datetime_full_from = $_SESSION['user_last_reg_datetime_full_from'];
	//$m_reg_user_last_reg_datetime_full_to = $_SESSION['user_last_reg_datetime_full_to'];
	//$m_reg_user_last_reg_date_from = $_SESSION['user_last_reg_date_from'];
	//$m_reg_user_last_reg_datetime_from = $_SESSION['user_last_reg_datetime_from'];
	//$m_reg_user_last_reg_date_to = $_SESSION['user_last_reg_date_to'];
	//$m_reg_user_last_reg_datetime_to = $_SESSION['user_last_reg_datetime_to'];
	// }


	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: name = " . $m_reg_name );
	//\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: phone = " . $m_reg_phone . ", "
	//		. $m_reg_phone1 . "-" . $m_reg_phone2 . "-" . $m_reg_phone3 );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: phone = " . $m_reg_user_phone );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: date = " . $m_reg_date );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: date_to = " . $m_reg_date_to );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: time = " . $m_reg_timelist_hh . ":"
			. $m_reg_timelist_mm . $m_reg_timelist_ampm );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: time_to = " . $m_reg_timelist_hh_to
			. ":" . $m_reg_timelist_mm_to . $m_reg_timelist_ampm_to );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: query type = " . $m_reg_query_type );


	$m_reg_timelist_hhmmss = "";
	$m_reg_timelist_hhmmss_to = "";
	{
		//$m_reg_timelist_hh = "12";
		//$m_reg_timelist_mm = "10";
		//$m_reg_timelist_ampm = "am";

		if ( $m_reg_timelist_ampm == "am" ) {
			if ( $m_reg_timelist_hh == 12 )
				$m_reg_timelist_hh = "00";

			$m_reg_timelist_hhmmss = $m_reg_timelist_hh . ":" . $m_reg_timelist_mm;
			//$m_reg_timelist_hhmmss = $m_reg_timelist_hhmmss . $m_reg_timelist_ampm . ", ";
		}
		else {
			if ( $m_reg_timelist_hh < 12 )
				$m_reg_timelist_hh = ((int)$m_reg_timelist_hh + 12);

			$m_reg_timelist_hhmmss = $m_reg_timelist_hh . ":" . $m_reg_timelist_mm;
			//$m_reg_timelist_hhmmss = $m_reg_timelist_hhmmss . $m_reg_timelist_ampm . ", ";
		}
		$m_reg_timelist_hhmmss = $m_reg_timelist_hhmmss . ":00";

		\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: time(24h) = " . $m_reg_timelist_hhmmss );

		// ---

		if ( $m_reg_timelist_ampm_to == "am" ) {
			if ( $m_reg_timelist_hh_to == 12 )
				$m_reg_timelist_hh_to = "00";

			$m_reg_timelist_hhmmss_to = $m_reg_timelist_hh_to . ":" . $m_reg_timelist_mm_to;
			//$m_reg_timelist_hhmmss_to = $m_reg_timelist_hhmmss_to . $m_reg_timelist_ampm_to . ", ";
		}
		else {
			if ( $m_reg_timelist_hh_to < 12 )
				$m_reg_timelist_hh_to = ((int)$m_reg_timelist_hh_to + 12);

			$m_reg_timelist_hhmmss_to = $m_reg_timelist_hh_to . ":" . $m_reg_timelist_mm_to;
			//$m_reg_timelist_hhmmss_to = $m_reg_timelist_hhmmss_to . $m_reg_timelist_ampm_to . ", ";
		}
		$m_reg_timelist_hhmmss_to = $m_reg_timelist_hhmmss_to . ":00";

		\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: time(24h)_to = " . $m_reg_timelist_hhmmss_to );
	}

	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: auth = " . $m_reg_auth );
	// 2010-02-06 19:30:13
	//echo "date = " . date( "Y-m-d H:i:s", strtotime(str_replace('/', '-', $m_reg_date)) );
	//echo "db_date = " . date( "Y-m-d H:i:s", strtotime($m_reg_date . " " . $m_reg_timelist_hhmmss) );
	$m_reg_timelist_datetime_from = date( "Y-m-d H:i:s", strtotime($m_reg_date . " " . $m_reg_timelist_hhmmss) );
	$m_reg_timelist_datetime_to = date( "Y-m-d H:i:s", strtotime($m_reg_date_to . " " . $m_reg_timelist_hhmmss_to) );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: datetime_full_from = " . $m_reg_timelist_datetime_from );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: datetime_full_to = " . $m_reg_timelist_datetime_to );

	// format: '2013-11-15 10:00:00' to '20131115100000'
	$m_reg_db_timelist_datetime_from = str_replace( " ", "", $m_reg_timelist_datetime_from );
	$m_reg_db_timelist_datetime_from = str_replace( "-", "", $m_reg_db_timelist_datetime_from );
	$m_reg_db_timelist_datetime_from = str_replace( ":", "", $m_reg_db_timelist_datetime_from );
	$m_reg_db_timelist_datetime_to = str_replace( " ", "", $m_reg_timelist_datetime_to );
	$m_reg_db_timelist_datetime_to = str_replace( "-", "", $m_reg_db_timelist_datetime_to );
	$m_reg_db_timelist_datetime_to = str_replace( ":", "", $m_reg_db_timelist_datetime_to );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: db_datetime_full_from = " . $m_reg_db_timelist_datetime_from );
	\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: db_datetime_full_to = " . $m_reg_db_timelist_datetime_to );

	$m_reg_chk_timelist_hh = "";
	$m_reg_chk_timelist_mm = "";
	$m_reg_chk_timelist_ampm = "";



	// Commit
	if ( $m_reg_query_type ) {
		// check datetime
		if ( $db ) {
			$query = null;
			$result = null;
			$result_update_userinfo = null;
			$schedule_cancel = 0;	// default: 0 (false)
			$schedule_done = 0;		// default: 0 (false)

			if ( $m_reg_query_type == "sel" ) {
				//$query = "select count(*) from schedule where reg_datetime_from >= \"$m_reg_timelist_datetime_from\" and
				//			reg_datetime_to <= \"$m_reg_timelist_datetime_to\"";

				$query = "select count(*) from schedule";
				$query = $query . " where reg_ud=\"$m_reg_user_id\"" . " and ";
				$query = $query . "reg_datetime_from >= \"$m_reg_db_timelist_datetime_from\"" . " and ";
				$query = $query . "reg_datetime_to <= \"$m_reg_db_timelist_datetime_to\"";
				\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: type = " . $m_reg_query_type
						. ", query = " . "'" . $query . "'" );

				$result = $db->select( $query );
			}
			else {
				if ( $m_reg_query_type == "ins" ) {
					//$query = "insert into schedule values(" . "'".$m_reg_user_id."', "
					//		. "'".$m_reg_phone."', " . "'".$m_reg_timelist_datetime_from."', "
					//		. "'".$m_reg_timelist_datetime_to."'" . ")";
					
					$query = "insert into schedule";
					$query = $query . "(reg_id, reg_name, reg_phone, reg_datetime_from, reg_datetime_to, reg_cancel, reg_done)";
					$query = $query . " values(";
					$query = $query . "'".$m_reg_user_id."', ";
					$query = $query . "'".$m_reg_user_name."', ";
					$query = $query . "'".$m_reg_user_phone."', ";
					$query = $query . $m_reg_db_timelist_datetime_from.", ";
					$query = $query . $m_reg_db_timelist_datetime_to.", ";
					$query = $query . $schedule_cancel.", ";
					$query = $query . $schedule_done;
					$query = $query . ")";
					\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: type = " . $m_reg_query_type
							. ", query = " . "'" . $query . "'" );
				}
				/*
				else if ( $m_reg_query_type == "del" ) {
					//$query = "delete from schedule where reg_datetime_from >= \"$m_reg_timelist_datetime_from\" and
					//			reg_datetime_to <= \"$m_reg_timelist_datetime_to\"";
					
					$query = "delete from schedule";
					$query = $query . " where reg_id=\"$m_reg_user_id\"" . " and ";
					$query = $query . "reg_datetime_from >= \"$m_reg_db_timelist_datetime_from\"" . " and ";
					$query = $query . "reg_datetime_to <= \"$m_reg_db_timelist_datetime_to\"";
					\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: type = " . $m_reg_query_type
							. ", query = " . "'" . $query . "'" );
				}
				*/
				// Delete: set schedule_cancel to 'false'
				else if ( ($m_reg_query_type == "del") || ($m_reg_query_type == "modify") ) {
					$query = "update schedule set ";
					$query = $query . "reg_datetime_from='".$m_reg_db_timelist_datetime_from."', ";
					$query = $query	. "reg_datetime_to='".$m_reg_db_timelist_datetime_to."'";

					if ( $m_reg_query_type == "del" ) {
						$schedule_cancel = 1;
						$query = $query	. ", reg_cancel='".$schedule_cancel."'";
					}

					$query = $query . " where reg_id='".$m_reg_user_id."'" . " and ";
					$query = $query . "reg_datetime_from='".$m_reg_db_user_old_reg_datetime_full_from."'" . " and ";
					$query = $query . "reg_datetime_to='".$m_reg_db_user_old_reg_datetime_full_to."'" . " and ";
					$query = $query . "reg_cancel = 0" . " and ";
					$query = $query . "reg_done = 0";
					\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: type = " . $m_reg_query_type
							. ", query = " . "'" . $query . "'" );
					$result = $db->query( $query );

					//! FIXME: if schedule_cancel is 'true' then ...
					$query = "update register set ";
					$query = $query . "reg_last_datetime_from='".$m_reg_db_timelist_datetime_from."', ";
					$query = $query . "reg_last_datetime_to='".$m_reg_db_timelist_datetime_to."'";
					$query = $query . " where reg_id='".$m_reg_user_id."'";
					\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: type = " . $m_reg_query_type
							. ", query = " . "'" . $query . "'" );
					$result_update_userinfo = $db->query( $query );
				}
				else {
					\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: query error" );
					//echo "<script> alert('query error'); </script>";
					exit;
				}

				$result = $db->query( $query );
			}

			/*
			$query = "select count(*) from schedule where reg_datetime_from=\"$m_reg_timelist_datetime_from\"";
			//$query = "select count(*) from schedule where reg_datetime_from >= \"$m_reg_timelist_datetime_from\" and
			//	reg_datetime_to <= \"$m_reg_timelist_datetime_to\"";
			$result = $db->select( $query );

			echo "reserv_register_commit: check datetime" . "<br>";
			if ( $result ) {
				echo "register_commit: result = " . $result[0][0] . "<br>";
				if ( $result[0][0] > 0 ) {
					echo "reserv_register_commit: reserved already" . "<br>";
				}
				else {
				}
			}
			*/


			// result
			if ( $result ) {
				if ( $m_reg_query_type == "sel" ) {
					\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: result = " . $result[0][0] );
					if ( $result[0][0] > 0 ) {
						\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: result: select [TRUE]" );
					}
					else {
						\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: result: no data" );
					}
				}
				else {
					\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: result = " . $result );
					if ( $m_reg_query_type == "ins" ) {
						\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: result: insert [TRUE]" );
					}
					else if ( $m_reg_query_type == "del" ) {
						\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: result: delete [TRUE]; schedule_cancel to 'true'" );
					}
					else if ( $m_reg_query_type == "modify" ) {
						\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: result: modify [TRUE]" );

						if ( $result_update_userinfo ) {
							\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: result: modify [TRUE]; last schedule" );
						}
						else {
						}
					}
				}
			}
			else {
				\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: result error" );
				exit;
			}
		}
	}
	else {
		\commons\log\logd( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit: unknown query type" );
		//echo "<script> alert('unknown query type'); </script>";
		exit;
	}



	//echo "<hr>";
	\commons\log\_echo( "<hr>" );

	link_page( TAG_RESERV_REGISTER_MODIFY );
?>



<!DOCTYPE HTML>
<html>
<head lang="kr">
	<title>:: TEST ::</title>
	<!--<META http-equiv="Content-Type" content="text/html; charset=KS_C_5601-1987">-->
	<META charset="utf-8">

	<style type="text/css">
	</style>

	<script language='JavaScript'>
		function chk_reg_datetime(form) {
			alert( "chk_reg_datetime()" );
			<?
				if ( $db ) {
					$query = "select count(*) from register where reg_date";
					$db->select( $query );
				}
			?>
		}

		function reg_logout(logout) {
			alert( "reg_logout()" );

			window.location.assign( "logout.php" );
		}
	</script>
</head>

<body>
	<div id="menu_top" style="background-color: #FFD700; height: 40px; width: 90%; float: left;" align="center">
		<table>
			<td> <b><a style="text-decoration: none" href="reserv.php">Reserve</a></b> </td>
			<td> <b>|</b> </td>
			<td> <b><a style="text-decoration: none" href="reserv_register_modify.php">Manage</a></b> </td>
		</table>
	</div>
	<div id="menu_top_login" style="background-color: #FFD700; height: 40px; width: 10%; float: left;" align="right">
		<table>
			<td>
				<?
					session_start();

					//echo "<b><a style='text-decoration: none' href='account_info.php'>[" . $m_reg_user_name . "]</a></b>";
					echo "<b><a style='text-decoration: none' href='account_info.php'>[Profile]</a></b> <br>";

					if ( chk_login_already(false) ) {
						//echo '<b><a style="text-decoration: none" href="JavaScript:reg_logout(this)">로그아웃</a></b>';
						echo '<b><a style="text-decoration: none" href="logout.php">logout</a></b>';
					}
					else {
						echo '<b><a style="text-decoration: none" href="login.php">login</a></b>';
					}
				?>
			</td>
		</table>
	</div>
	<br><br><br>

	commit page...
</body>
</html>

