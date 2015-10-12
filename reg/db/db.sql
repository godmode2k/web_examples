#-----------------------------------------------------------------
#Project:	Database schema
#Purpose:	
#Author:	Ho-Jung Kim (godmode2k@hotmail.com)
#Date:		Since Nov 15, 2013
#Filename:	db.sql
#
#Last modified: Sep 10, 2015
#License:
#
#*
#* Copyright (C) 2014 Ho-Jung Kim (godmode2k@hotmail.com)
#*
#* Licensed under the Apache License, Version 2.0 (the "License");
#* you may not use this file except in compliance with the License.
#* You may obtain a copy of the License at
#*
#*      http://www.apache.org/licenses/LICENSE-2.0
#*
#* Unless required by applicable law or agreed to in writing, software
#* distributed under the License is distributed on an "AS IS" BASIS,
#* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#* See the License for the specific language governing permissions and
#* limitations under the License.
#*
#-----------------------------------------------------------------
#Note:
#-----------------------------------------------------------------
#	- Have to create an account 'test' for the database 'test_reserv'
#	- charset = utf-8 (charset="utf8")
#-----------------------------------------------------------------



#CREATE SCHEMA `new_schema` DEFAULT CHARACTER SET utf8;

CREATE DATABASE IF NOT EXISTS test_reserv;
USE test_reserv;


# Need to encrypt all
CREATE TABLE if not exists register(
	uid INT(11) NOT NULL AUTO_INCREMENT,

	# id: 30 bytes
	reg_id VARCHAR(30) NOT NULL,

	# name: 30 bytes
	reg_name VARCHAR(30) NOT NULL,

	# password
	reg_password VARCHAR(41) NOT NULL,

	# email
	reg_email VARCHAR(30) NOT NULL,

	# phone: 11 bytes (with delimiter '-')
	reg_phone VARCHAR(30) NOT NULL,

	# lock for confirm the authentication
	reg_lock boolean NOT NULL DEFAULT 1,

	# authentication code: 41 bytes
	# SEE: TABLE confirm_auth
	#reg_auth VARCHAR(41) NOT NULL,

	reg_last_datetime_from DATETIME NOT NULL,
	reg_last_datetime_to DATETIME NOT NULL,

	PRIMARY KEY (uid)
#) default charset=utf8;
);

CREATE TABLE if not exists confirm_auth(
	uid INT(11) NOT NULL AUTO_INCREMENT,

	# id: 30 bytes
	reg_id VARCHAR(30) NOT NULL,

	# authentication key: 41 bytes, MD5('12345')
	reg_auth VARCHAR(41) NOT NULL,

	PRIMARY KEY (uid)
);

CREATE TABLE if not exists schedule(
	uid INT(11) NOT NULL AUTO_INCREMENT,

	# id: 30 bytes
	reg_id VARCHAR(30) NOT NULL,

	# name: 30 bytes
	reg_name VARCHAR(30) NOT NULL,

	# phone: 11 bytes
	reg_phone VARCHAR(30) NOT NULL,

	reg_datetime_from DATETIME NOT NULL,
	reg_datetime_to DATETIME NOT NULL,
	reg_cancel TINYINT UNSIGNED NOT NULL DEFAULT 0,
	reg_done TINYINT UNSIGNED NOT NULL DEFAULT 0,

	PRIMARY KEY (uid)
);



#
# Register
#
INSERT INTO register VALUES ( 0, 'test1', '테스트1', password('12345678'), 'test1@localhost', '010-1234-1678', 0, 20131115100000, 20131115110000 );
INSERT INTO register VALUES ( 0, 'test2', '테스트2', password('12345678'), 'test2@localhost', '010-2234-2678', 0, 20131115110000, 20131115120000 );
INSERT INTO register VALUES ( 0, 'test3', '테스트3', password('12345678'), 'test3@localhost', '010-3234-3678', 0, 20131115120000, 20131115130000 );
INSERT INTO register VALUES ( 0, 'test4', '테스트4', password('12345678'), 'test4@localhost', '010-4234-4678', 0, 20131115130000, 20131115140000 );
INSERT INTO register VALUES ( 0, 'test5', '테스트5', password('12345678'), 'test5@localhost', '010-5234-5678', 0, 20131115140000, 20131115150000 );
#INSERT INTO register VALUES ( 0, 'hello1', 'hello1', password('12345678'), 'hello1@localhost', '010-1234-1678', 1, 20131115140000, 20131115150000 );



#
# Confirm the authentication
#
#INSERT INTO confirm_auth VALUES ( 0, 'hello1', password('12345') );



#
# Schedule
#
INSERT INTO schedule VALUES ( 0, 'test1', '테스트1', '010-1234-1678', 20131115100000, 20131115110000, DEFAULT, DEFAULT );
INSERT INTO schedule VALUES ( 0, 'test2', '테스트2', '010-1234-2678', 20131115110000, 20131115120000, DEFAULT, DEFAULT );
INSERT INTO schedule VALUES ( 0, 'test3', '테스트3', '010-1234-3678', 20131115130000, 20131115140000, DEFAULT, DEFAULT );





# ACCOUNT AND PRIVILEGES
# ------------------------------------------------------
# CREATE AN USER
#CREATE USER 'test'@'localhost' IDENTIFIED BY 'password';
##CREATE USER 'test'@'%' IDENTIFIED BY 'password';
#
#GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost';
##GRANT ALL PRIVILEGES ON *.* TO 'test'@'%';
#
# DELETE AN USER
#DROP USER 'test'@'%';
#DROP USER 'test'@'localhost';
#
#
#
# for database 'test_reserv'
#
# Create an user with password and grant for the database
#GRANT ALL PRIVILEGES ON test_reserv.* TO 'test'@'localhost' IDENTIFIED BY 'password';
##GRANT ALL PRIVILEGES ON test_reserv.* TO 'test'@'%' IDENTIFIED BY 'password';
#
# or
#
# Grant only for the database
#GRANT ALL ON test_reserv.* TO 'test'@'localhost';
##GRANT ALL ON test_reserv.* TO 'test'@'%';
#
#
##FLUSH PRIVILEGES;



#_EOF_
