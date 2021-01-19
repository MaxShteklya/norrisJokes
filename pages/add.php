<?php
    if(!isset($_SESSION['user_id'])) exit("<p class='lead text-center mt-5 mb-5'>Для посищения данной страницы требуется <a href='./login.php'>авторизироваться</a></p>");

    if($_POST) {
        $author_id = $_SESSION['user_id'];
        $joke = htmlspecialchars(trim(mysqli_real_escape_string($db, $_POST['joke'])));
        $mysql = mysqli_query($db, "INSERT INTO `jokes` (`joke`, `author`) VALUES ('$joke', '$author_id')");
        if($mysql) {
            echo '<div class="alert alert-success" role="alert">Шутка успешно добавлена!</div>';
        }else{
            echo '<div class="alert alert-danger" role="alert">Ошибка!'.mysqli_error($db).'</div>';
        }
    }
?>

<div class="container text-center">
    <h1 class="display-4 mb-4">Добавить шутку</h1>
    <form action="#" method="post" class="w-50 mx-auto">
        <p class="error text-danger"></p>
        <textarea class="form-control joke_area" name="joke" rows="8" placeholder="Введите шутку..."></textarea>
        <button type="button" class="btn btn-outline-secondary mt-3 get_joke">Получить шутку</button>
        <button type="submit" class="btn btn-success mt-3 ms-3 add_btn">Добавить</button>
    </form>
</div>
<script>
    $(function (){
        $(".get_joke").click(function (){
            $.ajax({
                type: "POST",
                url: 'getJoke.php',
                data: "action=getRandomJoke",
                success: function (response){
                    data = JSON.parse(response)
                    $(".joke_area").html(data.value)
                }

            })
        })

        $(".add_btn").click(function (event){
            text = $(".joke_area").val();
            if(text.length == 0) {
                event.preventDefault()
                $(".error").text("Заполниете поле с шуткой")
            }
        })
    })
</script>