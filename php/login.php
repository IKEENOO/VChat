<?php 
    session_start();
    require_once "config.php";
    // Получаем значение email из POST-запроса и защищаем его от SQL-инъекций
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Получаем значение пароля из POST-запроса и защищаем его от SQL-инъекций
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($email) && !empty($password)){
        // Если поле email и пароль не пустые, выполняем запрос на выборку пользователя из базы данных
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        // Проверяем, есть ли результаты запроса (найден ли пользователь с таким email)
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            // Хешируем введенный пароль для сравнения с хранящимся в базе данных
            $user_pass = md5($password);
            $enc_pass = $row['password'];
            // Сравниваем хешированные пароли
            if($user_pass === $enc_pass){
                $status = "Active now";
                // Обновляем статус пользователя на "Active now"
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                if($sql2){
                    // Если обновление статуса прошло успешно, устанавливаем сессию 'unique_id' равной идентификатору пользователя
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                }else{
                    echo "Something went wrong. Please try again!";
                }
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else{
            echo "$email - This email not Exist!";
        }
    }else{
        echo "All input fields are required!";
    }
