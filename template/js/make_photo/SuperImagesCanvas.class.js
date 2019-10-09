import {$, matrixArray, getPercentage} from '../lib.js';
import {CanvasPoint} from './CanvasPoint.class.js';

export class SuperImagesCanvas
{
    constructor()
    {
        this._canv         = $('super-img-canvas');
        this._ctx          = this._canv.getContext('2d');
        this._super_base   = [];
        this._map          = null;

        this._is_mouse_down = false;
        this._is_image_in_focus = false;
        this._current_img_index = -1;
    }

    get canv() { return this._canv; }

    _getCenterX() { return Math.round(this._canv.width / 2) }
    _getCenterY() { return Math.round(this._canv.height / 2) }
    _getMousePos(evt)
    {
        const rect = this._canv.getBoundingClientRect();

        return new CanvasPoint(
            this._canv.width,
            this._canv.height,
            Math.ceil(evt.clientX - rect.left),
            Math.ceil(evt.clientY - rect.top)
        );
    }

    resetSize(width, height)
    {
        this._canv.width = width;
        this._canv.height = height;
        this._map = matrixArray(width, height, -1);
        // TODO Redraw ALL IMAGES
    }

    _drawOnMap(x, y, width, height, num)
    {
        let  yi = 0, xj = 0;

        for (let i = 0; i < height; ++i) {
            yi = y + i;
            if (yi === this._canv.height) {
                break;
            }
            for (let j = 0; j < width; ++j) {
                xj = x + j;
                if (xj === this._canv.width) {
                    break;
                }
                this._map[yi][xj] = num;
            }
        }
    }

    _addImage(src, x, y, width, height)
    {
        const base_image = new Image();

        base_image.src = src;
        base_image.onload = () => {
            this._super_base.push({
                img: base_image,
                point: new CanvasPoint(this._canv.width, this._canv.height, x, y)
            });
            this._drawOnMap(x, y, width, height, this._super_base.length - 1);
            this._ctx.drawImage(base_image, x, y, width, height);
        };
    }

    _addBaseImage(src)
    {
        let width = 100;
        let height = 100;
        let x = this._getCenterX() - getPercentage(width, 50, true);
        let y = this._getCenterY() - getPercentage(height, 50, true);
        this._addImage(src, x, y, width, height);
    }

    _addFrameImage(src)
    {

    }

    _mouseDown(evt)
    {
        const pos = this._getMousePos(evt);

        this._is_mouse_down = true;
        this._current_img_index = this._map[pos.y][pos.x];
        if (this._current_img_index !== -1) {
            this._is_image_in_focus = true;
            this._super_base.push(this._super_base.splice(this._current_img_index, 1)[0]);
        }
    }

    _mouseUp(evt)
    {
        if (this._is_image_in_focus) {
            let point = this._getMousePos(evt);

            if (this._super_base[this._current_img_index].point.isEqual(point)) {
                //TODO resize image
            }
        }

        this._is_mouse_down = false;
        this._is_image_in_focus = false;
    }

    _mouseMove(evt)
    {
        if (!this._is_mouse_down || !this._is_image_in_focus) {
            return ;
        }

        let cur_point = this._getMousePos(evt);
        let sb = this._super_base[this._current_img_index];
        // TODO отнимать разницу высоти и размера от позииции на площяди картинки
        sb.point.y = (sb.point.y - (sb.point.y - cur_point.y) - 70);
        sb.point.x = (sb.point.x - (sb.point.x - cur_point.x)) - 70;
        this._ctx.drawImage(sb.img, sb.point.x, sb.point.y, 100, 100);
        // TODO update map
        // console.log('x=', point.x, ',y=', point.y);
        // console.log(point.x);
        // console.log(point.y);
        // console.log(`x=${point.x},y=${point.y}`);
    }

    init(super_images)
    {
        super_images['base'].forEach((base) => {
            $('super-img-base' + base.id).onclick = () => this._addBaseImage('/' + base.file);
        });
        super_images['frame'].forEach((frame) => {
            $('super-img-frame' + frame.id).onclick = () => this._addFrameImage('/' + frame.file);
        });

        this._canv.onmousedown = (evt) => this._mouseDown(evt);
        this._canv.onmouseup = (evt) => this._mouseUp(evt);
        this._canv.onmousemove = (evt) => this._mouseMove(evt);
    }
}
