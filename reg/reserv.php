<?
	session_start();

	include_once "include/commons.php";

	\commons\log\_echo( "----------------------" );
	\commons\log\_echo( "reserv.php" );
	\commons\log\_echo( "----------------------" );

	include_once "include/auth.php";

	\commons\log\_echo( "----------------------" );



	// Session data {
	//$m_reg_user_uid = $_SESSION['user_uid'];
	$m_reg_user_id = $_SESSION['user_id'];
	$m_reg_user_name = $_SESSION['user_name'];
	//$m_reg_user_passwd = $_SESSION['user_passwd'];
	$m_reg_user_email = $_SESSION['user_email'];
	$m_reg_user_phone = $_SESSION['user_phone'];
	//$m_reg_user_last_reg_datetime_full_from = $_SESSION['user_last_reg_datetime_full_from'];
	//$m_reg_user_last_reg_datetime_full_to = $_SESSION['user_last_reg_datetime_full_to'];
	//$m_reg_user_last_reg_date_from = $_SESSION['user_last_reg_date_from'];
	//$m_reg_user_last_reg_datetime_from = $_SESSION['user_last_reg_datetime_from'];
	//$m_reg_user_last_reg_date_to = $_SESSION['user_last_reg_date_to'];
	//$m_reg_user_last_reg_datetime_to = $_SESSION['user_last_reg_datetime_to'];
	// }


	\commons\log\logd( TAG_RESERV, "reserv: login = " . $m_reg_login );
	\commons\log\logd( TAG_RESERV, "reserv: session login = " . $_SESSION['logged_in'] );
	\commons\log\logd( TAG_RESERV, "reserv: session user_id = " . $_SESSION['user_id'] . ", " . $m_reg_user_id );
	\commons\log\logd( TAG_RESERV, "reserv: session user_name = " . $_SESSION['user_name'] . ", " . $m_reg_user_name );
	\commons\log\logd( TAG_RESERV, "reserv: session user_email = " . $_SESSION['user_email'] . ", " . $m_reg_user_email );
	\commons\log\logd( TAG_RESERV, "reserv: session user_phone = " . $_SESSION['user_phone'] . ", " . $m_reg_user_phone );



	//echo "<hr>";
	\commons\log\_echo( "<hr>" );
?>



<!DOCTYPE HTML>
<html>
<head>
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

	<script language='JavaScript'>
		function init_page(form) {
			alert( "init_page()" );
			//history.back();
			history.go( -1 );
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
	</script>
</head>

<body>
	<div id="menu_top" style="background-color: #FFD700; height: 40px; width: 90%; float: left;" align="center">
		<table>
			<td> <b><a style="text-decoration: none" href="reserv.php">예약</a></b> </td>
			<td> <b>|</b> </td>
			<td> <b><a style="text-decoration: none" href="reserv_register_modify.php">관리</a></b> </td>
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
						echo '<b><a style="text-decoration: none" href="logout.php">로그아웃</a></b>';
					}
					else {
						echo '<b><a style="text-decoration: none" href="login.php">로그인</a></b>';
					}
				?>
			</td>
		</table>
	</div>
	<br><br><br>

	<form action="reserv_register_commit.php" method="post">
		<table border="0">
		<tr>
			<td> 날짜 </td>
		</tr>

		<tr>
			<td>
				<input readonly type="text" id="datepicker1" name="reg_date" size="10" value="<?echo date('Y-m-d');?>">
				<select name="reg_timelist_hh">
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>

				<select name="reg_timelist_mm">
					<option value="00">00</option>

					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>

					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>

					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>

					<option value="30">30</option>
					<option value="31">31</option>
					<option value="32">32</option>
					<option value="33">33</option>
					<option value="34">34</option>
					<option value="35">35</option>
					<option value="36">36</option>
					<option value="37">37</option>
					<option value="38">38</option>
					<option value="39">39</option>

					<option value="40">40</option>
					<option value="41">41</option>
					<option value="42">42</option>
					<option value="43">43</option>
					<option value="44">44</option>
					<option value="45">45</option>
					<option value="46">46</option>
					<option value="47">47</option>
					<option value="48">48</option>
					<option value="49">49</option>

					<option value="50">50</option>
					<option value="51">51</option>
					<option value="52">52</option>
					<option value="53">53</option>
					<option value="54">54</option>
					<option value="55">55</option>
					<option value="56">56</option>
					<option value="57">57</option>
					<option value="58">58</option>
					<option value="59">59</option>
				</select>

				<select name="reg_timelist_ampm">
					<option value="am">오전</option>
					<option value="pm">오후</option>
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
				<input readonly type="text" id="datepicker2" name="reg_date_to" size="10" value="<?echo date('Y-m-d');?>">
				<select name="reg_timelist_hh_to">
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>

				<select name="reg_timelist_mm_to">
					<option value="00">00</option>

					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>

					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>

					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>

					<option value="30">30</option>
					<option value="31">31</option>
					<option value="32">32</option>
					<option value="33">33</option>
					<option value="34">34</option>
					<option value="35">35</option>
					<option value="36">36</option>
					<option value="37">37</option>
					<option value="38">38</option>
					<option value="39">39</option>

					<option value="40">40</option>
					<option value="41">41</option>
					<option value="42">42</option>
					<option value="43">43</option>
					<option value="44">44</option>
					<option value="45">45</option>
					<option value="46">46</option>
					<option value="47">47</option>
					<option value="48">48</option>
					<option value="49">49</option>

					<option value="50">50</option>
					<option value="51">51</option>
					<option value="52">52</option>
					<option value="53">53</option>
					<option value="54">54</option>
					<option value="55">55</option>
					<option value="56">56</option>
					<option value="57">57</option>
					<option value="58">58</option>
					<option value="59">59</option>
				</select>

				<select name="reg_timelist_ampm_to">
					<option value="am">오전</option>
					<option value="pm">오후</option>
				</select>
			</td>

			<td>
				<input type="submit" value="예약">
				<?
					set_parcel_post();
					set_query_type_post( "ins" );
				?>
			</td>

			<!--
			<input type="button" onClick="chk_reg(this.form)" value="확인">
			-->
		</tr>
<!--
		<tr>
			<td> 이름 </td> <td> <input readonly type="text" name="reg_name" value="<?echo $m_reg_user_id ?>"> </td>
		</tr>
		<tr>
			<td> 연락처 </td>
			<td>
				<input type="text" name="reg_phone1" size="3" maxlength="3">
				<input type="text" name="reg_phone2" size="4" maxlength="4">
				<input type="text" name="reg_phone3" size="4" maxlength="4">
			</td>
		</tr>
-->
		</table>

<?
/*
		<input type="submit" value="예약">
		<?
			set_parcel_post();
			set_query_type_post( "ins" );
		?>
*/
?>
		<!--
		<input type="button" onClick="init_page(this.form)" value="취소">
		-->
	</form>
</body>
</html>

