<?php 
/*
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
  */
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
        /*
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
          // Выбираем пользователя из базы данных по его идентификатору
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql); // Получаем данные выбранного пользователя
          }else{
            header("location: users.php"); // Если пользователь не найден, перенаправляем на страницу с пользователями
          }
          */
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php //echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php //echo $row['fname']. " " . $row['lname'] ?></span>
          <p><?php //echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <button class="btn__file"><i class="fa fa-paperclip"></i></button>
        <input type="text" class="incoming_id" name="incoming_id" value="<?php //echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button class="btn__send"><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="javascript/chat.js"></script>

</body>
</html>
