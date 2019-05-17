
<?php foreach ($posts as $post): ?>
    <h2><?= $post['title']; ?></h2>
    <p><?= $post['content']; ?></p>
    <img src="<?= '/Camagru/trash/Posts/uploads/' . $post['image']; ?>" width="500">
<?php endforeach; ?>
