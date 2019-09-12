import {$} from '../lib.js';
import {like, dislike} from './likes.js';
import {send_comment} from './comments.js'

let modals = [];

function init_modal(id)
{
    const post_block_elem = $('post-block-' + id);
    const modal_elem = $('modal-' + id);
    const close_modal_elem = $('close-modal-' + id);

    post_block_elem.onclick = function() { modal_elem.style.display = 'block'; };
    close_modal_elem.onclick = function() { modal_elem.style.display = 'none'; };
    modals.push(modal_elem);
}

function init_like_system(id, like_status)
{
    const like_elem = $('like-' + id);
    const dislike_elem = $('dislike-' + id);

    if (like_status === '1')
        like_elem.classList.add('like');
    else if (like_status === '0')
        dislike_elem.classList.add('dislike');

    like_elem.onclick = function() { like(id) };
    dislike_elem.onclick = function() { dislike(id) };
}

function init_comment_system(id)
{
    const comment_btn_elem = $('comment-btn-' + id);
    const text_input_elem = $('comment-input-' + id);

    comment_btn_elem.onclick = function () { send_comment(id) };
    text_input_elem.onkeyup = function(event)
    {
        event.preventDefault();
        if (event.key === 'Enter')
            comment_btn_elem.click();
    };
}

window.posts.forEach(function(post)
{
    init_modal(post.id);
    init_like_system(post.id, post.like_status);
    init_comment_system(post.id);
});

window.onclick = function(event)
{
    for (let i = 0; i < modals.length; i++)
    {
        if (event.target === modals[i])
            modals[i].style.display = 'none';
    }
};
