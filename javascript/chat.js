const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault(); // Предотвращение отправки формы по умолчанию
}

inputField.focus(); // Установка фокуса на поле ввода

inputField.onkeyup = ()=> { // Обработчик события при вводе текста в поле ввода
    if(inputField.value != ""){
        sendBtn.classList.add("active"); // Добавление класса "active" для активации кнопки отправки
    }else{
        sendBtn.classList.remove("active"); // Удаление класса "active" для деактивации кнопки отправки
    }
}

sendBtn.onclick = ()=> { // Обработчик события клика на кнопку отправки
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true); // Настройка запроса POST на "php/insert-chat.php" с асинхронным режимом
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = ""; // Очистка значения поля ввода
              scrollToBottom(); // Прокрутка вниз до конца чата
          }
      }
    }
    let formData = new FormData(form); // Создание объекта FormData для отправки данных формы
    xhr.send(formData);
}
chatBox.onmouseenter = ()=> { // Обработчик события при наведении на контейнер чата
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=> { // Обработчик события при уходе курсора с контейнера чата
    chatBox.classList.remove("active");
}

setInterval(() => { // Обновление чата с определенным интервалом
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true); // Настройка запроса POST на "php/get-chat.php" с асинхронным режимом
    xhr.onload = ()=> {
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data; // Обновление содержимого контейнера чата
            if(!chatBox.classList.contains("active")){
                scrollToBottom(); // Прокрутка вниз до конца чата, если контейнер чата неактивен
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Установка заголовка запроса с типом контента
    xhr.send("incoming_id="+incoming_id); // Отправка данных формы на сервер с идентификатором входящего сообщения
}, 500);

function scrollToBottom(){ // Функция прокрутки вниз до конца чата
    chatBox.scrollTop = chatBox.scrollHeight; // Установка значения scrollTop контейнера чата равным его высоте
  }
  