require('./bootstrap');

window.Vue = require('vue');

window.EventBus = new Vue();

Vue.component('status-form', require('./components/StatusForm.vue').default);
Vue.component('statuses-list', require('./components/StatusesList.vue').default);

import auth from './mixins/auth';

Vue.mixin(auth);

const app = new Vue({
    el: '#app',
});
