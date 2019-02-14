<?php
    require_once("functions.php");

// показывать или нет выполненные задачи
    $show_complete_tasks = rand(0, 1);

    $con = mysqli_connect("localhost", "root", "", "works") or die (mysqli_error($con));

    mysqli_set_charset($con, "utf8");

    $sql_project = "SELECT name FROM project WHERE user_id = 1";
    $result_project = mysqli_query($con, $sql_project) or die (mysqli_error($con));
    $categories = mysqli_fetch_all($result_project, MYSQLI_ASSOC);

    $sql_tasks = "SELECT t.date_exec, t.status, t.name, p.NAME pname FROM tasks t join project p on p.ID = t.PROJECT_ID WHERE t.user_id = 1";
    $result_tasks = mysqli_query($con, $sql_tasks) or die (mysqli_error($con));
    $tasks_list = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
    

    function output_namber($tasks_list, $name) {
        $count = 0;                
        foreach ($tasks_list as $task) {
            if ($task['pname'] == $name) {
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