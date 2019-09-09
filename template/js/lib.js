export function $(name) { return document.getElementById(name); }

export function ajaxSendDataByPOST(url, data)
{
    let xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}
