import { $ } from '../helpers/lib.js';
import { loadMorePhotosOnMyPhotos } from './load_more_photos.js'

const API_DELETE_URL = '/api/DeletePhotoById';

function sendByAjax(id) {
    const data = `id=${id}`;
    let xhr = new XMLHttpRequest();

    xhr.open('POST', API_DELETE_URL, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            --window.ld_cycle;
            loadMorePhotosOnMyPhotos(1);
        }
    };
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}

function deletePhotoById(id) {
    let is_agree = confirm('Are you sure?');

    if (!is_agree) {
        return false;
    }

    const photo_elem = $('photo-elem' + id);

    photo_elem.parentNode.removeChild(photo_elem);
    sendByAjax(id);

    return true;
}

export function initDeleteSystem(photo_id) {
    const delete_elem = $('delete' + photo_id);

    delete_elem.onclick = function () {
        deletePhotoById(photo_id);
    };
}
