import { $, ajaxSendDataByPOST, insertAfter, redirect, dBlock, dNone } from '../helpers/lib.js';

const MESSAGE_MAX = 1024;
const POST_URL = '/api/AddNewComment';

function setError(input_elem, message) {
    const comment_error_elem = $('comment-error');

    comment_error_elem.innerHTML = message;
    dBlock(comment_error_elem);
    input_elem.classList.add('is-invalid');
}

function errorValidation(input_elem) {
    if (input_elem.value.length > MESSAGE_MAX) {
        setError(input_elem, `Message can't be more than ${MESSAGE_MAX} characters`);
    } else if (!input_elem.value.length) {
        setError(input_elem, 'Please write some characters');
    } else {
        return false;
    }

    return true;
}

function addNewComment(comment) {
    const input_elem = $('comment-input');
    const comment_error_elem = $('comment-error');
    const comments_elem = $('comments-block');

    dNone(comment_error_elem);
    input_elem.classList.remove('is-invalid');

    const div = document.createElement('div');
    const b = document.createElement('b');
    const span = document.createElement('span');

    div.classList.add('comment-block');
    b.innerText = window.login;
    span.classList.add('comment');
    span.innerText = comment;
    div.appendChild(b);
    div.innerHTML += ': ';
    div.appendChild(span);
    insertAfter(comments_elem, div);
    comments_elem.scrollTop = comments_elem.scrollHeight;
}

export function sendComment(photo_id) {
    if (!window.is_logged) {
        redirect('login');
    }

    const input_elem = $('comment-input');

    input_elem.value = input_elem.value.trim();
    if (errorValidation(input_elem)) {
        return true;
    }

    addNewComment(input_elem.value);

    const data = `id=${photo_id}&comment=${encodeURIComponent(input_elem.value)}`;
    ajaxSendDataByPOST(POST_URL, data);

    input_elem.value = '';

    return false;
}
