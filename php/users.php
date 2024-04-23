<?php
    session_start();
    include_once "config.php";
    // Получаем идентификатор отправителя из сессии
    $outgoing_id = $_SESSION['unique_id'];
    // Формируем SQL-запрос для выборки пользователей, кроме отправителя, с сортировкой по убыванию идентификатора пользователя
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    // Проверяем, есть ли доступные пользователи для чата
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat"; // Если пользователей нет, формируем сообщение об их отсутствии
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php"; // Включаем файл с обработкой данных пользователей
    }
    echo $output; // Выводим результаты или сообщение об отсутствии пользователей
