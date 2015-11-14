<?
	session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "account_info.php" );
	\commons\log\_echo( "----------------------" );

	$_SESSION['reg_get_account_info'] = true;

	include_once "include/auth.php";

	\commons\log\_echo( "----------------------" );


	unset( $_SESSION['reg_get_account_info'] );


	//\commons\log\logd( TAG_ACCOUNT_INFO, "account_info: login = " . $m_reg_login );
	//\commons\log\logd( TAG_ACCOUNT_INFO, "account_info: session login = " . $_SESSION['logged_in'] );
	//\commons\log\logd( TAG_ACCOUNT_INFO, "account_info: session user_id = " . $_SESSION['user_id'] );

	$m_reg_user_id = $_SESSION['user_id'];
	$m_reg_user_name = $_SESSION['user_name'];
	//$m_reg_user_passwd = $_SESSION['user_passwd'];
	$m_reg_user_email = $_SESSION['user_email'];
	$m_reg_user_phone = $_SESSION['user_phone'];


	///*
	// For Mobile
	if ( \commons\util\non_browser_agent() ) {
		$result = get_account_info( $db, $m_reg_user_id );

		if ( empty($result) ) {
			//echo( "<b>NO DATA found...</b> <br> </body> </html>" );
			\commons\response\json_ro( JSON_RESULT_FAIL );
			exit;
		}

		$account_info_id = $result[0][1];
		$account_info_name = $result[0][2];
		//$account_info_passwd = $result[0][3];
		$account_info_email = $result[0][4];
		$account_info_phone = $result[0][5];
		
		//$account_info_phone_1 = substr( $account_info_phone, 0, 3 );
		//$account_info_phone_2 = substr( $account_info_phone, 4, 4 );
		//$account_info_phone_3 = substr( $account_info_phone, 9 );

		$json_data = Array();
		if ( is_array($json_data) ) {
			$json_data[JSON_RESULT] = JSON_RESULT_SUCCESS;
			$json_data[JSON_ACCOUNT_INFO_ID] = $account_info_id;
			$json_data[JSON_ACCOUNT_INFO_NAME] = $account_info_name;
			$json_data[JSON_ACCOUNT_INFO_EMAIL] = $account_info_email;
			$json_data[JSON_ACCOUNT_INFO_PHONE] = $account_info_phone;
			\commons\response\json_array( $json_data );
		}

		exit;
	}
	//*/


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

	<script type="text/javascript" src="js/util.js"></script>
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
	$result = get_account_info( $db, $m_reg_user_id );

	if ( empty($result) ) {
		echo( "<b>NO DATA found...</b> <br> </body> </html>" );
		exit;
	}

	$account_info_id = $result[0][1];
	$account_info_name = $result[0][2];
	//$account_info_passwd = $result[0][3];
	$account_info_email = $result[0][4];
	$account_info_phone = $result[0][5];
	
	$account_info_phone_1 = substr( $account_info_phone, 0, 3 );
	$account_info_phone_2 = substr( $account_info_phone, 4, 4 );
	$account_info_phone_3 = substr( $account_info_phone, 9 );
	//\commons\log\logd( TAG_ACCOUNT_INFO, "phone = " . $account_info_phone );
	//\commons\log\logd( TAG_ACCOUNT_INFO, "phone 1 = " . $account_info_phone_1 );
	//\commons\log\logd( TAG_ACCOUNT_INFO, "phone 2 = " . $account_info_phone_2 );
	//\commons\log\logd( TAG_ACCOUNT_INFO, "phone 3 = " . $account_info_phone_3 );
	//echo( "<br><br><br" );

	echo( "
	<form action=\"account_info_commit.php\" method=\"post\">
		<table border=\"0\">

		<tr>
			<td> ID </td>
			<!--<td> <input type=\"text\" name=\"reg_login_id\" value=\"$account_info_id\"> </td>-->
			<td> $account_info_id </td>
		</tr>

		<tr>
			<td> Current password </td>
			<td> <input type=\"password\" maxlength=\"8\" name=\"reg_login_passwd_old\"
							onchange=\"onVerifyPasswdLength('reg_login_passwd_old', 'reg_login_passwd_new',
								'id_reg_login_passwd_verify', 8)\"> </td>
			<td> (8 length) </td>
		</tr>
		<tr>
			<td> New password </td>
			<td> <input type=\"password\" maxlength=\"8\" name=\"reg_login_passwd_new\"
							onchange=\"onVerifyPasswdLength('reg_login_passwd_old', 'reg_login_passwd_new',
								'id_reg_login_passwd_verify', 8)\"> </td>
			<td> (8 length) </td>
		</tr>
		<tr>
			<td></td>
			<td>
				<b><span id=\"id_reg_login_passwd_verify\" style='text-decoration: none; color: #ED9247;'></span></b>
			</td>
		</tr>

		<tr>
			<td> Name </td>
			<td> <input type=\"text\" name=\"reg_login_name\" value=\"$account_info_name\"> </td>
		</tr>

		<tr>
			<td> email </td>
			<td> <input type=\"text\" name=\"reg_login_email\" value=\"$account_info_email\"
							onchange=\"onVerifyEmail('reg_login_email', 'reg_login_email_verify',
								'id_reg_login_email_verify')\"> </td>
		</tr>
		<tr>
			<td> Confirm email</td>
			<td> <input type=\"text\" name=\"reg_login_email_verify\"
							onchange=\"onVerifyEmail('reg_login_email', 'reg_login_email_verify',
								'id_reg_login_email_verify')\"> </td>
		</tr>
		<tr>
			<td></td>
			<td>
				<b><span id=\"id_reg_login_email_verify\" style='text-decoration: none; color: #ED9247;'></span></b>
			</td>
		</tr>

		<tr>
			<!--
			<td> Phone </td> <td> <input type=\"text\" name=\"reg_login_phone\"> </td>
			-->

			<td> Phone </td>
			<td>
				<select name=\"reg_login_phone_num_1\">
					<!-- TODO: -->
					<!-- <option value=\"010\" <? if ( $account_info_phone_1 == \"010\" ) echo \"selected\" ?>>010</option> -->
					<option value=\"010\" selected>010</option>
					<option value=\"0xx\">0xx</option>
				</select>
				<input type=\"text\" size=\"3\" maxlength=\"4\" name=\"reg_login_phone_num_2\" value=\"$account_info_phone_2\"
						onchange=\"onVerifyNumber('reg_login_phone_num_2', 4)\">
				-
				<input type=\"text\" size=\"3\" maxlength=\"4\" name=\"reg_login_phone_num_3\" value=\"$account_info_phone_3\"
						onchange=\"onVerifyNumber('reg_login_phone_num_3', 4)\">
			</td>
		</tr>

		<tr>
			<td> <input type=\"submit\" value=\"Done\"> </td>
		</tr>
		</table>
	</form>
	" );

	echo( "
	<form action=\"account_remove_commit.php\" method=\"post\">
		<table border=\"0\">
		<tr>
			<td> Current password </td>
			<td> <input type=\"password\" maxlength=\"8\" name=\"reg_login_passwd_remove\"> </td>
		</tr>

		<tr>
			<td> <input type=\"submit\" value=\"Remove\"> </td>
		</tr>
		</table>
	</form>
	" );
?>

</body>
</html>

