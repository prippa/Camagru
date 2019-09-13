import {$, ajaxSendDataByPOST} from '../lib.js';

const POST_REQUEST_URL = '/LikeDislikePOST';

function like_logic(elem)
{
    const like_status = elem.like.classList.contains('like') ? 1 : 0;

    if (elem.dislike.classList.contains('dislike'))
    {

        elem.dislike_count.innerText = (parseInt(elem.dislike_count.innerText, 10) - 1).toString();
        elem.dislike.classList.remove('dislike');
    }
    if (like_status === 1)
    {
        elem.like_count.innerText = (parseInt(elem.like_count.innerText, 10) - 1).toString();
        elem.like.classList.remove('like');
    }
    else
    {
        elem.like_count.innerText = (parseInt(elem.like_count.innerText, 10) + 1).toString();
        elem.like.classList.add('like');
    }
}

function dislike_logic(elem)
{
    const like_status = elem.dislike.classList.contains('dislike') ? 0 : 1;

    if (elem.like.classList.contains('like'))
    {
        elem.like_count.innerText = (parseInt(elem.like_count.innerText, 10) - 1).toString();
        elem.like.classList.remove('like');
    }
    if (like_status === 0)
    {
        elem.dislike_count.innerText = (parseInt(elem.dislike_count.innerText, 10) - 1).toString();
        elem.dislike.classList.remove('dislike');
    }
    else
    {
        elem.dislike_count.innerText = (parseInt(elem.dislike_count.innerText, 10) + 1).toString();
        elem.dislike.classList.add('dislike');
    }
}

function getElements(id)
{
    if (!id) id = '';

    return {
        like: $('like' + id),
        dislike: $('dislike' + id),
        dislike_count: $('dislike-count' + id),
        like_count: $('like-count' + id)
    };
}

export function like(id, elem_id)
{
    const data = `id=${id}&like_status=1`;

    ajaxSendDataByPOST(POST_REQUEST_URL, data, like_logic, getElements(elem_id));
}

export function dislike(id, elem_id)
{
    const data = `id=${id}&like_status=0`;

    ajaxSendDataByPOST(POST_REQUEST_URL, data, dislike_logic, getElements(elem_id));
}
