import {$, ajaxSendDataByPOST} from '../lib.js';

function like_logic(id)
{
    const dislike_elem = $('dislike-' + id);
    const like_elem = $('like-' + id);
    const like_count_elem = $('like-count-' + id);
    const like_status = like_elem.classList.contains('like') ? 1 : 0;

    if (dislike_elem.classList.contains('dislike'))
    {
        const dislike_count_elem = $('dislike-count-' + id);

        dislike_count_elem.innerText = (parseInt(dislike_count_elem.innerText, 10) - 1).toString();
        dislike_elem.classList.remove('dislike');
    }

    if (like_status === 1)
    {
        like_count_elem.innerText = (parseInt(like_count_elem.innerText, 10) - 1).toString();
        like_elem.classList.remove('like');
    }
    else
    {
        like_count_elem.innerText = (parseInt(like_count_elem.innerText, 10) + 1).toString();
        like_elem.classList.add('like');
    }
}

function dislike_logic(id)
{
    const like_elem = $('like-' + id);
    const dislike_elem = $('dislike-' + id);
    const dislike_count_elem = $('dislike-count-' + id);
    const like_status = dislike_elem.classList.contains('dislike') ? 0 : 1;

    if (like_elem.classList.contains('like'))
    {
        const like_count_elem = $('like-count-' + id);

        like_count_elem.innerText = (parseInt(like_count_elem.innerText, 10) - 1).toString();
        like_elem.classList.remove('like');
    }

    if (like_status === 0)
    {
        dislike_count_elem.innerText = (parseInt(dislike_count_elem.innerText, 10) - 1).toString();
        dislike_elem.classList.remove('dislike');
    }
    else
    {
        dislike_count_elem.innerText = (parseInt(dislike_count_elem.innerText, 10) + 1).toString();
        dislike_elem.classList.add('dislike');
    }
}

const POST_REQUEST_URL = 'LikeDislikePOST';

export function like(id)
{
    const data = `id=${id}&like_status=1`;

    ajaxSendDataByPOST(POST_REQUEST_URL, data, like_logic, id);
}

export function dislike(id)
{
    const data = `id=${id}&like_status=0`;

    ajaxSendDataByPOST(POST_REQUEST_URL, data, dislike_logic, id);
}
