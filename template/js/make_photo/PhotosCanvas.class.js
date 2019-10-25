import {$, insertBefore, dNone, dBlock} from '../lib.js';

export class PhotosCanvas
{
    constructor()
    {
        this._id                = 0;
        this._images            = [];
        this._url               = '/api/UploadPhotos';
        this._made_img_col_elem = $('made-img-col');
        this._canv              = $('img-canvas');
        this._ctx               = this._canv.getContext('2d');

        this._canv.width  = 1280;
        this._canv.height = 720;
    }

    _getNewImageHTML(data)
    {
        return `<span class="delete-made-img-block" id="delete-made-img${data.id}">&times;</span>` +
               `<img class="img-fluid" src="${data.src}" alt="">`;
    }

    delete(id, video, super_img_obj)
    {
        const elem = $('made-img-block' + id);

        elem.parentNode.removeChild(elem);

        for (let i = 0; i < this._images.length; ++i) {
            if (this._images[i].id === id) {
                this._images.splice(i, 1);

                if (!this._images.length) {
                    dNone(this._made_img_col_elem);
                    super_img_obj.resetSize(video.clientWidth, video.clientHeight);
                }

                return false;
            }
        }

        return true;
    }

    add(container_elem, video, super_img_obj)
    {
        this._ctx.drawImage(video, 0, 0, this._canv.width, this._canv.height);
        this._ctx.drawImage(super_img_obj.canv, 0, 0, this._canv.width, this._canv.height);

        const src = this._canv.toDataURL('image/png');
        const div = document.createElement('div');
        const data = {id: this._id, src: src};

        div.classList.add('col-xl-12', 'col-lg-3', 'col-md-4', 'col-sm-6', 'made-img-block');
        div.id = `made-img-block${this._id}`;
        div.innerHTML = this._getNewImageHTML(data);

        insertBefore(container_elem, div);
        this._images.unshift(data);

        if (this._images.length === 1) {
            dBlock(this._made_img_col_elem);
            super_img_obj.resetSize(video.clientWidth, video.clientHeight);
        }

        $('delete-made-img' + data.id).onclick = () => this.delete(data.id, video, super_img_obj);

        ++this._id;
    }

    _ajaxSend(image)
    {
        let xhr = new XMLHttpRequest();

        xhr.open('POST', this._url, true);
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText !== 'KO') {
                    this.delete(parseInt(xhr.responseText, 10));
                }
            }
        };

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(`image_base_64=${image.src}&image_id=${image.id}`);
    }

    upload()
    {
        this._images.forEach((image) => {
            this._ajaxSend(image);
        });
    }
}
