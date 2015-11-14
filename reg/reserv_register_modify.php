<?
	session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "reserv_register_modify.php" );
	\commons\log\_echo( "----------------------" );

	include_once "include/auth.php";

	\commons\log\_echo( "----------------------" );



	// login
	// SEE: auth.php {
	//$m_reg_login_id = $_POST['reg_login_id'];
	//$m_reg_login_passwd = $_POST['reg_login_passwd'];
	//$m_reg_logon = false;
	//echo "reserv_register_modify: id = " . $m_reg_login_id . ", passwd = " . $m_reg_login_passwd . "<br>";
	// }

	//$m_reg_name = $_POST['reg_name'];
	//$m_reg_phone1 = $_POST['reg_phone1'];
	//$m_reg_phone2 = $_POST['reg_phone2'];
	//$m_reg_phone3 = $_POST['reg_phone3'];
	//$m_reg_auth = $_POST['reg_auth'];
	//$m_reg_date = $_POST['reg_date'];
	//$m_reg_timelist_hh = $_POST['reg_timelist_hh'];
	//$m_reg_timelist_mm = $_POST['reg_timelist_mm'];
	//$m_reg_timelist_ampm = $_POST['reg_timelist_ampm'];


	// Session data {
	//$m_reg_user_uid = $_SESSION['user_uid'];
	$m_reg_user_id = $_SESSION['user_id'];
	$m_reg_user_name = $_SESSION['user_name'];
	//$m_reg_user_passwd = $_SESSION['user_passwd'];
	$m_reg_user_phone = $_SESSION['user_phone'];
	$m_reg_user_last_reg_datetime_full_from = $_SESSION['user_last_reg_datetime_full_from'];
	$m_reg_user_last_reg_datetime_full_to = $_SESSION['user_last_reg_datetime_full_to'];
	$m_reg_user_last_reg_date_from = $_SESSION['user_last_reg_date_from'];
	$m_reg_user_last_reg_datetime_from = $_SESSION['user_last_reg_datetime_from'];
	$m_reg_user_last_reg_date_to = $_SESSION['user_last_reg_date_to'];
	$m_reg_user_last_reg_datetime_to = $_SESSION['user_last_reg_datetime_to'];
	// }

	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: id = " . $m_reg_user_id );
	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: name = " . $m_reg_user_name );
	//\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: phone = " . $m_reg_phone1
	//		. "-" . $m_reg_phone2 . "-" . $m_reg_phone3 );
	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: phone = " . $m_reg_user_phone );

	// last information
	//\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: last_reg_datetime_full_from = "
	//		. str_replace( ";", " ", $m_reg_user_last_reg_datetime_full_from) );
	//\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: last_reg_datetime_full_to = "
	//		. str_replace( ";", " ", $m_reg_user_last_reg_datetime_full_to) );
	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: last_reg_datetime_full_from = "
			. $m_reg_user_last_reg_datetime_full_from );
	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: last_reg_datetime_full_to = "
			. $m_reg_user_last_reg_datetime_full_to );

	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: last_date_from = "
			. $m_reg_user_last_reg_date_from );
	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: last_datetime_from = "
			.  $m_reg_user_last_reg_datetime_from );

	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: last_date_to = "
			. $m_reg_user_last_reg_date_to );
	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: last_datetime_to = "
			.  $m_reg_user_last_reg_datetime_to );

	$m_reg_date = $m_reg_user_last_reg_date_from; 
	$m_reg_timelist_hh = "";
	$m_reg_timelist_mm = "";
	$m_reg_timelist_ss = "";
	$m_reg_timelist_ampm = "";

	$m_reg_date_to = $m_reg_user_last_reg_date_to; 
	$m_reg_timelist_hh_to = "";
	$m_reg_timelist_mm_to = "";
	$m_reg_timelist_ss_to = "";
	$m_reg_timelist_ampm_to = "";

	list( $m_reg_timelist_hh, $m_reg_timelist_mm, $m_reg_timelist_ss )
		= explode( ":", $m_reg_user_last_reg_datetime_from );
	list( $m_reg_timelist_hh_to, $m_reg_timelist_mm_to, $m_reg_timelist_ss_to )
		= explode( ":", $m_reg_user_last_reg_datetime_to );
	
	$m_reg_timelist_hhmmss = "";
	$m_reg_timelist_hhmmss_to = "";
	{
		//$m_reg_timelist_hh = "12";
		//$m_reg_timelist_mm = "10";
		//$m_reg_timelist_ampm = "am";

		$m_reg_timelist_ampm = "pm";
		if ( $m_reg_timelist_hh == 00 ) {
			$m_reg_timelist_hh = "12";
			$m_reg_timelist_ampm = "am";
		}
		$m_reg_timelist_hhmmss = $m_reg_timelist_hh . ":" . $m_reg_timelist_mm . ":00";

		// -----

		//$m_reg_timelist_hh_to = "12";
		//$m_reg_timelist_mm_to = "10";
		//$m_reg_timelist_ampm_to = "am";

		$m_reg_timelist_ampm_to = "pm";
		if ( $m_reg_timelist_hh_to == 00 ) {
			$m_reg_timelist_hh_to = "12";
			$m_reg_timelist_ampm_to = "am";
		}

		$m_reg_timelist_hhmmss_to = $m_reg_timelist_hh_to . ":" . $m_reg_timelist_mm_to . ":00";

		\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: time(24h) from = "
				. $m_reg_timelist_hhmmss );
		\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: time(24h) to = "
				. $m_reg_timelist_hhmmss_to );
	}

	//\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: auth = " . $m_reg_auth );
	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "" );
	// 2010-02-06 19:30:13
	//\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: date = "
	//		. date( "Y-m-d H:i:s", strtotime(str_replace('/', '-', $m_reg_date)) ) );
	//\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: db_date = "
	//		. date( "Y-m-d H:i:s", strtotime($m_reg_date . " " . $m_reg_timelist_hhmmss) ) );
	$m_reg_timelist_datetime_db = date( "Y-m-d H:i:s", strtotime($m_reg_date . " " . $m_reg_timelist_hhmmss) );
	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: db_date_from = " . $m_reg_timelist_datetime_db );

	$m_reg_timelist_datetime_db_to = date( "Y-m-d H:i:s", strtotime($m_reg_date_to . " " . $m_reg_timelist_hhmmss_to) );
	\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: db_date_to = " . $m_reg_timelist_datetime_db_to );

	$m_reg_chk_timelist_hh = "";
	$m_reg_chk_timelist_mm = "";
	$m_reg_chk_timelist_ampm = "";



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

<!--
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" media="all" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
-->

<!--
	<script type="text/javascript">
		$(function() {
		  $( "#datepicker1" ).datepicker({
			dateFormat: 'yy-mm-dd'
		  });
		});

		$(function() {
		  $( "#datepicker2" ).datepicker({
			dateFormat: 'yy-mm-dd'
		  });
		});
	</script>
-->

	<script language='JavaScript'>
		function init_page(form) {
			alert( "init_page()" );
			//history.back();
			history.go( -1 );
		}

		function reg_get_timelist_hh(sel) {
			var selected = sel.options[sel.selectedIndex].value;
			
			//$.post( 'register_modify.php', {reg_chk_timelist_hh: selected} );
			//<? $m_reg_chk_timelist_hh = $_POST['reg_chk_timelist_hh'];
			//echo "chk_timelist_hh = " . $m_reg_chk_timelist_hh; ?>

			alert( "reg_get_timelist_hh(): sel = " + selected );
		}

		function reg_get_timelist_mm(sel) {
			var selected = sel.options[sel.selectedIndex].value;

			//$m_reg_chk_timelist_mm = "";
			alert( "reg_get_timelist_mm(): sel = " + selected );
		}

		function reg_get_timelist_ampm(sel) {
			var selected = sel.options[sel.selectedIndex].value;

			//$m_reg_chk_timelist_ampm = "";
			alert( "reg_get_timelist_ampm(): sel = " + selected );
		}

		function chk_reg_datetime(form) {
			alert( "chk_reg_datetime()" );
		}

		function reg_save(form) {
			alert( "reg_save()" );
		}

		function reg_logout(logout) {
			alert( "reg_logout()" );

			window.location.assign( "logout.php" );
		}

		function addHiddenInputTagData(_form, _name, _value) {
			var tag_input = document.createElement( 'input' );

			tag_input.type = 'hidden';
			tag_input.name = _name;
			tag_input.value = _value;

			_form.appendChild( tag_input );
		}

		/*
		function addHiddenInputTag_submit(_form, _type) {
			//var form = document.forms['frm1'];
			//document.getElementById("frm1").submit();
			
			addHiddenInputTagData( _form, "db_query_type", _type );
			_form.submit();
		}
		*/

		function add_query_info(_form, _type, datetime_full_from, datetime_full_to) {
			alert( "js: add_query_info(): form = " + _form.name + ", type = " + _type +
					", datetime_from = " + datetime_full_from + ", datetime_to = " + datetime_full_to );

			addHiddenInputTagData( _form, "db_query_type", _type );
			addHiddenInputTagData( _form, "reg_db_old_datetime_full_from", datetime_full_from );
			addHiddenInputTagData( _form, "reg_db_old_datetime_full_to", datetime_full_to );
			_form.submit();
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

<?
/*
		<form action="" method="post">
		<!--<form action="reserv_register_commit.php" method="post">-->
			<table border="0">
			<tr>
				<td> 날짜 </td>
			</tr>

			<tr>
				<td>
					<input readonly type="text" id="datepicker1" name="reg_date" size="10" value="<?echo $m_reg_date?>">
					<select name="timelist_hh" onchange="reg_get_timelist_hh(this)">
						<!--
						<option value="01">01</option> ~ <option value="12">12</option>
						-->

						<?
							for ( $i = 0; $i < 12; $i++ ) {
								$str = $i + 1;
								if ( $i < 9 )
									$str = "0" . $str;

								if ( $str == $m_reg_timelist_hh ) {
									echo '<option value="' . $str . '" selected>' . $str . "</option>";
								}
								else {
									// 24HR: 12 AM
									if ( $m_reg_timelist_hh == "00" ) {
										if ( $str == 12 )
											echo '<option value="' . $str . '" selected>' . $str . "</option>";
										else
											echo '<option value="' . $str . '">' . $str . "</option>";
									}
									else {
										echo '<option value="' . $str . '">' . $str . "</option>";
									}
								}
							}
						?>
					</select>

					<select name="timelist_mm" onchange="reg_get_timelist_mm(this)">
						<!--
						<option value="00">00</option> ~ <option value="59">59</option>
						-->

						<?
							for ( $i = 0; $i < 60; $i++ ) {
								$str = $i;
								if ( $i <= 9 )
									$str = "0" . $str;

								if ( $str == $m_reg_timelist_mm )
									echo '<option value="' . $str . '" selected>' . $str . "</option>";
								else
									echo '<option value="' . $str . '">' . $str . "</option>";
							}
						?>
					</select>

					<select name="reg_timelist_ampm" onchange="reg_get_timelist_ampm(this)">
						<!--
						<option value="am">오전</option>
						<option value="pm">오후</option>
						-->

						<?
							$time_AM = "am";
							$time_PM = "pm";
							if ( $m_reg_timelist_ampm == $time_AM )
								echo '<option value="am">오전</option>';
							else
								echo '<option value="pm">오후</option>';
						?>
					</select>
				</td>
<!--
			</tr>

			<tr>
-->
				<td> ~ </td>
<!--
			</tr>

			<tr>
-->
				<td>
					<input readonly type="text" id="datepicker2" name="reg_date_to" size="10" value="<?echo $m_reg_date?>">
					<select name="timelist_hh_to" onchange="reg_get_timelist_hh_to(this)">
						<!--
						<option value="01">01</option> ~ <option value="12">12</option>
						-->

						<?
							for ( $i = 0; $i < 12; $i++ ) {
								$str = $i + 1;
								if ( $i < 9 )
									$str = "0" . $str;

								if ( $str == $m_reg_timelist_hh_to ) {
									echo '<option value="' . $str . '" selected>' . $str . "</option>";
								}
								else {
									// 24HR: 12 AM
									if ( $m_reg_timelist_hh_to == "00" ) {
										if ( $str == 12 )
											echo '<option value="' . $str . '" selected>' . $str . "</option>";
										else
											echo '<option value="' . $str . '">' . $str . "</option>";
									}
									else {
										echo '<option value="' . $str . '">' . $str . "</option>";
									}
								}
							}
						?>
					</select>

					<select name="timelist_mm_to" onchange="reg_get_timelist_mm_to(this)">
						<!--
						<option value="00">00</option> ~ <option value="59">59</option>
						-->

						<?
							for ( $i = 0; $i < 60; $i++ ) {
								$str = $i;
								if ( $i <= 9 )
									$str = "0" . $str;

								if ( $str == $m_reg_timelist_mm_to )
									echo '<option value="' . $str . '" selected>' . $str . "</option>";
								else
									echo '<option value="' . $str . '">' . $str . "</option>";
							}
						?>
					</select>

					<select name="reg_timelist_ampm_to" onchange="reg_get_timelist_ampm_to(this)">
						<!--
						<option value="am">오전</option>
						<option value="pm">오후</option>
						-->

						<?
							$time_AM_to = "am";
							$time_PM_to = "pm";
							if ( $m_reg_timelist_ampm_to == $time_AM_to )
								echo '<option value="am">오전</option>';
							else
								echo '<option value="pm">오후</option>';
						?>
					</select>
				<td>

				<!--
				<input type="button" value="확인" onClick="chk_reg_datetime(this.form)">
				-->
			</tr>
			</table>

<!--
			<table border="0">
			<tr>
				<td> 이름 </td> <td> <input type="text" name="reg_name" value="<?echo $m_reg_name?>"> </td>
			</tr>
			<tr>
				<td> 연락처 </td>
				<td>
					<input type="text" name="reg_phone1" size="3" maxlength="3" value="<?echo $m_reg_phone1?>">
					<input type="text" name="reg_phone2" size="4" maxlength="4" value="<?echo $m_reg_phone2?>">
					<input type="text" name="reg_phone3" size="4" maxlength="4" value="<?echo $m_reg_phone3?>">
				</td>
			</tr>
			</table>
-->

			<br>
			<input type="submit" value="수정">
			<input type="button" value="취소" onClick="init_page(this.form)">
			<input type="submit" value="삭제">
		</form>
*/
?>



	<!-- ======================================================================== -->
	<?
		if ( !$db )
			exit;

		$query = "select * from schedule";
		$query = $query . " where reg_id=\"$m_reg_user_id\"";
		//echo "reserv_register_modify: type = sel, query = " . "'" . $query . "'" . "<br>";

		$result = $db->select( $query );

		// result
		if ( $result ) {
			//echo "reserv_register_commit: result = " . $result[0][0] . "<br>";

			/*
			foreach ( $result as $a => $b ) {
				if ( $b ) {
					$record = "";

					foreach ( $b as $c => $d ) {
						$record = $record . $d . ", ";
					}

					echo "reserv_register_commit: result = [$a] = $record" . "<br>";
				}
			}
			*/

			// Optimization in PHP: $size and $size_j
			for ( $i = 0, $size = sizeof($result); $i < $size; $i++ ) {
				$record = "";
				$record_index = "";
				$record_datetime_from = "";
				$record_datetime_to = "";
				$datepicker_from = "";
				$datepicker_to = "";
				$cancel = 0;
				$done = 0;

				// record all
				// example: [0] = "1, test1, 테스트1, 010-1234-1678, 2013-11-15 10:00:00, 2013-11-15 11:00:00, 0, 0"
				/*
				for ( $j = 0, $size_j = sizeof($result[$i]); $j < $size_j; $j++ ) {
					if ( isset($result[$i][$j]) )
						$record = $record . $result[$i][$j] . ", ";
				}
				$record = substr_replace( $record, "", -2 );	// remove the last ','

				echo "reserv_register_commit: result = [$i] = $record" . "<br>";
				*/

				if ( isset($result[$i][0]) && isset($result[$i][4]) && isset($result[$i][5]) ) {
					$record_index = $result[$i][0];
					$record_datetime_from = $result[$i][4];
					$record_datetime_to = $result[$i][5];

					if ( isset($result[$i][6]) )
						$cancel = (int)$result[$i][6];
					if ( isset($result[$i][7]) )
						$done = (int)$result[$i][7];

					//\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_commit: result = datetime_from:
					//		$record_datetime_from, datetime_to: $record_datetime_to" );
				}
				else {
					\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: result error" );
					exit;
				}

				$datepicker_idx = ((int)$i > 0)? ((int)$i + 1) : 0;
				$datepicker_from = "auto_datepicker" . ((int)$datepicker_idx+1);
				$datepicker_to = "auto_datepicker" . ((int)$datepicker_idx+2);
				echo "
					<script type=\"text/javascript\">
						$(function() {
						  $( \"#$datepicker_from\" ).datepicker({
							dateFormat: 'yy-mm-dd'
						  });
						});

						$(function() {
						  $( \"#$datepicker_to\" ).datepicker({
							dateFormat: 'yy-mm-dd'
						  });
						});
					</script>
				";

				show_info( $record_index, $record_datetime_from, $record_datetime_to,
							$datepicker_from, $datepicker_to,
							$cancel, $done );
			}
		}
		else {
			\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "result = " . $result . ", size = " . sizeof($result) );
			\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: No data found" );
			exit;
		}


		function show_info($_idx, $_reg_datetime_from, $_reg_datetime_to,
							$datepicker_from, $datepicker_to, $cancel, $done) {
			list( $date_from, $date_time_from ) = explode( " ", $_reg_datetime_from );
			list( $date_to, $date_time_to ) = explode( " ", $_reg_datetime_to );

			$form_name = "form" . $_idx;
			$reg_idx = $_idx;
			$reg_date = $date_from; 
			$reg_timelist_hh = "";
			$reg_timelist_mm = "";
			$reg_timelist_ss = "";
			$reg_timelist_ampm = "";

			$reg_date_to = $date_to; 
			$reg_timelist_hh_to = "";
			$reg_timelist_mm_to = "";
			$reg_timelist_ss_to = "";
			$reg_timelist_ampm_to = "";

			list( $reg_timelist_hh, $reg_timelist_mm, $reg_timelist_ss )
				= explode( ":", $date_time_from);
			list( $reg_timelist_hh_to, $reg_timelist_mm_to, $reg_timelist_ss_to )
				= explode( ":", $date_time_to);

			$reg_timelist_hhmmss = "";
			$reg_timelist_hhmmss_to = "";
			{
				//$reg_timelist_hh = "12";
				//$reg_timelist_mm = "10";
				//$reg_timelist_ampm = "am";

				if ( (int)$reg_timelist_hh > 12 ) {
					$reg_timelist_ampm = "pm";
					$reg_timelist_hh = ((int)$reg_timelist_hh - 12);
				}
				else {
					$reg_timelist_ampm = "am";
					if ( $reg_timelist_hh == 00 ) {
						$reg_timelist_hh = "12";
					}
				}
				$reg_timelist_hhmmss = $reg_timelist_hh . ":" . $reg_timelist_mm . ":00";

				// -----

				//$reg_timelist_hh_to = "12";
				//$reg_timelist_mm_to = "10";
				//$reg_timelist_ampm_to = "am";

				if ( (int)$reg_timelist_hh_to > 12 ) {
					$reg_timelist_ampm_to = "pm";
					$reg_timelist_hh_to = ((int)$reg_timelist_hh_to - 12);
				}
				else {
					$reg_timelist_ampm_to = "am";
					if ( $reg_timelist_hh_to == 00 ) {
						$reg_timelist_hh_to = "12";
					}
				}
				$reg_timelist_hhmmss_to = $reg_timelist_hh_to . ":" . $reg_timelist_mm_to . ":00";

				//\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: time(24h) from = "
				//		. $reg_timelist_hhmmss );
				//\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify: time(24h) to = "
				//		. $reg_timelist_hhmmss_to );
			}

			/*
			\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "show_info(): [$_idx]: form name = $form_name" );
			\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "show_info(): [$_idx]: date_from = $date_from,
					date_time_from = $date_time_from" );
			\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "show_info(): [$_idx]: date_time_from: hh = $reg_timelist_hh,
					mm = $reg_timelist_mm, ss = $reg_timelist_ss, $reg_timelist_ampm" );
			\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "show_info(): [$_idx]: date_to = $date_to,
					date_time_to = $date_time_to " );
			\commons\log\logd( TAG_RESERV_REGISTER_MODIFY, "show_info(): [$_idx]: date_time_to: hh = $reg_timelist_hh_to,
					mm = $reg_timelist_mm_to, ss = $reg_timelist_ss_to, $reg_timelist_ampm_to" );
			*/

			echo "
				<!--<form action=\"\" method=\"post\" name=\"$form_name\">-->
				<form action=\"reserv_register_commit.php\" method=\"post\" name=\"$form_name\">
			";
			echo '
					<table border="0">
					<!--
					<tr>
						<td> 날짜 </td>
					</tr>
					-->

					<tr>
						<td>
			';
			echo "
							<input readonly type=\"text\" id=\"$datepicker_from\" name=\"reg_date\" size=\"10\" value=\"$reg_date\">
			";
			echo '
							<select name="reg_timelist_hh" onchange="reg_get_timelist_hh(this)">
								<!--
								<option value="01">01</option> ~ <option value="12">12</option>
								-->
			';

								{
									for ( $i = 0; $i < 12; $i++ ) {
										$str = $i + 1;
										if ( $i < 9 )
											$str = "0" . $str;

										if ( $str == $reg_timelist_hh ) {
											echo '<option value="' . $str . '" selected>' . $str . "</option>";
										}
										else {
											// 24HR: 12 AM
											if ( $reg_timelist_hh == "00" ) {
												if ( $str == 12 )
													echo '<option value="' . $str . '" selected>' . $str . "</option>";
												else
													echo '<option value="' . $str . '">' . $str . "</option>";
											}
											else {
												echo '<option value="' . $str . '">' . $str . "</option>";
											}
										}
									}
								}
			echo '
							</select>

							<select name="reg_timelist_mm" onchange="reg_get_timelist_mm(this)">
								<!--
								<option value="00">00</option> ~ <option value="59">59</option>
								-->
			';

								{
									for ( $i = 0; $i < 60; $i++ ) {
										$str = $i;
										if ( $i <= 9 )
											$str = "0" . $str;

										if ( $str == $reg_timelist_mm )
											echo '<option value="' . $str . '" selected>' . $str . "</option>";
										else
											echo '<option value="' . $str . '">' . $str . "</option>";
									}
								}
			echo '
							</select>

							<select name="reg_timelist_ampm" onchange="reg_get_timelist_ampm(this)">
								<!--
								<option value="am">오전</option>
								<option value="pm">오후</option>
								-->
			';

								{
									$time_AM = "am";
									$time_PM = "pm";
									if ( $reg_timelist_ampm == $time_AM ) {
										echo '<option value="am" selected>AM</option>';
										echo '<option value="pm">PM</option>';
									}
									else {
										echo '<option value="am">AM</option>';
										echo '<option value="pm" selected>PM</option>';
									}
								}
			echo "
							</select>
						</td>
		<!--
					</tr>

					<tr>
		-->
						<td> ~ </td>
		<!--
					</tr>

					<tr>
		-->

						<td>
							<input readonly type=\"text\" id=\"$datepicker_to\" name=\"reg_date_to\" size=\"10\" value=\"$reg_date_to\">
			";
			echo '
							<select name="reg_timelist_hh_to" onchange="reg_get_timelist_hh_to(this)">
								<!--
								<option value="01">01</option> ~ <option value="12">12</option>
								-->
			';

								{
									for ( $i = 0; $i < 12; $i++ ) {
										$str = $i + 1;
										if ( $i < 9 )
											$str = "0" . $str;

										if ( $str == $reg_timelist_hh_to ) {
											echo '<option value="' . $str . '" selected>' . $str . "</option>";
										}
										else {
											// 24HR: 12 AM
											if ( $reg_timelist_hh_to == "00" ) {
												if ( $str == 12 )
													echo '<option value="' . $str . '" selected>' . $str . "</option>";
												else
													echo '<option value="' . $str . '">' . $str . "</option>";
											}
											else {
												echo '<option value="' . $str . '">' . $str . "</option>";
											}
										}
									}
								}
			echo '
							</select>

							<select name="reg_timelist_mm_to" onchange="reg_get_timelist_mm_to(this)">
								<!--
								<option value="00">00</option> ~ <option value="59">59</option>
								-->
			';

								{
									for ( $i = 0; $i < 60; $i++ ) {
										$str = $i;
										if ( $i <= 9 )
											$str = "0" . $str;

										if ( $str == $reg_timelist_mm_to )
											echo '<option value="' . $str . '" selected>' . $str . "</option>";
										else
											echo '<option value="' . $str . '">' . $str . "</option>";
									}
								}
			echo '
							</select>

							<select name="reg_timelist_ampm_to" onchange="reg_get_timelist_ampm_to(this)">
								<!--
								<option value="am">오전</option>
								<option value="pm">오후</option>
								-->
			';

								{
									$time_AM_to = "am";
									$time_PM_to = "pm";
									if ( $reg_timelist_ampm_to == $time_AM_to ) {
										echo '<option value="am" selected>AM</option>';
										echo '<option value="pm">PM</option>';
									}
									else {
										echo '<option value="am">AM</option>';
										echo '<option value="pm" selected>PM</option>';
									}
								}
			echo "
							</select>
						</td>
			";
						if ( $cancel == 1 ) {
			echo "		<td> cancelled </td>
			";
						}
						else {
			echo "
						<td>
							<!--
							<input type=\"button\" value=\"확인\" onClick=\"chk_reg_datetime(this.form)\">
							-->

							<!--<input type=\"submit\" value=\"수정\">-->
							<!--<input type=\"button\" value=\"취소\" onClick=\"init_page(this.form)\">-->
							<!--<input type=\"submit\" value=\"삭제\">-->


							<input type=\"button\" value=\"Edit\" onClick=\"add_query_info(this.form,
									'modify', '$_reg_datetime_from', '$_reg_datetime_to')\">
							<input type=\"button\" value=\"Delete\" onClick=\"add_query_info(this.form,
									'del', '$_reg_datetime_from', '$_reg_datetime_to')\">
						</td>
			";
						}
			echo "
					</tr>
					</table>
				</form>
			";
		}	// show_info()
	?>
</body>
</html>

