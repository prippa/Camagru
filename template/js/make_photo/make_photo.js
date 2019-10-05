import {$, ResizeSensor} from '../lib.js';
import {colDNone, colDBlock} from './helpers.js';
import {Photos} from './image.class.js';

(function () {
    // Variables INIT
    let video                   = $('video-element'),
        video_col               = $('video-col'),
        img_canvas              = $('img-canvas'),
        img_ctx                 = img_canvas.getContext('2d'),
        super_img_canvas        = $('super-img-canvas'),
        super_img_ctx           = super_img_canvas.getContext('2d'),
        col_load_mod            = $('col-load-mod'),
        col_cancel              = $('col-cancel'),
        col_remove_super_img    = $('col-remove-super-img'),
        col_confirm             = $('col-confirm'),
        col_make                = $('col-make'),
        btn_load_mod            = col_load_mod.firstElementChild,
        btn_cancel              = col_cancel.firstElementChild,
        btn_remove_super_img    = col_remove_super_img.firstElementChild,
        btn_confirm             = col_confirm.firstElementChild,
        btn_make                = col_make.firstElementChild,
        btn_upload              = $('btn-upload'),
        photos                  = new Photos();

    img_canvas.width = 1280;
    img_canvas.height = 720;

    /* -------------- Events -------------- */
    // Make Photo Event
    function makePhotoEvent()
    {
        video.pause();
        colDNone(col_make);
        colDNone(col_load_mod);
        colDBlock(col_confirm);
        colDBlock(col_cancel);
    }

    // Cancel Event
    function cancelEvent()
    {
        video.play();
        colDBlock(col_make);
        colDBlock(col_load_mod);
        colDNone(col_confirm);
        colDNone(col_cancel);
    }

    // Confirm Event
    function confirmEvent()
    {
        colDNone(col_confirm);
        colDNone(col_cancel);

        img_ctx.drawImage(video, 0, 0, img_canvas.width, img_canvas.height);
        img_ctx.drawImage(super_img_canvas, 0, 0, img_canvas.width, img_canvas.height);
        const src = img_canvas.toDataURL('image/png');

        photos.add($('made-img-container'), src);

        video.play();
        colDBlock(col_make);
        colDBlock(col_load_mod);
    }

    // Upload Event
    function uploadEvent()
    {
        photos.upload();
    }
    /* ------------- Events END ------------ */

    /* -------------- Base Methods -------------- */
    function startVideo()
    {
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
    }

    function sicrDraw()
    {
        let base_image = new Image();
        base_image.src = '/template/images/superposable/42.png';
        base_image.onload = function() {
            super_img_ctx.drawImage(base_image, 400, 400);
        }
    }

    function sicrResetSize()
    {
        super_img_canvas.width = video.clientWidth;
        super_img_canvas.height = video.clientHeight;
    }

    function superImagesCanvasReset()
    {
        sicrResetSize();
        sicrDraw();
    }

    /* -------------- Base Methods END -------------- */

    // Set Events
    btn_make.onclick = makePhotoEvent;
    btn_cancel.onclick = cancelEvent;
    btn_confirm.onclick = confirmEvent;
    btn_upload.onclick = uploadEvent;
    video.onloadeddata = function () {
        superImagesCanvasReset();
        colDBlock(col_make);
    };
    new ResizeSensor(video_col, function () {
        superImagesCanvasReset();
    });

    startVideo();
    colDBlock(col_load_mod);
})();
