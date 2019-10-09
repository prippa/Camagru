export class CanvasPoint
{
    constructor(x_max, y_max, x=0, y=0)
    {
        this.x_max = x_max - 1;
        this.y_max = y_max - 1;
        this._x = 0;
        this._y = 0;

        this.x = x;
        this.y = y;
    }

    _keepNumberWithin(n, n_max)
    {
        if (n > n_max) {
            n = n_max;
        } else if (n < 0) {
            n = 0;
        }
        return n;
    }

    get x()
    {
        return this._x;
    }
    set x(x)
    {
        x = this._keepNumberWithin(x, this.x_max);
        this._x = x;
    }

    get y()
    {
        return this._y;
    }
    set y(y)
    {
        y = this._keepNumberWithin(y, this.y_max);
        this._y = y;
    }

    isEqual(point) { return (this.x === point.x && this.y === point.y); }
}
