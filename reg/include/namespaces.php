<?
/* --------------------------------------------------------------
Project:	Namespaces
Purpose:
Author:		Ho-Jung Kim (godmode2k@hotmail.com)
Date:		Since November 16, 2013
Filename:	namespaces.php

Last modified: Oct 23, 2015
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
 - namespace test
	\commons\log\logd( "AUTH", "first msg..." );
	\commons\log\logd2( "AUTH", "GLOBAL", "first msg..." );
-------------------------------------------------------------- */



//! Namespace
// -----------------------------------------------
namespace commons\log {
	function _echo($msg) {
		// for Mobile App
		//if ( \commons\util\non_browser_agent() ) return;

		if ( FLAG_DEBUG ) {
			echo $msg . "<br>";
		}
	}

	function logd($TAG, $msg) {
		// for Mobile App
		//if ( \commons\util\non_browser_agent() ) return;

		if ( FLAG_DEBUG ) {
			echo "[" . $TAG . "] " . $msg . "<br>";
		}
	}

	function logd2($TAG, $func, $msg) {
		// for Mobile App
		//if ( \commons\util\non_browser_agent() ) return;

		if ( FLAG_DEBUG ) {
			echo "[" . $TAG . "][" . $func . "()] " . $msg . "<br>";
		}
	}
}

namespace commons\response {
	function json_encode_utf8($val) {
		/*
			Source:
			- http://www.phppro.jp/qa/4026
		 	- http://stackoverflow.com/questions/16498286/why-does-the-php-
				json-encode-function-convert-utf-8-strings-to-hexadecimal-entit

			- PHP >= 5.4 JSON_UNESCAPED_UNICODE
		*/

		// PHP < 5.4
		return preg_replace_callback(
			'/\\\\u([0-9a-zA-Z]{4})/',
			function ($matches) {
				return mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UTF-16');
			},
			json_encode($val)
		);
	}

	// result only
	function json_ro($result) {
		$response = Array( JSON_RESULT => FALSE );
		if ( is_array($response) )  {
			$response[JSON_RESULT] = $result;
			echo json_encode_utf8( $response ) . "<br>";
		}
	}

	function json_rkv($result, $key, $value) {
		$response = Array( JSON_RESULT => FALSE );
		if ( is_array($response) )  {
			$response[JSON_RESULT] = $result;
			$response[$key] = $value;
			echo json_encode_utf8( $response ) . "<br>";
		}
	}

	function json($key, $value) {
		$response = Array();
		if ( is_array($response) )  {
			$response[$key] = $value;
			echo json_encode_utf8( $response ) . "<br>";
		}
	}

	function json_array($response) {
		if ( is_array($response) ) {
			echo json_encode_utf8( $response ) . "<br>";
		}
	}
}

namespace commons\util {
	function non_browser_agent() {
		//$TAG = "commons::non_browser_agent()";
		$APP_AGENT = "mobile_app";
		$ret = false;

		// php.ini: browsercap.ini
		//$browser = get_browser( null, true );
		//print_r( $browser );

		$browser = $_SERVER['HTTP_USER_AGENT'];


		//if ( FLAG_DEBUG ) { echo "[" . $TAG . "] " . $browser . "<br>"; }

		if ( isset($browser) && (strlen($browser) > 0) ) {
			if ( $browser == $APP_AGENT )
				$ret = true;
			else
				$ret = false;
		}

		//if ( FLAG_DEBUG ) { echo "[" . $TAG . "] result = " . ($ret? "true" : "false") . "<br>"; }



		//\commons\util\non_browser_agent();
		//\commons\response\json( "hehehe", "test0", "val0_test" );


		return $ret;
	}
}

?>
