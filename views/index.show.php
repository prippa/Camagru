<?php require_once 'config/dirs.php'; ?>

<?php foreach ($posts as $post): ?>
    <h2><?= $post['title']; ?></h2>
    <p><?= $post['content']; ?></p>
    <img src="<?= '/Camagru/uploads/' . $post['image']; ?>" width="400">
<?php endforeach; ?>
