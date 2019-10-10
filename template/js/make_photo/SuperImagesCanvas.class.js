import {$, matrixArray, matrixFill, getPercentage} from '../lib.js';
import {Point} from './Point.class.js';

export class SuperImagesCanvas
{
    constructor()
    {
        this._canv         = $('super-img-canvas');
        this._ctx          = this._canv.getContext('2d');
        this._super_base   = [];
        this._map          = null;
        this._id           = 1;

        this._is_image_in_focus = false;
        this._current_img = null;
        this.pos_size = null;
        this.width = 100;
        this.height = 100;
    }

    get canv() { return this._canv; }

    _clearCanvas() { this._ctx.clearRect(0, 0, this._canv.width, this._canv.height); }
    _getCenterX() { return Math.round(this._canv.width / 2) }
    _getCenterY() { return Math.round(this._canv.height / 2) }
    _getMousePos(evt)
    {
        const rect = this._canv.getBoundingClientRect();

        return new Point(
            Math.ceil(evt.clientX - rect.left),
            Math.ceil(evt.clientY - rect.top)
        );
    }

    clear()
    {
        this._super_base = [];
        this._clearCanvas();
    }

    _draw()
    {
        this._clearCanvas();
        matrixFill(this._map);

        for (let i = 0; i < this._super_base.length; ++i) {
            const sb = this._super_base[i];

            this._drawOnMap(sb.point.x, sb.point.y, sb.width, sb.height, sb.id);
            this._ctx.drawImage(sb.img, sb.point.x, sb.point.y, sb.width, sb.height);
        }
    }

    resetSize(width, height)
    {
        this._canv.width = width;
        this._canv.height = height;
        this._map = matrixArray(width, height);
        matrixFill(this._map);
        // TODO Redraw ALL IMAGES
    }

    _drawOnMap(x, y, width, height, num)
    {
        let  yi = 0, xj = 0;

        for (let i = 0; i < height; ++i) {
            yi = y + i;
            if (yi < 0) {
                continue;
            }
            if (yi === this._canv.height) {
                break;
            }
            for (let j = 0; j < width; ++j) {
                xj = x + j;
                if (xj < 0) {
                    continue;
                }
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
                id: this._id,
                img: base_image,
                point: new Point(x, y),
                width: width,
                height: height
            });
            this._drawOnMap(x, y, width, height, this._id);
            this._ctx.drawImage(base_image, x, y, width, height);
            ++this._id;
        };
    }

    _addBaseImage(src)
    {
        let width = this.width;
        let height = this.height;
        let x = this._getCenterX() - getPercentage(width, 50, true);
        let y = this._getCenterY() - getPercentage(height, 50, true);
        this._addImage(src, x, y, width, height);
        this.height += 50;
        this.width += 50;
    }

    _addFrameImage(src)
    {

    }

    _getSizeFromImagePoint(point)
    {
        const number = this._map[point.y][point.x];
        let size = {width: 0, height: 0};
        let x = point.x, y = point.y;

        while (number === this._map[point.y][x--]) {
            ++size.width;
            if (x === -1) {
                break;
            }
        }

        while (number === this._map[y--][point.x]) {
            ++size.height;
            if (y === -1) {
                break;
            }
        }

        return size;
    }

    _mouseDown(evt)
    {
        const pos = this._getMousePos(evt);
        const id = this._map[pos.y][pos.x];

        if (id) {
            this._is_image_in_focus = true;

            for (let i = 0; i < this._super_base.length; ++i) {
                if (this._super_base[i].id === id) {
                    this._current_img = this._super_base[i];
                    this._super_base.push(this._super_base.splice(i, 1)[0]);
                }
            }
            this.pos_size = this._getSizeFromImagePoint(pos);
        }
    }

    _mouseUp(evt)
    {
        if (this._is_image_in_focus) {
            let point = this._getMousePos(evt);

            if (this._current_img.point.isEqual(point)) {
                //TODO resize image
            }
        }

        this._is_image_in_focus = false;
    }

    _mouseMove(evt)
    {
        if (!this._is_image_in_focus) {
            return ;
        }

        let cur_point = this._getMousePos(evt);

        this._current_img.point.y += (cur_point.y - this._current_img.point.y) - this.pos_size.height;
        this._current_img.point.x += (cur_point.x - this._current_img.point.x) - this.pos_size.width;
        this._draw();
    }

    _mouseLeave()
    {
        this._is_image_in_focus = false;
    }

    _doubleClick(evt)
    {
        const pos = this._getMousePos(evt);
        const id = this._map[pos.y][pos.x];

        if (id) {
            for (let i = 0; i < this._super_base.length; ++i) {
                if (this._super_base[i].id === id) {
                    this._super_base.splice(i, 1);
                }
            }
            this._draw();
        }
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
        this._canv.onmouseleave = () => this._mouseLeave();
        this._canv.ondblclick = (evt) => this._doubleClick(evt);
    }
}
