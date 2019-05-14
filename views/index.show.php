
<?php foreach ($posts as $post):?>
    <h2><?= $post['title'];?></h2>
    <p><?= $post['content'];?></p>
    <img src="/Camagru/uploads/<?= $post['image'];?>" width="50">
<?php endforeach;?>
