import { $, ajaxSendDataByPOST, redirect } from '../helpers/lib.js';

const POST_REQUEST_URL = '/api/LikeDislikePOST';

function likeLogic(elem) {
    const like_status = elem.like.classList.contains('like') ? 1 : 0;

    if (elem.dislike.classList.contains('dislike')) {
        elem.dislike_count.innerText = (parseInt(elem.dislike_count.innerText, 10) - 1).toString();
        elem.dislike.classList.remove('dislike');
    }
    if (like_status === 1) {
        elem.like_count.innerText = (parseInt(elem.like_count.innerText, 10) - 1).toString();
        elem.like.classList.remove('like');
    } else {
        elem.like_count.innerText = (parseInt(elem.like_count.innerText, 10) + 1).toString();
        elem.like.classList.add('like');
    }
}

function dislikeLogic(elem) {
    const like_status = elem.dislike.classList.contains('dislike') ? 0 : 1;

    if (elem.like.classList.contains('like')) {
        elem.like_count.innerText = (parseInt(elem.like_count.innerText, 10) - 1).toString();
        elem.like.classList.remove('like');
    }
    if (like_status === 0) {
        elem.dislike_count.innerText = (parseInt(elem.dislike_count.innerText, 10) - 1).toString();
        elem.dislike.classList.remove('dislike');
    } else {
        elem.dislike_count.innerText = (parseInt(elem.dislike_count.innerText, 10) + 1).toString();
        elem.dislike.classList.add('dislike');
    }
}

function getElements(id) {
    return {
        like: $('like' + id),
        dislike: $('dislike' + id),
        dislike_count: $('dislike-count' + id),
        like_count: $('like-count' + id)
    };
}

function like(id, elem_id) {
    if (!window.is_logged) {
        redirect('login');
    }

    const data = `id=${id}&like_status=1`;

    likeLogic(getElements(elem_id));
    ajaxSendDataByPOST(POST_REQUEST_URL, data);
}

function dislike(id, elem_id) {
    if (!window.is_logged) {
        redirect('login');
    }

    const data = `id=${id}&like_status=0`;

    dislikeLogic(getElements(elem_id));
    ajaxSendDataByPOST(POST_REQUEST_URL, data);
}

export function initLikeSystem(photo_id, like_status, id = '') {
    const like_elem = $('like' + id);
    const dislike_elem = $('dislike' + id);

    if (like_status === '1') {
        like_elem.classList.add('like');
    } else if (like_status === '0') {
        dislike_elem.classList.add('dislike');
    }

    like_elem.onclick = function () {
        like(photo_id, id)
    };
    dislike_elem.onclick = function () {
        dislike(photo_id, id)
    };
}
