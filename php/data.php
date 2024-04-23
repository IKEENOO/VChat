<?php
    while($row = mysqli_fetch_assoc($query)) {
        // Запрос для получения последнего сообщения между текущим пользователем и пользователем из результата первого запроса
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);

        // Проверка наличия сообщений в результате второго запроса
        // Если есть сообщения, то присваиваем переменной $result значение последнего сообщения, иначе устанавливаем "No message available"
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
        // Обрезаем сообщение, если его длина превышает 28 символов, и добавляем многоточие
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        // Проверяем, является ли отправитель текущего сообщения текущим пользователем
        // Если да, то устанавливаем "You: ", иначе оставляем пустую строку
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        }else{
            $you = "";
        }
        // Проверяем статус пользователя и устанавливаем класс "offline", если статус равен "Offline now"
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        // Проверяем, является ли отправитель текущего сообщения текущим пользователем
        // Если да, то устанавливаем класс "hide", иначе оставляем пустую строку
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";
        // Формируем HTML-код для каждой записи
        $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                    <div class="content">
                    <img src="php/images/'. $row['img'] .'" alt="">
                    <div class="details">
                        <span>'. $row['fname']. " " . $row['lname'] .'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
