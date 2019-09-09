import {$, switchLogic} from './lib.js';

function ajaxSendDataByPOST(url, data)
{
    let xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}

window.like = function(id, like_status)
{
    const data = 'id=' + id + '&like_status=' + 1;

    ajaxSendDataByPOST('LikeDislikePOST', data);

    const dislike_elem = $('dislike-' + id);
    const like_elem = $('like-' + id);
    const like_count_elem = $('like-count-' + id);

    if (dislike_elem.classList.contains('dislike'))
    {
        const dislike_count_elem = $('dislike-count-' + id);

        dislike_count_elem.innerText = (parseInt(dislike_count_elem.innerText, 10) - 1).toString();
        dislike_elem.classList.remove('dislike');
    }

    if (like_status === '1')
    {
        like_count_elem.innerText = (parseInt(like_count_elem.innerText, 10) - 1).toString();
        like_elem.classList.remove('like');
    }
    else
    {
        like_count_elem.innerText = (parseInt(like_count_elem.innerText, 10) + 1).toString();
        like_elem.classList.add('like');
    }
};

window.dislike = function(id, like_status)
{
    const data = 'id=' + id + '&like_status=' + 0;

    ajaxSendDataByPOST('LikeDislikePOST', data);

    const dislike_elem = $(dislike_pref_id + id);

    if (like_status === '0')
        dislike_elem.classList.remove('dislike');
    else
        dislike_elem.classList.add('dislike');
};
