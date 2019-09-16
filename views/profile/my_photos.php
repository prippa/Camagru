<div class="container">
    <div class="row">

        <div class="col-md-4">
            <?php require 'aside.php' ?>
        </div>

        <div class="col-md-8">
            <div class="row no-gutters" id="photo-container">
                <?php foreach ($data['photos'] as $item): ?>
                    <div class="col-12 col-main-block">
                        <?php require 'views/includes/photo_block.php' ?>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="show-more-block" id="show-more-block">
                <span class="show-more" id="show-more">show more</span>
            </div>

        </div>

    </div>
</div>

<script type="module">
    window.photos = <?= json_encode($data['photos']) ?>;
    window.ld_photo_count = 3;
</script>
<script src="/template/js/photo_layout/my_photos.js" type="module"></script>