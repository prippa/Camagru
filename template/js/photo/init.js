import {$} from "../lib.js";
import {initLikeSystem} from './likes.js';
import {initDeleteSystem} from './delete.js';

export function initPhotos(photos)
{
    window.ld_cycle = photos.length;
    console.log(window.ld_cycle);

    photos.forEach(function(photo) {
        initLikeSystem(photo.id, photo.like_status, photo.id);
    });
}

export function initPhotosDelete(photos)
{
    photos.forEach(function(photo) {
        initDeleteSystem(photo.id);
    });
}

export function initShowMore(func)
{
    const show_more_elem = $('show-more');

    if (window.photos.length === window.ld_photo_count) {
        show_more_elem.onclick = function() {
            func(window.ld_photo_count, window.ld_cycle);
        };
        $('show-more-block').style.display = 'block';
    }
}
