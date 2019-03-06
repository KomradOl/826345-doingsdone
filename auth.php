<?php
require_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required = ['email', 'password'];
    $errors   = [];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    $email = mysqli_real_escape_string($con, $form['email']);
    $sql   = "SELECT id, name, email, pass FROM users WHERE email = '$email'";
    $res   = mysqli_query($con, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    $user_pass = $user['pass'];
    if (!count($errors) and $user) {

        if (password_verify($form['password'], $user_pass)) {
            $_SESSION['user'] = $user;

        } else {
            $errors['password'] = 'Неверный пароль';password_hash($us, PASSWORD_DEFAULT);

        }

    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $content = include_template('auth.php', ['form' => $form, 'errors' => $errors, 'required' => $required]);

    } else {
        header("Location: /index.php");
        exit();
    }

} else {
    if (isset($_SESSION['user'])) {
        $content = include_template("auth.php.", ['form' => $form, 'errors' => $errors]);
    } else {
        $content = include_template('auth.php', []);
    }
}

print($content);
