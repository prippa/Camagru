import {$, ajaxSendDataByPOST} from '../lib.js';

const MESSAGE_MAX = 1024;
const POST_URL = '/AddNewComment';

function set_error(input_elem, message)
{
    const comment_error_elem = $('comment-error');

    comment_error_elem.innerHTML = message;
    comment_error_elem.style.display = 'block';
    input_elem.classList.add('is-invalid');
}

function error_validation(input_elem)
{
    if (input_elem.value.length > MESSAGE_MAX)
        set_error(input_elem, `Message can't be more than ${MESSAGE_MAX} characters`);
    else if (!input_elem.value.length)
        set_error(input_elem, 'Please write some characters');
    else
        return false;
    return true;
}

function send_success(comment)
{
    const input_elem = $('comment-input');
    const comment_error_elem = $('comment-error');
    const comments_elem = $('comments-block');

    comment_error_elem.style.display = 'none';
    input_elem.classList.remove('is-invalid');
    input_elem.value = '';

    const fragment = document.createDocumentFragment();
    const div = document.createElement('div');
    const b = document.createElement('b');
    const span = document.createElement('span');

    div.classList.add('comment-block');
    b.innerText = window.login;
    span.innerText = comment;
    div.appendChild(b);
    div.innerHTML += ': ';
    div.appendChild(span);
    fragment.appendChild(div);
    comments_elem.appendChild(fragment);
    comments_elem.scrollTop = comments_elem.scrollHeight;
}

export function send_comment(photo_id)
{
    const input_elem = $('comment-input');

    input_elem.value = input_elem.value.trim();
    if (error_validation(input_elem))
        return true;

    const data = `id=${photo_id}&comment=${encodeURIComponent(input_elem.value)}`;
    ajaxSendDataByPOST(POST_URL, data, send_success, input_elem.value);
    
    return false;
}
