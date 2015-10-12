<?
/* --------------------------------------------------------------
Project:	Namespaces
Purpose:
Author:		Ho-Jung Kim (godmode2k@hotmail.com)
Date:		Since November 16, 2013
Filename:	namespaces.php

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
 - namespace test
	\commons\log\logd( "AUTH", "first msg..." );
	\commons\log\logd2( "AUTH", "GLOBAL", "first msg..." );
-------------------------------------------------------------- */



//! Namespace
// -----------------------------------------------
namespace commons\log {
	function logd($TAG, $msg) {
		if ( FLAG_DEBUG ) {
			echo "[" . $TAG . "] " . $msg . "<br>";
		}
	}

	function logd2($TAG, $func, $msg) {
		if ( FLAG_DEBUG ) {
			echo "[" . $TAG . "][" . $func . "()] " . $msg . "<br>";
		}
	}
}

?>
