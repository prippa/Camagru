export function $(name) {
    return document.getElementById(name);
}

export function redirect(url) {
    window.location.href = '/' + url; exit();
}

export function exit() {
    window.addEventListener('error', function (e) {
        e.preventDefault();
        e.stopPropagation();
    }, false);

    let handlers = ['copy', 'cut', 'paste', 'beforeunload', 'blur', 'change', 'click', 'contextmenu', 'dblclick',
        'focus', 'keydown', 'keypress', 'keyup', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup',
        'resize', 'scroll', 'DOMNodeInserted', 'DOMNodeRemoved', 'DOMNodeRemovedFromDocument',
        'DOMNodeInsertedIntoDocument', 'DOMAttrModified', 'DOMCharacterDataModified', 'DOMElementNameChanged',
        'DOMAttributeNameChanged', 'DOMActivate', 'DOMFocusIn', 'DOMFocusOut', 'online', 'offline', 'textInput',
        'abort', 'close', 'dragdrop', 'load', 'paint', 'reset', 'select', 'submit', 'unload'];

    function stopPropagation(e) { e.stopPropagation(); }

    for (let i = 0; i < handlers.length; i++) {
        window.addEventListener(handlers[i], function (e) { stopPropagation(e); }, true);
    }

    if (window.stop) {
        window.stop();
    }

    throw 'exit';
}

export function ajaxSendDataByPOST(url, data) {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}

export function insertAfter(insert_block_elem, new_elem) {
    const fragment = document.createDocumentFragment();

    fragment.appendChild(new_elem);
    insert_block_elem.appendChild(fragment);
}

export function insertBefore(insert_block_elem, new_elem) {
    const fragment = document.createDocumentFragment(),
        the_first_child = insert_block_elem.firstChild;

    fragment.appendChild(new_elem);
    insert_block_elem.insertBefore(fragment, the_first_child);
}

export function matrixArray(x, y) {
    let arr = new Array(y);

    for (let i = 0; i < y; ++i) {
        arr[i] = new Array(x);
    }

    return arr;
}

export function matrixFill(matrix, number = 0) {
    for (let i = 0; i < matrix.length; ++i) {
        matrix[i].fill(number);
    }
}

export function getPercentage(number, percent, integer = true) {
    let result = (number / 100) * percent;
    if (integer) {
        result = Math.round(result);
    }
    return result;
}

export function getPercentFromSumAndNumber(sum, number, integer = true) {
    let result = 100 / (sum / number);
    if (integer) {
        result = Math.round(result);
    }
    return result;
}

export function dNone(elem) {
    elem.style.display = 'none';
}

export function dBlock(elem) {
    elem.style.display = 'block';
}

export function setCursor(elem, cursor = 'default') {
    elem.style.cursor = cursor;
}

export function switchLogic(number) {
    if (number) {
        number = 0;
    } else {
        number = 1;
    }
    return number;
}

export function clearCanvas(canv) {
    canv.getContext('2d').clearRect(0, 0, canv.width, canv.height);
}

export function setLoadButton(btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
}
