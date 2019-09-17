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


function setNewPhotosOnMainPage(photos)
{
    const photo_container_elem = $('photo-container');

    photos.forEach(function(photo)
    {
        const div = document.createElement('div');

        div.classList.add('col-lg-6', 'col-main-block');
        div.innerHTML = getNewPhotoBlock(photo);
        setNewElementToDOM(photo_container_elem, div);
        initLikeSystem(photo.id, photo.like_status, photo.id);
    });
}

function setNewPhotosOnMyPhotos(photos)
{
    const photo_container_elem = $('photo-container');

    photos.forEach(function(photo)
    {
        const div = document.createElement('div');

        div.classList.add('col-lg-6', 'col-main-block');
        div.innerHTML = getNewPhotoBlock(photo);
        setNewElementToDOM(photo_container_elem, div);
        initLikeSystem(photo.id, photo.like_status, photo.id);
    });
}

function ajaxSend(func, photo_count, cycle, query_type)
{
    let xhr = new XMLHttpRequest();

    xhr.open('POST', '/GetMorePhotos', true);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState === 4 && xhr.status === 200)
        {
            let photos = JSON.parse(xhr.responseText);
            if (photos.length < photo_count)
                $('show-more-block').style.display = 'none';
            func(photos);
        }
    };
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(`photo_count=${photo_count}&cycle=${cycle}&query_type=${query_type}`);
}

export function loadMorePhotosOnMainPage(photo_count, cycle)
{
    ajaxSend(setNewPhotosOnMainPage, photo_count, cycle, 1);
}

export function loadMorePhotosOnMyPhotos(photo_count, cycle)
{
    ajaxSend(setNewPhotosOnMyPhotos, photo_count, cycle, 2);
}
