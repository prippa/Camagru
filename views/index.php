<div class="container">
    <div class="row no-gutters">
        <?php foreach ($data['posts'] as $item): ?>
            <div class="col-lg-6 col-main-block">

                <!-- Render Modal -->
                <?php require 'views/includes/modal.php' ?>

                <div class="post-block" id="post-block-<?= $item['id'] ?>">
                    <div class="row no-gutters">
                        <div class="col-auto mr-auto">
                            <div class="post-head-elem">
                                By: <b class="post-login"><?= $item['login'] ?></b>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="post-head-elem">
                                <div class="post-create-date"><?= $item['create_date'] ?></div>
                            </div>
                        </div>
                    </div>
                    <img class="img-fluid main-img" src="<?= $item['img'] ?>" alt="">
                </div>

            </div>
        <?php endforeach ?>
    </div>

</div>

<script type="module">
    window.posts = <?= json_encode($data['posts']) ?>;
    window.login = '<?= $data['login'] ?>';
</script>
<script src="/template/js/photo_layout/main.js" type="module"></script>
