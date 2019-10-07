import {$} from '../lib.js';

export class SuperImages
{
    constructor(super_img_ctx)
    {
        this.canv_x = 0;
        this.canv_y = 0;
        this._sic = super_img_ctx;
        this._super_images = [];
    }

    _drawImage(src, x, y, width, height)
    {
        let base_image = new Image();
        base_image.src = src;
        base_image.onload = () => {
            this._sic.drawImage(base_image, x, y, width, height);
        }
    }

    _drawImages(){}

    _addBaseImage(src)
    {
        let obj = {x: 0, y: 0, width: 0, height: 0};

        this._super_images
    }

    _addFrameImage(src)
    {

    }

    _getCenterX() { return this.canv_x / 2 }
    _getCenterY() { return this.canv_y / 2 }

    initSuperImages(super_images)
    {
        super_images['base'].forEach((base) => {
            $('super-img-base' + base.id).onclick = () => this._addBaseImage('/' + frame.file);
        });
        super_images['frame'].forEach((frame) => {
            $('super-img-frame' + frame.id).onclick = () => this._addFrameImage('/' + frame.file);
        });
    }
}
