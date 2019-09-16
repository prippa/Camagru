<div class="container">
    <div class="row no-gutters" id="photo-container">
        <?php foreach ($data['photos'] as $item): ?>
            <div class="col-lg-6 col-main-block">

                <a target="_blank" class="post-block" href="<?= $item['link'] ?>">
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
                </a>

                <div class="row no-gutters pt-2">
                    <div class="col-6">
                        <div class="post-like" id="like<?= $item['id'] ?>">
                            <img class="like-img" src="/template/images/like.png" alt="">
                            <span id="like-count<?= $item['id'] ?>"><?= $item['likes'] ?></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="post-dislike" id="dislike<?= $item['id'] ?>">
                            <img src="/template/images/dislike.png" alt="">
                            <span id="dislike-count<?= $item['id'] ?>"><?= $item['dislikes'] ?></span>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach ?>
    </div>

    <div class="show-more-block">
        <span class="show-more" id="show-more">show more</span>
    </div>

</div>

<script type="module">
    window.photos = <?= json_encode($data['photos']) ?>;
    window.ld_photo_count = 6;
    window.ld_cycle = 1;
</script>
<script src="/template/js/photo_layout/index.js" type="module"></script>
