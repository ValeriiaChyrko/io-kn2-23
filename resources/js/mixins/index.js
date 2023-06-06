import Vue from 'vue';
import AuthCan from '~/mixins/AuthCan';
import UIDGenerator from '~/mixins/UIDGenerator';

Vue.mixin(UIDGenerator);
Vue.mixin(AuthCan);
