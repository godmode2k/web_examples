<?
/* --------------------------------------------------------------
Project:	Authentication
Purpose:	All stuffs with an Authentication
Author:		Ho-Jung Kim (godmode2k@hotmail.com)
Date:		Since November 16, 2013
Filename:	auth.php

Last modified: Nov 13, 2015
License:

*
* Copyright (C) 2014 Ho-Jung Kim (godmode2k@hotmail.com)
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*      http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*
-----------------------------------------------------------------
Note:
-----------------------------------------------------------------
-------------------------------------------------------------- */



include_once "commons.php";
require_once "mysql.php";

//$TAG = "auth.php";



// namespace test
//\commons\log\logd( "AUTH", "first msg..." );
//\commons\log\logd2( "AUTH", "GLOBAL", "first msg..." );
//\commons\util\non_browser_agent();


global $db;



function set_parcel_post() {
	//\commons\log\logd( TAG_AUTH, "auth: set_parcel_post()" );

	foreach ( $_POST as $a => $b ) {
		echo "<input type='hidden' name='" . htmlentities($a) . "' value='" . htmlentities($b) . "'>";
	}
}

function add_data_post($name, $val) {
	echo "<input type='hidden' name='" . $name . "' value='" . $val . "'>";
}

function set_query_type_post($val) {
	$post_name = "db_query_type";

	if ( $val == "ins" ) {
		add_data_post( $post_name, $val );
	}
	else if ( $val == "del" ) {
		add_data_post( $post_name, $val );
	}
	else if ( $val == "modify" ) {
		add_data_post( $post_name, $val );
	}
}

function session_clear($location, $_exit) {
	unset( $_POST );
	$_POST = array();

	unset( $_SESSION['reg_new_account'] );
	unset( $_SESSION['reg_confirm_account'] );
	unset( $_SESSION['reg_confirm_account_done'] );
	unset( $_SESSION['reg_remove_account'] );
	unset( $_SESSION['reg_edit_account'] );

	unset( $_SESSION['logged_in'] );
	unset( $_SESSION['user_uid'] );
	unset( $_SESSION['user_id'] );
	unset( $_SESSION['user_name'] );
	unset( $_SESSION['user_passwd'] );
	unset( $_SESSION['user_email'] );
	unset( $_SESSION['user_phone'] );
	unset( $_SESSION['user_lock'] );
	unset( $_SESSION['user_last_reg_datetime_full_from'] );
	unset( $_SESSION['user_last_reg_datetime_full_to'] );
	unset( $_SESSION['user_last_reg_date_from'] );
	unset( $_SESSION['user_last_reg_datetime_from'] );
	unset( $_SESSION['user_last_reg_date_to'] );
	unset( $_SESSION['user_last_reg_datetime_to'] );
	session_destroy();

	if ( $location ) {
		header( "Location: " . $location );
	}

	if ( $_exit ) {
		exit;
	}
}

function link_page($location) {
	if ( $location ) {
		header( "Location: " . $location );
	}

	exit;
}



// -----------------------------------------------



{
	// Session info
	if ( !$_SESSION['logout'] ) {
		\commons\log\logd( TAG_AUTH, "auth: result: session login = " . $_SESSION['logged_in'] );
		\commons\log\logd( TAG_AUTH, "auth: result: login = " . $m_reg_login );
		\commons\log\logd( TAG_AUTH, "auth: result: new account = " . $_SESSION['reg_new_account'] );


		//! Confirm an account
		// -----------------------------------------------


		if ( $_SESSION['reg_confirm_account'] ) {
			\commons\log\logd( TAG_AUTH, "auth: [+] trying to confirm a new account" );

			{
				$id = $_GET['id'];
				$auth = $_GET['auth'];

				//\commons\log\logd( TAG_AUTH, "id = " . $id . ", auth = " . $auth );

				// confirm
				if ( account_confirm($db, $id, $auth) ) {
					$_SESSION['reg_confirm_account_done'] = true;
					header( 'Location: account_confirm.php' );
				}
			}

			unset( $_SESSION['reg_confirm_account'] );
			exit;
		}


		//! Confirm an account done
		// -----------------------------------------------


		if ( $_SESSION['reg_confirm_account_done'] ) {
			\commons\log\logd( TAG_AUTH, "auth: [+] confirm a new account done" );
			unset( $_SESSION['reg_confirm_account_done'] );
			exit;
		}


		//! Create an account 
		// -----------------------------------------------


		if ( $_SESSION['reg_new_account'] ) {
			\commons\log\logd( TAG_AUTH, "auth: [+] trying to create an account" );

			{
				$id = $_POST['reg_login_id'];
				$passwd = $_POST['reg_login_passwd'];
				$name = $_POST['reg_login_name'];
				$email = $_POST['reg_login_email'];
				$phone_num_1 = $_POST['reg_login_phone_num_1'];
				$phone_num_2 = $_POST['reg_login_phone_num_2'];
				$phone_num_3 = $_POST['reg_login_phone_num_3'];
				$phone_num = $phone_num_1 . "-" . $phone_num_2 . "-" . $phone_num_3;
				///*
				// For Mobile
				if ( \commons\util\non_browser_agent() ) {
					$phone_num = $_POST['reg_login_phone'];
				}
				//*/

				//$auth_code = $_POST['reg_login_auth_code'];

				\commons\log\logd( TAG_AUTH, "auth: {" );
				\commons\log\logd( TAG_AUTH, "    id = " . $id );
				\commons\log\logd( TAG_AUTH, "    password = " . $passwd );
				\commons\log\logd( TAG_AUTH, "    name = " . $name );
				\commons\log\logd( TAG_AUTH, "    email = " . $email );
				\commons\log\logd( TAG_AUTH, "    phone number = " . $phone_num );
				\commons\log\logd( TAG_AUTH, "}" );
				$result = account_register( $db, $id, $passwd, $name, $email, $phone_num );

				if ( !$result ) {
					\commons\log\logd( TAG_AUTH, "Account created [FALSE]" );
					exit;
				}

				\commons\log\logd( TAG_AUTH, "Account created [TRUE]" );

				//$_SESSION['reg_new_account'] = "n";
				//session_clear( "login.php", true );
			}
		}


		//! Remove an account
		// -----------------------------------------------


		if ( $_SESSION['reg_remove_account'] ) {
			\commons\log\logd( TAG_AUTH, "auth: [+] trying to remove an account" );

			{
				$id = $_SESSION['user_id'];
				$passwd = $_POST['reg_login_passwd_remove'];

				\commons\log\logd( TAG_AUTH, "id = " . $id . ", password = " . $passwd );

				$result = account_remove( $db, $id, $passwd );

				if ( !$result ) {
					\commons\log\logd( TAG_AUTH, "Removed [FALSE]" );

					///*
					// For Mobile
					if ( \commons\util\non_browser_agent() ) {
						\commons\response\json_ro( JSON_RESULT_FAIL );
					}
					//*/

					exit;
				}

				\commons\log\logd( TAG_AUTH, "Removed [TRUE]" );

				///*
				// For Mobile
				if ( \commons\util\non_browser_agent() ) {
					\commons\response\json_ro( JSON_RESULT_SUCCESS );
					session_clear( null, false );
					exit;
				}
				//*/
			}

			session_clear( PAGE__LOGIN, true );
			exit;
		}


		//! Edit an account information
		// -----------------------------------------------


		if ( $_SESSION['reg_edit_account'] ) {
			\commons\log\logd( TAG_AUTH, "auth: [+] trying to edit an account" );

			{
				//$id = $_POST['reg_login_id'];
				$id = $_SESSION['user_id'];
				$passwd_old = $_POST['reg_login_passwd_old'];
				$passwd_new = $_POST['reg_login_passwd_new'];
				$name = $_POST['reg_login_name'];
				$email = $_POST['reg_login_email'];
				$phone_num_1 = $_POST['reg_login_phone_num_1'];
				$phone_num_2 = $_POST['reg_login_phone_num_2'];
				$phone_num_3 = $_POST['reg_login_phone_num_3'];
				$phone_num = $phone_num_1 . "-" . $phone_num_2 . "-" . $phone_num_3;
				///*
				// For Mobile
				if ( \commons\util\non_browser_agent() ) {
					$phone_num = $_POST['reg_login_phone'];
				}
				//*/

				//$auth_code = $_POST['reg_login_auth_code'];

				\commons\log\logd( TAG_AUTH, "auth: {" );
				\commons\log\logd( TAG_AUTH, "    id = " . $id );
				//\commons\log\logd( TAG_AUTH, "   password(old) = " . $passwd_old );
				//\commons\log\logd( TAG_AUTH, "   password(new) = " . $passwd_new );
				\commons\log\logd( TAG_AUTH, "   name = " . $name );
				\commons\log\logd( TAG_AUTH, "   email = " . $email );
				\commons\log\logd( TAG_AUTH, "   phone number = " . $phone_num );
				\commons\log\logd( TAG_AUTH, "}" );

				$result = account_edit( $db, $id, $passwd_old, $passwd_new, $name, $email, $phone_num );

				if ( !$result ) {
					\commons\log\logd( TAG_AUTH, "Account edited [FALSE]" );

					unset( $_SESSION['reg_edit_account'] );

					///*
					// For Mobile
					if ( \commons\util\non_browser_agent() ) {
						\commons\response\json_ro( JSON_RESULT_FAIL );
					}
					//*/

					exit;
				}

				\commons\log\logd( TAG_AUTH, "Account edited [TRUE]" );

				unset( $_SESSION['reg_edit_account'] );
				get_user_info( $db, $id );

				///*
				// For Mobile
				if ( \commons\util\non_browser_agent() ) {
					$json_data = Array();
					if ( is_array($json_data) ) {
						$json_data[JSON_RESULT] = JSON_RESULT_SUCCESS;
						$json_data[JSON_ACCOUNT_INFO_ID] = $id;
						$json_data[JSON_ACCOUNT_INFO_NAME] = $name;
						$json_data[JSON_ACCOUNT_INFO_EMAIL] = $email;
						$json_data[JSON_ACCOUNT_INFO_PHONE] = $phone_num;
						\commons\response\json_array( $json_data );
					}

					//\commons\response\json_ro( JSON_RESULT_SUCCESS );
					exit;
				}
				//*/

				link_page( PAGE__HOME );
				exit;
			}
		}


		//! Login
		// -----------------------------------------------


		//if ( empty($_SESSION['logged_in']) || !$m_reg_login ) {
		if ( empty($_SESSION['logged_in']) ) {
			\commons\log\logd( TAG_AUTH, "auth: trying to login" );
			$m_reg_login_id = $_POST['reg_login_id'];
			$m_reg_login_passwd = $_POST['reg_login_passwd'];
			$m_reg_login = false;
			\commons\log\logd( TAG_AUTH, "auth: id = " . $m_reg_login_id . ", password = " . $m_reg_login_passwd );

			if ( !$m_reg_login_id || !$m_reg_login_passwd ) {
				\commons\log\logd( TAG_AUTH, "Invalid login (id/password == NULL)" );
				header( 'Location: login.php' );
				exit;
			}

			/*
			$m_reg_login = chk_login( $db, $m_reg_login_id, $m_reg_login_passwd );
			if ( !$m_reg_login ) {
				\commons\log\logd( TAG_AUTH, "auth: result: wrong id/password or locked" . $m_reg_login );
				header( 'Location: login.php' );
				exit;
			}
			*/


			$result = chk_login( $db, $m_reg_login_id, $m_reg_login_passwd );

			$m_reg_login = (isset($result) && $result >= 0)? true : false;
			\commons\log\logd( TAG_AUTH, "auth: result: result = " . $result . ", login = " . $m_reg_login );

			switch ( $result ) {
				case RET__SUCCESS:
					{
					} break;
				case ERR__LOGIN__ID_PASSWD:
					{
						\commons\log\logd( TAG_AUTH, "auth: result: wrong id/password or locked" . $m_reg_login );
						//header( 'Location: login.php' );


						///*
						{
							// For Mobile
							if ( \commons\util\non_browser_agent() ) {
								\commons\response\json_ro( JSON_RESULT_FAIL );
							}
							else {
								header( 'Location: login.php' );
							}
						}
						//*/

						exit;
					} break;
				case ERR__LOGIN__LOCKED:
					{
						\commons\log\logd( TAG_AUTH, "auth: result: locked" );
						$auth = account_get_auth( $db, $m_reg_login_id );
						$_GET['id'] = $m_reg_login_id;
						$_GET['auth'] = $auth;
						\commons\log\logd( TAG_AUTH, "auth: result: auth = " . $auth );
						header( "Location: account_confirm_url.php?id=" . $m_reg_login_id . "&auth=" . $auth );


						/*
						{
							// For Mobile
							if ( \commons\util\non_browser_agent() ) {
								\commons\response\json_rkv( JSON_RESULT_FAIL, JSON_LOGIN_LOCKED, JSON_RESULT_TRUE );
								//JSON_LOGIN_CONFIRM_URL
								$json_data = Array();
								if ( is_array($json_data) ) {
									$confirm_url = "Location: account_confirm_url.php?id="
													. $m_reg_login_id . "&auth=" . $auth;
									$json_data[JSON_RESULT] = JSON_RESULT_SUCCESS;
									$json_data[JSON_LOGIN_LOCKED] = JSON_RESULT_SUCCESS;
									$json_data[JSON_LOGIN_CONFIRM_URL] = $confirm_url;
									\commons\response\json_array( $json_data );
								}
							}
						}
						*/

						exit;
					} break;
				default:
					{
						\commons\log\logd( TAG_AUTH, "auth: result: unknown error" );
						//header( 'Location: login.php' );


						///*
						{
							// For Mobile
							if ( \commons\util\non_browser_agent() ) {
								\commons\response\json_ro( JSON_RESULT_UNKNOWN );
							}
							else {
								header( 'Location: login.php' );
							}
						}
						//*/

						exit;
					} break;
			}


			\commons\log\logd( TAG_AUTH, "auth: get user info" );
			//$m_reg_user_uid = null;
			$m_reg_user_id = null;
			$m_reg_user_name = null;
			//$m_reg_user_passwd = null;
			$m_reg_user_email = null;
			$m_reg_user_phone = null;
			//$m_reg_user_lock = 1;
			//$m_reg_user_auth = null;
			$m_reg_user_last_reg_datetime_full_from = null;		// 2013-11-15 10:00:00
			$m_reg_user_last_reg_datetime_full_to = null;
			$m_reg_user_last_reg_date_from = null; 
			$m_reg_user_last_reg_datetime_from = null; 
			$m_reg_user_last_reg_date_to = null; 
			$m_reg_user_last_reg_datetime_to = null; 
			if ( get_user_info($db, $_POST['reg_login_id']) ) {
				//$m_reg_user_uid = $_SESSION['user_uid'];
				//$m_reg_user_id = $_SESSION['user_id'];
				$m_reg_user_name = $_SESSION['user_name'];
				//$m_reg_user_passwd = $_SESSION['user_passwd'];
				$m_reg_user_email = $_SESSION['user_email'];
				$m_reg_user_phone = $_SESSION['user_phone'];
				//$m_reg_user_lock = $_SESSION['user_lock'];
				$m_reg_user_last_reg_datetime_full_from = $_SESSION['user_last_reg_datetime_full_from'];
				$m_reg_user_last_reg_datetime_full_to = $_SESSION['user_last_reg_datetime_full_to'];
				$m_reg_user_last_reg_date_from = $_SESSION['user_last_reg_date_from'];
				$m_reg_user_last_reg_datetime_from = $_SESSION['user_last_reg_datetime_from'];
				$m_reg_user_last_reg_date_to = $_SESSION['user_last_reg_date_to'];
				$m_reg_user_last_reg_datetime_to = $_SESSION['user_last_reg_datetime_to'];


				///*
				// For Mobile
				if ( \commons\util\non_browser_agent() ) {
					//\commons\response\json_ro( JSON_RESULT_SUCCESS );

					$json_data = Array();
					if ( is_array($json_data) ) {
						$json_data[JSON_RESULT] = JSON_RESULT_SUCCESS;
						$json_data[JSON_LOGIN] = JSON_RESULT_SUCCESS;
						$json_data[JSON_LOGIN_ALREADY] = JSON_RESULT_FALSE;
						$json_data[JSON_LOGIN_USER_NAME] = $_SESSION['user_name'];
						$json_data[JSON_LOGIN_USER_EMAIL] = $_SESSION['user_email'];
						$json_data[JSON_LOGIN_USER_PHONE] = $_SESSION['user_phone'];
						\commons\response\json_array( $json_data );
					}
				}
				//*/
			}
		}
		else {
			\commons\log\logd( TAG_AUTH, "auth: logged in already" );
			//if ( !$m_reg_login ) {
			//if ( empty($_SESSION['logged_in']) || !$m_reg_login ) {
			//if ( !isset($_SESSION['logged_in']) || !$m_reg_login ) {
			if ( !chk_login_already(true) || !$m_reg_login ) {
				\commons\log\logd( TAG_AUTH, "auth: " );
				//header( 'Location: login.php' );
				//exit;
			}


			///*
			// For Mobile
			if ( \commons\util\non_browser_agent() ) {
				//\commons\response\json_ro( JSON_RESULT_SUCCESS );

				if ( $_SESSION['reg_get_account_info'] ) {
					//! SEE: account_info page
					unset( $_SESSION['reg_get_account_info'] );
				}
				// ...
				else {
					$json_data = Array();
					if ( is_array($json_data) ) {
						$json_data[JSON_RESULT] = JSON_RESULT_SUCCESS;
						$json_data[JSON_LOGIN] = JSON_RESULT_SUCCESS;
						$json_data[JSON_LOGIN_ALREADY] = JSON_RESULT_SUCCESS;
						$json_data[JSON_LOGIN_USER_NAME] = $_SESSION['user_name'];
						$json_data[JSON_LOGIN_USER_EMAIL] = $_SESSION['user_email'];
						$json_data[JSON_LOGIN_USER_PHONE] = $_SESSION['user_phone'];
						\commons\response\json_array( $json_data );
					}
				}
			}
			//*/






		/*
			//$m_reg_user_uid = null;
			$m_reg_user_id = null;
			$m_reg_user_name = null;
			//$m_reg_user_passwd = null;
			//$m_reg_user_email = null;
			$m_reg_user_phone = null;
			//$m_reg_user_lock = 1;
			//$m_reg_user_auth = null;
			$m_reg_user_last_reg_datetime_full_from = null;		// 2013-11-15 10:00:00
			$m_reg_user_last_reg_datetime_full_to = null;
			$m_reg_user_last_reg_date_from = null; 
			$m_reg_user_last_reg_datetime_from = null; 
			$m_reg_user_last_reg_date_to = null; 
			$m_reg_user_last_reg_datetime_to = null; 
			if ( get_user_info($db, $m_reg_user_id) ) {
				//$m_reg_user_uid = $_SESSION['user_uid'];
				$m_reg_user_id = $_SESSION['user_id'];
				$m_reg_user_name = $_SESSION['user_name'];
				//$m_reg_user_passwd = $_SESSION['user_passwd'];
				//$m_reg_user_email = $_SESSION['user_email'];
				$m_reg_user_phone = $_SESSION['user_phone'];
				//$m_reg_user_lock = $_SESSION['user_lock'];
				$m_reg_user_last_reg_datetime_full_from = $_SESSION['user_last_reg_datetime_full_from'] = $result[0][5];
				$m_reg_user_last_reg_datetime_full_to = $_SESSION['user_last_reg_datetime_full_to'] = $result[0][6];
				$m_reg_user_last_reg_date_from = $_SESSION['user_last_reg_date_from'];
				$m_reg_user_last_reg_datetime_from = $_SESSION['user_last_reg_datetime_from'];
				$m_reg_user_last_reg_date_to = $_SESSION['user_last_reg_date_to'];
				$m_reg_user_last_reg_datetime_to = $_SESSION['user_last_reg_datetime_to'];
			}
		*/
		}

		\commons\log\logd( TAG_AUTH, "auth: result: session login = " . $_SESSION['logged_in'] );
		\commons\log\logd( TAG_AUTH, "auth: result: login = " . $m_reg_login );
		//chk_login_already( true );
	}
}

?>
