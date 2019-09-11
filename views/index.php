<div class="container">

    <div class="row no-gutters">
        <?php foreach ($data['posts'] as $item): ?>
            <div class="col-lg-6 col-main-block">

                <!-- Render Modal -->
                <div class="modal" id="modal-<?= $item['id'] ?>">
                    <div class="modal-content">

                        <div class="close-modal-block">
                            <span class="close-modal" id="close-modal-<?= $item['id'] ?>">&times;</span>
                        </div>

                        <img class="img-fluid" src="<?= $item['img'] ?>" alt="">

                        <div class="descriptions-block">
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
                        </div>

                        <div class="comments-block p-2">
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                            <h2>comments</h2>
                        </div>

                        <div class="likes-and-text-input-block">
                            <div class="row no-gutters p-2">
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
                            <div class="row no-gutters p-2">
                                <div class="col-9 pr-2">
                                    <textarea class="form-control modal-textarea"
                                              rows="2" placeholder="Write comment..."></textarea>
                                </div>
                                <div class="col-3 align-self-center">
                                    <button class="btn btn-primary btn-block">Send</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!---->

                <div class="post-block" id="post-block-<?= $item['id'] ?>">
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

            </div>
        <?php endforeach ?>
    </div>

</div>

<script type="module">
    window.posts = <?= json_encode($data['posts']) ?>;
</script>
<script src="/template/js/main.js" type="module"></script>
