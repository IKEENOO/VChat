<?php 
    session_start();
// Проверяем, установлена ли сессия 'unique_id', чтобы убедиться, что пользователь аутентифицирован
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        // Получаем идентификатор отправителя из сессии
        $outgoing_id = $_SESSION['unique_id'];
        // Получаем идентификатор получателя из POST-запроса и защищаем его от SQL-инъекций
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";
        // Запрос для выборки сообщений между отправителем и получателем
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($conn, $sql);
        // Проверяем, есть ли сообщения в результате запроса
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                // Проверяем, является ли отправитель текущего сообщения текущим пользователем
                // В зависимости от этого формируем HTML-код для отправленного и полученного сообщений
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }else{
                    // Если нет доступных сообщений, выводим соответствующее сообщение
                    $output .= '<div class="chat incoming">
                                <img src="php/images/'.$row['img'].'" alt="">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }
            }
        }else{
            // Если нет доступных сообщений, выводим соответствующее сообщение
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        // Выводим сформированный HTML-код
        echo $output;
    }else{
        // Если сессия 'unique_id' не установлена, перенаправляем пользователя на страницу входа
        header("location: ../login.php");
    }
