import {$} from '../lib.js';
import {like, dislike} from './likes.js';
import {send_comment} from './comments.js'

function init_like_system(photo_id, like_status)
{
    const like_elem = $('like');
    const dislike_elem = $('dislike');

    if (like_status === '1')
        like_elem.classList.add('like');
    else if (like_status === '0')
        dislike_elem.classList.add('dislike');

    like_elem.onclick = function() { like(photo_id, null) };
    dislike_elem.onclick = function() { dislike(photo_id, null) };
}

function init_comment_system(photo_id)
{
    const comment_btn_elem = $('comment-btn');
    const text_input_elem = $('comment-input');

    comment_btn_elem.onclick = function () { send_comment(photo_id) };
    text_input_elem.onkeyup = function(event)
    {
        event.preventDefault();
        if (event.key === 'Enter')
            comment_btn_elem.click();
    };
}

init_like_system(photo.id, photo.like_status);
init_comment_system(photo.id);
