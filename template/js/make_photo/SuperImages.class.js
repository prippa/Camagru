import {$} from '../lib.js';

export class SuperImages
{
    constructor()
    {
        this._canv = $('super-img-canvas');
        this._ctx  = this._canv.getContext('2d');
        this._super_images = [];
    }

    get canv() { return this._canv; }

    resetSize(width, height)
    {
        this._canv.width = width;
        this._canv.height = height;
        // TODO Redraw ALL IMAGES
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
        // let obj = {x: 0, y: 0, width: 0, height: 0};

        // this._super_images
    }

    _addFrameImage(src)
    {

    }

    _getCenterX() { return this._canv.width / 2 }
    _getCenterY() { return this._canv.height / 2 }

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
