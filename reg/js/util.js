
/*
 * obj = this
function onVerifyPasswd(obj, maxlen) {
	if ( (obj.name == "reg_login_passwd") || (obj.name == "reg_login_passwd_verify") ) {
		var passwd = document.getElementsByName("reg_login_passwd").item( 0 );
		var passwd_verify = document.getElementsByName("reg_login_passwd_verify").item( 0 );
		var verifying_result = document.getElementById("id_reg_login_passwd_verify");
		var str = "";

		if ( (passwd.value != "") && (passwd_verify.value != "") ) {
			if ( passwd.value != passwd_verify.value ) {
				str = "not matched";
			}

			verifying_result.innerHTML = str;
		}

		if ( (passwd.value.length < maxlen) || (passwd_verify.value.length < maxlen) ) {
			if ( str == "" )
				str = maxlen + " digits";
			else
				str += ", " + maxlen + " digits";

			verifying_result.innerHTML = str;
		}
	}
}
*/

function onVerifyPasswd(obj_name, obj_name_verify, obj_id_result, maxlen) {
	var passwd = document.getElementsByName(obj_name).item( 0 );
	var passwd_verify = document.getElementsByName(obj_name_verify).item( 0 );
	var verifying_result = document.getElementById(obj_id_result);
	var str = "";

	if ( (passwd.value != "") && (passwd_verify.value != "") ) {
		if ( passwd.value != passwd_verify.value ) {
			str = "not matched";
		}

		verifying_result.innerHTML = str;
	}

	if ( (passwd.value.length < maxlen) || (passwd_verify.value.length < maxlen) ) {
		if ( str == "" )
			str = maxlen + " digits";
		else
			str += ", " + maxlen + " digits";

		verifying_result.innerHTML = str;
	}
}

function onVerifyPasswdLength(obj_name, obj_name_verify, obj_id_result, maxlen) {
	var passwd = document.getElementsByName(obj_name).item( 0 );
	var passwd_verify = document.getElementsByName(obj_name_verify).item( 0 );
	var verifying_result = document.getElementById(obj_id_result);
	var str = "";

	if ( (passwd.value != "") && (passwd_verify.value != "") ) {
		if ( (passwd.value.length < maxlen) || (passwd_verify.value.length < maxlen) ) {
			if ( str == "" )
				str = maxlen + " digits";

			verifying_result.innerHTML = str;
		}
		else {
			verifying_result.innerHTML = "";
		}
	}
}

/*
 * obj = this
function onVerifyEmail(obj) {
	if ( (obj.name == "reg_login_email") || (obj.name == "reg_login_email_verify") ) {
		var email = document.getElementsByName("reg_login_email").item( 0 );
		var email_verify = document.getElementsByName("reg_login_email_verify").item( 0 );
		var verifying_result = document.getElementById("id_reg_login_email_verify");
		var str = "";

		if ( (email.value != "") && (email_verify.value != "") ) {
			if ( email.value != email_verify.value ) {
				str = "not matched";
			}

			verifying_result.innerHTML = str;
		}
	}
}
*/

function onVerifyEmail(obj_name, obj_name_verify, obj_id_result) {
	var email = document.getElementsByName(obj_name).item( 0 );
	var email_verify = document.getElementsByName(obj_name_verify).item( 0 );
	var verifying_result = document.getElementById(obj_id_result);
	var str = "";

	if ( (email.value != "") && (email_verify.value != "") ) {
		if ( email.value != email_verify.value ) {
			str = "not matched";
		}

		verifying_result.innerHTML = str;
	}
}

function onVerifyNumber(obj_name, maxlen) {
	var num = document.getElementsByName(obj_name).item( 0 );

	//alert( "num = " + num.value + ", len = " + num.value.length + ", maxlen = " + maxlen );
	if ( num.value.length < maxlen ) {
		alert( maxlen + " digits" );
	}
}

function onVerifyLength(obj_name, obj_id_result, maxlen) {
	var obj = document.getElementsByName(obj_name).item( 0 );
	var verifying_result = document.getElementById(obj_id_result);
	var str = maxlen + " digits";

	//alert( "obj = " + obj.value + ", len = " + obj.value.length + ", maxlen = " + maxlen );
	if ( obj.value.length < maxlen ) {
		if ( verifying_result == null )
			alert( str );
		else
			verifying_result.innerHTML = str;
	}
	else {
		verifying_result.innerHTML = "";
	}
}







/*
 * obj = this
function func_search(obj) {
	//var focused = document.activeElement;
	//if ( focused != document.body ) {
	//	var id_search = document.getElementsByName("id_search").item( 0 );
	//	if ( id_search.value != "" ) {
	//		alert( "Search -> " + id_search.value );
	//	}
	//}
	
	if ( (obj.name == "id_search") || (obj.id == "id_search_text") ) {
		var id_search = document.getElementsByName("id_search").item( 0 );
		if ( id_search.value != "" ) {
			alert( "Search -> " + id_search.value );
		}
	}
}
*/

