import {$} from '../lib.js';
import {btnGet, btnDNone, btnDBlock} from './helpers.js';
import {Image} from './image.class.js';

// Two canvases. First for Image second for super image.
(function () {
    // Variables INIT
    let video = $('video-element'),
        img_canvas = $('img-canvas'),
        ctx = img_canvas.getContext('2d'),
        btn_load_mod = $('btn-load-mod'),
        btn_cancel = $('btn-cancel'),
        btn_remove_super_img = $('btn-remove-super-img'),
        btn_confirm = $('btn-confirm'),
        btn_make = $('btn-make'),
        img = new Image();

    img_canvas.width = 1280;
    img_canvas.height = 720;

    /* -------------- Events -------------- */
    // Make Photo Event
    function makePhotoEvent()
    {
        video.pause();
        btnDNone(btn_make);
        btnDNone(btn_load_mod);
        btnDBlock(btn_confirm);
        btnDBlock(btn_cancel);
    }

    // Cancel Event
    function cancelEvent()
    {
        video.play();
        btnDBlock(btn_make);
        btnDBlock(btn_load_mod);
        btnDNone(btn_confirm);
        btnDNone(btn_cancel);
    }

    // Confirm Event
    function confirmEvent()
    {
        btnDNone(btn_confirm);
        btnDNone(btn_cancel);

        ctx.drawImage(video, 0, 0, img_canvas.width, img_canvas.height);
        const src = img_canvas.toDataURL('image/jpeg');

        img.add($('made-img-container'), src, $('made-img-col'));

        video.play();
        btnDBlock(btn_make);
        btnDBlock(btn_load_mod);
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

    function setSuperImgCanvasSize()
    {
        // TODO
    }

    /* -------------- Base Methods END -------------- */

    // Set Events
    btnGet(btn_make).onclick = makePhotoEvent;
    btnGet(btn_cancel).onclick = cancelEvent;
    btnGet(btn_confirm).onclick = confirmEvent;
    video.onloadeddata = function () {
        setSuperImgCanvasSize();
        btnDBlock(btn_make);
    };
    window.onresize = function () {
        setSuperImgCanvasSize();
    };

    // Start Video
    startVideo();

    // $('load-img-from-device').onclick = function () {
    //     ctx.drawImage(video, 0, 0, img_canvas.width, img_canvas.height);
    //     console.log(img_canvas.toDataURL('image/jpeg'));
    //     // $('photo').setAttribute('src', img_canvas.toDataURL('image/jpeg'));
    // };
})();
