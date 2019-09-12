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
