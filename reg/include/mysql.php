<?
/* --------------------------------------------------------------
Project:	MySQL Interface Class
Purpose:	Port MySQL API to mysqli API
Author:		Ho-Jung Kim (godmode2k@hotmail.com)
Date:		Since November 16, 2013
Filename:	mysql.php

Last modified: Sep 24, 2015
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
 1. Base code 'Class MySQL { ... }'
	- Source: Unknown
-------------------------------------------------------------- */



include_once "commons.php";
//$TAG = "mysql.php";



Class MySQL {
	var $CONN = "";
	var $DBASE = "test_reserv";
	var $USER = "test";
	var $PASS = "test";
	var $SERVER = "localhost";
	//var $SERVER = "192.168.1.193";

	var $TRAIL = array();
	var $SubTRAIL = array();
	var $HITS = array();

	var $AUTOAPPROVE = true;

	function error($conn, $text) {
		//\commons\log\logd( TAG_MYSQL, "error()" );

		$no = mysqli_errno( $conn );
		$msg = mysqli_error( $conn );
		\commons\log\logd( TAG_MYSQL, "[$text] ( $no : $msg )" );
		exit;
	}

	function init () {
		//\commons\log\logd( TAG_MYSQL, "init()" );

		$user = $this->USER;
		$pass = $this->PASS;
		$server = $this->SERVER;
		$dbase = $this->DBASE;

		$conn = mysqli_connect( $server, $user, $pass );
		if (!$conn) {
			$this->error( $conn, "Connection attempt failed" );
		}

		if (!mysqli_select_db($conn, $dbase)) {
			$this->error( $conn, "Database Select failed" );
		}

		$this->CONN = $conn;

		//mysqli_query( $conn, "SET character_set_results=utf8" );
		//mb_language('uni'); 
		//mb_internal_encoding('UTF-8');

		return true;
	}

	function query($sql) {
		//\commons\log\logd( TAG_MYSQL, "query()" );

		if (empty($this->CONN)) {
			return false;
		}

		$conn = $this->CONN;
		$results = mysqli_query( $conn, $sql );

		if (!$results) {
			//\commons\log\logd( TAG_MYSQL, mysqli_error() );
			\commons\log\logd( TAG_MYSQL, "[ERROR]: ". mysqli_error() );
			exit;
		}

		return $results;
	}

	// <SELECT>
	// return: array {
	//  	- result[0][0]: record 0, field 0
	//  	- result[0][1]: record 1, field 1
	//	}
	// return: null: no data found
	//
	// <UPDATE/DELETE>
	// return: boolean
	function query2($sql) {
		//\commons\log\logd( TAG_MYSQL, "query2()" );

		if ( empty($sql) ) {
			return false;
		}

		if ( empty($this->CONN) ) {
			return false;
		}

		$conn = $this->CONN;
		$results = mysqli_query( $conn, $sql );

		if ( (!$results) or (empty($results)) ) {
			//\commons\log\logd( TAG_MYSQL, mysqli_error() );
			\commons\log\logd( TAG_MYSQL, "[ERROR]: ". mysqli_error() );
			return false;
		}


		//if ( preg_match("/^update/",$sql) || preg_match("/^UPDATE/",$sql) ) {
		if ( preg_match("/^update/",$sql) || preg_match("/^UPDATE/",$sql) ||
			 preg_match("/^delete/",$sql) || preg_match("/^DELETE/",$sql) ) {
			// 'update, delete' are return boolean type only
			// so, skip here.
		}
		else {
			$count = 0;
			while ( $row = mysqli_fetch_array($results) ) {
				$data[$count] = $row;
				$count++;
			}

			mysqli_free_result( $results );

			// No data found
			if ( $count == 1 && $data[0][0] == 0 ) {
				return false;
			}

			return $data;
		}

		return $results;
	}

	function select($sql="") {
		//\commons\log\logd( TAG_MYSQL, "select()" );

		if (empty($sql)) {
			return false;
		}

		if (!preg_match("/^select/",$sql)) {
			\commons\log\logd( TAG_MYSQL, "[ERROR]: QUERY: SELECT" );
			return false;
		}

		if (empty($this->CONN)) {
			return false;
		}

		$conn = $this->CONN;
		$results = mysqli_query( $conn, $sql );

		if ((!$results) or (empty($results))) {
			\commons\log\logd( TAG_MYSQL, "[ERROR]: ". mysqli_error() );
//			mysqli_free_result($results);
			return false;
		}

		$count = 0;
//		$data = array();

		while ($row = mysqli_fetch_array($results)) {
			$data[$count] = $row;
			$count++;
		}

		mysqli_free_result( $results );
		return $data;
	}

	function insert($sql) {
		//\commons\log\logd( TAG_MYSQL, "insert()" );

		if (empty($sql)) {
			return false;
		}
		
		if (!preg_match("/^insert/",$sql)) {
			\commons\log\logd( TAG_MYSQL, "[ERROR]: QUERY: INSERT" );
			return false;
		}

		if (empty($this->CONN)) {
			return false;
		}

		$conn = $this->CONN;
		$results = mysqli_query( $conn, $sql );
		if (!$results) {
			\commons\log\logd( TAG_MYSQL, mysqli_error() );
			return false;
		}

		//$results_ = mysqli_insert_id();
		$results_ = mysqli_insert_id( $conn );
		return $results_;
	}

	function update($sql) {
		//\commons\log\logd( TAG_MYSQL, "update()" );

		if (empty($sql)) {
			return false;
		}

		if (!preg_match("/^update/",$sql)) {
			\commons\log\logd( TAG_MYSQL, "[ERROR]: QUERY: UPDATE" );
			return false;
		}

		if (empty($this->CONN)) {
			return false;
		}

		$conn = $this->CONN;
		$results = mysqli_query( $conn, $sql );

		if (!$results) {
			\commons\log\logd( TAG_MYSQL, mysqli_error() );
			return false;
		}
	}
	
	function delete($sql) {
		//\commons\log\logd( TAG_MYSQL, "delete()" );

		if (empty($sql)) {
			return false;
		}

		if (!preg_match("/^delete/",$sql)) {
			\commons\log\logd( TAG_MYSQL, "[ERROR]: QUERY: DELETE" );
			return false;
		}

		if (empty($this->CONN)) {
			return false;
		}

		$conn = $this->CONN;
		$results = mysqli_query( $conn, $sql );
		if (!$results) {
			return false;
		}
	
		return $results;
	}
	
	function now() {
		//\commons\log\logd( TAG_MYSQL, "now()" );

		if (empty($this->CONN)) {
			return false;
		}

		$conn = $this->CONN;
		$result = mysqli_query( $conn, "select now()" );
		//$result = mysqli_query( $conn, "select now() as now" );
		//$now = mysqli_result( $result, 0, "now()") ;
		//$now = mysqli_fetch_assoc($result)['now()'];
		$now_list = mysqli_fetch_assoc($result);
		$now = $now_list['now()'];

		mysqli_free_result( $result );
		return $now; 
	}
}	//	End Class



// -----------------------------------------------



function db_server_login_error() {
	//\commons\log\logd( TAG_MYSQL, "db_server_login_error()" );

	//Header("WWW-authenticate: basic realm=\"MySQL connector\"");
	Header( "HTTP/1.0 401 Unauthorized" );

	\commons\log\logd( TAG_MYSQL, "db_server_login_error(): Invalid login" );
	exit;
}

function db_server_login() {
	//\commons\log\logd( TAG_MYSQL, "db_server_login()" );

	$my_db='test_reserv';
	$my_user='test';
	$my_host='localhost';
	//$my_host='192.168.1.193';
	$my_password = 'test';

	//! register_globals=off: Use $_SERVER['PHP_AUTH_USER']

	//if(!isset($PHP_AUTH_USER)) {
	if ( !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ) {
		db_server_login_error();
	}
	else {
		//$dbconn = mysql_pconnect($my_host,$my_user,$my_password) or die("Unable to connect to SQL server");
		$dbconn = mysqli_connect( $my_host,$my_user,$my_password ) or die( "Unable to connect to SQL server" );
		//mysql_select_db($dbconn, $my_db) or die("Unable to select database");
		if ( mysqli_select_db($dbconn, $my_db) ) {
			// ...
		}

		//$id = trim(strtolower($PHP_AUTH_USER));
		$id = trim( strtolower($_SERVER['PHP_AUTH_USER']) );

		//$pass = mysql_query("select password('$PHP_AUTH_PW')");
		$pass = mysqli_query( $dbconn, "select password('".$_SERVER['PHP_AUTH_PW']."')" );
		//$password = mysql_result($pass,0,0);
		$password = mysqli_fetch_array( $pass, MYSQLI_NUM );
		$password = $password[0];

		$query = mysqli_query( $dbconn, "select * from user where id='$id'" );
		//$pw = mysqli_result($dbconn, $query,0,'password');
		//$pw = mysqli_fetch_assoc($query)['password'];
		$pw_list = mysqli_fetch_assoc( $query );
		$pw = $pw_list['password'];

		if ( $password <> $pw && !empty($pw) ) {
			//authenticate(); 
			db_server_login_error();
		}
		else {
			\commons\log\logd( TAG_MYSQL, "db_server_login(): logged in " );
		}
	}
}

// -----------------------------------------------

function login_error($msg, $exit) {
	//\commons\log\logd( TAG_MYSQL, "login_error()" . "<br>";

	echo "<script type=\"text/javascript\">\n";
	echo "alert( \"" . $msg . "\");\n";
	echo "</script>";

	if ( $exit )
		exit;
}

//! check login
// -----------------------------------------------
function chk_login($db, $id, $passwd) {
	\commons\log\logd( TAG_MYSQL, "chk_login()" );

	//\commons\log\logd( TAG_MYSQL, "auth: chk_login(): id = " . $id . ", password = " . $passwd );

	//! Checks contain denial symbols (without "@-_.")
	if ( ereg( "[" . SYMBOL_DENY . "]", $id) ) {
		\commons\log\logd( TAG_MYSQL, "auth: chk_login(): contains denied symbols; login [FALSE]" );
		return ERR__SYMBOL_DENY;
	}

	if ( $id && $passwd ) {
		if ( $db ) {
			$query = "select count(*), reg_lock from register where reg_id=\"$id\" and reg_password=password(\"$passwd\")";
			$result = $db->select( $query );

			\commons\log\logd( TAG_MYSQL, "auth: chk_login(): check login: id = " . $id . ", password = " . $passwd );
			if ( $result ) {
				//echo $result[0][0] . "<br>";
				if ( $result[0][0] == 1 ) {
					\commons\log\logd( TAG_MYSQL, "auth: chk_login(): login [TRUE]" );


					if ( $result[0][1] == 1 ) {
						//\commons\log\logd( TAG_MYSQL, "auth: chk_login(): login: locked [FALSE]" );
						//return false;
						return ERR__LOGIN__LOCKED;
					}
					
					// Session
					//session_start();
					$_SESSION['logged_in'] = true;
					$_SESSION['user_id'] = $id;
					//header( "Location: reserv.php" );

					//return true;
					return RET__SUCCESS;
				}
				else {
					\commons\log\logd( TAG_MYSQL, "auth: chk_login(): login [FALSE]" );
				}
			}
		}

		//login_error( "Invalid login", false );
	}

	//return false;
	return ERR__LOGIN__ID_PASSWD;
}

function chk_login_already($log) {
	//\commons\log\logd( TAG_MYSQL, "chk_login_already()" );

	if ( $log ) {
		if ( isset($_SESSION['logged_in']) && isset($_SESSION['user_id']) ) {
			\commons\log\logd( TAG_MYSQL, "auth: chk_login_already(): [TRUE]" );
			//if ( !isset($_SESSION['logged_in']) && !isset($_SESSION['user_id']) && $m_reg_login ) {
			\commons\log\logd( TAG_MYSQL, "auth: chk_login_already(): session login = " . $_SESSION['logged_in'] );
			\commons\log\logd( TAG_MYSQL, "auth: chk_login_already(): session user_id = " . $_SESSION['user_id'] );
			\commons\log\logd( TAG_MYSQL, "auth: chk_login_already(): session user_name = " . $_SESSION['user_name'] );
			\commons\log\logd( TAG_MYSQL, "auth: chk_login_already(): session user_email = " . $_SESSION['user_email'] );
			\commons\log\logd( TAG_MYSQL, "auth: chk_login_already(): session user_phone = " . $_SESSION['user_phone'] );
			\commons\log\logd( TAG_MYSQL, "auth: chk_login_already(): session user_last_reg_datetime_full_from = "
											 . $_SESSION['user_last_reg_datetime_full_from'] );
			\commons\log\logd( TAG_MYSQL, "auth: chk_login_already(): session user_last_reg_datetime_full_to = "
											 . $_SESSION['user_last_reg_datetime_full_to'] );

			return true;
		}

		\commons\log\logd( TAG_MYSQL, "auth: chk_login_already(): [FALSE]" );
		return false;
	}
	else {
		//if ( !isset($_SESSION['logged_in']) && !isset($_SESSION['user_id']) && $m_reg_login ) {
		if ( isset($_SESSION['logged_in']) && isset($_SESSION['user_id']) ) {
			return true;
		}

		return false;
	}
}

//! DO NOT USE THIS
// SEE: logout.php
//function logout() { }

//! Register an account
// -----------------------------------------------
function account_register($db, $id, $passwd, $name, $email, $phone_num) {
	//\commons\log\logd( TAG_MYSQL, "account_register()" );

	if ( $id && $passwd && $name && $email && $phone_num ) {
		$uid = 0; // AUTO_INCREMENTAL

		if ( $db ) {
			$query = "select count(*) from register where reg_id=\"$id\"";
			$result = $db->select( $query );

			if ( $result ) {
				if ( $result[0][0] > 0 ) {
					\commons\log\logd( TAG_MYSQL, "account_register(): account existed already, \"$id\"" );
					\commons\log\logd( TAG_MYSQL, "account_register(): created [FALSE]" );
					return false;
				}
			}
			$result = "";


			$query = "INSERT INTO register";
			//$query = $query . "(reg_id, reg_name, reg_password, reg_email, reg_phone,
			//				reg_lock, reg_auth, reg_last_datetime_from, reg_last_datetime_to)";
			$query .= " VALUES (";
			$query .= $uid . ", ";
			$query .= "'" . $id . "', ";
			$query .= "'" . $name . "', ";
			$query .= "password('$passwd')" . ", ";
			$query .= "'" . $email . "', ";
			$query .= "'" . $phone_num . "', ";
			$query .= "DEFAULT" . ", ";	// lock: default is 1
			//$query .= "'" . $auth . "', ";
			//$query .= "'" . $reg_last_datetime_from . "', ";
			//$query .= "'" . $reg_last_datetime_to . "' ";

			//$query .= "'" . "010-0000-1111" . "' ";
			//$query .= "password('12345')" . ", ";
			$query .= "20150101010000" . ", ";
			$query .= "20150101010000";
			$query .= " )";

			//\commons\log\logd( TAG_MYSQL, "account_register: query = " . "'" . $query . "'" );
			$result = $db->query( $query );

			if ( $result ) {
				//\commons\log\logd( "account_register()", "result = " . $result );

				\commons\log\logd( TAG_MYSQL, "account_register(): created [TRUE]" );

				{
					$query = "INSERT INTO confirm_auth";
					$query .= " VALUES (";
					$query .= $uid . ", ";
					$query .= "'" . $id . "', ";
					//$query .= "password('12345')";	//! DELETE
					$query .= "'" . md5("12345") . "' ";	//! TEMPORARY: CHANGE '12345'
					$query .= " )";

					//\commons\log\logd( TAG_MYSQL, "account_register: query = " . "'" . $query . "'" );
					$result = $db->query( $query );

					if ( $result ) {
						\commons\log\logd( TAG_MYSQL, "account_register(): created (confirm auth) [TRUE]" );
					}
					else {
						\commons\log\logd( TAG_MYSQL, "account_register(): created (confirm auth) [FALSE]" );
						return false;
					}
				}

				
				// Session
				//session_start();
				//
				//$_SESSION['logged_in'] = true;
				//$_SESSION['user_id'] = $id;
				//$_SESSION['reg_new_account'] = "";
				unset( $_SESSION['reg_new_account'] );
				//header( "Location: reserv.php" );

				return true;
			}
			else {
				\commons\log\logd( TAG_MYSQL, "account_register(): created [FALSE]" );
			}
		}
	}

	return false;
}

//! Remove an account
// -----------------------------------------------
function account_remove($db, $id, $passwd) {
	//\commons\log\logd( TAG_MYSQL, "account_remove()" );

	if ( $id && $passwd ) {
		$uid = 0; // AUTO_INCREMENTAL

		if ( $db ) {
			$query = "delete from register where reg_id=\"$id\" and reg_password=password(\"$passwd\")";
			$result = $db->query2( $query );

			//\commons\log\logd( TAG_MYSQL, "account_remove(): query = " . $query );

			// boolean type here
			if ( $result ) {
				\commons\log\logd( TAG_MYSQL, "account_remove(): removed [TRUE]" );
				return true;
			}
			else {
				\commons\log\logd( TAG_MYSQL, "account_remove(): account not existed or wrong id/passwd or removed already, \"$id\"" );
				\commons\log\logd( TAG_MYSQL, "account_remove(): removed [FALSE]" );
			}
		}
	}

	return false;
}

//! Edit an account
// -----------------------------------------------
function account_edit($db, $id, $passwd_old, $passwd_new, $name, $email, $phone_num) {
	//\commons\log\logd( TAG_MYSQL, "account_edit()" );

	if ( $id && $name && $email && $phone_num ) {
		$uid = 0; // AUTO_INCREMENTAL

		if ( $db ) {
			$query = "select reg_id from register where reg_id=\"$id\"";
			if ( $passwd_old ) {
				$query .= "and reg_password = password(\"$passwd_old\")";
			}
			$result = $db->select( $query );

			//\commons\log\logd( TAG_MYSQL, "account_edit(): query = " . $query );

			if ( $result ) {
				if ( $result[0][0] == $id) {
					$query = "update register set ";
					$query .= "reg_id = '" . $id . "', ";
					$query .= "reg_name = '" . $name . "', ";
					if ( $passwd_new ) {
						$query .= "reg_password = password('$passwd_new')" . ", ";
					}
					$query .= "reg_email = '" . $email . "', ";
					$query .= "reg_phone = '" . $phone_num . "' ";
					$query .= "where reg_id=\"$id\"";

					$result = $db->query2( $query );

					//\commons\log\logd( TAG_MYSQL, "account_edit(): query = " . $query );

					// boolean type here
					if ( $result ) {
						\commons\log\logd( TAG_MYSQL, "account_edit(): edited [TRUE]" );
						return true;
					}
					else {
						\commons\log\logd( TAG_MYSQL, "account_edit(): edited [FALSE]" );
					}
				}
			}

			if ( $passwd_old && $passwd_new ) {
				\commons\log\logd( TAG_MYSQL, "account_edit(): wrong id/passwd, \"$id\"" );
			}
		}
	}

	return false;
}

//! Confirmation URL
// -----------------------------------------------
function account_confirm($db, $id, $auth) {
	//\commons\log\logd( TAG_MYSQL, "account_confirm()" );

	if ( $id && $auth ) {
		if ( $db ) {
			$query = "select count(*), reg_auth from confirm_auth where reg_id=\"$id\"";
			$result = $db->select( $query );

			if ( $result ) {
				if ( $result[0][0] > 0 && $result[0][1] == $auth) {
					// unlock
					$query = "update register set reg_lock = 0 where reg_id=\"$id\"";
					$result = $db->query2( $query );

					//\commons\log\logd( TAG_MYSQL, "result = " . $result );

					// boolean type here
					if ( $result ) {
						\commons\log\logd( TAG_MYSQL, "account_confirm(): unlocked [TRUE]" );
					}
					else {
						\commons\log\logd( TAG_MYSQL, "account_confirm(): unlocked [FALSE]" );
						return false;
					}


					// unlock: auth
					$query = "delete from confirm_auth where reg_id=\"$id\"";
					$result = $db->query2( $query );

					// boolean type here
					if ( $result ) {
						\commons\log\logd( TAG_MYSQL, "account_confirm(): confirmed [TRUE]" );
						return true;
					}
					else {
						\commons\log\logd( TAG_MYSQL, "account_confirm(): confirmed [FALSE]" );
					}
				}
			}
		}
	}

	\commons\log\logd( TAG_MYSQL, "account_confirm(): unlocked/confirmed [FALSE]" );
	return false;
}

function account_get_auth($db, $id) {
	//\commons\log\logd( TAG_MYSQL, "account_get_auth()" );

	if ( $id ) {
		if ( $db ) {
			$query = "select count(*), reg_auth from confirm_auth where reg_id=\"$id\"";

			//\commons\log\logd( TAG_MYSQL, "account_get_auth(): query = " . $query );
			$result = $db->select( $query );

			if ( $result ) {
				if ( $result[0][0] == 1 ) {
					return $result[0][1];
				}
			}
		}
	}

	\commons\log\logd( TAG_MYSQL, "account_get_auth(): get authentication key [FALSE]" );
	return false;
}


// -----------------------------------------------


function get_account_info($db, $id) {
	//\commons\log\logd( TAG_MYSQL, "get_account_info()" );

	//\commons\log\logd( TAG_MYSQL, "auth: get_account_info(): id = " . $id );

	if ( $id ) {
		if ( $db ) {
			$query = "select * from register where reg_id=\"$id\"";
			$result = $db->select( $query );

			if ( $result && count($result) == 1 ) {
				return $result;
			}
		}
	}
}

function get_user_info($db, $id) {
	//\commons\log\logd( TAG_MYSQL, "get_user_info()" );

	//\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): id = " . $id );

	if ( $id ) {
		if ( $db ) {
			$query = "select * from register where reg_id=\"$id\"";
			$result = $db->select( $query );

			if ( $result ) {
				//echo $result[0][0] . "<br>";
				//if ( $result[0][0] == 1 ) {
				{
					\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): user id = " . $id );
					
					// Session

					//session_start();
					{
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): user info {" );
						//$_SESSION['uid'] = $result[0][0];
						//\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): uid = " . $result[0][0] );

						$_SESSION['user_id'] = $result[0][1];
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): user id = " . $result[0][1] );

						$_SESSION['user_name'] = $result[0][2];
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): user name = " . $result[0][2] );

						//$_SESSION['user_passwd'] = $result[0][3];
						//\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): password = " . $result[0][3] );

						$_SESSION['user_email'] = $result[0][4];
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): email = " . $result[0][4] );

						$_SESSION['user_phone'] = $result[0][5];
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): phone = " . $result[0][5] );

						//$_SESSION['user_auth'] = $result[0][6];
						//$_SESSION['user_lock'] = $result[0][6];
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): lock = " . $result[0][6] );
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): }" );
					}
					
					{
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): last schedule from = " . $result[0][7] );
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): last schedule to = " . $result[0][8] );

						// format: '2013-11-15 10:00:00'
						//$_SESSION['user_last_reg_datetime_full_from'] = str_replace( " ", ";", $result[0][7] );
						//$_SESSION['user_last_reg_datetime_full_to'] = str_replace( " ", ";",  $result[0][8] );
						$_SESSION['user_last_reg_datetime_full_from'] = $result[0][7];
						$_SESSION['user_last_reg_datetime_full_to'] = $result[0][8];

						// format: '2013-11-15 10:00:00' to '20131115100000'
						$db_last_full_from = str_replace( " ", "", $result[0][7] );
						$db_last_full_from = str_replace( "-", "", $db_last_full_from );
						$db_last_full_from = str_replace( ":", "", $db_last_full_from );
						$db_last_full_to = str_replace( " ", "", $result[0][8] );
						$db_last_full_to = str_replace( "-", "", $db_last_full_to );
						$db_last_full_to = str_replace( ":", "", $db_last_full_to );
						$_SESSION['user_db_last_reg_datetime_full_from'] = $db_last_full_from;
						$_SESSION['user_db_last_reg_datetime_full_to'] = $db_last_full_to;

						list( $date_from, $date_time_from ) = explode( " ", $result[0][7] );
						list( $date_to, $date_time_to ) = explode( " ", $result[0][8] );

						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): last schedule {" );
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info():     date_from = " . $date_from );
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info():     date_time_from = " . $date_time_from );
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info():     date_to = " . $date_to );
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info():     date_time_to = " . $date_time_to );
						\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): }" );

						if ( $date_from )
							$_SESSION['user_last_reg_date_from'] = $date_from;
						if ( $date_time_from )
							$_SESSION['user_last_reg_datetime_from'] = $date_time_from;

						if ( $date_to )
							$_SESSION['user_last_reg_date_to'] = $date_to;
						if ( $date_time_to )
							$_SESSION['user_last_reg_datetime_to'] = $date_time_to;
					}

					//header( "Location: reserv.php" );

					return true;
				}
				//else {
				//	\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): [FALSE]" );
				//}
			}
			else {
				\commons\log\logd( TAG_MYSQL, "auth: get_user_info(): [FALSE]" );
			}
		}

		//login_error( "Invalid login", false );
	}

	return false;
}



// -----------------------------------------------



$db = new MySQL;
if ( !$db->init() ) {
	\commons\log\logd( TAG_MYSQL, "MySQL Connected... [FALSE]" );
	exit;
}

?>
