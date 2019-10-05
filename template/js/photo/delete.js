import {$, ajaxSendDataByPOST} from '../lib.js';

function deletePhotoById(id)
{
    let is_agree = confirm('Are you sure?');

    if (!is_agree) {
        return false;
    }

    const photo_elem = $('photo-elem' + id);
    const data = `id=${id}`;

    photo_elem.parentNode.removeChild(photo_elem);
    ajaxSendDataByPOST('/api/DeletePhotoById', data);
    --window.ld_cycle;

    return true;
}

export function initDeleteSystem(photo_id)
{
    const delete_elem = $('delete' + photo_id);

    delete_elem.onclick = function() {
        deletePhotoById(photo_id);
    };
}