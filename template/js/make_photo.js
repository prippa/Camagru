import {$} from './lib.js';

(function ()
{
    function handleVideo(stream)
    {
        const videoElem = $('videoElement');

        videoElem.srcObject = stream;
        videoElem.play();
    }

    function videoError(e)
    {
        alert('There has some problems with video: ' + e.code);
    }

    navigator.getMedia = navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;

    if (navigator.getMedia)
    {
        navigator.getMedia({video: true, audio: false}, handleVideo, videoError);
    }
})();
