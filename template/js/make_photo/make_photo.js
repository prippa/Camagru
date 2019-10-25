import {$, dNone, dBlock} from '../lib.js';
import {PhotosCanvas} from './PhotosCanvas.class.js';
import {SuperImagesCanvas} from './SuperImagesCanvas.class.js'

(function () {
    // Variables INIT
    let video                   = $('video-element'),
        col_load_mod            = $('col-load-mod'),
        col_cancel              = $('col-cancel'),
        col_confirm             = $('col-confirm'),
        col_make                = $('col-make'),
        btn_load_mod            = col_load_mod.firstElementChild,
        btn_cancel              = col_cancel.firstElementChild,
        btn_confirm             = col_confirm.firstElementChild,
        btn_make                = col_make.firstElementChild,
        btn_upload              = $('btn-upload'),
        photos                  = new PhotosCanvas(),
        super_images            = new SuperImagesCanvas();

    /* --------------- Events Methods -------------- */
    // Make Photo Event
    function makePhotoEvent()
    {
        video.pause();
        dNone(col_make);
        dNone(col_load_mod);
        dBlock(col_confirm);
        dBlock(col_cancel);
    }

    // Cancel Event
    function cancelEvent()
    {
        video.play();
        dBlock(col_make);
        dBlock(col_load_mod);
        dNone(col_confirm);
        dNone(col_cancel);
    }

    // Confirm Event
    function confirmEvent()
    {
        dNone(col_confirm);
        dNone(col_cancel);

        photos.add($('made-img-container'), video, super_images);

        video.play();
        dBlock(col_make);
        dBlock(col_load_mod);
    }

    // Upload Event
    function uploadEvent()
    {
        photos.upload();
    }
    /* ------------- Events Methods END ------------ */

    /* ---------------- Set Events ----------------- */
    btn_make.onclick = makePhotoEvent;
    btn_cancel.onclick = cancelEvent;
    btn_confirm.onclick = confirmEvent;
    btn_upload.onclick = uploadEvent;
    video.onloadeddata = function () {
        super_images.init(window.super_images);
        super_images.resetSize(video.clientWidth, video.clientHeight);
        dBlock(col_make);
    };
    window.onresize = function () {
        super_images.resetSize(video.clientWidth, video.clientHeight);
    };
    /* --------------- Set Events END -------------- */

    navigator.getMedia = navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;

    if (navigator.getMedia) {
        navigator.getMedia({video: true, audio: false},
            function (stream) {
                video.srcObject = stream;
                video.play();
            },
            function (e) {
                alert('There has some problems with video: ' + e);
            });
    }
    dBlock(col_load_mod);
})();
