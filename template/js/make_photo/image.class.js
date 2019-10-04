import {$, insertBefore} from '../lib.js';

export class Image
{
    constructor()
    {
        this.id = 0;
        this.images = [];
    }

    _getNewImageHTML(data)
    {
        return `<span class="delete-made-img-block" id="delete-made-img${data.id}">&times;</span>` +
               `<img class="img-fluid" src="${data.src}" alt="">`;
    }

    delete(id, made_img_col_elem)
    {
        const elem = $('made-img-block' + id);

        elem.parentNode.removeChild(elem);

        for (let i = 0; i < this.images.length; ++i) {
            if (this.images[i].id === id) {
                this.images.splice(i, 1);

                if (!this.images.length) {
                    made_img_col_elem.style.display = 'none';
                }

                return false;
            }
        }

        return true;
    }

    add(container_elem, src, made_img_col_elem)
    {
        const div = document.createElement('div');
        const data = {id: this.id, src: src};

        div.classList.add('col-xl-12', 'col-lg-3', 'col-md-4', 'col-sm-6', 'made-img-block');
        div.id = `made-img-block${this.id}`;
        div.innerHTML = this._getNewImageHTML(data);

        insertBefore(container_elem, div);
        this.images.push(data);

        if (this.images.length === 1) {
            made_img_col_elem.style.display = 'block';
        }

        $('delete-made-img' + data.id).onclick = () => this.delete(data.id, made_img_col_elem);

        ++this.id;
    }
}
