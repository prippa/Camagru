import { initPhotos, initShowMore, initPhotosDelete } from './photo/init.js';
import { loadMorePhotosOnMyPhotos } from './photo/load_more_photos.js'

(function () {
    initShowMore(loadMorePhotosOnMyPhotos);
    initPhotos(window.photos);
    initPhotosDelete(window.photos);
})();
