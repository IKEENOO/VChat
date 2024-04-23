const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault(); // Предотвращение отправки формы и перезагрузки страницы
}

continueBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest(); // Создание объекта XMLHttpRequest для отправки запроса на сервер
    xhr.open("POST", "php/login.php", true); // Настройка запроса POST на "php/login.php" с асинхронным режимом
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){ // Проверка состояния запроса
          if(xhr.status === 200){
              let data = xhr.response;
              if(data === "success"){
                location.href = "users.php";
              }else{
                errorText.style.display = "block"; // Отображение элемента с текстом ошибки
                errorText.textContent = data; // Установка текста ошибки
              }
          }
      }
    }
    let formData = new FormData(form); // Создание объекта FormData для хранения данных формы
    xhr.send(formData); // Отправка данных формы на сервер
}