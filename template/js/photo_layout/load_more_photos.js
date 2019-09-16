import {$, setNewElementToDOM} from '../lib.js';
import {initLikeSystem} from './likes.js';

function getNewPhotoBlock(photo)
{
    return `<a target="_blank" class="post-block" href="${photo['link']}">` +

                `<div class="row no-gutters">` +
                    `<div class="col-auto mr-auto">` +
                        `<div class="post-head-elem">` +
                            `By: <b class="post-login">${photo['login']}</b>` +
                        `</div>` +
                    `</div>` +
                    `<div class="col-auto">` +
                        `<div class="post-head-elem">` +
                            `<div class="post-create-date">${photo['create_date']}</div>` +
                        `</div>` +
                    `</div>` +
                `</div>` +
                `<img class="img-fluid main-img" src="${photo['img']}" alt="">` +

            `</a>` +
            `<div class="row no-gutters pt-2">` +

                `<div class="col-6">` +
                    `<div class="post-like" id="like${photo['id']}">` +
                        `<img class="like-img" src="/template/images/like.png" alt="">` +
                        `<span id="like-count${photo['id']}">${photo['likes']}</span>` +
                    `</div>` +
                `</div>` +

                `<div class="col-6">` +
                    `<div class="post-dislike" id="dislike${photo['id']}">` +
                        `<img src="/template/images/dislike.png" alt="">` +
                        `<span id="dislike-count${photo['id']}">${photo['dislikes']}</span>` +
                    `</div>` +
                `</div>` +

            `</div>`;
}


function setNewPhotosOMP(data, photo_count)
{
    if (data.length < photo_count)
        $('show-more').style.display = 'none';

    data.forEach(function(photo)
    {
        const photo_container_elem = $('photo-container');
        const div = document.createElement('div');

        div.classList.add('col-lg-6', 'col-main-block');
        div.innerHTML = getNewPhotoBlock(photo);
        setNewElementToDOM(photo_container_elem, div);
        initLikeSystem(photo.id, photo.like_status, photo.id);
    });
}

export function loadMorePhotosOnMainPage(photo_count, cycle)
{
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'GetMorePhotos', true);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState === 4 && xhr.status === 200)
        {
            let data = JSON.parse(xhr.responseText);
            setNewPhotosOMP(data, photo_count);
        }
    };
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(`photo_count=${photo_count}&cycle=${cycle}`);
}
