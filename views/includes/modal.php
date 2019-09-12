<div class="modal" id="modal-<?= $item['id'] ?>">
    <div class="modal-content">

        <div class="close-modal" id="close-modal-<?= $item['id'] ?>">&times;</div>

        <div class="descriptions-block">
            <div class="row no-gutters">
                <div class="col-auto mr-auto">
                    <div class="post-head-elem">
                        <div>By: <b class="post-login"><?= $item['login'] ?></b></div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="post-head-elem">
                        <div class="post-create-date"><?= $item['create_date'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <img class="img-fluid" src="<?= $item['img'] ?>" alt="">

        <div class="likes-block p-2">
            <div class="row no-gutters">
                <div class="col-6">
                    <div class="post-like" id="like-<?= $item['id'] ?>">
                        <img class="like-img" src="/template/images/like.png" alt="">
                        <span id="like-count-<?= $item['id'] ?>"><?= $item['likes'] ?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="post-dislike" id="dislike-<?= $item['id'] ?>">
                        <img src="/template/images/dislike.png" alt="">
                        <span id="dislike-count-<?= $item['id'] ?>"><?= $item['dislikes'] ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="comments-block p-2" id="comments-block-<?= $item['id'] ?>">
            <?php foreach ($item['comments'] as $value): ?>
                <div class="comment-block">
                    <b><?= $value['login'] ?></b>:
                    <span><?= htmlspecialchars($value['comment']) ?></span>
                </div>
            <?php endforeach ?>
        </div>

        <div class="leave-comment-block">
            <div class="row no-gutters p-2">
                <div class="col-12">
                    <div class="comment-error" id="comment-error-<?= $item['id'] ?>"></div>
                </div>
                <div class="col-9 pr-2">
                    <input class="form-control modal-input"
                           placeholder="Write comment..."
                           id="comment-input-<?= $item['id'] ?>"/>
                </div>
                <div class="col-3">
                    <button class="btn btn-primary btn-block"
                            id="comment-btn-<?= $item['id'] ?>">Send</button>
                </div>
            </div>
        </div>

    </div>
</div>