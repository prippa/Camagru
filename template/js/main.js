import {$} from './lib.js';
import {like, dislike} from "./likes.js";

let modals = [];

function init_likes_system(id, like_status)
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

function init_modals(id)
{
    const post_block_elem = $('post-block-' + id);
    const modal_elem = $('modal-' + id);
    const close_modal_elem = $('close-modal-' + id);

    post_block_elem.onclick = function() { modal_elem.style.display = 'block'; };
    close_modal_elem.onclick = function() { modal_elem.style.display = 'none'; };
    modals.push(modal_elem);
}

window.posts.forEach(function(post)
{
    init_likes_system(post.id, post.like_status);
    init_modals(post.id);
});

window.onclick = function(event)
{
    for (let i = 0; i < modals.length; i++)
    {
        if (event.target === modals[i])
            modals[i].style.display = 'none';
    }
};
