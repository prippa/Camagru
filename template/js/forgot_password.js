import {$, setLoadButton} from './helpers/lib.js'

(function () {
    $('form').onsubmit = function () {
        setLoadButton($('form-submit-btn'));
    };
})();
