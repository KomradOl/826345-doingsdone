<?php
    require_once("functions.php");
// показывать или нет выполненные задачи
    $show_complete_tasks = rand(0, 1);
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $user_id = $user['id'];
        $user_name = $user['name'];
    

    if($tab = $_GET["tab"] ?? NULL) {
    $tab = (int)$tab;

    $sql_project = "SELECT name, id FROM project WHERE user_id = $user_id";
    $result_project = mysqli_query($con, $sql_project) or die (mysqli_error($con));
    $categories = mysqli_fetch_all($result_project, MYSQLI_ASSOC);  
    
    $nam_tasks = "SELECT id, name FROM tasks WHERE project_id = $tab ";
    $result_nam_tasks = mysqli_query($con, $nam_tasks) or die (mysqli_error($con));
    $tasks_nam_list = mysqli_fetch_all($result_nam_tasks, MYSQLI_ASSOC);

    if (!empty($tasks_nam_list)) {
    $sql_tasks = "SELECT t.date_exec, t.status, t.id, t.name, p.NAME pname, t.project_id  FROM tasks t join project p on p.ID = t.project_id WHERE t.project_id = $tab";
    } else {
    $sql_tasks = "SELECT t.date_exec, t.status, t.name, p.NAME pname, t.project_id  FROM tasks t join project p on p.ID = t.project_id WHERE t.user_id = $user_id";
    };
    $result_tasks = mysqli_query($con, $sql_tasks) or die (mysqli_error($con));
    $tasks_list = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);       

    $r_tab = $tab - 1;
    $sqli_project = "SELECT id FROM project";
    $res_project = mysqli_query($con, $sqli_project) or die (mysqli_error($con));
    $categories_id = mysqli_fetch_all($res_project, MYSQLI_ASSOC);
    if (!array_key_exists($r_tab, $categories_id)) {
    http_response_code(404);
    exit;
    }

    } else {
    $sql_project = "SELECT name, id FROM project WHERE user_id = $user_id";
    $result_project = mysqli_query($con, $sql_project) or die (mysqli_error($con));
    $categories = mysqli_fetch_all($result_project, MYSQLI_ASSOC);
    
    $sql_tasks = "SELECT t.date_exec, t.status, t.name, p.NAME pname, t.project_id  FROM tasks t join project p on p.ID = t.project_id WHERE t.user_id = $user_id";
    $result_tasks = mysqli_query($con, $sql_tasks) or die (mysqli_error($con));
    $tasks_list = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
    }
    }
    $page_content = include_template("index.php", ["show_complete_tasks" => $show_complete_tasks, "tasks_list" => $tasks_list]);
 
    $layout_content = include_template("layout.php", ["content" => $page_content, "title" => "Дела в порядке", "user_name" => $user_name,  "categories" => 
        $categories, "tasks_list" => $tasks_list]);

    print($layout_content);

   ?>