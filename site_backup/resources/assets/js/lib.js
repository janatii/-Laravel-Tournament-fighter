'use strict';

var $ = require('jquery');

export function addSpinnerTo($element) {
    $element.append(' <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
}

export function removeSpinnerFrom($element) {
    $element.find('.fa-spinner').remove();
}

export function debounce(func, wait, immediate) {
    var timeout;
    return function () {
        var context = this,
            args = arguments;
        var later = function later() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

export function remodalize(id, cbDone, cbFail, cbClosed) {
    var $remodal = $('[data-remodal-id="' + id + '"]');
    var $form = $remodal.find('form');
    var $button = $remodal.find('button[type="submit"]');
    var $alertsBox = $remodal.find('.alert');

    $remodal.on('closed', function () {
        $form[0].reset();
        $alertsBox.css('display', 'none');

        if (cbClosed) {
            cbClosed($form, $button, $alertsBox);
        }
    });

    $form.on('submit', function (e) {
        e.preventDefault();

        $button.attr('disabled', 'disabled');
        $alertsBox.css('display', 'none');

        addSpinnerTo($button);

        $.post(this.action, $(this).serialize())
            .done(function (data, status, jqXhr) {
                var redirectPath = '/';
                if (data && data.redirect) {
                    redirectPath = data.redirect;
                }

                if (cbDone == null || (typeof cbDone === 'boolean' && cbDone)) {
                    window.location.replace(redirectPath);
                } else if (typeof cbDone === 'function') {
                    cbDone(data, status, jqXhr);
                }

                $remodal.remodal().close();
            })
            .fail(function (data) {
                if (data.responseJSON) {
                    var fieldsNames = Object.keys(data.responseJSON);
                    var html = '';
                    fieldsNames.forEach(function (fieldName) {
                        if (typeof data.responseJSON[fieldName] == 'string') {
                            html += data.responseJSON[fieldName] + '<br>';
                        } else {
                            html += data.responseJSON[fieldName][0] + '<br>';
                        }
                    });
                    $alertsBox.html(html);
                } else {
                    $alertsBox.html("An error occured, please try again later");
                }
                $alertsBox.css('display', 'block');

                if (cbFail) {
                    cbFail(data, $alertsBox);
                }
            })
            .always(function () {
                $button.attr('disabled', null);
                removeSpinnerFrom($button);
            });
    });
}

export function errorModal(html) {
    var $remodal = $('[data-remodal-id="error-modal"]');
    $remodal.find('p').html(html);

    var $remodalObj = $remodal.remodal();
    $remodalObj.settings.hashTracking = false;
    $remodalObj.open();
}

export function errorModalWithCallback(html, cb) {
    var $remodal = $('[data-remodal-id="error-modal"]');
    $remodal.find('p').html(html);

    $remodal.one('closed', cb);

    var $remodalObj = $remodal.remodal();
    $remodalObj.settings.hashTracking = false;
    $remodalObj.open();
}

export function confirmModal(html, cb) {
    var $remodal = $('[data-remodal-id="confirm-modal"]');
    $remodal.find('p').html(html);

    var $remodalObj = $remodal.remodal();
    $remodalObj.settings.hashTracking = false;

    $remodal.on('confirmation', cb);

    $remodal.one('closed', function () {
        $remodal.off('confirmation');
    });

    $remodalObj.open();
}

export function readURL(input, prev) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(prev).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

export function readURLBG(input, prev) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(prev).css('background-image', "url('" + e.target.result + "')");
        };
        reader.readAsDataURL(input.files[0]);
    }
}
