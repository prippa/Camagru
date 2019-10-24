import {$, matrixArray, matrixFill, getPercentage,
    dBlock, dNone, setCursor, getPercentFromSumAndNumber} from '../lib.js';
import {Point} from './Point.class.js';
import {ImageSize} from './ImageSize.class.js';

export class SuperImagesCanvas
{
    constructor()
    {
        this._canv         = $('super-img-canvas');
        this._ctx          = this._canv.getContext('2d');
        this._super_base   = [];
        this._frame        = null;
        this._map          = null;
        this._id           = 1;

        this._is_image_in_focus = false;
        this._current_img       = null;
        this._pos_size          = null;

        this._image_size = new ImageSize();

        this._col_remove_img    = $('col-remove-img');
        this._col_remove_frame  = $('col-remove-frame');
        this._col_zoom_in       = $('col-zoom-in');
        this._col_zoom_out      = $('col-zoom-out');

        //Button Remove Image Event
        this._col_remove_img.firstElementChild.onclick = () => {
            if (this._super_base.length) {
                this._super_base.pop();
                this._draw();
                if (!this._super_base.length) {
                    this._hideSuperImageButtons();
                }
            }
        };

        //Button Remove Frame Event
        this._col_remove_frame.firstElementChild.onclick = () => {
            this._frame = null;
            this._draw();
            this._hideFrameImageButtons();
        };

        // Button Zoom Image In
        this._col_zoom_in.firstElementChild.onclick = () => {
            const img = this._super_base[this._super_base.length - 1];

            img.size_index = this._image_size.incrementIndex(img.size_index);
            this._resizeImage(img);
            this._draw();
        };

        // Button Zoom Image Out
        this._col_zoom_out.firstElementChild.onclick = () => {
            const img = this._super_base[this._super_base.length - 1];

            img.size_index = this._image_size.decrementIndex(img.size_index);
            this._resizeImage(img);
            this._draw();
        };
    }

    get canv() { return this._canv; }

    _clearCanvas() { this._ctx.clearRect(0, 0, this._canv.width, this._canv.height); }
    _getCenterX() { return Math.round(this._canv.width / 2) }
    _getCenterY() { return Math.round(this._canv.height / 2) }
    _getMousePos(evt)
    {
        const rect = this._canv.getBoundingClientRect();
        let x = Math.ceil(evt.clientX - rect.left);
        let y = Math.ceil(evt.clientY - rect.top);

        if (x < 0) {
            x = 0;
        }
        if (y < 0) {
            y = 0;
        }

        return new Point(x, y);
    }
    _hideSuperImageButtons()
    {
        dNone(this._col_remove_img);
        dNone(this._col_zoom_in);
        dNone(this._col_zoom_out);
    }
    _hideFrameImageButtons()
    {
        dNone(this._col_remove_frame);
    }
    _showSuperImageButtons()
    {
        dBlock(this._col_remove_img);
        dBlock(this._col_zoom_in);
        dBlock(this._col_zoom_out);
    }
    _showFrameImageButtons()
    {
        dBlock(this._col_remove_frame);
    }

    clear()
    {
        if (this._super_base.length) {
            this._super_base = [];
            this._hideSuperImageButtons();
        }
        if (this._frame) {
            this._frame = null;
            this._hideFrameImageButtons();
        }
        this._clearCanvas();
    }

    _drawOnMap(x, y, width, height, num)
    {
        let  yi = 0, xj = 0;

        for (let i = 0; i < height; ++i) {
            yi = y + i;
            if (yi < 0) {
                continue;
            }
            if (yi >= this._canv.height) {
                break;
            }
            for (let j = 0; j < width; ++j) {
                xj = x + j;
                if (xj < 0) {
                    continue;
                }
                if (xj >= this._canv.width) {
                    break;
                }
                this._map[yi][xj] = num;
            }
        }
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

    _resizeImage(img)
    {
        const map_sum = this._canv.height * this._canv.width;
        let img_sum = img.height * img.width;
        let current_percent = getPercentFromSumAndNumber(map_sum, img_sum);
        let needed_percent = this._image_size.sizes[img.size_index];
        let move = img.width;

        while (needed_percent < current_percent) {
            --img.width;
            --img.height;
            img_sum = img.height * img.width;
            current_percent = getPercentFromSumAndNumber(map_sum, img_sum);
        }
        while (needed_percent > current_percent) {
            ++img.width;
            ++img.height;
            img_sum = img.height * img.width;
            current_percent = getPercentFromSumAndNumber(map_sum, img_sum);
        }

        move = move - img.width;
        if (move) {
            move = Math.round(move / 2);
            img.point.y += move;
            img.point.x += move;
        }
    }

    resetSize(width, height)
    {
        // const width_diff = width - this._canv.width;
        // const height_diff = height - this._canv.height;
        this._canv.width = width;
        this._canv.height = height;
        this._map = matrixArray(width, height);
        matrixFill(this._map);
        for (let i = 0; i < this._super_base.length; ++i) {
            let img = this._super_base[i];
            this._resizeImage(img);
        }
        this._draw();
    }

    init(super_images)
    {
        // Init Super Images
        super_images['base'].forEach((base) => {
            $('super-img-base' + base.id).onclick = () => {
                const src = '/' + base.file;
                const img = new Image();

                img.src = src;
                img.onload = () => {
                    const x = this._getCenterX() - getPercentage(img.width, 50);
                    const y = this._getCenterY() - getPercentage(img.height, 50);

                    let new_super_image = {
                        id: this._id,
                        img: img,
                        point: new Point(x, y),
                        width: img.width,
                        height: img.height,
                        size_index: this._image_size.default_img_size_index
                    };
                    this._resizeImage(new_super_image);
                    this._super_base.push(new_super_image);
                    this._draw();
                    ++this._id;
                    if (this._super_base.length === 1) {
                        this._showSuperImageButtons();
                    }
                };
            };
        });

        // Init Frames
        super_images['frame'].forEach((frame) => {
            $('super-img-frame' + frame.id).onclick = () => {
                const src = '/' + frame.file;

                this._frame = new Image();
                this._frame.src = src;
                this._frame.onload = () => {
                    this._draw();
                };
                this._showFrameImageButtons();
            };
        });

        // Canvas onmousedown Event
        this._canv.onmousedown = (evt) => {
            const pos = this._getMousePos(evt);
            const id = this._map[pos.y][pos.x];

            if (id) {
                this._is_image_in_focus = true;

                for (let i = 0; i < this._super_base.length; ++i) {
                    if (this._super_base[i].id === id) {
                        this._current_img = this._super_base[i];
                        this._super_base.push(this._super_base.splice(i, 1)[0]);
                        this._pos_size = {
                            width: pos.x - this._current_img.point.x,
                            height: pos.y - this._current_img.point.y
                        };
                        this._draw();
                        break;
                    }
                }
            }
        };

        // Canvas onmouseup Event
        this._canv.onmouseup = () => {
            this._is_image_in_focus = false;
        };

        // Canvas onmousemove Event
        this._canv.onmousemove = (evt) => {
            let cur_point = this._getMousePos(evt);

            if (!this._is_image_in_focus) {
                if (this._map[cur_point.y][cur_point.x]) {
                    setCursor(this._canv, 'grab');
                } else {
                    setCursor(this._canv, 'default');
                }
                return ;
            }

            this._current_img.point.y += (cur_point.y - this._current_img.point.y) - this._pos_size.height;
            this._current_img.point.x += (cur_point.x - this._current_img.point.x) - this._pos_size.width;
            this._draw();
        };

        // Canvas onmouseleave Event
        this._canv.onmouseleave = () => {
            this._is_image_in_focus = false;
        };
    }
}
