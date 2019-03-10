<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required = ['email', 'password', 'name'];
    $dict     = ['email' => 'E-mail', 'password' => 'Пароль', 'name' => 'Имя'];
    $errors   = [];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    $email = mysqli_real_escape_string($con, $form['email']);
    $sql   = "SELECT name, email, pass FROM users WHERE email = '$email'";
    $res   = mysqli_query($con, $sql);
    $user  = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if ($user !== null) {
        $errors['email'] = 'Такой E-mail уже используется';
    } 
    else {
        if (filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
            $user['email'] = $form['email'];
        } else {
            $errors['email'] = 'E-mail введён некорректно';
        }

        $user['pass'] = password_hash($form['password'], PASSWORD_DEFAULT);
       	$user['name'] = $form['name'];
       }

    if (!count($errors)) {

        $sql  = "INSERT INTO users (date_reg, name, email, pass) VALUES (NOW(), ?, ?, ?)";
        $stmt = db_get_prepare_stmt($con, $sql, [$user['name'], $form['email'], $user['pass']]);
        $res  = mysqli_stmt_execute($stmt);
        header("Location: /auth.php");
        exit();
    }
    else {
    	$content = include_template('enter_add.php', ['required'=> $required, 'errors' => $errors, 'dict' =>$dict]);
    }


}
else {
$content = include_template('enter_add.php', []);
}
print($content);

?>