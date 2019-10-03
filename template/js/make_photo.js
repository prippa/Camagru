import {$} from './lib.js';
// Two canvases. First for Image second for super image.
(function () {
    let video_elem = $('video-element');
    let img_canvas = $('img-canvas');
    let ctx = img_canvas.getContext('2d');

    function setCanvasSize()
    {
        img_canvas.width = 1280;
        img_canvas.height = 960;
    }

    video_elem.onloadeddata = function () {
        setCanvasSize();
    };

    window.onresize = function () {
        setCanvasSize();
    };

    function handleVideo(stream)
    {
        video_elem.srcObject = stream;
        video_elem.play();
        // video_elem.play().then(function () {
        //     console.log(video_elem.clientWidth);
        //     console.log(video_elem.clientHeight);
        // });
    }

    function videoError(e)
    {
        alert('There has some problems with video: ' + e);
    }

    navigator.getMedia = navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;

    if (navigator.getMedia) {
        navigator.getMedia({video: true, audio: false}, handleVideo, videoError);
    }

    $('load-img-from-device').onclick = function () {
        ctx.drawImage(video_elem, 0, 0, img_canvas.width, img_canvas.height);
        $('photo').setAttribute('src', img_canvas.toDataURL('image/jpeg'));
    };
})();
