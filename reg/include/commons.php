<?
/* --------------------------------------------------------------
Project:	Common stuffs
Purpose:
Author:		Ho-Jung Kim (godmode2k@hotmail.com)
Date:		Since November 16, 2013
Filename:	commons.php

Last modified: Nov 16, 2015
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



// DEBUG
define( FLAG_DEBUG, false );



include_once "namespaces.php";



// -----------------------------------------------

// date(), mktime() warning in PHP v5.x
date_default_timezone_set( 'Asia/Seoul' );



//! Constant values: Flags
// -----------------------------------------------
// ...


//! Constant values
// -----------------------------------------------
// Symbol
// Checks contain denial symbols (without "@-_.")
// e.g.,
//		$result = ereg( "[" . SYMBOL_DENY . "]", $str );
// return: TRUE if contains denied symbols, FALSE otherwise
define( SYMBOL_DENY, "~`!#%^&*()=+|;:\'\"\,<>/?" );


//! Constant Return Codes
// -----------------------------------------------
define( RET__SUCCESS, 1 );
define( RET__FAIL, 0 );
define( ERR__LOGIN__ID_PASSWD, -1 );
define( ERR__LOGIN__LOCKED, -2 );
define( ERR__SYMBOL_DENY, -3 );


//! Pages
// -----------------------------------------------
define( PAGE__HOME, "login.php" );
define( PAGE__LOGIN, "login.php" );


//! TAGs
// -----------------------------------------------
define( TAG_AUTH, "auth.php" );
define( TAG_MYSQL, "mysql.php" );

define( TAG_LOGIN, "login.php" );
define( TAG_LOGIN_CHK, "login_chk.php" );
define( TAG_LOGOUT, "logout.php" );

define( TAG_ACCOUNT_SIGN_UP, "account_sign_up.php" );
define( TAG_ACCOUNT_COMMIT, "account_commit.php" );
define( TAG_ACCOUNT_CONFIRM, "account_confirm.php" );
define( TAG_ACCOUNT_CONFIRM_URL, "account_confirm_url.php" );
define( TAG_ACCOUNT_INFO, "account_info.php" );
define( TAG_ACCOUNT_INFO_COMMIT, "account_info_commit.php" );
define( TAG_ACCOUNT_REMOVE_COMMIT, "account_remove_commit.php" );

define( TAG_RESERV, "reserv.php" );
define( TAG_RESERV_REGISTER_MODIFY, "reserv_register_modify.php" );
define( TAG_RESERV_REGISTER_COMMIT, "reserv_register_commit.php" );


//! For Mobile
// -----------------------------------------------
define( JSON_RESULT_SUCCESS, 1 );
define( JSON_RESULT_FAIL, 0 );
define( JSON_RESULT_UNKNOWN, "unknown" );
define( JSON_RESULT_NUMBER, "number" );
define( JSON_RESULT_TRUE, 1 );
define( JSON_RESULT_FALSE, 0 );
define( JSON_RESULT, "result" );
define( JSON_RESULT_ERROR_LOGIN_ID, "id" );
define( JSON_RESULT_ERROR_LOGIN_PASSWD, "passwd" );
define( JSON_LOGIN, "login" );
define( JSON_LOGIN_LOCKED, "login_locked" );
define( JSON_LOGIN_CONFIRM_URL, "login_confirm_url" );
define( JSON_LOGIN_ALREADY, "login_already" );
define( JSON_LOGIN_USER_ID, "user_id" );
define( JSON_LOGIN_USER_NAME, "user_name" );
define( JSON_LOGIN_USER_EMAIL, "user_email" );
define( JSON_LOGIN_USER_PHONE, "user_phone" );
define( JSON_ACCOUNT_INFO_ID, "account_info_id" );
define( JSON_ACCOUNT_INFO_NAME, "account_info_name" );
define( JSON_ACCOUNT_INFO_EMAIL, "account_info_email" );
define( JSON_ACCOUNT_INFO_PHONE, "account_info_phone" );	// "xxx-xxxx-xxxx"


//!
// -----------------------------------------------


?>
