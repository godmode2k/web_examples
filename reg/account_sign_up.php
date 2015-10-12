<?
	echo "----------------------" . "<br>";
	echo "account_sign_up.php" . "<br>";
	echo "----------------------" . "<br>";

	session_start();

	include_once "include/commons.php";

	//$TAG = "account_sign_up.php";
	echo "----------------------" . "<br>";



	//\commons\log\logd( TAG_ACCOUNT_SIGN_UP, "account_sign_up: login = " . $m_reg_login );
	//\commons\log\logd( TAG_ACCOUNT_SIGN_UP, "account_sign_up: session login = " . $_SESSION['logged_in'] );
	//\commons\log\logd( TAG_ACCOUNT_SIGN_UP, "account_sign_up: session user_id = " . $_SESSION['user_id'] );



	echo "<hr>";
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
	<form action="account_commit.php" method="post">
		<table border="0">
		<tr>
			<td> ID </td>
			<td> <input type="text" name="reg_login_id"> </td>
		</tr>

		<tr>
			<td> Password </td>
			<td> <input type="password" maxlength="8" name="reg_login_passwd"
						onchange="onVerifyPasswd('reg_login_passwd', 'reg_login_passwd_verify',
							'id_reg_login_passwd_verify', 8)"> </td>
			<td> (8 length) </td>
		</tr>
		<tr>
			<td> Confirm password </td>
			<td> <input type="password" maxlength="8" name="reg_login_passwd_verify"
						onchange="onVerifyPasswd('reg_login_passwd', 'reg_login_passwd_verify',
							'id_reg_login_passwd_verify', 8)"> </td>
			<td> (8 length) </td>
		</tr>
		<tr>
			<td></td>
			<td>
				<b><span id="id_reg_login_passwd_verify" style='text-decoration: none; color: #ED9247;'></span></b>
			</td>
		</tr>

		<tr>
			<td> Name </td>
			<td> <input type="text" name="reg_login_name"> </td>
		</tr>

		<tr>
			<td> Email </td>
			<td> <input type="text" name="reg_login_email"
						onchange="onVerifyEmail('reg_login_email', 'reg_login_email_verify',
							'id_reg_login_email_verify')"> </td>
		</tr>

		<tr>
			<td> Confirm email</td>
			<td> <input type="text" name="reg_login_email_verify"
						onchange="onVerifyEmail('reg_login_email', 'reg_login_email_verify',
							'id_reg_login_email_verify')"> </td>
		</tr>
		<tr>
			<td></td>
			<td>
				<b><span id="id_reg_login_email_verify" style='text-decoration: none; color: #ED9247;'></span></b>
			</td>
		</tr>

		<tr>
			<!--
			<td> Phone </td> <td> <input type="text" name="reg_login_phone"> </td>
			-->

			<td> Phone </td>
			<td>
				<select name="reg_login_phone_num_1">
					<option value="010">010</option>
					<option value="0xx">0xx</option>
				</select>
				<input type="text" size="3" maxlength="4" name="reg_login_phone_num_2"
						onchange="onVerifyNumber('reg_login_phone_num_2', 4)">
				-
				<input type="text" size="3" maxlength="4" name="reg_login_phone_num_3"
						onchange="onVerifyNumber('reg_login_phone_num_3', 4)">
			</td>
		</tr>

		<!--
		<tr>
			<td> Authentication code </td>
			<td> <input type="text" name="reg_login_auth_code"> </td>
		</tr>
		-->


		<tr>
			<td> <input type="submit" value="Submit"> </td>
		</tr>
		</table>
	</form>

	<!--
	<form action="account_commit.php" method="post">
		<table border="0">
		<tr>
			<td> authentication url </td>
			<td> <input type="text" name="reg_login_auth_url"> </td>
		</tr>
		</table>
	</form>
	-->
</body>
</html>

