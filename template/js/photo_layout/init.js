import {$} from "../lib.js";
import {initLikeSystem} from './likes.js';

export function initPhotos(photos)
{
    window.ld_cycle = 1;

    photos.forEach(function(photo)
    {
        initLikeSystem(photo.id, photo.like_status, photo.id);
    });
}

export function initShowMore(func)
{
    const show_more_elem = $('show-more');

    if (window.photos.length === window.ld_photo_count)
    {
        show_more_elem.onclick = function()
        {
            func(window.ld_photo_count, window.ld_cycle);
            ++window.ld_cycle;
        };
        $('show-more-block').style.display = 'block';
    }
}
