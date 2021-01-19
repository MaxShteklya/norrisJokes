<?php
    $joke_id = $_GET['id'];


    if($_POST) {
        $comment = trim(htmlspecialchars(mysqli_real_escape_string($db, $_POST['comment'])));
        $author_id = $_SESSION['user_id'];
        $query = mysqli_query($db, "INSERT INTO `comments` (`comment`, `joke_id`, `author`) VALUES ('$comment', '$joke_id', '$author_id')");
    }

    $query = mysqli_query($db, "SELECT * FROM `jokes` WHERE `id`=$joke_id");
    if(!mysqli_num_rows($query)){
        echo "<p class='lead text-center mt-5 mb-5'>Данной шутки не существует или она была удалена :( <br><a href='./' class='text-decoration-none'>Дргуие шутки</a></p>";
    }else{
        $row = mysqli_fetch_assoc($query);
        $edit = false;
        if($row['author'] == $_SESSION['user_id']) $edit = true;
?>
<div class="row">
    <div class="col-12 col-sm-8 col-md-6 mx-auto">
        <div class="card my-5 shadow-sm">
            <div class="card-body">
                <p class="joke_text"><?=$row['joke']?></p>
                <?php if($edit) { ?><button class='btn btn-success mt-1 save_changes'>Сохранить</button><?php } ?>
            </div>
            <?php if($edit) { ?>
            <div class="redact">
                <a class="edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                    </svg>
                </a>
                <a href="./deleteJoke.php?id=<?=$joke_id?>" class="trash">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </a>
            </div>
            <?php } ?>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-8 col-md-6 mx-auto">
        <h2 class="display-6">Коментарии:</h2>
            <?php if(!isset($_SESSION['user_id']))
                echo "Оставить коментарий могут только авторизированные пользователи. <a href='./login.php'>Авторизироваться</a>";
            else { ?>
                <form action="#" method="post" class="w-75">
                    <textarea class="form-control comment_area" name="comment" rows="4" placeholder="Введите коментарий..."></textarea>
                    <button type="submit" class="btn btn-success mt-1 add_btn">Добавить</button>
                </form>
            <?php } ?>

        <?php
            $query_comment = mysqli_query($db, "SELECT comment, author FROM `comments` WHERE `joke_id` = $joke_id ORDER BY id DESC");
            if(!mysqli_num_rows($query_comment)) echo "<p class='text-secondary my-4'>Коментариев пока нету.</p>";
            foreach ($query_comment as $row){
                $query_author = mysqli_query($db, "SELECT login FROM `users` WHERE `id`=$row[author]");
                $author_name = mysqli_fetch_assoc($query_author);
        ?>
                <div class="col">
                    <div class="card my-4">
                        <div class="card-header"><?=$author_name['login']?></div>
                        <div class="card-body">
                            <p><?=$row['comment']?></p>
                        </div>
                    </div>
                </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
<script>
    $(function (){
        $(".edit").click(function (){
            $(".joke_text").attr("contenteditable", true).focus()
            $(".save_changes").show()
        })
        $(".save_changes").click(function (){
            $(".joke_text").attr("contenteditable", false)
            text = $(".joke_text").html()
            $.ajax({
                type: "POST",
                url: 'editJoke.php',
                data: "id=<?=$joke_id?>&text="+text,
            })
            $(this).hide()
        })
    })
</script>