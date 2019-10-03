import {initPhotos, initShowMore} from './init.js';
import {loadMorePhotosOnMainPage} from './load_more_photos.js'

(function ()
{
    initShowMore(loadMorePhotosOnMainPage);
    initPhotos(window.photos);
})();
