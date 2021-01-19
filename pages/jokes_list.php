<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto4">
    <h1 class="display-4">Все шутки</h1>
</div>
<div class="row row-cols-1 row-cols-md-4 mb-3">
    <?php
        $query = mysqli_query($db, "SELECT id, joke FROM `jokes` ORDER BY `id` desc");
        foreach ($query as $row){
    ?>
        <div class="col">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <p class="clip"><?=$row['joke']?></p>
                    <a href="./?page=joke&id=<?=$row['id']?>" target="_blank" class="w-100 btn btn-outline-primary">Открыть</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>