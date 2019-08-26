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
                        <div class="post-like <?= $item['like_status'] == '1' ? 'like' : '' ?>">
                            <img class="likes-img" src="/template/images/like.png" alt=""> <?= $item['likes'] ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="post-dislike <?= $item['like_status'] == '0' ? 'dislike' : '' ?>">
                            <img class="likes-img" src="/template/images/dislike.png" alt=""> <?= $item['dislikes'] ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</div>
<script type="text/javascript" src="/template/js/likes.js"></script>