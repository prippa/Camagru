<div class="container">

    <div class="row">
        <div class="col" id="main-col">
            <div class="row">
                <div class="col-12 mb-3">
                    <aside class="aside-horizontal">
                        <?php foreach ($data['super_images']['base'] as $item): ?>
                            <img alt="" class="img-fluid super-img"
                                 src="/<?= $item['file'] ?>"
                                 id="super-img-base<?= $item['id'] ?>">
                        <?php endforeach ?>
                        <?php foreach ($data['super_images']['frame'] as $item): ?>
                            <img alt="" class="img-fluid super-img"
                                 src="/<?= $item['file'] ?>"
                                 id="super-img-frame<?= $item['id'] ?>">
                        <?php endforeach ?>
                    </aside>
                </div>
                <div class="col-12 mb-3" id="video-col">
                    <video autoplay class="video" id="video-element">
                        No Video support in your browser...
                    </video>
                    <canvas class="super-img-canvas" id="super-img-canvas"></canvas>
                </div>

                <!-- Buttons -->
                <div class="col-md mb-2 display-none" id="col-confirm">
                    <button class="btn btn-success btn-block">Confirm</button>
                </div>
                <div class="col-md mb-2 display-none" id="col-cancel">
                    <button class="btn btn-danger btn-block">Cancel</button>
                </div>
                <div class="col-md mb-2 display-none" id="col-remove-super-img">
                    <button class="btn btn-danger btn-block">Remove super images</button>
                </div>
                <div class="col-md mb-2 display-none" id="col-make">
                    <button class="btn btn-primary btn-block">Make Photo</button>
                </div>
                <div class="col-12 display-none" id="col-load-mod">
                    <button class="btn btn-dark btn-block" id="load-img-from-device">Load from device ...</button>
                </div>
                <!------------->

            </div>
        </div>
        <div class="col-xl-3 made-img-col" id="made-img-col">
            <div class="row">
                <div class="col-12 pb-3">
                    <aside class="aside-vertical">
                        <div class="row no-gutters disable-selection" id="made-img-container">
                            <!-- Made Images -->
                        </div>
                    </aside>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary btn-block" id="btn-upload">Upload</button>
                </div>
            </div>
        </div>
    </div>

</div>

<canvas class="display-none" id="img-canvas"></canvas>

<script type="module">
    window.super_images = <?= json_encode($data['super_images']) ?>;
</script>
<script src="/template/js/make_photo/make_photo.js" type="module"></script>
