<div class="container">
    <div class="row">

        <div class="col-12">
            <div class="descriptions-block">
                <div class="row no-gutters">
                    <div class="col-auto mr-auto">
                        <div class="post-head-elem">
                            <div>By: <b class="post-login"><?= $data['photo']['login'] ?></b></div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="post-head-elem">
                            <div class="post-create-date"><?= $data['photo']['create_date'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <img class="img-fluid" src="/<?= $data['photo']['img'] ?>" alt="">
        </div>

        <div class="col-12">
            <div class="likes-block p-2">
                <div class="row no-gutters">
                    <div class="col-6">
                        <div class="post-like" id="like">
                            <img class="like-img" src="/template/images/like.png" alt="">
                            <span id="like-count"><?= $data['photo']['likes'] ?></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="post-dislike" id="dislike">
                            <img src="/template/images/dislike.png" alt="">
                            <span id="dislike-count"><?= $data['photo']['dislikes'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="comments-block p-2" id="comments-block">
                <?php foreach ($data['photo']['comments'] as $value): ?>
                    <div class="comment-block">
                        <b><?= $value['login'] ?></b>:
                        <span class="comment"><?= htmlspecialchars($value['comment']) ?></span>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="col-12">
            <div class="leave-comment-block">
                <div class="row no-gutters p-2">
                    <div class="col-12">
                        <div class="comment-error" id="comment-error"></div>
                    </div>
                    <div class="col-9 pr-2">
                        <input class="form-control modal-input" placeholder="Write comment..." id="comment-input">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary btn-block" id="comment-btn">Send</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="module">
    window.photo = <?= json_encode($data['photo']) ?>;
    window.is_logged = <?= $data['is_logged'] ? 1 : 0 ?>;
    window.login = '<?= $data['login'] ?>';
</script>
<script src="/template/js/single_photo.js" type="module"></script>