<?php
    require_once("functions.php");
// показывать или нет выполненные задачи
    $show_complete_tasks = rand(0, 1);

    $categories = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
    
    $tasks_list = [
    [
        "task" => "Собеседование в IT компании",
        "date" => "01.12.2019",
        "category" => "Работа",
        "completed" => false
    ],
    [
        "task" => "Выполнить тестовое задание",
        "date" => "25.12.2019",
        "category" => "Работа",
        "completed" => false
    ],
    [
        "task" => "Сделать задание первого раздела",
        "date" => "21.12.2019",
        "category" => "Учеба",
        "completed" => true
    ],
    [
        "task" => "Встреча с другом",
        "date" => "22.12.2019",
        "category" => "Входящие",
        "completed" => false
    ],
    [
        "task" => "Купить корм для кота",
        "date" => "Нет",
        "category" => "Домашние дела",
        "completed" => false
    ],
    [
        "task" => "Заказать пиццу",
        "date" => "Нет",
        "category" => "Домашние дела",
        "completed" => false
    ]
    ];

    function output_namber($tasks, $name) {
        $count = 0;                
        foreach ($tasks as $task) {
            if ($task['category'] == $name) {
                $count++;
            };
        };

        return $count;

    }

    $output_namber = output_namber($tasks_list, $category);

    $page_content = include_template("index.php", ["show_complete_tasks" => $show_complete_tasks, "tasks_list" => $tasks_list]);

    $layout_content = include_template("layout.php", ["content" => $page_content, "user_name" => "Константин", "title" => "Дела в порядке", "categories" =>
        $categories, "output_namber" => output_namber, "category" => $category, "tasks_list" => $tasks_list]);

    print($layout_content);
    ?>