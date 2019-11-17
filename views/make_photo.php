<div class="container">

    <div class="row">
        <div class="col" id="main-col">
            <div class="row">
                <div class="col-12 mb-3 display-none" id="super-canvas-images">
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
                <div class="col-12 mb-3">
                    <video autoplay class="video display-none" id="video-element">
                        No Video support in your browser...
                    </video>
                    <img class="img-fluid display-none" id="device-img" alt="">
                    <canvas class="super-img-canvas display-none" id="super-img-canvas"></canvas>
                </div>

                <!-- Buttons -->
                <div class="col-md mb-2 display-none" id="col-confirm">
                    <button class="btn btn-success btn-block">Confirm</button>
                </div>
                <div class="col-md mb-2 display-none" id="col-cancel">
                    <button class="btn btn-danger btn-block">Cancel</button>
                </div>
                <div class="col-12 mb-2 display-none" id="col-make">
                    <button class="btn btn-primary btn-block">Make Photo</button>
                </div>
                <div class="col-12" id="super-canvas-buttons">
                    <div class="row">
                        <!-- Image Buttons -->
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md mb-2 display-none" id="col-zoom-in">
                                    <button class="btn btn-primary btn-block">+</button>
                                </div>
                                <div class="col-md mb-2 display-none" id="col-zoom-out">
                                    <button class="btn btn-primary btn-block">-</button>
                                </div>
                                <div class="col-md mb-2 display-none" id="col-remove-img">
                                    <button class="btn btn-danger btn-block">Remove Image</button>
                                </div>
                            </div>
                        </div>
                        <!-- Frame Buttons -->
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md mb-2 display-none" id="col-change-mod">
                                    <button class="btn btn-primary btn-block">Under Image</button>
                                </div>
                                <div class="col-md mb-2 display-none" id="col-remove-frame">
                                    <button class="btn btn-danger btn-block">Remove Frame</button>
                                </div>
                            </div>
                        </div>
                        <!-- Extra Buttons -->
                        <div class="col-12 mb-2 display-none" id="col-clear-all">
                            <button class="btn btn-danger btn-block">Remove All</button>
                        </div>
                    </div>
                </div>
                <!-- Load from device -->
                <div class="col-md mb-2 display-none" id="col-load-img">
                    <button class="btn btn-dark btn-block">Load from device ...</button>
                    <input type="file" accept="image/*" class="display-none" id="load-from-device">
                </div>
                <div class="col-md display-none" id="col-load-video">
                    <button class="btn btn-dark btn-block">Turn on Camera</button>
                </div>
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
<script src="/template/js/make_photo.js" type="module"></script>
