<div class="container">

    <div class="row no-gutters">
        <?php foreach ($data['posts'] as $item): ?>
            <div class="col-lg-6 col-main-block">
                <div class="post-block-content"
                     onclick="runPhotoModal('<?= $item['img'] ?>')">
                    <div class="row no-gutters">
                        <div class="col-auto mr-auto">
                            <div class="post-head-elem">
                                By: <i class="post-login"><?= $item['login'] ?></i>
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
                <div class="row no-gutters mt-1">
                    <div class="col-6">
                        <div id="like-<?= $item['id'] ?>"
                             class="post-like <?= $item['like_status'] == '1' ? 'like' : '' ?>"
                             onclick="like('<?= $item['id'] ?>')">
                            <img class="like-img" src="/template/images/like.png" alt="">
                            <span id="like-count-<?= $item['id'] ?>"><?= $item['likes'] ?></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="dislike-<?= $item['id'] ?>"
                             class="post-dislike <?= $item['like_status'] == '0' ? 'dislike' : '' ?>"
                             onclick="dislike('<?= $item['id'] ?>')">
                            <img src="/template/images/dislike.png" alt="">
                            <span id="dislike-count-<?= $item['id'] ?>"><?= $item['dislikes'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</div>

<script src="/template/js/likes.js" type="module"></script>
<script src="/template/js/photo_modal.js" type="module"></script>
