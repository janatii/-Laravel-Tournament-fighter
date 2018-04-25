/**
 * jQuery
 */

window.$ = window.jQuery = require('jquery');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * jQuery UI
 */

require('jquery-ui/ui/core');
require('jquery-ui/ui/widgets/slider');

/**
 * Twitter Bootstrap
 */

require('bootstrap-sass');

/**
 * remodal
 */

import 'remodal';

/**
 * Laravel Echo
 */

import Echo from "laravel-echo";

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

/**
 * Moment
 */

import moment from 'moment';

window.moment = moment;

/**
 * Load utils functions
 */

var lib = require('./lib');

window.debounce = lib.debounce;
window.remodalize = lib.remodalize;
window.addSpinnerTo = lib.addSpinnerTo;
window.removeSpinnerFrom = lib.removeSpinnerFrom;
window.errorModal = lib.errorModal;
window.errorModalWithCallback = lib.errorModalWithCallback;
window.confirmModal = lib.confirmModal;
window.readURL = lib.readURL;
window.readURLBG = lib.readURLBG;

/**
 * VueJS
 */
window.Vue = require('vue');

Vue.prototype.$store = {};
Vue.prototype.$trans = {};
Vue.prototype.$urls = {};

Vue.component('training-list', require('./components/TrainingList.vue'));
Vue.component('create-training-form', require('./components/CreateTrainingForm.vue'));
Vue.component('join-training-form', require('./components/JoinTrainingForm.vue'));
Vue.component('clock', require('./components/Clock.vue'));
Vue.component('chat', require('./components/Chat.vue'));

$('.js-confirmable-form').on('submit', function (e) {
    e.preventDefault();

    var form = this;
    confirmModal($(this).data('confirm'), function () {
        form.submit();
    });
});
