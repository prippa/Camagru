
<?php foreach ($posts as $post):?>
    <h2><?= $post['title'];?></h2>
    <p><?= $post['content'];?></p>
<!--    <p>--><?//= $post['image'];?><!--</p>-->
    <img src="/uploads/<?= $post['image'];?>" width="50">
<?php endforeach;?>
