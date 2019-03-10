<?php

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = mysqli_connect("localhost", "root", "", "works") or die (mysqli_error($con));

    mysqli_set_charset($con, "utf8");

    session_start();


function db_get_prepare_stmt($con, $sql, $data = []) {
    $stmt = mysqli_prepare($con, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

function show_error(&$content, $error) {
    $content = include_template('error.php', ['error' => $error]);
}

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require_once $name;

    $result = ob_get_clean();

    return $result;
}

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
    
    ?>