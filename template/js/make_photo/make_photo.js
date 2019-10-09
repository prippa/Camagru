import {$, ResizeSensor} from '../lib.js';
import {colDNone, colDBlock} from './helpers.js';
import {Photos} from './Photos.class.js';
import {SuperImages} from './SuperImages.class.js'

(function () {
    // Variables INIT
    let video                   = $('video-element'),
        video_col               = $('video-col'),
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
        photos                  = new Photos(),
        super_images            = new SuperImages();

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

        photos.add($('made-img-container'), [video, super_images.canv]);

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

    // Set Events
    btn_make.onclick = makePhotoEvent;
    btn_cancel.onclick = cancelEvent;
    btn_confirm.onclick = confirmEvent;
    btn_upload.onclick = uploadEvent;
    video.onloadeddata = function () {
        super_images.initSuperImages(window.super_images);
        super_images.resetSize(video.clientWidth, video.clientHeight);
        colDBlock(col_make);
    };
    new ResizeSensor(video_col, function () {
        super_images.resetSize(video.clientWidth, video.clientHeight);
    });

    //Get Mouse Position
    // function getMousePos(canvas, evt) {
    //     var rect = canvas.getBoundingClientRect();
    //     return {
    //         x: Math.ceil(evt.clientX - rect.left),
    //         y: Math.ceil(evt.clientY - rect.top)
    //     };
    // }
    // super_img_canvas.onmousemove = function(evt) {
    //     let mouse_pos = getMousePos(super_img_canvas, evt);
    //     console.log(mouse_pos.x + ',' + mouse_pos.y);
    // };

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
    colDBlock(col_load_mod);
})();
