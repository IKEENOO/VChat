const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
usersList = document.querySelector(".users-list");

searchIcon.onclick = ()=> { // Обработчик события клика на иконку поиска
  searchBar.classList.toggle("show"); // Переключение класса "show" для отображения/скрытия поля ввода
  searchIcon.classList.toggle("active"); // Переключение класса "active" для изменения стиля иконки
  searchBar.focus();
  if(searchBar.classList.contains("active")){
    searchBar.value = ""; // Очистка значения поля ввода
    searchBar.classList.remove("active");
  }
}

searchBar.onkeyup = ()=> { // Обработчик события при вводе текста в поле поиска
  let searchTerm = searchBar.value; // Получение введенного поискового запроса
  if(searchTerm != ""){
    searchBar.classList.add("active");
  }else{
    searchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest(); // Создание объекта XMLHttpRequest для отправки запроса на сервер
  xhr.open("POST", "php/search.php", true); // Настройка запроса POST на "php/search.php" с асинхронным режимом
  xhr.onload = ()=> {
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data; // Обновление списка пользователей на странице
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Установка заголовка запроса с типом контента
  xhr.send("searchTerm=" + searchTerm); // Отправка данных формы на сервер
}

setInterval(() => { // Обновление списка пользователей с определенным интервалом
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true); // Настройка запроса GET на "php/users.php" с асинхронным режимом
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data; // Обновление списка пользователей на странице при отсутствии активного поиска
          }
        }
    }
  }
  xhr.send(); // Отправка GET-запроса на сервер
}, 500); // Интервал выполнения запроса (500 миллисекунд)
