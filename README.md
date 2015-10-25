Web Examples
===============


Summary
----------
> The sources show you how to make a simple Web page for <br>
> manage the account(sign-in/up) and schedule.
> And handle JSON response in PHP/Android (Currently login/logout only).
> In Android, you can see how to keep PHP session.


Environment
----------
> tested on

    GNU/Linux: Ubuntu 11.10
    Apache: 2.2.20
    PHP: 5.3.6
    MySQL: 5.1.63


Files
----------
> as following or you should make whatever you want

    ./reg {
	  // Login
	  - login.php
	  - login_chk.php
	  - logout.php
	  -
	  // Account
	  - account_sign_up.php
	  - account_commit.php
	  - account_confirm_url.php
	  - account_commit.php
	  -
	  - account_info.php
	  - account_info_commit.php
	  - account_remove_commit.php
	  -
	  // Manage the schedules
	  - reserv.php
	  - reserv_register_modify.php
	  - reserv_register_commit.php
	  -
	  /include
	    - commons.php
	    - namespaces.php
	    - auth.php                    // Authentication and most actions
	    - mysql.php                   // Database (MySQL) actions
	  -
	  /js
	    - util.js                     // some JavaScript for 'form' tag action
	  -
	  /db
	    - db.sql                      // Database schema
	  -
	  /Mobile {
	    /Android
	      - http_test_activity.xml    // HTTP Test Layout
	      - HttpTestActivity.java     // HTTP Test Activity
	  }
	}
	  

Note
----------
>
	For Mobile App,
	You have to set <User-Agent> to "mobile_app" for JSON response.
	Currently login/logout only.



Screenshots
----------

> Login

![alt tag](https://github.com/godmode2k/web_examples/raw/master/reg/screenshots/01_login.png)

> Reserv

![alt tag](https://github.com/godmode2k/web_examples/raw/master/reg/screenshots/02_reserv.png)

> Modify

![alt tag](https://github.com/godmode2k/web_examples/raw/master/reg/screenshots/03_modify.png)

> Profile

![alt tag](https://github.com/godmode2k/web_examples/raw/master/reg/screenshots/04_profile.png)

> Sign-up

![alt tag](https://github.com/godmode2k/web_examples/raw/master/reg/screenshots/05_signup.png)

> Sign-up: Confirm URL (Verify)

![alt tag](https://github.com/godmode2k/web_examples/raw/master/reg/screenshots/06_signup_confirm_url.png)


