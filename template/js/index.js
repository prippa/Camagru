import { initPhotos, initShowMore } from './photo/init.js';
import { loadMorePhotosOnMainPage } from './photo/load_more_photos.js'

(function () {
    initShowMore(loadMorePhotosOnMainPage);
    initPhotos(window.photos);
})();
