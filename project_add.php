<?php
require_once "functions.php";
if (isset($_SESSION['user'])) {
    $user      = $_SESSION['user'];
    $user_id   = $user['id'];
    $user_name = $user['name'];

    $sql        = "SELECT name, id FROM project WHERE user_id = $user_id";
    $result     = mysqli_query($con, $sql) or die(mysqli_error($con));
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $required = ['name'];
        $dict     = ['name' => 'Название проекта'];
        $errors   = [];
        $task = $_POST;
        if (preg_match("/script|http|&lt;|&gt;|&lt;|&gt;|SELECT|UNION|UPDATE|exe|exec|INSERT|tmp/i", $task['name'])) {
            $errors['name'] = 'Введите правильное имя';
        }

        foreach ($required as $key) {
            if (empty($task[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        foreach ($categories as $cat) {
            if ($cat['name'] === $task['name']) {
                $errors['name'] = 'Такой проект уже есть';
            }
        }

        if (count($errors)) {

            $content = include_template("project_add.php", ['errors' => $errors, 'dict' => $dict, 'task' => $task]);

        } else {
            $sql  = 'INSERT INTO project (name, user_id) VALUES (?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql, [$task['name'], $user_id]);
            $res  = mysqli_stmt_execute($stmt);
            header("Location: /index.php");
            exit();
        }
    } else {
            $content = include_template("project_add.php", []);
        }
    $sql_tasks    = "SELECT t.date_exec, t.status, t.name, p.NAME pname, t.project_id  FROM tasks t join project p on p.ID = t.project_id WHERE t.user_id = $user_id";
    $result_tasks = mysqli_query($con, $sql_tasks) or die(mysqli_error($con));
    $tasks_list   = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

    $layout_content = include_template("layout.php", ["content" => $content, "title" => "Дела в порядке", "user_name" => $user_name, "categories" =>
        $categories, "tasks_list" => $tasks_list]);
}
print($layout_content);
