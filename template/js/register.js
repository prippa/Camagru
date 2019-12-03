import {Form} from './helpers/Form.js'

(function () {
    let form = new Form('form', 'form-submit-btn', window.fv);
    form.setPasswordValidation('password');
    form.setPasswordValidation('password-confirm');
    form.isetEmailValidationWithAllEmailCheck('email');
    form.setUsernameValidationWithAllUsernameCheck('username');
})();
