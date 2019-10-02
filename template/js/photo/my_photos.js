import {initPhotos, initShowMore, initPhotosDelete} from './init.js';
import {loadMorePhotosOnMyPhotos} from './load_more_photos.js'

(function () {
    initShowMore(loadMorePhotosOnMyPhotos);
    initPhotos(window.photos);
    initPhotosDelete(window.photos);
})();
