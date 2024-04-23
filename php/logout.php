<?php
    session_start();
// Проверяем, установлена ли сессия 'unique_id', чтобы убедиться, что пользователь аутентифицирован
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        // Получаем значение идентификатора для выхода из сессии из GET-запроса и защищаем его от SQL-инъекций
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){
            $status = "Offline now";
            // Обновляем статус пользователя на "Offline now"
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
            if($sql){
                // Очищаем сессию и разрушаем ее
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            // Если идентификатор для выхода из сессии не установлен, перенаправляем пользователя на страницу с пользователями
            header("location: ../users.php");
        }
    }else{
        // Если сессия 'unique_id' не установлена, перенаправляем пользователя на страницу входа
        header("location: ../login.php");
    }
