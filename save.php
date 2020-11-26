<?php

    require_once 'config.php';

    if(empty($_POST['name'])){
        echo ('<div class="alert alert-danger " role="alert">
                 Введите имя
                </div>');
        exit();
    }
    if(empty($_POST['fullname'])){
        echo ('<div class="alert alert-danger " role="alert">
                 Введите фамилию
                </div>');
        exit();
    }
    if(empty($_POST['age'])){
        echo ('<div class="alert alert-danger " role="alert">
                 Введите возраст
                </div>');
        exit();
    }

    $name = trim($_POST['name']);
    $fullname = trim($_POST['fullname']);
    $age = trim($_POST['age']);
    
    $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
    
    $query ="INSERT INTO users(`name`,`fullname`,`age`) VALUES('$name','$fullname','$age')";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    
    mysqli_close($link);

    echo('<div class="alert alert-success" role="alert">Данные успешно отправлены</div>');
?>