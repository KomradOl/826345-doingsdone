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
        $task = $_POST;

        $required = ['name', 'project', 'date_exec'];
        $dict     = ['name' => 'Название', 'project' => 'Проект', 'date_exec' => 'Дата выполнения'];
        $errors   = [];

        foreach ($required as $key) {
            if (empty($task[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
            }
            $new_date = strtotime($task['date_exec']);
         
            if (floor($new_date/86400) < floor(time()/86400)-2) {
                $errors['date_exec'] = 'Неправильный ввод даты';
            }

            foreach ($categories as $cat) {
                if ($cat['name'] === $task['project']) {
                    $project_id = $cat['id'];
                }
            }
            if ($project_id === null) {
                $errors['project'] = 'Неправильный ввод имени проекта';
            }
            
        if (isset($_FILES['preview']) && $_FILES['preview']['size'] !== 0) {
            $tmp_name = $_FILES['preview']['tmp_name'];
            $path     = $_FILES['preview']['name'];
            $file_type = $_FILES['preview']['type'];
            if ($file_type !== "image/jpeg" && $file_type !== "image/png" && $file_type !== "image/jpeg") {
                $errors['preview'] = 'Загрузите файл в формате JPEG/PNG';

            } else {
                move_uploaded_file($tmp_name, '' . $path);
                $task['file'] = $path;
                $sql = 'INSERT INTO tasks (date_exec, name, file, project_id, user_id, status) VALUES (?, ?, ?, ?, ?, ?)';
                $stmt = db_get_prepare_stmt($con, $sql, [$task['date_exec'], $task['name'], $task['file'], $project_id, $user_id, 0]);
            }
        }
        else {
            $sql = 'INSERT INTO tasks (date_exec, name,  project_id, user_id, status) VALUES (?, ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql, [$task['date_exec'], $task['name'],  $project_id, $user_id, 0]);
        }

        if (count($errors)) {
            $content = include_template("layout_add.php", ['errors' => $errors, 'dict' => $dict, 'task' => $task, "categories" => $categories]);
        } 
        else {
            $res  = mysqli_stmt_execute($stmt);
            header("Location: /index.php");
            exit();
        }

     }
     else {
        $content = include_template("layout_add.php", ["categories" => $categories]);
        }
    
    $sql_tasks    = "SELECT t.date_exec, t.status, t.name, p.NAME pname, t.project_id  FROM tasks t join project p on p.ID = t.project_id WHERE t.user_id = $user_id";
    $result_tasks = mysqli_query($con, $sql_tasks) or die(mysqli_error($con));
    $tasks_list   = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

    $layout_content = include_template("layout.php", ["content" => $content, "title" => "Дела в порядке", "user_name" => $user_name, "categories" =>
        $categories, "tasks_list" => $tasks_list]);
    
}
print($layout_content);
