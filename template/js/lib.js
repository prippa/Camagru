export function $(name) { return document.getElementById(name); }
export function redirect(url) { window.location.href = url; exit(); }
export function exit()
{
    window.addEventListener('error', function(e) { e.preventDefault(); e.stopPropagation(); }, false);

    let handlers = [ 'copy', 'cut', 'paste', 'beforeunload', 'blur', 'change', 'click', 'contextmenu', 'dblclick',
        'focus', 'keydown', 'keypress', 'keyup', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup',
        'resize', 'scroll','DOMNodeInserted', 'DOMNodeRemoved', 'DOMNodeRemovedFromDocument',
        'DOMNodeInsertedIntoDocument', 'DOMAttrModified', 'DOMCharacterDataModified', 'DOMElementNameChanged',
        'DOMAttributeNameChanged', 'DOMActivate', 'DOMFocusIn', 'DOMFocusOut', 'online', 'offline', 'textInput',
        'abort', 'close', 'dragdrop', 'load', 'paint', 'reset', 'select', 'submit', 'unload' ];

    function stopPropagation(e) { e.stopPropagation(); }

    for (let i = 0; i < handlers.length; i++)
        window.addEventListener(handlers[i], function(e) { stopPropagation(e); }, true);

    if (window.stop)
        window.stop();

    throw 'exit';
}

export function ajaxSendDataByPOST(url, data, callback_function, callback_function_data)
{
    let xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState === 4 && xhr.status === 200)
        {
            if (xhr.responseText === 'redirect')
                redirect('login');
            callback_function(callback_function_data);
        }
    };
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}
