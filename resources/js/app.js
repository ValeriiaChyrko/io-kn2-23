import Vue from 'vue';
import '~/components';
import App from '~/components/App';
import '~/mixins';

import '~/plugins';
import vuetify from '~/plugins/vuetify';
import router from '~/router';
import store from '~/store';


new Vue({
    ...App,
    store,
    router,
    vuetify
});
