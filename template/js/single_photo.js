import { $ } from './helpers/lib.js';
import { initLikeSystem } from './photo/likes.js';
import { sendComment } from './photo/comments.js'

(function () {
    function initCommentSystem(photo_id) {
        const comment_btn_elem = $('comment-btn');
        const text_input_elem = $('comment-input');

        comment_btn_elem.onclick = function () {
            sendComment(photo_id)
        };
        text_input_elem.onkeyup = function (event) {
            event.preventDefault();
            if (event.key === 'Enter') {
                comment_btn_elem.click();
            }
        };
    }

    initLikeSystem(photo.id, photo.like_status);
    initCommentSystem(photo.id);
})();
