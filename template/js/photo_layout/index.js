import {$} from '../lib.js';
import {initLikeSystem} from './likes.js';
import {loadMorePhotosOnMainPage} from './load_more_photos.js';

window.photos.forEach(function(photo)
{
    initLikeSystem(photo.id, photo.like_status, photo.id);
});

$('show-more').onclick = function()
{
    loadMorePhotosOnMainPage(window.ld_photo_count, window.ld_cycle);
    ++window.ld_cycle;
};
