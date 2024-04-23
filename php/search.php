<?php
    session_start();
    include_once "config.php";
    // Получаем идентификатор отправителя из сессии
    $outgoing_id = $_SESSION['unique_id'];
    // Получаем значение поискового запроса из POST-запроса и защищаем его от SQL-инъекций
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    // Формируем SQL-запрос для выборки пользователей, совпадающих с поисковым запросом
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = mysqli_query($conn, $sql);
    // Проверяем, есть ли результаты запроса (найдены ли пользователи)
    if(mysqli_num_rows($query) > 0){
        include_once "data.php"; // Включаем файл с обработкой данных пользователей
    }else{
        $output .= 'No user found related to your search term'; // Если пользователи не найдены, формируем сообщение об отсутствии результатов
    }
    echo $output; // Выводим результаты поиска или сообщение об отсутствии результатов
