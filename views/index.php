<div class="container">

    <div class="row no-gutters">
        <?php foreach ($data['posts'] as $item): ?>
            <div class="col-lg-6 col-main-block">
                <div class="post-block-content">
                    <p class="post-title">By: <i class="post-login"><?= $item['login'] ?></i></p>
                    <img class="img-fluid main-img" src="/uploads/<?= $item['filename'] ?>" alt="">
                </div>
                <div class="row no-gutters mt-1">
                    <div class="col-6">
                        <div id="like-<?= $item['id'] ?>"
                             class="post-like <?= $item['like_status'] == '1' ? 'like' : '' ?>"
                             onclick="like('<?= $item['id'] ?>', '<?= $item['like_status'] ?>')">
                            <img class="likes-img" src="/template/images/like.png" alt=""> <?= $item['likes'] ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="dislike-<?= $item['id'] ?>"
                             class="post-dislike <?= $item['like_status'] == '0' ? 'dislike' : '' ?>"
                             onclick="dislike('<?= $item['id'] ?>', '<?= $item['like_status'] ?>')">
                            <img class="likes-img" src="/template/images/dislike.png" alt=""> <?= $item['dislikes'] ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</div>
<script src="/template/js/lib.js" type="text/javascript"></script>
<script src="/template/js/likes.js" type="text/javascript"></script>