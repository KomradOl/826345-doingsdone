<?php
    require_once("functions.php");
// показывать или нет выполненные задачи
    $show_complete_tasks = rand(0, 1);

    $con = mysqli_connect("localhost", "root", "", "works") or die (mysqli_error($con));

    mysqli_set_charset($con, "utf8");

    $sql_project = "SELECT name, id FROM project WHERE user_id = 1";
    $result_project = mysqli_query($con, $sql_project) or die (mysqli_error($con));
    $categories = mysqli_fetch_all($result_project, MYSQLI_ASSOC);

    $sql_tasks = "SELECT t.date_exec, t.status, t.name, p.NAME pname, t.project_id   FROM tasks t join project p on p.ID = t.PROJECT_ID WHERE t.user_id = 1";
    $result_tasks = mysqli_query($con, $sql_tasks) or die (mysqli_error($con));
    $tasks_list = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

    
      
    if($tab = $_GET["tab"] ?? NULL) {  
    $nam_tasks = "SELECT name FROM tasks WHERE project_id = $tab";
    $result_nam_tasks = mysqli_query($con, $nam_tasks) or die (mysqli_error($con));
    $tasks_nam_list = mysqli_fetch_all($result_nam_tasks, MYSQLI_ASSOC);

    foreach ($tasks_nam_list as $task) {
        if (isset($task['name'])) {
    $sq_tasks = "SELECT t.date_exec, t.status, t.name, p.NAME pname, t.project_id  FROM tasks t join project p on p.ID = t.project_id WHERE t.project_id = $tab";
    $res_tasks = mysqli_query($con, $sq_tasks) or die (mysqli_error($con));
    $tasks_list = mysqli_fetch_all($res_tasks, MYSQLI_ASSOC);
    };       
    };
    

    $r_tab = $tab - 1;
    $sqli_project = "SELECT id FROM project";
    $res_project = mysqli_query($con, $sqli_project) or die (mysqli_error($con));
    $categories_id = mysqli_fetch_all($res_project, MYSQLI_ASSOC);
    if (!array_key_exists($r_tab, $categories_id)) {
    http_response_code(404);
    exit;
    }  
    };
    

    function output_namber($tasks_list, $p_id) {
        $count = 0;              
  
        foreach ($tasks_list as $task) {       
            if ($task['project_id'] == $p_id) {
                $count++;
            };
        };
        return $count;
    }

    function warn_date($tasks_list, $date){ 
        date_default_timezone_set("Europe/Samara");
        setlocale(LC_ALL, "ru_RU.utf8");
        $ts = time();
        $secs_in_day = 86400;
        $dt_end = strtotime($date);
        $dt_dif = $dt_end - $ts; 
        $days_until_end = floor($dt_dif / $secs_in_day);

         if($days_until_end < 0 && $days_until_end > -2) {
            $dt_warn = "task--important";
        };
  
        return  $dt_warn;
        
    }

    

    $page_content = include_template("index.php", ["show_complete_tasks" => $show_complete_tasks, "tasks_list" => $tasks_list]);

    $layout_content = include_template("layout.php", ["content" => $page_content, "user_name" => "Константин", "title" => "Дела в порядке",
     "categories" => $categories, "tasks_list" => $tasks_list]);

    print($layout_content);

   ?>