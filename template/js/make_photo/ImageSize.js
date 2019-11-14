export class ImageSize {
    constructor() {
        // Size in % on the map
        this.sizes = [1, 3, 5, 10, 15, 20, 25, 35, 45, 60, 80, 100];
        this.default_img_size_index = 4;
    }

    incrementIndex(index) {
        if (index === this.sizes.length - 1) {
            index = 0;
        } else {
            ++index;
        }

        return index;
    }

    decrementIndex(index) {
        if (!index) {
            index = this.sizes.length - 1;
        } else {
            --index;
        }

        return index;
    }
}

