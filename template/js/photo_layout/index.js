import {$} from '../lib.js';
import {like, dislike} from './likes.js';

function init_like_system(id, like_status)
{
    const like_elem = $('like' + id);
    const dislike_elem = $('dislike' + id);

    if (like_status === '1')
        like_elem.classList.add('like');
    else if (like_status === '0')
        dislike_elem.classList.add('dislike');

    like_elem.onclick = function() { like(id, id) };
    dislike_elem.onclick = function() { dislike(id, id) };
}

window.photos.forEach(function(photo)
{
    init_like_system(photo.id, photo.like_status);
});
