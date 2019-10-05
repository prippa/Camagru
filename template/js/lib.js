export function $(name) { return document.getElementById(name); }
export function redirect(url) { window.location.href = '/' + url; exit(); }
export function exit()
{
    window.addEventListener('error', function(e) {
        e.preventDefault();
        e.stopPropagation();
    }, false);

    let handlers = [ 'copy', 'cut', 'paste', 'beforeunload', 'blur', 'change', 'click', 'contextmenu', 'dblclick',
        'focus', 'keydown', 'keypress', 'keyup', 'mousedown', 'mousemove', 'mouseout', 'mouseover', 'mouseup',
        'resize', 'scroll','DOMNodeInserted', 'DOMNodeRemoved', 'DOMNodeRemovedFromDocument',
        'DOMNodeInsertedIntoDocument', 'DOMAttrModified', 'DOMCharacterDataModified', 'DOMElementNameChanged',
        'DOMAttributeNameChanged', 'DOMActivate', 'DOMFocusIn', 'DOMFocusOut', 'online', 'offline', 'textInput',
        'abort', 'close', 'dragdrop', 'load', 'paint', 'reset', 'select', 'submit', 'unload' ];

    function stopPropagation(e) { e.stopPropagation(); }

    for (let i = 0; i < handlers.length; i++) {
        window.addEventListener(handlers[i], function(e) { stopPropagation(e); }, true);
    }

    if (window.stop) {
        window.stop();
    }

    throw 'exit';
}

export function ajaxSendDataByPOST(url, data)
{
    let xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}

export function insertAfter(insert_block_elem, new_elem)
{
    const fragment = document.createDocumentFragment();

    fragment.appendChild(new_elem);
    insert_block_elem.appendChild(fragment);
}

export function insertBefore(insert_block_elem, new_elem)
{
    const fragment = document.createDocumentFragment(),
          the_first_child = insert_block_elem.firstChild;

    fragment.appendChild(new_elem);
    insert_block_elem.insertBefore(fragment, the_first_child);
}

export function ResizeSensor(element, callback)
{
    let zIndex = parseInt(getComputedStyle(element));
    if(isNaN(zIndex)) { zIndex = 0; }
    --zIndex;

    let expand = document.createElement('div');
    expand.style.position = "absolute";
    expand.style.left = "0px";
    expand.style.top = "0px";
    expand.style.right = "0px";
    expand.style.bottom = "0px";
    expand.style.overflow = "hidden";
    expand.style.zIndex = zIndex;
    expand.style.visibility = "hidden";

    let expandChild = document.createElement('div');
    expandChild.style.position = "absolute";
    expandChild.style.left = "0px";
    expandChild.style.top = "0px";
    expandChild.style.width = "10000000px";
    expandChild.style.height = "10000000px";
    expand.appendChild(expandChild);

    let shrink = document.createElement('div');
    shrink.style.position = "absolute";
    shrink.style.left = "0px";
    shrink.style.top = "0px";
    shrink.style.right = "0px";
    shrink.style.bottom = "0px";
    shrink.style.overflow = "hidden";
    shrink.style.zIndex = zIndex;
    shrink.style.visibility = "hidden";

    let shrinkChild = document.createElement('div');
    shrinkChild.style.position = "absolute";
    shrinkChild.style.left = "0px";
    shrinkChild.style.top = "0px";
    shrinkChild.style.width = "200%";
    shrinkChild.style.height = "200%";
    shrink.appendChild(shrinkChild);

    element.appendChild(expand);
    element.appendChild(shrink);

    function setScroll()
    {
        expand.scrollLeft = 10000000;
        expand.scrollTop = 10000000;

        shrink.scrollLeft = 10000000;
        shrink.scrollTop = 10000000;
    }

    setScroll();

    let size = element.getBoundingClientRect();

    let currentWidth = size.width;
    let currentHeight = size.height;

    let onScroll = function()
    {
        let size = element.getBoundingClientRect();

        let newWidth = size.width;
        let newHeight = size.height;

        if(newWidth != currentWidth || newHeight != currentHeight)
        {
            currentWidth = newWidth;
            currentHeight = newHeight;

            callback();
        }

        setScroll();
    };

    expand.addEventListener('scroll', onScroll);
    shrink.addEventListener('scroll', onScroll);
}
