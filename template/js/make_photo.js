import { $, dNone, dBlock, setLoadButton } from './helpers/lib.js';
import { PhotosCanvas } from './make_photo/PhotosCanvas.js';
import { SuperImagesCanvas } from './make_photo/SuperImagesCanvas.js'

(function () {
    // Variables INIT
    navigator.getMedia = navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;

    let video = $('video-element'),
        img = $('device-img'),
        col_load_img = $('col-load-img'),
        col_load_video = $('col-load-video'),
        col_cancel = $('col-cancel'),
        col_confirm = $('col-confirm'),
        col_make = $('col-make'),
        btn_load_img = col_load_img.firstElementChild,
        btn_load_video = col_load_video.firstElementChild,
        btn_cancel = col_cancel.firstElementChild,
        btn_confirm = col_confirm.firstElementChild,
        btn_make = col_make.firstElementChild,
        btn_upload = $('btn-upload'),
        input_file = $('load-from-device'),
        photos = new PhotosCanvas(),
        super_images = new SuperImagesCanvas();

    const VIDEO_MOD = 1,
        IMG_MOD = 2;
    let mod = VIDEO_MOD;

    function disableButtonUpload() {
        setLoadButton(btn_upload);
    }

    function enableButtonUpload() {
        btn_upload.disabled = false;
        btn_upload.innerHTML = 'Upload';
    }

    function videoOff() {
        if (!video.srcObject) {
            return;
        }
        let stream = video.srcObject;
        let tracks = stream.getTracks();

        tracks.forEach(function (track) {
            track.stop();
        });

        video.srcObject = null;
        dNone(video);
        super_images.hide();
    }

    function videoOn() {
        if (navigator.getMedia) {
            navigator.getMedia({ video: true, audio: false },
                function (stream) {
                    video.srcObject = stream;
                    video.play();
                    video.onloadedmetadata = function() {
                        dBlock(video);
                        super_images.show();
                    };
                },
                function (e) {
                    alert('There has some problems with video: ' + e);
                    dBlock(col_load_video);
                });
        }
    }

    function imgOff() {
        dNone(col_make);
        super_images.hide();
        videoOn();
        dNone(img);
        dNone(col_load_video);
        mod = VIDEO_MOD;
    }

    function imgOn() {
        videoOff();
        dBlock(img);
        dBlock(col_load_video);
        super_images.show();
        mod = IMG_MOD;
    }

    // Make Photo Event
    btn_make.onclick = function () {
        if (mod === VIDEO_MOD) {
            video.pause();
        }
        dNone(col_make);
        dNone(col_load_img);
        dBlock(col_confirm);
        dBlock(col_cancel);
    };

    // Cancel Event
    btn_cancel.onclick = function () {
        if (mod === VIDEO_MOD) {
            video.play();
        }
        dBlock(col_make);
        dBlock(col_load_img);
        dNone(col_confirm);
        dNone(col_cancel);
    };

    // Confirm Event
    btn_confirm.onclick = function () {
        dNone(col_confirm);
        dNone(col_cancel);

        let src_obj = (mod === VIDEO_MOD ? video : img);

        photos.add($('made-img-container'), src_obj, super_images);

        if (mod === VIDEO_MOD) {
            video.play();
        }
        dBlock(col_make);
        dBlock(col_load_img);
    };

    // Upload Event
    btn_upload.onclick = async function () {
        disableButtonUpload();
        await photos.upload();
        enableButtonUpload();
    };

    // Load Image from Device Event
    btn_load_img.onclick = function () {
        input_file.click();
    };

    // Turn Off the img mod and turn on video
    btn_load_video.onclick = function () {
        imgOff();
    };

    // Input File onchange Event
    input_file.onchange = function () {
        if (this.files && this.files[0]) {
            let reader = new FileReader();

            reader.onload = function (e) {
                imgOn();

                img.src = e.target.result;
                img.onload = function () {
                    super_images.resetSize(img.width, img.height);
                    dBlock(col_make);
                }
            };

            reader.readAsDataURL(this.files[0]);
            input_file.value = '';
        }
    };

    video.onloadeddata = function () {
        super_images.resetSize(video.clientWidth, video.clientHeight);
        dBlock(col_make);
    };

    window.onresize = function () {
        if (mod === VIDEO_MOD) {
            super_images.resetSize(video.clientWidth, video.clientHeight);
        } else if (mod === IMG_MOD) {
            super_images.resetSize(img.width, img.height);
        }
    };

    super_images.init(window.super_images);
    videoOn();
    dBlock(col_load_img);
})();
