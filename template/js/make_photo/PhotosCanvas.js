import { $, insertBefore, dNone, dBlock, clearCanvas } from '../helpers/lib.js';

export class PhotosCanvas {
    constructor() {
        this._id = 0;
        this._images = [];
        this._url = '/api/UploadPhotos';
        this._made_img_col_elem = $('made-img-col');
        this._canv = $('img-canvas');
        this._ctx = this._canv.getContext('2d');

        this._canv.width = 1280;
        this._canv.height = 720;
    }

    _getNewImageHTML(data) {
        return `<span class="delete-made-img-block" id="delete-made-img${data.id}">&times;</span>` +
            `<img class="img-fluid" src="${data.src}" alt="">`;
    }

    delete(id) {
        const elem = $('made-img-block' + id);

        elem.parentNode.removeChild(elem);

        for (let i = 0; i < this._images.length; ++i) {
            if (this._images[i].id === id) {
                this._images.splice(i, 1);

                if (!this._images.length) {
                    dNone(this._made_img_col_elem);
                    window.onresize(undefined);
                }

                return false;
            }
        }

        return true;
    }

    add(container_elem, src_obj, super_img_obj) {
        this._ctx.drawImage(src_obj, 0, 0, this._canv.width, this._canv.height);
        this._ctx.drawImage(super_img_obj.canv, 0, 0, this._canv.width, this._canv.height);
        const src = this._canv.toDataURL('image/png');
        clearCanvas(this._canv);

        const div = document.createElement('div');
        const data = { id: this._id, src: src };

        div.classList.add('col-xl-12', 'col-lg-3', 'col-md-4', 'col-sm-6', 'made-img-block');
        div.id = `made-img-block${this._id}`;
        div.innerHTML = this._getNewImageHTML(data);

        insertBefore(container_elem, div);
        this._images.unshift(data);

        if (this._images.length === 1) {
            dBlock(this._made_img_col_elem);
            window.onresize(undefined);
        }

        $('delete-made-img' + data.id).onclick = () => this.delete(data.id);

        ++this._id;
    }

    async _ajaxSend(image) {
        const res = await fetch(this._url, {
            method: 'POST',
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            },
            body: `image_base_64=${image.src}&image_id=${image.id}`
        });
        const photoId = await res.json();
        this.delete(photoId);
        return res;
    }

    upload() {
        let promises = [];
        this._images.forEach((image) => {
            promises.push(this._ajaxSend(image));
        });
        return Promise.all(promises);
    }
}
