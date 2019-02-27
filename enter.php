<?php
require_once('functions.php');
$con = mysqli_connect("localhost", "root", "", "works") or die (mysqli_error($con));

    mysqli_set_charset($con, "utf8");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$form = $_POST;
	
	$required = ['email', 'password', 'name'];
	$errors = [];
	foreach ($required as $field) {
	    if (empty($form[$field])) {
	        $errors[$field] = 'Это поле надо заполнить';        
        }
    }
    

	$email = mysqli_real_escape_string($con, $form['email']);
	$sql = "SELECT name, email, pass FROM users WHERE email = '$email'";
	$res = mysqli_query($con, $sql);

	$user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
	$us = $user['pass'];
	$user_pass = password_hash($us, PASSWORD_DEFAULT);

	
	if (!count($errors) and $user) {

		if($user['name']!== $form['name']) {
			 	$errors['name'] = 'Введено неправильное имя';
		}
			
		if (password_verify($form['password'], $user_pass)) {
			$_SESSION['user'] = $user;
		}
		else {
			$errors['password'] = 'Неверный пароль';
		}

	}
	else {
		$errors['email'] = 'E-mail введён некорректно';
	}

	if (count($errors)) {
		$content = include_template('enter_add.php', ['form' => $form, 'errors' => $errors, 'required' => $required]);
	
	}
	else {
		$content = include_template('enter_add.php', ['form' => $form, 'errors' => $errors, 'required' => $required]);
	}
}
else {
    if (isset($_SESSION['user'])) {
     $content = include_template("enter_add.php", ['form' => $form, 'errors' => $errors]);
    }
    else {
        $content = include_template('enter_add.php', []);
    }
}

print($content);