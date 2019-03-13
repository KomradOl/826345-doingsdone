<?php
require_once "functions.php";
$show_complete_tasks = (int)($_GET['show_completed'] ?? null);
if (isset($_SESSION['user'])) {
    $user      = $_SESSION['user'];
    $user_id   = $user['id'];
    $user_name = $user['name'];

    if ($stat_task = $_GET["stat_task"] ?? null) {
        $stat_task    = (int) $stat_task;
        $sql_tasks    = "SELECT  status FROM tasks  WHERE id = $stat_task";
        $result_tasks = mysqli_query($con, $sql_tasks) or die(mysqli_error($con));
        $tasks_stat   = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
        if (isset($tasks_stat)) {
            $new_status   = $tasks_stat[0]['status'] === '1' ? 0 : 1;
            $sql_tasks    = "UPDATE tasks SET status = $new_status WHERE id = $stat_task";
            $result_tasks = mysqli_query($con, $sql_tasks) or die(mysqli_error($con));
        }
    }

    if ($tab = $_GET["tab"] ?? null) {
        $tab = (int) $tab;

        $sql_project    = "SELECT name, id FROM project WHERE user_id = $user_id";
        $result_project = mysqli_query($con, $sql_project) or die(mysqli_error($con));
        $categories     = mysqli_fetch_all($result_project, MYSQLI_ASSOC);
        $categories_id  = categories_id($categories);

        if (!array_key_exists($tab, categories_id($categories))) {
            http_response_code(404);
            exit;
        }

        $sql_tasks    = "SELECT t.date_exec, t.status, t.id, t.file, t.name, p.NAME pname, t.project_id  FROM tasks t join project p on p.ID = t.project_id WHERE t.project_id = $tab";
        $result_tasks = mysqli_query($con, $sql_tasks) or die(mysqli_error($con));
        $tasks_list   = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

    } else {
        $sql_project    = "SELECT name, id FROM project WHERE user_id = $user_id";
        $result_project = mysqli_query($con, $sql_project) or die(mysqli_error($con));
        $categories     = mysqli_fetch_all($result_project, MYSQLI_ASSOC);

        $sql_tasks    = "SELECT t.date_exec, t.status, t.file, t.id, t.name, p.NAME pname, t.project_id  FROM tasks t join project p on p.ID = t.project_id WHERE t.user_id = $user_id";
        $result_tasks = mysqli_query($con, $sql_tasks) or die(mysqli_error($con));
        $tasks_list   = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

    }
    $task_choice = (int)($_GET["task_choice"] ?? null);
    
    $page_content = include_template("index.php", ["show_complete_tasks" => $show_complete_tasks, "tasks_list" => $tasks_list, 'task_choice' => $task_choice, 'tab' =>$tab]);

    $layout_content = include_template("layout.php", ["content" => $page_content, "title" => "Дела в порядке", "user_name" => $user_name, "categories" =>
        $categories, "tasks_list" => $tasks_list]);
} else {

    $page_content = include_template("index.php", ["show_complete_tasks" => $show_complete_tasks]);

    $layout_content = include_template("layout.php", ["content" => $page_content, "title" => "Дела в порядке"]);

}

print($layout_content);
