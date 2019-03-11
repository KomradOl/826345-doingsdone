CREATE DATABASE works 
DEFAULT character SET utf8
DEFAULT collate utf8_general_ci;

use works;

CREATE TABLE project (
		id int auto_increment PRIMARY KEY,
		name char(100),
		user_id int);

CREATE TABLE tasks (
		id int auto_increment PRIMARY KEY,
		date_create date,
		date_exec date,
		status int,
		name char(100),
		file char(100),
		deadline datetime,
		project_id int,
		user_id int);

CREATE TABLE users (
		id int auto_increment PRIMARY KEY,
		date_REG date,
		name char(100),
		email char(100),
		pass char(100));
		
CREATE INDEX n_task ON tasks(name);
CREATE INDEX n_user ON users(name);
CREATE INDEX n_project ON project(name);