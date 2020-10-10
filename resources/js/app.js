import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import Echo from "laravel-echo"

import '~/plugins'
import '~/components'

window.axios = require('axios');

Vue.config.productionTip = false

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '2a039f54d3cd24112198',
    cluster: 'ap1',
    encrypted: true
});

/* eslint-disable no-new */
new Vue({
    i18n,
    store,
    router,
    ...App
})