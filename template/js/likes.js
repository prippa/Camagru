import {$} from './lib.js';

function ajaxSendDataByPOST(url, data)
{
    let xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.send(data);
}

window.like = function(id, like_status)
{
    const element_id = 'like-' + id;

    console.log($(element_id));
};

window.dislike = function(id, like_status)
{
    const element_id = 'dislike-' + id;

    console.log($(element_id));
};
