import {$, setLoadButton} from './lib.js'

export class Form {
    constructor(form_id, submit_btn_id, fields_validation) {
        this._fv = fields_validation;
        this._fields = {};
        this._sb = $(submit_btn_id);
        $(form_id).onsubmit = () => {
            setLoadButton(this._sb);
        };
    }

    _setIsValid(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }

    _setIsInvalid(input, invalid, text) {
        input.classList.remove('is-valid');
        invalid.innerHTML = text;
        input.classList.add('is-invalid');
    }

    _getDataFromDB(uri, call_back_func) {
        let xhr = new XMLHttpRequest();

        xhr.open('POST', uri, true);
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                call_back_func(data);
            }
        };

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send();
    }

    _checkDBData(data, key, str) {
        if (!data) {
            return false;
        }

        for (let i = 0; i < data.length; ++i) {
            if (data[i][key] === str) {
                return true
            }
        }
        return false;
    }

    _validateUsername(id, all_username) {
        const input = $(id + '-field');
        const invalid = $(id + '-field-invalid');
        let res = true;

        if (input.value.search(this._fv['username'])) {
            this._setIsInvalid(input, invalid, '0-9, a-z, _, from 1 to 32 characters');
        } else if (this._checkDBData(all_username, 'login', input.value)) {
            this._setIsInvalid(input, invalid, `<b>${input.value}</b> is already taken`);
        } else {
            this._setIsValid(input);
            res = false;
        }
        this._afterValidation(id, !!res);
    }

    _validateEmail(id, all_email) {
        const input = $(id + '-field');
        const invalid = $(id + '-field-invalid');
        let res = true;

        if (input.value.search(this._fv['email'])) {
            this._setIsInvalid(input, invalid, 'Invalid Email');
        } else if (this._checkDBData(all_email, 'email', input.value)) {
            this._setIsInvalid(input, invalid, `<b>${input.value}</b> is already registered`);
        } else {
            this._setIsValid(input);
            res = false;
        }
        this._afterValidation(id, !!res);
    }

    _validatePassword(id) {
        const input = $(id + '-field');
        const invalid = $(id + '-field-invalid');
        let res = true;

        if (input.value.search(this._fv['password'])) {
            this._setIsInvalid(input, invalid, 'From 6 to 128 characters');
        } else {
            this._setIsValid(input);
            res = false;
        }
        this._afterValidation(id, !!res);
    }

    setUsernameValidation(id) {
        const input = $(id + '-field');

        this._fields[id] = true;
        input.oninput = () => this._validateUsername(id, null);
        if (input.value) {
            input.oninput(undefined);
        }
    }

    setUsernameValidationWithAllUsernameCheck(id) {
        this._getDataFromDB('/api/GetAllLogin', ((data) => {
            const input = $(id + '-field');

            this._fields[id] = true;
            input.oninput = () => this._validateUsername(id, data);
            if (input.value) {
                input.oninput(undefined);
            }
        }));
    }

    setEmailValidation(id) {
        const input = $(id + '-field');

        this._fields[id] = true;
        input.oninput = () => this._validateEmail(id);
        if (input.value) {
            input.oninput(undefined);
        }
    }

    isetEmailValidationWithAllEmailCheck(id) {
        this._getDataFromDB('/api/GetAllEmail', ((data) => {
            const input = $(id + '-field');

            this._fields[id] = true;
            input.oninput = () => this._validateEmail(id, data);
            if (input.value) {
                input.oninput(undefined);
            }
        }));
    }

    setPasswordValidation(id) {
        const input = $(id + '-field');

        this._fields[id] = true;
        input.oninput = () => this._validatePassword(id);
        if (input.value) {
            input.oninput(undefined);
        }
    }

    _afterValidation(id, res) {
        this._fields[id] = res;
        for (let key in this._fields) {
            if (this._fields[key]) {
                this._sb.disabled = true;
                return false;
            }
        }
        this._sb.disabled = false;
        return true;
    }
}