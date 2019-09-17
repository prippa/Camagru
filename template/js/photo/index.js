import {initPhotos, initShowMore} from './init.js';
import {loadMorePhotosOnMainPage} from './load_more_photos.js'

initShowMore(loadMorePhotosOnMainPage);
initPhotos(window.photos);
