<?php
    require_once("functions.php");
$con = mysqli_connect("localhost", "root", "", "works");
    mysqli_set_charset($con, "utf8");
if (!$con) {
    $error = mysqli_connect_error();
    show_error($content, $error);
}
else {
    $sql = 'SELECT id, name FROM project WHERE user_id = 1';
    $result = mysqli_query($con, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        show_error($content, $error);
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST;

    $required = ['name', 'project', 'date_exec'];
    $dict = ['title' => 'Название', 'project' => 'Проект', 'date_exec'=> 'Дата выполнения', 'file' => ''];
    $errors = [];
    print_r($_POST);
    print_r($_FILES);
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }

        $new_date = strtotime($_POST['date_exec']);

        if (time() > $new_date) {
          $errors['date_exec'] = 'Неправильный ввод даты';
        };
           
   
        foreach ($categories as $cat) {
            if ($cat['name'] === $_POST['project']){
                $project_id = $cat['id'];
            } 
            }   
        if ($project_id === NULL) {
            $errors['project'] = 'Неправильный ввод имени проекта';
            }
}
        if (isset($_FILES['preview']['name'])) {
        $tmp_name = $_FILES['preview']['tmp_name'];
        $path = $_FILES['preview']['name'];

        
        $file_type = $_FILES['preview']['type'];
        if ($file_type !== "image/jpeg") {
            $errors['preview'] = 'Загрузите картинку в формате JPEG';
        }
        else {
            move_uploaded_file($tmp_name, '' . $path);
            $task['file'] = $path;
        }
        }
        else {
        $errors['preview'] = 'Вы не загрузили файл';
        }

        
        $sql = 'INSERT INTO tasks (date_exec, user_id, name, file, project_id) VALUES (?, 1, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($con, $sql, [$task['date_exec'], $task['name'], $task['file'], $project_id]);
        $res = mysqli_stmt_execute($stmt);

       /* if ($res) {
            $gif_id = mysqli_insert_id($link);

            header("Location: gif.php?id=" . $gif_id);
        }
        else {
            $content = include_template('error.php', ['error' => mysqli_error($link)]);
        }
    
}

print include_template('index.php', ['content' => $content, 'categories' => $categories]);

        /**/


   



}
    $content = include_template("layout_add.php", ['errors' => $errors, 'dict' => $dict, 'task' => $task ]);

   /* if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $gif = $_POST['gif'];

        $filename = uniqid() . '.gif';
        $gif['path'] = $filename;
        move_uploaded_file($_FILES['gif_img']['tmp_name'], 'uploads/' . $filename);



    }
}

print include_template('index.php', ['content' => $content, 'categories' => $categories]);?>*/

 print($content);

 ?>