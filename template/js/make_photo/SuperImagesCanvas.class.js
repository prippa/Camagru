import {$, matrixArray, matrixFill, getPercentage, dBlock, dNone, setCursor} from '../lib.js';
import {Point} from './Point.class.js';

export class SuperImagesCanvas
{
    constructor()
    {
        this._col_remove_img    = $('col-remove-img');
        this._col_remove_frame  = $('col-remove-frame');
        this._col_remove_img.firstElementChild.onclick = () => this._removeImage();
        this._col_remove_frame.firstElementChild.onclick = () => this._removeFrame();

        this._canv         = $('super-img-canvas');
        this._ctx          = this._canv.getContext('2d');
        this._super_base   = [];
        this._frame        = null;
        this._map          = null;
        this._id           = 1;

        this._is_image_in_focus = false;
        this._current_img       = null;
        this.pos_size           = null;
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

    _drawImages()
    {
        for (let i = 0; i < this._super_base.length; ++i) {
            const sb = this._super_base[i];

            this._drawOnMap(sb.point.x, sb.point.y, sb.width, sb.height, sb.id);
            this._ctx.drawImage(sb.img, sb.point.x, sb.point.y, sb.width, sb.height);
        }
    }

    _drawFrame()
    {
        if (!this._frame) {
            return ;
        }
        this._ctx.drawImage(this._frame, 0, 0, this._canv.width, this._canv.height);
    }

    _draw()
    {
        this._clearCanvas();
        matrixFill(this._map);
        this._drawImages();
        this._drawFrame();
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

    _removeImage()
    {
        if (this._super_base.length) {
            this._super_base.pop();
            this._draw();
            if (!this._super_base.length) {
                dNone(this._col_remove_img);
            }
        }
    }

    _removeFrame()
    {
        this._frame = null;
        this._draw();
        dNone(this._col_remove_frame);
    }

    _addBaseImage(src)
    {
        const img = new Image();

        img.src = src;
        img.onload = () => {
            const x = this._getCenterX() - getPercentage(img.width, 50, true),
                  y = this._getCenterY() - getPercentage(img.height, 50, true);

            this._super_base.push({
                id: this._id,
                img: img,
                point: new Point(x, y),
                width: img.width,
                height: img.height
            });

            this._draw();
            ++this._id;
            if (this._super_base.length == 1) {
                dBlock(this._col_remove_img);
            }
        };
    }

    _addFrameImage(src)
    {
        this._frame = new Image();
        this._frame.src = src;
        this._frame.onload = () => {
            this._draw();
        };
        dBlock(this._col_remove_frame);
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
                    this.pos_size = {
                        width: pos.x - this._current_img.point.x,
                        height: pos.y - this._current_img.point.y
                    };
                }
            }
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
        let cur_point = this._getMousePos(evt);

        if (!this._is_image_in_focus) {
            if (this._map[cur_point.y][cur_point.x]) {
                setCursor(this._canv, 'grab');
            } else {
                setCursor(this._canv, 'default');
            }
            return ;
        }

        this._current_img.point.y += (cur_point.y - this._current_img.point.y) - this.pos_size.height;
        this._current_img.point.x += (cur_point.x - this._current_img.point.x) - this.pos_size.width;
        this._draw();
    }

    _mouseLeave()
    {
        this._is_image_in_focus = false;
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
    }
}
