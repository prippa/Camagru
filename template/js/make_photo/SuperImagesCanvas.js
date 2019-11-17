import {
    $, matrixArray, matrixFill, getPercentage, switchLogic,
    dBlock, dNone, setCursor, getPercentFromSumAndNumber, clearCanvas
} from '../helpers/lib.js';
import { Point } from '../helpers/Point.js';
import { ImageSize } from './ImageSize.js';

export class SuperImagesCanvas {
    constructor() {
        this._canv = $('super-img-canvas');
        this._sc_images = $('super-canvas-images');
        this._sc_buttons = $('super-canvas-buttons');
        this._ctx = this._canv.getContext('2d');
        this._super_base = [];
        this._frame = null;
        this._frame_mod = 1;
        this._map = null;
        this._id = 1;

        this._is_image_in_focus = false;
        this._current_img = null;
        this._pos_size = null;

        this._image_size = new ImageSize();

        this._col_remove_img = $('col-remove-img');
        this._col_zoom_in_img = $('col-zoom-in');
        this._col_zoom_out_img = $('col-zoom-out');
        this._col_remove_frame = $('col-remove-frame');
        this._col_change_mod_frame = $('col-change-mod');
        this._col_clear_all = $('col-clear-all');

        //Button Remove Image Event
        this._col_remove_img.firstElementChild.onclick = () => this._removeImage();

        //Button Remove Frame Event
        this._col_remove_frame.firstElementChild.onclick = () => this._removeFrame();

        // Button Zoom Image In
        this._col_zoom_in_img.firstElementChild.onclick = () => this._zoomImageIn();

        // Button Zoom Image Out
        this._col_zoom_out_img.firstElementChild.onclick = () => this._zoomImageOut();

        // Change Frame mod
        this._col_change_mod_frame.firstElementChild.onclick = () => this._changeFrameMod();

        // Clear All
        this._col_clear_all.firstElementChild.onclick = () => this.clear();
    }

    _removeImage() {
        if (this._super_base.length) {
            this._super_base.pop();
            this._draw();
            if (!this._super_base.length) {
                this._hideSuperImageButtons();
            }
        }
    }
    _removeFrame() {
        this._frame = null;
        this._draw();
        this._hideFrameImageButtons();
    }
    _zoomImageIn() {
        const img = this._super_base[this._super_base.length - 1];

        img.size_index = this._image_size.incrementIndex(img.size_index);
        this._resizeImage(img);
        this._draw();
    }
    _zoomImageOut() {
        const img = this._super_base[this._super_base.length - 1];

        img.size_index = this._image_size.decrementIndex(img.size_index);
        this._resizeImage(img);
        this._draw();
    }
    _changeFrameMod() {
        this._frame_mod = switchLogic(this._frame_mod);
        if (this._frame_mod) {
            this._col_change_mod_frame.firstElementChild.innerHTML = 'Under Image'
        } else {
            this._col_change_mod_frame.firstElementChild.innerHTML = 'Over Image';
        }
        this._draw();
    }

    get canv() { return this._canv; }

    _getCenterX() { return Math.round(this._canv.width / 2) }
    _getCenterY() { return Math.round(this._canv.height / 2) }
    _posValidation(x, y) {
        if (x < 0) {
            x = 0;
        }
        if (y < 0) {
            y = 0;
        }
        if (x >= this._canv.width) {
            x = this._canv.width - 1;
        }
        if (y >= this._canv.height) {
            y = this._canv.height - 1;
        }

        return new Point(x, y);
    }
    _getMousePos(evt) {
        const rect = this._canv.getBoundingClientRect();
        let x = Math.ceil(evt.clientX - rect.left);
        let y = Math.ceil(evt.clientY - rect.top);

        return this._posValidation(x, y);
    }
    _getTouchPos(touchEvent) {
        const rect = this._canv.getBoundingClientRect();
        let x = Math.ceil(touchEvent.touches[0].clientX - rect.left);
        let y = Math.ceil(touchEvent.touches[0].clientY - rect.top);

        return this._posValidation(x, y);
    }

    _hideSuperImageButtons() {
        dNone(this._col_remove_img);
        dNone(this._col_zoom_in_img);
        dNone(this._col_zoom_out_img);
        if (!this._frame) {
            dNone(this._col_clear_all);
        }
    }
    _hideFrameImageButtons() {
        dNone(this._col_remove_frame);
        dNone(this._col_change_mod_frame);
        if (!this._super_base.length) {
            dNone(this._col_clear_all);
        }
    }
    _showSuperImageButtons() {
        dBlock(this._col_remove_img);
        dBlock(this._col_zoom_in_img);
        dBlock(this._col_zoom_out_img);
        dBlock(this._col_clear_all);
    }
    _showFrameImageButtons() {
        dBlock(this._col_remove_frame);
        dBlock(this._col_change_mod_frame);
        dBlock(this._col_clear_all);
    }

    hide() {
        dNone(this._canv);
        dNone(this._sc_buttons);
        dNone(this._sc_images);
    }

    show() {
        dBlock(this._canv);
        dBlock(this._sc_buttons);
        dBlock(this._sc_images);
    }

    clear() {
        if (this._super_base.length) {
            this._super_base = [];
            this._hideSuperImageButtons();
        }
        if (this._frame) {
            this._frame = null;
            this._hideFrameImageButtons();
        }
        matrixFill(this._map);
        clearCanvas(this._canv);
    }

    _drawOnMap(x, y, width, height, num) {
        let yi = 0, xj = 0;

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

    _drawImages() {
        for (let i = 0; i < this._super_base.length; ++i) {
            const sb = this._super_base[i];

            this._drawOnMap(sb.point.x, sb.point.y, sb.width, sb.height, sb.id);
            this._ctx.drawImage(sb.img, sb.point.x, sb.point.y, sb.width, sb.height);
        }
    }

    _drawFrame() {
        if (!this._frame) {
            return;
        }
        this._ctx.drawImage(this._frame, 0, 0, this._canv.width, this._canv.height);
    }

    _draw() {
        clearCanvas(this._canv);
        matrixFill(this._map);
        if (this._frame_mod) {
            this._drawImages();
            this._drawFrame();
        } else {
            this._drawFrame();
            this._drawImages();
        }
    }

    _resizeImage(img) {
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

    resetSize(width, height) {
        const old_width = this._canv.width;
        const old_height = this._canv.height;

        this._canv.width = width;
        this._canv.height = height;
        this._map = matrixArray(width, height);
        matrixFill(this._map);
        for (let i = 0; i < this._super_base.length; ++i) {
            let img = this._super_base[i];
            let x_div = 0, y_div = 0;

            if (img.point.x) {
                x_div = (old_width / (img.point.x + (img.width / 2))).toFixed(1);
            }
            if (img.point.y) {
                y_div = (old_height / (img.point.y + (img.height / 2))).toFixed(1);
            }
            if (x_div) {
                img.point.x = Math.round(width / x_div) - getPercentage(img.width, 50);
            }
            if (y_div) {
                img.point.y = Math.round(height / y_div) - getPercentage(img.height, 50);
            }
            this._resizeImage(img);
        }
        this._draw();
    }

    _onmousedown(evt, pos = null) {
        if (!pos) {
            pos = this._getMousePos(evt);
        }
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
    }

    _onmouseup() {
        this._is_image_in_focus = false;
    }

    _onmousemove(evt, pos = null) {
        if (!pos) {
            pos = this._getMousePos(evt);
        }

        if (!this._is_image_in_focus) {
            if (this._map[pos.y][pos.x]) {
                setCursor(this._canv, 'pointer');
            } else {
                setCursor(this._canv, 'default');
            }
            return;
        }

        this._current_img.point.y += (pos.y - this._current_img.point.y) - this._pos_size.height;
        this._current_img.point.x += (pos.x - this._current_img.point.x) - this._pos_size.width;
        this._draw();
    }

    _ontouchmove(evt) {
        this._onmousemove(evt, this._getTouchPos(evt));
    }
    _ontouchstart(evt) {
        this._onmousedown(evt, this._getTouchPos(evt));
    }

    _onmouseleave() {
        this._is_image_in_focus = false;
    }

    init(super_images) {
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
        this._canv.onmousedown = (evt) => this._onmousedown(evt);
        this._canv.ontouchstart = (evt) => this._ontouchstart(evt);

        // Canvas onmouseup Event
        this._canv.onmouseup = () => this._onmouseup();
        this._canv.ontouchend = () => this._onmouseup();

        // Canvas onmousemove Event
        this._canv.onmousemove = (evt) => this._onmousemove(evt);
        this._canv.ontouchmove = (evt) => this._ontouchmove(evt);

        // Canvas onmouseleave Event
        this._canv.onmouseleave = () => this._onmouseleave();
        this._canv.ontouchcancel = () => this._onmouseleave();
    }
}
