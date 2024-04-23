<?php 
    session_start();
// Проверяем, установлена ли сессия 'unique_id', чтобы убедиться, что пользователь аутентифицирован
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        // Получаем идентификатор отправителя из сессии
        $outgoing_id = $_SESSION['unique_id'];
        // Получаем идентификатор получателя из POST-запроса и защищаем его от SQL-инъекций
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        // Получаем текст сообщения из POST-запроса и защищаем его от SQL-инъекций
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        if(!empty($message)){
            // Если сообщение не пустое, выполняем запрос на вставку сообщения в базу данных
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
        }
    }else{
        // Если сессия 'unique_id' не установлена, перенаправляем пользователя на страницу входа
        header("location: ../login.php");
    }
