<div class="container">

    <div class="row no-gutters" id="photo-container">
        <?php foreach ($data['photos'] as $item): ?>
            <div class="col-lg-6 col-main-block">
                <?php require 'views/includes/photo_block.php' ?>
            </div>
        <?php endforeach ?>
    </div>

    <div class="show-more-block" id="show-more-block">
        <span class="show-more" id="show-more">show more</span>
    </div>

</div>

<script type="module">
    window.photos = <?= json_encode($data['photos']) ?>;
    window.ld_photo_count = 6;
</script>
<script src="/template/js/photo_layout/index.js" type="module"></script>
